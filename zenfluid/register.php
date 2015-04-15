<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH')) die();
?>
<?php
if (function_exists('printRegistrationForm')) {?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
  <?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
		<head>
			<title><?php echo getBareGalleryTitle(); ?></title>
			<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
			<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
				<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
			<?php } ?>
			<?php zp_apply_filter('theme_head'); ?>
		</head>
		<body>
		
			<?php include("header.php");?>

			<div id="container">
				<div id="contents">
					<div id="pagetitle">
						<?php echo gettext('User Registration'); ?>
					</div>
					<div id="pagecontent">
						<?php printRegistrationForm(); ?>
					</div>
				</div>
				<?php include("sidebar.php");?>
			</div>
			<?php include("footer.php");?>
		</body>
  <?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
	</html>
	<?php
} else {
	include(dirname(__FILE__) . '/404.php');
}
?>