<!DOCTYPE html>
<html lang="<?php echo Theme::lang() ?>">
<head>
	<?php include(THEME_DIR_PHP.'head.php'); ?>
	<?php echo Theme::css('css/bundle.min.css');  ?>

</head>
<?php $bodyClass = $WHERE_AM_I == 'page' ? 'post-template' : 'home-template';?>
<body class="<?php echo $bodyClass;?>  nav-closed">
	<div class="main-container">
		<?php Theme::plugins('siteBodyBegin'); ?>
		<?php include(THEME_DIR_PHP.'header.php'); ?>		
		<?php
		if ($WHERE_AM_I == 'page') {
			include(THEME_DIR_PHP.'page.php');
		}
		elseif ($WHERE_AM_I == 'dtsearch') {
			include(THEME_DIR_PHP.'search.php');
		}
		else {
			include(THEME_DIR_PHP.'home.php');
		}
        ?>
		<?php include(THEME_DIR_PHP.'footer.php'); ?>
		<?php echo Theme::javascript('js/bundle.min.js'); ?>	
        <?php Theme::plugins('siteBodyEnd'); ?>		
	</div>
</body>
</html>