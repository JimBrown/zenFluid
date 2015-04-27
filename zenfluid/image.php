<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style/theme.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style/admintoolbox.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
</head>

	<body>
	
		<?php include("header.php");?>

		<div id="container">
			<div id="contents">
				<?php $doSlideShowLink = false;
				$titleMargin = getOption("zenfluid_titlemargin");
				$stageWidth = getOption('zenfluid_stagewidth');
				$stageStyle = ($stageWidth > 0) ? 'style="max-width: ' . $stageWidth . 'px; margin-left: auto; margin-right: auto;"' : ''; ?>
				<div id="stage" <?php echo $stageStyle;?>>
					<?php if (getOption('zenfluid_titletop')) {
						$titleMargin = $titleMargin - 20; ?>
						<div id="title" class="border colour">
							<?php if (getOption('zenfluid_titlebreadcrumb')) { ?>
								<a href="<?php echo getGalleryIndexURL(); ?>" title="<?php gettext('Home'); ?>"><?php echo gettext("Home"); ?></a> : <?php
								printParentBreadcrumb("", " : ", " : ");
								printAlbumBreadcrumb("  ", " : ");
							} ?>
							<strong><?php printImageTitle(); ?></strong>
						</div>
					<?php } ?>
				</div>
				<?php if (isImagePhoto()) {
					$doSlideShowLink = true;
					if (getOption('zenfluid_imagewidth')) {
						echo ImageJS($titleMargin,$stageWidth);
					} else {
						echo ImageJS($titleMargin,0);
					}
					if (zp_has_filter('theme_head', 'colorbox::css')) {
						echo colorBoxJS();
					} ?>
					<div id="image">
						<?php if (getOption("Use_thickbox")) {
							$boxclass = "class=\"thickbox\"";
						} else {
							$boxclass = "";
						}
						$tburl = getFullImageURL();
						if (!empty($tburl)) {
							echo '<a href="' . html_encode(pathurlencode($tburl)) . '" ' . $boxclass . ' title="' . getBareImageTitle() . '">' . "\n";
						}
						printCustomSizedImageMaxSpace(getBareImageTitle(),null,null,"imgheight border");
						if (!empty($tburl)) {
							echo "\n</a>\n";
						}?>
					</div>
					<?php } else {
					$metadata = getImageMetaData(NULL,false);
					$vidWidth = $metadata['VideoResolution_x'];
					$vidHeight = $metadata['VideoResolution_y'];
					echo VideoJS($vidWidth, $vidHeight, $titleMargin, $stageWidth);
					// jPlayer adds a 40 px controls bar below the video. Others add the bar in the video.
					$playerMarginBottom = (extensionEnabled('jPlayer')) ? 'style="margin-bottom: 44px;"' : ''; ?>
					<div id="videocontainer" <?php echo $playerMarginBottom; ?>>
						<div id="video">
							<?php printCustomSizedImageMaxSpace(getBareImageTitle(),null,null); ?>
						</div>
					</div>
				<?php } ?>
				<div id="stage" <?php echo $stageStyle;?>>
					<div id="buttons">
						<?php if (hasPrevImage()) { ?>
							<div id="button" class="border colour">
								<a href="<?php echo html_encode(getPrevImageURL()) ?>" title="<?php echo gettext('Previous Image') ?>"><?php echo gettext('« Prev') ?></a>
							</div>
						<?php } ?>
						<div id="button" class="border colour">
							<?php echo imageNumber() . "/" . getNumImages(); ?>
						</div>
						<?php if (hasNextImage()) { ?>
							<div id="button" class="border colour">
								<a href="<?php echo html_encode(getNextImageURL()) ?>" title="<?php echo gettext('Next Image') ?>"><?php echo gettext('Next »') ?></a>
							</div>
						<?php }
						if ($doSlideShowLink && function_exists('printSlideShowLink')) { ?>
							<div id="button" class="border colour">
								<?php printSlideShowLink();?>
							</div>
						<?php }
						if (getImageMetaData()) { ?>
							<div id="button" class="border colour">
								<?php printImageMetadata(NULL, 'colorbox');?>
							</div>
						<?php }
						if (function_exists('getHitcounter')) { ?>
							<div id="button" class="border colour">
								<?php echo gettext("Views: ") . getHitcounter() . "\n";?>
							</div>
						<?php }
						if (function_exists('printCommentForm') && ($_zp_current_image->getCommentsAllowed() || getCommentCount())) { 
							$num = getCommentCount();
							if ($num == 0) {
								$comments = gettext('No Comments');
							} else {
								$comments = sprintf(ngettext('%u Comment', '%u Comments', $num), $num);
							}
							?>
							<div id="button" class="border colour">
								<a href="#readComment"><?php echo $comments; ?></a>
							</div>
							<div id="button" class="border colour">
								<a href="#addComment">Add Comment</a>
							</div>
						<?php }
						if (function_exists('printLikeButton')) { ?>
							<div id="button" class="fb-button border colour">
								<?php printLikeButton(); ?>
							</div>
						<?php } ?>
					</div>
					<div class="clearing" ></div>
					<?php if (getOption('zenfluid_titletop')) {
						if (getImageDesc()) { ?>
							<div id="title" class="border colour">
								<?php printImageDesc(); ?>
							</div>
						<?php }
					} else { ?>
						<div id="title" class="border colour">
							<?php if (getOption('zenfluid_titlebreadcrumb')) {
								printParentBreadcrumb("", " : ", " : ");
								printAlbumBreadcrumb("  ", " : ");
							} ?>
							<?php printImageTitle();
							if (getImageDesc()) {
								printImageDesc();
							} ?>
						</div>
					<?php } ?>
					<div class="clearing" ></div>
					<?php if (function_exists('printCommentForm') && ($_zp_current_image->getCommentsAllowed() || getCommentCount())) { ?>
						<a id="readComment"></a>
						<?php printCommentForm(true, '<a id="addComment"></a>', false); ?>
					<?php }
					if(getTags()) {?>
						<div id="button" class="border colour">
							<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
						</div>
					<?php } ?>
				</div>
			</div>
			<?php include("sidebar.php");?>
		</div>
		<?php include("footer.php");?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>
