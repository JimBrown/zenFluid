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
				<div id="content">
					<div id="imgtitle" style="text-align: center; margin-left: auto; margin-right: auto;">
						<?php printAlbumTitle();
						printAlbumDesc();?>
					</div>
					<?php printPageListWithNav(gettext("« prev"), gettext("next »"));?>
					<div id="albums">
						<?php $doslideshowlink = false;
						while (next_album()):?>
							<div id="album">
								<div id="albumthumb">
									<a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View album: '); printBareAlbumTitle();?>"><?php printAlbumThumbImage(getBareAlbumTitle()); ?></a>
									<div id="albumdesc">
										<a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View album: '); printBareAlbumTitle();?>"><?php printAlbumTitle(); ?></a>
										<br /><?php printAlbumDate("");
										echo shortenContent(getAlbumDesc(), 130,'...');?>
									</div>
								</div>
							</div>
						<?php endwhile;?>
					</div>
					<?php if (getOption('zenfluid_transitionnewrow')) { ?>
						<div class="clearing"></div>
					<?php } ?>
					<div id= "imagethumbs">
						<?php while (next_image()):
							if (isImagePhoto()) {
								if (getNumImages() > 1) {$doslideshowlink = true;}?>
								<div id="imagethumb">
									<a href="<?php echo html_encode(getImageURL());?>" title="<?php printBareImageTitle();?>"><?php printImageThumb(getBareImageTitle()); ?></a>
								</div>
							<?php } else { ?>
								<div id="album">
									<div id="albumthumb">
										<a href="<?php echo html_encode(getImageURL());?>" title="<?php echo gettext('View video: '); printBareImageTitle();?>"><?php printImageThumb(getBareImageTitle()); ?></a>
										<div id="albumdesc">
											<a href="<?php echo html_encode(getImageURL());?>" title="<?php echo gettext('View video: '); printBareImageTitle();?>"><?php printImageTitle(); ?></a>
											<br /><?php printImageDate("");
											echo shortenContent(getImageDesc(), 90,'...');?>
										</div>
									</div>
								</div>
							<?php }
						endwhile; ?>
					</div>
					<div class="clearing"></div>
					<?php printPageListWithNav(gettext("« prev"), gettext("next »"));
					if ($doslideshowlink && function_exists('printSlideShowLink')) { ?>
						<div id="buttons">
							<div id="slideshowlink" style="display: inline-block; float: none;">
								<?php printSlideShowLink();?>
							</div>
						</div>
					<?php }
					if(getTags()) {?>
						<div id="buttons">
							<div id="tags" style="display: inline-block; float: none;">
								<?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
							</div>
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