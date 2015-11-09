<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
	<head>
		<?php include("inc-head.php");?>
		<?php printZDSearchToggleJS(); ?>
	</head>
	<body>

		<?php include("header.php");?>

		<?php $zenpage = extensionEnabled('zenpage');
		$numimages = getNumImages();
		$numalbums = getNumAlbums();
		$total = $numimages + $numalbums;
		if ($zenpage && !isArchive()) {
			$numpages = getNumPages();
			$numnews = getNumNews();
			$total = $total + $numnews + $numpages;
		} else {
			$numpages = $numnews = 0;
		}
		if ($total == 0) {
			$_zp_current_search->clearSearchWords();
		}

		$searchwords = getSearchWords();
		$searchdate = getSearchDate();
		if (!empty($searchdate)) {
			if (!empty($searchwords)) {
				$searchwords .= ": ";
			}
			$searchwords .= $searchdate;
		} ?>

		<div id="container">
			<div id="contents">
				<?php if ($total > 0 ) { ?>
					<div id="title" class="border colour">
						<?php printf(ngettext('%1$u Hit for <em>%2$s</em>','%1$u Hits for <em>%2$s</em>',$total), $total, html_encode($searchwords)); ?>
					</div>
				<?php }
				if ($_zp_page == 1) { //test of zenpage searches

					if ($numpages > 0) {
						$number_to_show = 1;
						$c = 0; ?>
						<div id="title" class="border colour">
							<?php printf(gettext('Pages (%s)'), $numpages);?>
							<span id="searchshowmore"><?php printZDSearchShowMoreLink("pages", $number_to_show); ?></span>
							<ul class="searchresults">
								<?php while (next_page()) {
									$c++; ?>
									<li<?php printZDToggleClass('pages', $c, $number_to_show); ?>>
										<?php printPageURL(); ?>
										<p><?php echo shortenContent(strip_tags(getPageContent()), 150, getOption("zenpage_textshorten_indicator")); ?> </p>
									</li>
								<?php }	?>
							</ul>
						</div>
					<?php }
					
					if ($numnews > 0) {
						$number_to_show = 1;
						$c = 0; ?>
						<div id="buttons">
							<div id="button" class="border colour" style="font-size: 18px;">
								<?php printf(gettext('Articles (%s)'), $numnews); ?>
							</div>
							<?php if ($numnews > $number_to_show) { ?>
								<div id="button" class="border colour" style="font-size: 18px;">
									<span id="searchshowmore"><?php printZDSearchShowMoreLink("news", $number_to_show); ?></span>
								</div>
							<?php } ?>
						</div>
						<div class="clearing"></div>
						<?php while (next_news()) :
							$c++; ?>
							<div <?php printZDToggleClass('news', $c, $number_to_show); ?>>
								<div id="thumbs" class="border">
									<a href="<?php echo html_encode(getNewsURL());?>" title="<?php echo gettext('View: '); printNewsTitle();?>">
										<div id="articlethumb">
											<?php printNewsTitle(); ?>
											<p><?php echo shortenContent(strip_tags(getNewsContent()), 180, getOption("zenpage_textshorten_indicator")); ?> </p>
										</div>
									</a>
								</div>
							</div>
						<?php endwhile; ?>
						<div class="clearing"></div>
					<?php }
					
				}
				if ($numalbums > 0) { ?>
					<div id="title" class="border colour">
						<?php printf(gettext('Albums (%s)'), $numalbums); ?>
					</div>
					<div id="albums">
						<?php while (next_album()) : ?>
							<div id="thumbs" class="border colour">
								<a href="<?php echo html_encode(getAlbumURL());?>" title="<?php echo gettext('View: '); printBareAlbumTitle();?>">
									<div id="thumbimage">
										<?php printAlbumThumbImage(getBareAlbumTitle(),"border"); ?>
										<div id="thumbtitle">
											<?php $numItems = getNumImages() + getNumAlbums();
											printAlbumTitle(); echo ' (' . $numItems . ')';
											echo shortenContent(getAlbumDesc(), 100,'...');?>
										</div>
									</div>
								</a>
							</div>
						<?php endwhile; ?>
					</div>
				<?php } ?>
				<div class="clearing"></div>
				
				<?php if ($numimages > 0) { ?>
					<div id="title" class="border colour">
						<?php printf(gettext('Images and Videos (%s)'), $numimages); ?>
					</div>
					<?php while (next_image()): ?>
						<div id="thumbs" class="border">
							<a href="<?php echo html_encode(getImageURL());?>" title="<?php echo gettext('View: '); printBareImageTitle();?>">
								<div id="thumbimage">
									<?php printImageThumb(getBareImageTitle(),"border");
									if (isImageVideo()) { ?>
										<img id="videoplay" src="<?php echo $_zp_themeroot; ?>/images/videoplay.png">
									<?php } ?>
									<div id="thumbtitle">
										<?php printImageTitle();
										echo shortenContent(getImageDesc(), 100,'...');?>
									</div>
								</div>
							</a>
						</div>
					<?php endwhile; ?>
				<?php }?>
				<div class="clearing"></div>
				<div id="buttons">
					<?php if (hasPrevPage() || hasNextPage()) { ?>
						<div id="button" class="border colour">
							<?php printPageListWithNav("Prev ", " Next", false, true, 'taglist', NULL, true); ?>
						</div>
					<?php } ?>
				</div>
				<?php if ($total == 0) { ?>
					<div id="title" class="border colour">
						<?php echo gettext("Sorry, no matches found. Try refining your search."); ?>
					</div>
				<?php } ?>
			</div>
			<?php include("sidebar.php"); ?>
		</div>
		<?php include("footer.php");?>
	</body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>