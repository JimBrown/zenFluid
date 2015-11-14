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

		<?php include("inc-header.php");?>

		<div id="container">
			<div id="contents">
				<?php $doSlideShowLink = false;
				$stageWidth = getOption('zenfluid_stagewidth');
				$stageStyle = ($stageWidth > 0) ? 'style="max-width: ' . $stageWidth . 'px; margin-left: auto; margin-right: auto;"' : ''; ?>
				<?php if (getOption('zenfluid_titletop')) { ?>
					<div id="stage" <?php echo $stageStyle;?>>
						<div id="title" class="border colour">
							<?php if (getOption('zenfluid_titlebreadcrumb')) { ?>
								<a href="<?php echo getGalleryIndexURL(); ?>" title="<?php gettext('Home'); ?>"><?php echo gettext("Home"); ?></a> : <?php
								printParentBreadcrumb("", " : ", " : ");
							} ?>
							<strong><?php printAlbumTitle(); ?></strong>
						</div>
					</div>
				<?php } ?>
					<?php while (next_album()):?>
						<div id="thumbs" class="border colour">
							<a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View: '); printBareAlbumTitle();?>">
								<div id="thumbimage">
									<?php printAlbumThumbImage(getBareAlbumTitle(),"border"); ?>
									<div id="thumbtitle">
										<?php $numItems = getNumImages() + getNumAlbums();
										printAlbumTitle(); echo ' (' . $numItems . ')';
										echo "<p>" . shortenContent(strip_tags(getAlbumDesc()), 150, getOption("zenpage_textshorten_indicator")) . "</p>"; ?>
									</div>
								</div>
							</a>
						</div>
					<?php endwhile;
					if (getOption('zenfluid_transitionnewrow')) { ?>
						<div class="clearing"></div>
					<?php }
					while (next_image()):
						if (isImagePhoto()) {
							$doSlideShowLink = true;
						} ?>
						<div id="thumbs" class="border">
							<a href="<?php echo html_encode(getImageURL());?>" title="<?php echo gettext('View: '); printBareImageTitle();?>">
								<div id="thumbimage">
									<?php printImageThumb(getBareImageTitle(),"border");
									if (isImageVideo()) { ?>
										<img id="videoplay" src="<?php echo $_zp_themeroot; ?>/images/videoplay.png">
									<?php } ?>
									<div id="thumbtitle">
										<?php printImageTitle();
										echo "<p>" . shortenContent(strip_tags(getImageDesc()), 150, getOption("zenpage_textshorten_indicator")) . "</p>"; ?>
									</div>
								</div>
							</a>
						</div>
					<?php endwhile; ?>
				<div class="clearing"></div>
				<div id="stage" <?php echo $stageStyle;?>>
					<?php if (hasPrevPage() || hasNextPage() || ($doSlideShowLink && function_exists('printSlideShowLink'))) { ?>
						<div id="albumbuttons">
							<?php if (hasPrevPage() || hasNextPage()) { ?>
								<div id="button" class="border colour">
									<?php printPageListWithNav("Prev ", " Next", false, true, 'taglist', NULL, true); ?>
								</div>
							<?php }
							if ($doSlideShowLink && function_exists('printSlideShowLink')) { ?>
								<div id="button" class="border colour">
									<div id="slideshowlink" style="display: inline-block; float: none;">
										<?php printSlideShowLink();?>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="clearing"></div>
					<?php }
					if (getOption('zenfluid_titletop')) {
						if (getAlbumDesc()) { ?>
							<div id="title" class="border colour">
								<?php printAlbumDesc(); ?>
							</div>
						<?php }
					} else { ?>
						<div id="title" class="border colour">
							<?php if (getOption('zenfluid_titlebreadcrumb')) {
								printParentBreadcrumb("", " : ", " : ");
							} ?>
							<?php printAlbumTitle(); ?>
							<?php if (getAlbumDesc()) {
								printAlbumDesc();
							} ?>
						</div>
					<?php }
					if(getTags()) {?>
						<div id="albumbuttons">
							<div id="button" class="border colour">
								<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php include("inc-sidebar.php");?>
		</div>
		
		<?php include("inc-footer.php");?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>