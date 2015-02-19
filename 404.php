<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
	</head>

	<body>

		<?php include("header.php");?>

		<div id="container">
			<div id="contents">
				<div id="content-error">
					<div class="errorbox">
						<?php echo gettext("The Zenphoto object you are requesting cannot be found.");
						if (isset($album)) {
							echo '<br />'.gettext("Album").': '.html_encode($album);
						}
						if (isset($image)) {
							echo '<br />'.gettext("Image").': '.html_encode($image);
						}
						if (isset($obj)) {
							echo '<br />'.gettext("Theme page").': '.html_encode(substr(basename($obj),0,-4));
						}?>
					</div>
				</div>
			</div>
			<?php include("sidebar.php"); ?>
		</div>

		<?php include("footer.php");?>
	</body>
</html>
