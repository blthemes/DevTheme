<?php

$searchTerm = urldecode($url->parameter('search'));
$searchTerm = Text::removeHTMLTags($searchTerm);
$searchTerm = trim($searchTerm); 
$searchTerm = htmlspecialchars ($searchTerm);

echo '<script>var uploadsFolder = "'.HTML_PATH_UPLOADS.'", searchTerm="'. $searchTerm .'", domainBase="'.DOMAIN_PAGES.'" ;</script>'.PHP_EOL;

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
			<div class="loop">				
			</div>			
		</div>
	</div>
	<div class="col-md-12 text-center">
			<a href="#" id="load-posts" data-posts_per_page="6" class="btn hide"><?php echo $L->get('Load more posts')?></a>
	</div>
</main>
<script>
	var translations ={
	  "search-results-for"    : "<?php echo $L->get('Search results for')?>",
	  "nothing-found-for"     : "<?php echo $L->get('Nothing found for')?>",
	  "search-term-too-short" : "<?php echo $L->get('Search term too short')?>",
	};
</script>
