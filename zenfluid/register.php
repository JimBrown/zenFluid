<?php
	// force UTF-8 �
	if (!defined('WEBPATH')) die();
?>
<?php
if (function_exists('printRegistrationForm')) {?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
  <?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
		<head>
			<?php include("inc-head.php");?>
		</head>
		<body>
		
			<?php include("inc-header.php");?>

			<div id="container">
				<div id="contents">
					<div id="title" class="border colour">
						<?php echo gettext('User Registration'); ?>
					</div>
					<div id="content" class="border colour">
						<?php printRegistrationForm(); ?>
					</div>
				</div>
				<?php include("inc-sidebar.php");?>
			</div>
			<?php include("inc-footer.php");?>
		</body>
  <?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
	</html>
	<?php
} else {
	include(dirname(__FILE__) . '/404.php');
}
?>