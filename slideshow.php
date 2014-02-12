<?php
	// force UTF-8
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<meta charset="<?php echo LOCAL_CHARSET; ?>" />
		<meta name="viewport" content="width=device-width" />
		<title><?php echo gettext('Slideshow').' | '.getBareGalleryTitle(); ?></title>
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
	</head>
	<body>
		<?php 
		zp_apply_filter('theme_body_open');
		if (function_exists('printGslideshow')) {
			printGslideshow();
		} else { ?>
			<div id="slideshowpage">
				<?php printSlideShow(true,true); ?>
			</div>
		<?php } ?>
	</body>
</html>
