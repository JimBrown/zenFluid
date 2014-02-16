<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?php echo getBareGalleryTitle(); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
		<?php printZDSearchToggleJS(); ?>
		<?php zp_apply_filter('theme_head'); ?>
	</head>
	<body>

		<?php zp_apply_filter('theme_body_open');

		$zenpage = extensionEnabled('zenpage');
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
			if (getOption('Allow_search')) {
				$categorylist = $_zp_current_search->getCategoryList();
				if (is_array($categorylist)) {
					$catlist = array('news' => $categorylist, 'albums' => '0', 'images' => '0', 'pages' => '0');
					printSearchForm(NULL, 'search', NULL, gettext('Search category'), NULL, NULL, $catlist);
				} else {
					$albumlist = $_zp_current_search->getAlbumList();
					if (is_array($albumlist)) {
						$album_list = array('albums' => $albumlist, 'pages' => '0', 'news' => '0');
						printSearchForm(NULL, 'search', NULL, gettext('Search album'), NULL, NULL, $album_list);
					} else {
						printSearchForm("", "search", "", gettext("Search gallery"));
					}
				}
			}
		} ?>

		<div id="container">
			<div id="contents">
				<div id="content">
					<?php if ($total > 0 ) { ?>
						<div id="searchtitle">
							<?php printf(ngettext('%1$u Hit for <em>%2$s</em>','%1$u Hits for <em>%2$s</em>',$total), $total, html_encode($searchwords)); ?>
						</div>
					<?php }
					if ($_zp_page == 1) { //test of zenpage searches

						if ($numpages > 0) {
							$number_to_show = 5;
							$c = 0; ?>
							<div id="searchcategory">
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
							$number_to_show = 5;
							$c = 0; ?>
							<div id="searchcategory">
								<?php printf(gettext('Articles (%s)'), $numnews); ?>
								<span id="searchshowmore"><?php printZDSearchShowMoreLink("news", $number_to_show); ?></span>
								<ul class="searchresults">
									<?php while (next_news()) {
										$c++; ?>
										<li<?php printZDToggleClass('news', $c, $number_to_show); ?>>
											<?php printNewsURL(); ?>
											<p><?php echo shortenContent(strip_tags(getNewsContent()), 80, getOption("zenpage_textshorten_indicator")); ?> </p>
										</li>
									<?php } ?>
								</ul>
							</div>
						<?php }
						
					} 
					
					$doslideshowlink = false;
					if ($numalbums > 0) { ?>
					<div id="searchcategory">
						<?php printf(gettext('Albums (%s)'), $numalbums); ?>
					</div>
					<div id="albums">
						<?php while (next_album()){
							$doslideshowlink = false;?>
							<div id="album">
								<div id="albumthumb">
									<a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php echo 'View album: '; printBareAlbumTitle();?>"><?php printCustomAlbumThumbImage(getBareAlbumTitle(), NULL, 95, 95, 95, 95); ?></a>
									<div id="albumdesc">
										<a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php echo 'View album: '; printBareAlbumTitle();?>"><?php printAlbumTitle(); ?></a>
										<br /><?php printAlbumDate("");
										echo shortenContent(getAlbumDesc(), 90,'...');?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<?php } ?>
					<div class="clearing"></div>
					
					<?php if ($numimages > 0) { ?>
						<div id="searchcategory">
							<?php printf(gettext('Images (%s)'), $numimages); ?>
						</div>
						<div id= "imagethumbs">
							<?php while (next_image()){
								$doslideshowlink = true;?>
								<div id="imagethumb">
									<a href="<?php echo html_encode(getImageLinkURL());?>" title="<?php printBareImageTitle();?>"><?php printImageThumb(getBareImageTitle()); ?></a>
								</div>
							<?php } ?>
						</div>
					<?php }?>
					<div class="clearing"></div>

					<?php printPageListWithNav("« prev", "next »");
					if ($doslideshowlink) {?>
						<div id="slideshowlink">
							<?php printSlideShowLink();?>
						</div>
					<?php }
					if ($total == 0) { ?>
						<div id="searchtitle">
							<?php echo gettext("Sorry, no matches found. Try refining your search."); ?>
						</div>
					<?php } ?>
					
				</div>
			</div>
			<?php include("sidebar.php"); ?>
		</div>
		<?php include("footer.php");?>
	</body>
</html>