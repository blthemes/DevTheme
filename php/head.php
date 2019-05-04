
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="author" content="BlThemes" />

<?php if($WHERE_AM_I == 'dtsearch'): ?>
<title>
	<?php echo $L->get('Search page')?>
</title>
<meta name="description" content="Search results" />
<?php else:?>
<?php echo Theme::metaTags('title'); ?>
<?php echo $helper->head_description(); ?>
<?php endif;?>
<?php echo Theme::favicon('img/favicon.ico'); ?>
<?php Theme::plugins('siteHead'); ?>

<link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,700&amp;subset=cyrillic" rel="stylesheet" />

