<?php 

/**
 * Remove admin toolbox for all but site and album admins.
 */
if (!zp_loggedin(ADMIN_RIGHTS | MANAGE_ALL_ALBUM_RIGHTS)) zp_remove_filter('theme_body_close', 'adminToolbox');
 
/**
 * Returns latest image from the album or its subalbums. (May be NULL if none exists. Cannot be used on dynamic albums.)
 *
 * @param mixed $rootAlbum optional album object/folder from which to get the image.
 *
 * @return object
 */
function getLatestImagesAlbum($rootAlbum = NULL) {
	global $_zp_current_album, $_zp_gallery, $_zp_current_search;
	if (empty($rootAlbum)) {
		$album = $_zp_current_album;
	} else {
		if (is_object($rootAlbum)) {
			$album = $rootAlbum;
		} else {
			$album = newAlbum($rootAlbum);
		}
	}
	$image = NULL;

	$albumfolder = $album->getFileName();
	if ($album->isMyItem(LIST_RIGHTS)) {
		$imageWhere = '';
		$albumInWhere = '';
	} else {
		$imageWhere = " AND " . prefix('images') . ".show=1";
		$albumInWhere = prefix('albums') . ".show=1";
	}

	$query = "SELECT id FROM " . prefix('albums') . " WHERE ";
	if ($albumInWhere)
		$query .= $albumInWhere . ' AND ';
	$query .= "folder LIKE " . db_quote(db_LIKE_escape($albumfolder) . '%');
	$result = query($query);
	if ($result) {
		$albumInWhere = prefix('albums') . ".id IN (";
		while ($row = db_fetch_assoc($result)) {
			$albumInWhere = $albumInWhere . $row['id'] . ", ";
		}
		db_free_result($result);
		$albumInWhere = ' AND ' . substr($albumInWhere, 0, -2) . ')';
		$sql = 'SELECT `folder`, `filename` ' .
						' FROM ' . prefix('images') . ', ' . prefix('albums') .
						' WHERE ' . prefix('albums') . '.folder!="" AND ' . prefix('images') . '.albumid = ' .
						prefix('albums') . '.id ' . $albumInWhere . $imageWhere . ' ORDER BY '.prefix("images").'.date DESC LIMIT 1';
		$result = query($sql);
		$image = filterImageQuery($result, $album->name);
	}
	return $image;
}

function printFormattedGalleryDesc($galleryDesc = "") {
	$galleryDescFormatted = str_replace("[br]","<br />",$galleryDesc);
	echo $galleryDescFormatted;
	return;
}

function ImageJS($footerHeight = 0) {
	$ImageJS = '
		<script type="text/javascript">
			// <!-- <![CDATA[
			var viewportwidth;
			var viewportheight;
			var imgheight
			function setStage(){
				if (typeof window.innerWidth != "undefined") {
					viewportwidth = window.innerWidth,
					viewportheight = window.innerHeight
				} else if (typeof document.documentElement != "undefined" && typeof document.documentElement.clientWidth != "undefined" && document.documentElement.clientWidth != 0) {
					viewportwidth = document.documentElement.clientWidth,
					viewportheight = document.documentElement.clientHeight
				} else {
					viewportwidth = document.getElementsByTagName("body")[0].clientWidth,
					viewportheight = document.getElementsByTagName("body")[0].clientHeight
				}
				if ($(".imgheight").css("max-height") !== undefined) {
					imgheight = viewportheight - ' . $footerHeight . '
					$(".imgheight").css({"max-height" : imgheight + "px"})
				};
			};
			$(document).ready(function() {
				setStage()
			});
			var resizeTimer;
			$(window).resize(function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(setStage, 100);
			});
			// ]]> -->
		</script>
	';
	return $ImageJS;
}

function colorBoxJS() {
		$colorBoxJS = '		<script type="text/javascript">
			// <!-- <![CDATA[
			$(document).ready(function() {
				$(".colorbox").colorbox({
					inline: true,
					href: "#imagemetadata",
					close: "' . gettext("close") . '"
				});
				$("a.thickbox").colorbox({
					maxWidth: "98%",
					maxHeight: "98%",
					photo: true,
					close: "' . gettext("close") . '"
				});
			});
			// ]]> -->
			</script>
			';
	return $colorBoxJS;
}
/**
 * Prints the "Show more results link" for search results for Zenpage items
 *
 * @param string $option "news" or "pages"
 * @param int $number_to_show how many search results should be shown initially
 */
function printZDSearchShowMoreLink($option, $number_to_show) {
	$option = strtolower($option);
	switch ($option) {
		case "news":
			$num = getNumNews();
			break;
		case "pages":
			$num = getNumPages();
			break;
	}
	if ($num > $number_to_show) {
		?>
		<a class="<?php echo $option; ?>_showmore"href="javascript:toggleExtraElements('<?php echo $option; ?>',true);"><?php echo gettext('Show more results'); ?></a>
		<a class="<?php echo $option; ?>_showless" style="display: none;"	href="javascript:toggleExtraElements('<?php echo $option; ?>',false);"><?php echo gettext('Show fewer results'); ?></a>
		<?php
	}
}

/**
 * Adds the css class necessary for toggling of Zenpage items search results
 *
 * @param string $option "news" or "pages"
 * @param string $c After which result item the toggling should begin. Here to be passed from the results loop.
 */
function printZDToggleClass($option, $c, $number_to_show) {
	$option = strtolower($option);
	$c = sanitize_numeric($c);
	if ($c > $number_to_show) {
		echo ' class="' . $option . '_extrashow" style="display:none;"';
	}
}
/**
 * Prints jQuery JS to enable the toggling of search results of Zenpage  items
 *
 */
function printZDSearchToggleJS() {
	?>
	<script type="text/javascript">
		// <!-- <![CDATA[
		function toggleExtraElements(category, show) {
			if (show) {
				jQuery('.' + category + '_showless').show();
				jQuery('.' + category + '_showmore').hide();
				jQuery('.' + category + '_extrashow').show();
			} else {
				jQuery('.' + category + '_showless').hide();
				jQuery('.' + category + '_showmore').show();
				jQuery('.' + category + '_extrashow').hide();
			}
		}
		// ]]> -->
	</script>
	<?php
}
?>