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
				<?php $commentCount = getCommentCount();
				echo CommentsJS($commentCount);?>
				<div class="stage" <?php echo $stageStyle;?>>
					<?php if (is_NewsArticle()) { // single news article ?>
						<div class="title border colour">
							<?php printNewsTitle(); ?>
							<div class="newsdate">
								<?php printNewsDate(); ?>
							</div>
						</div>
						<div class="content border colour">
							<?php printNewsContent();?>
						</div>
						<div class="imagebuttons">
							<?php if (getPrevNewsURL()) { ?>
								<div class="button border colour">
									Previous:&nbsp
									<?php printPrevNewsLink(''); ?>
								</div>
							<?php }
							if (getNextNewsURL()) { ?>
								<div class="button border colour">
									Next:&nbsp
									<?php printNextNewsLink(''); ?>
								</div>
							<?php }
							if (function_exists('getHitcounter')) { ?>
								<div class="button border colour">
									<?php echo "Views: " . getHitcounter();?>
								</div>
							<?php }
							if (function_exists('printCommentForm') && ($_zp_current_zenpage_news->getCommentsAllowed() || $commentCount)) { 
								if ($commentCount == 0) {
									$comments = gettext('No Comments');
								} else {
									$comments = sprintf(ngettext('%u Comment', '%u Comments', $commentCount), $commentCount);
								}
								?>
								<div class="button border colour">
									<a href="#readComment"><?php echo $comments; ?></a>
								</div>
								<div class="button border colour">
									<a href="#addComment">Add Comment</a>
								</div>
							<?php }
							if (function_exists('printLikeButton')) { ?>
							<div class="button fb-button border colour">
								<?php printLikeButton(); ?>
							</div>
							<?php } ?>
						</div>
						<div class="clearing" ></div>
						<?php if (function_exists('printCommentForm') && ($_zp_current_zenpage_news->getCommentsAllowed() || $commentCount)) { ?>
							<a id="readComment"></a>
							<?php printCommentForm(true, '<a id="addComment"></a>', false); ?>
						<?php } ?>
						<div class="albumbuttons">
							<?php if(getNewsCategories()) { ?>
								<div class="button border colour">
									<?php printNewsCategories(", ", gettext("Categories: "), "taglist"); ?>
								</div>
							<?php }
							if(getTags()) {?>
								<div class="button border colour">
									<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
								</div>
							<?php } ?>
						</div>
						<div class="clearing" ></div>
					<?php } else { ?>
						<div class="buttons">
							<?php if (getNextNewsPageURL() || getPrevNewsPageURL()) { ?>
								<div class="button border colour">
									<?php printNewsPageListWithNav(gettext('Next'), gettext('Prev'), true, 'taglist', true); ?>
								</div>
							<?php } ?>
						</div>
						<div class="clearing" ></div>
						<?php while (next_news()):;  // news article loop ?>
							<div class="title border colour">
								<div class="newslink">
									<?php printNewsURL();?>
								</div>
								<div class="newsdate">
									<?php printNewsDate(); ?>
								</div>
								<?php printNewsContent();?>
							</div>
							<div class="albumbuttons">
								<?php if (function_exists('getHitcounter')) { ?>
									<div class="button border colour">
										<?php echo "Views: " . getHitcounter();?>
									</div>
								<?php }
								if (function_exists('printCommentForm') && ($_zp_current_zenpage_news->getCommentsAllowed() || $commentCount)) { 
									if ($commentCount == 0) {
										$comments = gettext('No Comments');
									} else {
										$comments = sprintf(ngettext('%u Comment', '%u Comments', $commentCount), $commentCount);
									}
									?>
									<div class="button border colour">
										<?php echo $comments; ?></a>
									</div>
								<?php }
								if(getTags()) {?>
									<div class="button border colour">
										<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
									</div>
								<?php }
								if(getNewsCategories()) { ?>
									<div class="button border colour">
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
		<?php if(getOption('zenfluid_showfooter')) include("inc-footer.php");?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>