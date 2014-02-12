<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php zp_apply_filter('theme_head');
		printHeadTitle();?>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
</head>

	<body>
	
		<?php zp_apply_filter('theme_body_open');?>

			<div id="container">
			<div id="contents">
				<div id="imagecontent">
					<?php $doSlideShowLink = false;
					if (isImagePhoto()) {
						echo ImageJS(70);
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
							if (!empty($tburl)) { ?>
								<a href="<?php echo html_encode(pathurlencode($tburl)); ?>" <?php echo $boxclass; ?> title="<?php printBareImageTitle(); ?>">
							<?php }
							printCustomSizedImageMaxSpace(getBareImageTitle(),null,null,"imgheight");
							if (!empty($tburl)) {
								?></a><?php
							}?>
						</div>
					<?php } else { ?>
						<div id="video">
							<?php printCustomSizedImageMaxSpace(getBareImageTitle(),null,null);?>
						</div>
					<?php } ?>
					<div id="commentstage">
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
							} ?>
						</div>
						<div id="buttons">
							<?php if (hasPrevImage()) { ?>
								<div id="imgprevious"><a href="<?php echo html_encode(getPrevImageURL()); ?>" title="Previous Image">« Prev</a></div>
							<?php }
							if (hasNextImage()) { ?>
								<div id="imgnext"><a href="<?php echo html_encode(getNextImageURL()); ?>" title="Next Image">Next »</a></div>
							<?php }
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
									<?php printTags('links', 'Tags: ', 'taglist', ', ');?>
								</div>
							<?php }
							if (function_exists('getHitcounter')) { ?>
								<div id="hitcounter">
									<?php echo "Views: " . getHitcounter();?>
								</div>
							<?php }
							if (function_exists('printLikeButton')) {
								printLikeButton();
							} ?>
						</div>
						<div class="clearing" ></div>
						<?php if (function_exists('printCommentForm') && ($_zp_current_image->getCommentsAllowed() || getCommentCount())) {
							printCommentForm();
						}?>
					</div>
				</div>
			</div>
			<?php include("sidebar.php");?>
		</div>
		<?php include("footer.php");?>
	</body>
</html>
