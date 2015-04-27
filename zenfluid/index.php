<?php
  // force UTF-8 Ø
  if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
	<head>
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style/theme.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style/admintoolbox.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
		<?php zp_apply_filter('theme_head'); ?>
	</head>
	<body>

		<?php include("header.php");?>

		<div id="container">
		  <div id="contents">
			  <div id="image">
				<?php echo ImageJS();?>
				<?php printHomepageImage(getOption('zenfluid_imageroot'),getOption('zenfluid_randomimage'));?>
			  </div>
		  </div>
		  <?php include("sidebar.php"); ?>
		</div>

		<?php include("footer.php");?>

	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>
