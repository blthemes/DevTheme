<!DOCTYPE html>
<html lang="<?php echo Theme::lang() ?>">
<head>
	<?php include(THEME_DIR_PHP.'head.php'); ?>
	<?php
	/*
	echo Theme::css('css/vendor.css');
	echo Theme::css('css/main.css');
	echo Theme::css('css/dticons.css');
	*/ 
	echo Theme::css('css/bundle.min.css');
    ?>

</head>
<?php $bodyClass = $WHERE_AM_I == 'page' ? 'post-template' : 'home-template';?>
<body class="<?php echo $bodyClass;?>  nav-closed">
	<div class="main-container">
		
		<?php Theme::plugins('siteBodyBegin'); ?>
		<?php include(THEME_DIR_PHP.'header.php'); ?>
		<!-- Content -->
		<?php
		// $WHERE_AM_I variable detect where the user is browsing
		// If the user is watching a particular page the variable takes the value "page"
		// If the user is watching the frontpage the variable takes the value "home"
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

		<!-- Footer -->
		<?php include(THEME_DIR_PHP.'footer.php'); ?>

		<?php
		/*
		echo Theme::javascript('js/jquery-3.3.1.min.js');
		echo Theme::javascript('js/vendor.js');	
		echo Theme::javascript('js/main.js');
		echo Theme::javascript('js/highlight.js');
		*/
		echo Theme::javascript('js/bundle.min.js');			
        ?>		
	</div>
</body>
</html>