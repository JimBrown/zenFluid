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
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
</head>

	<body>
	
		<?php include("header.php");?>

		<div id="container">
			<div id="contents">
				<div id="imagecontent">
					<?php $doSlideShowLink = false;
					if (isImagePhoto()) {
						echo ImageJS(getOption("zenfluid_titlemargin"));
						if (zp_has_filter('theme_head', 'colorbox::css')) {
							echo colorBoxJS();
						}
						if (getNumImages() > 1) {$doSlideShowLink = true;} ?>
						<div id="image">
							<?php if (getOption("Use_thickbox")) {
								$boxclass = "class=\"thickbox\"";
							} else {
								$boxclass = "";
							}
							$tburl = getFullImageURL();
							if (!empty($tburl)) {
								echo '<a href="' . html_encode(pathurlencode($tburl)) . '" ' . $boxclass . 'title="' . getBareImageTitle() . '">' . "\n";
							}
							printCustomSizedImageMaxSpace(getBareImageTitle(),null,null,"imgheight");
							if (!empty($tburl)) {
								echo "\n</a>\n";
							}?>
						</div>
					<?php } else {
						$metadata = getImageMetaData(NULL,false);
						$vidWidth = $metadata['VideoResolution_x'];
						$vidHeight = $metadata['VideoResolution_y'];
						echo VideoJS($vidWidth, $vidHeight, getOption("zenfluid_titlemargin"));?>
						<div id="video" style="max-width: <?php echo $vidWidth; ?>px; max-height: <?php echo $vidHeight; ?>px;">
							<?php printCustomSizedImageMaxSpace(getBareImageTitle(),null,null); ?>
						</div>
					<?php }
					$commentWidth = strtolower(getOption('zenfluid_commentwidth'));
					$commentWidth = ($commentWidth == "auto") ? $commentWidth : $commentWidth . "px";
					$commentMarginTop = (extensionEnabled('jPlayer')) ? 50 : 10; // jPlayer adds a 40 px controls bar below the video. Others add the bar in the video.
					?>
					<div id="commentstage" style="margin-top: <?php echo $commentMarginTop; ?>px; max-width: <?php echo $commentWidth;?>;">
						<div id="buttons">
							<?php if (hasPrevImage()) {
								echo '<div id="imgprevious">' . "\n" . '<a href="' . html_encode(getPrevImageURL()) . '" title="' . gettext('Previous Image') . '">' . gettext('« Prev') . '</a>' . "\n" . '</div>' . "\n";
							}
							if (hasNextImage()) {
								echo '<div id="imgnext">' . "\n" . '<a href="' . html_encode(getNextImageURL()) . '" title="' . gettext('Next Image') . '">' . gettext('Next »') . '</a>' . "\n" . '</div>' . "\n";
							}
							if ($doSlideShowLink && function_exists('printSlideShowLink')) { ?>
								<div id="slideshowlink">
									<?php printSlideShowLink();?>
								</div>
							<?php }
							if (getImageMetaData()) { ?>
								<div id="metadata">
									<?php printImageMetadata(NULL, 'colorbox');?>
								</div>
							<?php }
							if(getTags()) {?>
								<div id="tags">
									<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
								</div>
							<?php }
							if (function_exists('getHitcounter')) { ?>
								<div id="hitcounter">
									<?php echo gettext("Views: ") . getHitcounter() . "\n";?>
								</div>
							<?php }
							if (function_exists('printLikeButton')) {
								printLikeButton();
							}
							if (function_exists('printCommentForm') && ($_zp_current_image->getCommentsAllowed() || getCommentCount())) { 
								$num = getCommentCount();
								if ($num == 0) {
									$comments = gettext('No Comments');
								} else {
									$comments = sprintf(ngettext('%u Comment', '%u Comments', $num), $num);
								}
								?>
								<div id="hitcounter">
									<a href="#addComment"><?php echo $comments; ?></a>
								</div>
								<div id="hitcounter">
									<a href="#addComment">Add Comment</a>
								</div>
							<?php }?>
						</div>
						<div class="clearing" ></div>
						<div id="imgtitle">
							<?php if (getOption('zenfluid_titlebreadcrumb')) {
								$parentalbum = $_zp_current_album->getParent();
								if(!empty($parentalbum)) {
									$parentAlbumTitle = $parentalbum->getTitle();
									echo "$parentAlbumTitle: ";
								}
								printAlbumTitle();
								echo ": ";
							}
							printImageTitle();
							if (getImageDesc()) {
								printImageDesc();
							}
							echo "\n"; ?>
						</div>
						<?php if (function_exists('printCommentForm') && ($_zp_current_image->getCommentsAllowed() || getCommentCount())) { ?>
							<a id="addComment"></a>
							<?php printCommentForm(true, '', false); ?>
						<?php }?>
					</div>
				</div>
			</div>
			<?php include("sidebar.php");?>
		</div>
		<?php include("footer.php");?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>
