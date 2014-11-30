<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH') || !class_exists('Zenpage')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php printHeadTitle();?>
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
					<?php echo gettext('Contact us'); ?>
				</div>
				<div id="pagecontent">
					<?php if (zp_loggedin()) setOption('contactform_captcha',false,false);
					printContactForm(); ?>
				</div>
			</div>
			<?php include("sidebar.php");?>
		</div>
		<?php include("footer.php");?>
	</body>
</html>
