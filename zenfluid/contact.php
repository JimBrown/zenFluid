<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH') || !class_exists("CMS")) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include("inc-head.php");?>
	</head>

	<body>

		<?php include("header.php");?>

		<div id="container">
			<div id="contents">
				<?php $stageWidth = getOption('zenfluid_stagewidth');
				$stageStyle = ($stageWidth > 0) ? 'style="max-width: ' . $stageWidth . 'px; margin-left: auto; margin-right: auto;"' : ''; ?>
				<div id="stage" <?php echo $stageStyle;?>>
					<div id="title" class="border colour">
						<?php echo gettext('Contact us'); ?>
					</div>
					<div id="content" class="border colour">
						<?php if (zp_loggedin()) setOption('contactform_captcha',false,false);
						printContactForm(); ?>
					</div>
				</div>
			</div>
			<?php include("sidebar.php");?>
		</div>
		<?php include("footer.php");?>
	</body>
</html>
