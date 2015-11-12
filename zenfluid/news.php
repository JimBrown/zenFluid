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
	
		<?php include("inc-header.php");?>

		<div id="container">
			<div id="contents">
				<?php $stageWidth = getOption('zenfluid_stagewidth');
				$stageStyle = ($stageWidth > 0) ? 'style="max-width: ' . $stageWidth . 'px; margin-left: auto; margin-right: auto;"' : ''; ?>
				<div id="stage" <?php echo $stageStyle;?>>
					<?php if (is_NewsArticle()) { // single news article ?>
						<div id="newsnav">
							<?php if (getPrevNewsURL()) { ?>
								<div id="button" class="border colour">
									Previous:&nbsp
									<?php printPrevNewsLink(''); ?>
								</div>
							<?php }
							if (getNextNewsURL()) { ?>
								<div id="button" class="border colour">
									Next:&nbsp
									<?php printNextNewsLink(''); ?>
								</div>
							<?php } ?>
							<div class="clearing" ></div>
						</div>
						<div id="title" class="border colour">
							<?php printNewsTitle(); ?>
							<div id="newsdate">
								<?php printNewsDate(); ?>
							</div>
							<?php printNewsContent();?>
						</div>
						<div id="buttons">
							<?php if (function_exists('getHitcounter')) { ?>
								<div id="button" class="border colour">
									<?php echo "Views: " . getHitcounter();?>
								</div>
							<?php }
							if (function_exists('printLikeButton')) { ?>
							<div id="button" class="fb-button border colour">
								<?php printLikeButton(); ?>
							</div>
							<?php }
							if(getTags()) {?>
								<div id="button" class="border colour">
									<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
								</div>
							<?php }
							if(getNewsCategories()) { ?>
								<div id="button" class="border colour">
									<?php printNewsCategories(", ", gettext("Categories: "), "taglist"); ?>
								</div>
							<?php } ?>
						</div>
						<div class="clearing" ></div>
						<?php if (function_exists('printCommentForm') && ($_zp_current_zenpage_news->getCommentsAllowed() || getCommentCount())) {
							printCommentForm();
						}?>
					<?php } else { ?>
						<div id="buttons">
							<?php if (getNextNewsPageURL() || getPrevNewsPageURL()) { ?>
								<div id="button" class="border colour">
									<?php printNewsPageListWithNav(gettext('Next'), gettext('Prev'), true, 'taglist', true); ?>
								</div>
							<?php } ?>
						</div>
						<div class="clearing" ></div>
						<?php while (next_news()):;  // news article loop ?>
							<div id="title" class="border colour">
								<div id="newslink">
									<?php printNewsURL();?>
								</div>
								<div id="newsdate">
									<?php printNewsDate(); ?>
								</div>
								<?php printNewsContent();?>
							</div>
							<div id="buttons">
								<?php if (function_exists('getHitcounter')) { ?>
									<div id="button" class="border colour">
										<?php echo "Views: " . getHitcounter();?>
									</div>
								<?php }
								if(getTags()) {?>
									<div id="button" class="border colour">
										<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
									</div>
								<?php }
								if(getNewsCategories()) { ?>
									<div id="button" class="border colour">
										<?php printNewsCategories(", ", gettext("Categories: "), "taglist"); ?>
									</div>
								<?php } ?>
							</div>
							<div class="clearing" ></div>
						<?php endwhile; ?>
					<?php }	?>
				</div>
			</div>
			<?php include("inc-sidebar.php");?>
		</div>
		<?php include("inc-footer.php");?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>