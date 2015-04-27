<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
	<head>
		<meta charset="<?php echo LOCAL_CHARSET; ?>" />
		<meta name="viewport" content="width=device-width" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style/theme.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style/admintoolbox.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
		<?php zp_apply_filter('theme_head'); ?>
	</head>
	<body>
		<?php 
		zp_remove_filter('theme_body_open', 'printLikeButtonJS');
		zp_apply_filter('theme_body_open');
		if (function_exists('printGslideshow')) {
			printGslideshow();
		} else { ?>
			<div id="slideshowpage">
				<?php printSlideShow(true,true); ?>
			</div>
		<?php } ?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
<?php //makeNeatEnd();?>
</html>
