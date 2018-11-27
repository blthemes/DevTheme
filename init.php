<?php
$searchHook = 'dtsearch';
if (!isset($login)) {
	$login = new Login();
}
if (!isset($helper)) {
	include(THEME_DIR_PHP.'lib/helper.php');
	$helper = new Helper();
}
if( strpos( $url->slug(), $searchHook)!== false){
	$url->setWhereAmI('dtsearch');
	$url->setHttpCode();
	$url->setHttpMessage();
	if (!headers_sent()) {
	  header("HTTP/1.1 200 OK");
	}
}