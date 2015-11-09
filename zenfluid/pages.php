<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH') || !class_exists("CMS")) die();
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
				<?php $stageWidth = getOption('zenfluid_stagewidth');
				$stageStyle = ($stageWidth > 0) ? 'style="max-width: ' . $stageWidth . 'px; margin-left: auto; margin-right: auto;"' : ''; ?>
				<div id="stage" <?php echo $stageStyle;?>>
					<div id="title" class="border colour">
					<?php printPageTitle();?>
					</div>
					<div id="content" class="border colour">
						<?php printPageContent();?>
					</div>
					<div id="buttons">
						<?php if (function_exists('getHitcounter')) { ?>
							<div id="button" class="border colour">
								<?php echo gettext("Views: ") . getHitcounter();?>
							</div>
						<?php }
						if(getTags()) { ?>
							<div id="button" class="border colour">
								<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
							</div>
						<?php }
						if (function_exists('printLikeButton')) { ?>
							<div id="button" class="fb-button border colour">
								<?php printLikeButton(); ?>
							</div>
						<?php } ?>
					</div>
					<div class="clearing" ></div>
					<?php @call_user_func('printCommentForm');?>
				</div>
			</div>
			<?php include("sidebar.php");?>
		</div>
		<?php include("footer.php");?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>