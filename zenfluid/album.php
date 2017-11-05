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
				$stageStyle = ($stageWidth > 0) ? 'style="max-width: ' . $stageWidth . 'px;"' : '';
				$thumbstageStyle = (getOption('zenfluid_stagethumb')) ? $stageStyle : '';
				if (getOption('zenfluid_titletop')) { ?>
					<div class="stage" <?php echo $stageStyle;?>>
						<div class="title border colour">
							<?php if (getOption('zenfluid_titlebreadcrumb')) { ?>
								<a href="<?php echo getGalleryIndexURL(); ?>" title="<?php gettext('Home'); ?>"><?php echo gettext("Home"); ?></a> : <?php
								printParentBreadcrumb("", " : ", " : ");
							} ?>
							<strong><?php printAlbumTitle(); ?></strong>
						</div>
					</div>
				<?php } ?>
					<div class="thumbstage" <?php echo $thumbstageStyle;?>>
						<?php while (next_album()):?>
							<div class="thumbs border colour">
								<a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View: '); printBareAlbumTitle();?>">
									<div class="thumbimage">
										<?php printAlbumThumbImage(getBareAlbumTitle(),"border"); ?>
										<div class="thumbtitle">
											<?php $numItems = getNumImages() + getNumAlbums();
											printAlbumTitle(); echo ' (' . $numItems . ')';
											echo "<p>" . shortenContent(strip_tags(getAlbumDesc()), 150, getOption("zenpage_textshorten_indicator")) . "</p>"; ?>
										</div>
									</div>
								</a>
							</div>
						<?php endwhile;
						if (getOption('zenfluid_transitionnewrow') && getNumAlbums() > 0 && getNumImages() > 0) { ?>
							<div class="clearing"></div>
						<?php }
						while (next_image()):
							if (isImagePhoto()) {
								$doSlideShowLink = true;
							} ?>
							<div class="thumbs border">
								<a href="<?php echo html_encode(getImageURL());?>" title="<?php echo gettext('View: '); printBareImageTitle();?>">
									<div class="thumbimage">
										<?php printImageThumb(getBareImageTitle(),"border");
										if (isImageVideo()) { ?>
											<img class="videoplay" src="<?php echo $_zp_themeroot; ?>/images/videoplay.png">
										<?php } ?>
										<div class="thumbtitle">
											<?php printImageTitle();
											echo "<p>" . shortenContent(strip_tags(getImageDesc()), 150, getOption("zenpage_textshorten_indicator")) . "</p>"; ?>
										</div>
									</div>
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				<div class="clearing"></div>
				<div class="stage" <?php echo $stageStyle;?>>
					<?php if (hasPrevPage() || hasNextPage() || (getNumImages() > 1 && $doSlideShowLink && function_exists('printSlideShowLink'))) { ?>
						<div class="albumbuttons">
							<?php if (hasPrevPage() || hasNextPage()) { ?>
								<div class="button border colour">
									<?php printPageListWithNav("Prev ", " Next", false, true, 'taglist', NULL, true); ?>
								</div>
							<?php }
							if (getNumImages() > 1 && $doSlideShowLink && function_exists('printSlideShowLink')) { ?>
								<div class="button border colour">
									<div class="slideshowlink">
										<?php printSlideShowLink();?>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="clearing"></div>
					<?php }
					if (getOption('zenfluid_titletop')) {
						if (getAlbumDesc()) { ?>
							<div class="title border colour">
								<?php printAlbumDesc(); ?>
							</div>
						<?php }
					} else { ?>
						<div class="title border colour">
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
						<div class="albumbuttons">
							<div class="button border colour">
								<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php include("inc-sidebar.php");?>
		</div>
		
		<?php if(getOption('zenfluid_showfooter')) include("inc-footer.php");?>

	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>