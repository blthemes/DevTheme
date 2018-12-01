<?php
require_once 'lib/filecache.php';
$searchTerm = urldecode($url->parameter('search'));
$searchTerm = Text::removeHTMLTags($searchTerm);
$searchTerm = trim(preg_replace('/\s+/', ' ',$searchTerm)); //remove repeated spaces and trim
$searchTerm = htmlspecialchars ($searchTerm);
/**caching pages for performance */
$fCache = new fileCache();
$fCache->changeConfig([
	"cacheDirectory" => PATH_TMP."cache-storage".DS,
	'gzipCompression'        => false
	]);

$cache = array();
$searchCache = $fCache->get('searchCache');
if(!$searchCache){
	$list = $pages->getPublishedDB();

	foreach ($list as $pageKey) {
		$page = buildPage($pageKey);

		// Process content

		$content = str_replace('<', ' <', $page->content(false));
		$content = html_entity_decode($content, ENT_COMPAT, UTF-8);
		$content = Text::removeHTMLTags($content);
		$content = $helper->limit_text_words($content, 350, '');
		$content = trim(preg_replace('/\s+/', ' ', $content)); //remove repeated spaces
		$content = htmlentities($content, ENT_QUOTES | ENT_IGNORE, "UTF-8");

		// Include the page to the cache
		$cache[]=	array(
						'title' =>  Sanitize::html($page->title()),
						'content' =>  $content,
						'key' => $pageKey,
					);

	}
	$fCache->set('searchCache',$cache, strtotime('+1 hour')); //cache pages for one hour
}
else{
	$cache = $searchCache;
}


$json = json_encode($cache, JSON_UNESCAPED_UNICODE|JSON_HEX_APOS);
//$err = json_last_error();

echo '<script>var searchArr='. $json.', searchTerm="'. $searchTerm .'", domainBase="'.DOMAIN_PAGES.'" ;</script>'.PHP_EOL;
echo Theme::javascript('js/search/searchbundle.min.js');
?>
<main id="content" class="container search" role="main">
	<div class="row">
		<div class="col-md-12 col-lg-10 col-xl-8 mr-auto ml-auto">
			<form method="get" class="dts-form">
				<input type="search" name="search" placeholder="Search..." value="<?php echo $searchTerm; ?>" class="dt-input" autocomplete="off" spellcheck="false" />
			</form>
			<?php if($searchTerm): ?>
			<h4 class="title">
				<?php echo $L->get('Search results for')?> "<?php echo $searchTerm; ?>"
			</h4>
			<?php else: ?>
			<h4 class="title"></h4>
			<?php endif; ?>
			<div class="loop"></div>
		</div>
	</div>
	<div class="col-md-12 text-center">
		<a href="#" id="load-posts" data-posts_per_page="6" class="btn hide">
			<?php echo $L->get('Load more posts')?>
		</a>
	</div>
</main>
