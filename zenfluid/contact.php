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

		<?php include("inc-header.php");?>

		<div id="container">
			<div id="contents">
				<div class="stage" <?php echo $stageStyle;?>>
					<div class="title border colour">
						<?php echo gettext('Contact us'); ?>
					</div>
					<div class="content border colour">
						<?php if (zp_loggedin()) setOption('contactform_captcha',false,false);
						printContactForm(); ?>
					</div>
				</div>
			</div>
			<?php include("inc-sidebar.php");?>
		</div>
		<?php if(getOption('zenfluid_showfooter')) include("inc-footer.php");?>
	</body>
</html>
