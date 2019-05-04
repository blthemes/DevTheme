<?php


if (!isset($login)) {
	$login = new Login();
}
if (!isset($helper)) {
	include(THEME_DIR_PHP.'lib/helper.php');
	$helper = new Helper($useCdn=false);
}

//search page
$searchHook = 'dtsearch';
if( strpos( $url->slug(), $searchHook)!== false){
	$url->setWhereAmI('dtsearch');
	$url->setHttpCode();
	$url->setHttpMessage();
	if (!headers_sent()) {
	  header("HTTP/1.1 200 OK");
	}
}

//create or update bltsearch.json
$pubList = $pages->getDB(false);
foreach ($pubList as $key=>$fields) {
	if ($fields['type']!='published' && $fields['type']!='sticky') {
		unset($pubList[$key]);
	}
}
$pubList = array_keys($pubList);

$jsonFile = PATH_UPLOADS . 'bltsearch.json';
if (!isset($searchJson)) {
	include(THEME_DIR_PHP.'lib/jsondb.php');
	$searchJson = new jsonDB($jsonFile);
}

if(count($pubList) != $searchJson->count() ){
	$searchJson->truncate();
	foreach ($pubList as $pageKey) {
		try {
			$tpage = buildPage($pageKey);

			// Process $ clean content
			$tcont = str_replace('<', ' <', $tpage->content(false));
			$tcont = html_entity_decode($tcont, ENT_QUOTES, "UTF-8");
			$tcont = Text::removeHTMLTags($tcont);
			$tcont = $helper->limit_text_words($tcont, 300, '');
			$tcont = trim($tcont);
			$tcont = htmlentities($tcont, ENT_QUOTES | ENT_IGNORE, "UTF-8");

			$ttitle = html_entity_decode($tpage->title(), ENT_QUOTES, "UTF-8");
			$ttitle =  htmlentities($ttitle, ENT_QUOTES | ENT_IGNORE, "UTF-8");

			$searchJson->db[] = array(
				'title' => $ttitle,
				'content' => $tcont,
				'slug' => $pageKey
			);
		}
		catch (Exception $e) {
			// Continue
		}
	}
	$searchJson->save();
}