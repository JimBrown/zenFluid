<?php
  // force UTF-8 Ø
  if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
	<head>
		<?php include("inc-head.php");?>
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
