<?php
	// force UTF-8
	if (!defined('WEBPATH')) die();
if (function_exists('printRegistrationForm')) {?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<?php zp_apply_filter('theme_head'); ?>
			<title><?php echo getBareGalleryTitle(); ?></title>
			<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
			<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
				<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
			<?php } ?>
		</head>
		<body>
			<?php zp_apply_filter('theme_body_open'); ?>

			<div id="container">
				<div id="contents">
					<div id="pagetitle">
						User Registration
					</div>
					<div id="pagecontent">
						<?php printRegistrationForm(); ?>
					</div>
				</div>
				<?php include("sidebar.php");?>
			</div>
			<?php include("footer.php");?>
		</body>
	</html>
	<?php
} else {
	include(dirname(__FILE__) . '/404.php');
}
?>