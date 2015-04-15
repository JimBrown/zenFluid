<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH') || !class_exists("CMS")) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
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
				<div id="pagetitle">
					<?php printPageTitle();?>
				</div>
				<div id="pagecontent">
					<?php printPageContent();?>
					<div id="buttons">
						<?php if (function_exists('getHitcounter')) { ?>
							<div id="hitcounter">
								<?php echo gettext("Views: ") . getHitcounter();?>
							</div>
						<?php }
						if (function_exists('printLikeButton')) {
							printLikeButton();
						}
						if(getTags()) {?>
							<div id="tags">
								<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
							</div>
						<?php } ?>
					</div>
					<div class="clearing" ></div>
					<?php if (function_exists('printCommentForm') && ($_zp_current_zenpage_page->getCommentsAllowed() || getCommentCount())) {
						printCommentForm();
					}?>
				</div>
			</div>
			<?php include("sidebar.php");?>
		</div>
		<?php include("footer.php");?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>