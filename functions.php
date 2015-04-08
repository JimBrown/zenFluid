<?php
  // force UTF-8 Ø

/**
 * Remove admin toolbox for all but site and album admins.
 */
if (!zp_loggedin(ADMIN_RIGHTS | MANAGE_ALL_ALBUM_RIGHTS)) zp_remove_filter('theme_body_close', 'adminToolbox');

/**
 * Returns an image for the home page
 *
 */
 function printHomepageImage($imageRoot, $imageRandom) {
  global $_zp_gallery;

  if ($imageRoot == '*All Albums*') $imageRoot = '';
  
  if (empty($imageRoot)) {
    if ($imageRandom) {
      $titleImage = getRandomImages();
    } else {
      $titleImage = getLatestImages();
    }
  } else if (is_dir(getAlbumFolder() . $imageRoot) && (!(count(glob(getAlbumFolder() . $imageRoot . "/*")) === 0))) {
    if ($imageRandom) {
      $titleImage = getRandomImagesAlbum($imageRoot);
    } else {
      $titleImage = getLatestImagesAlbum($imageRoot);
    }
  }
  if (isset($titleImage)) {
    echo '<a href="'.$titleImage->getLink().'"><img class="imgheight" src="'.$titleImage->getCustomImage(null, null, null, null, null, null, null).'" title="'.$titleImage->getTitle().'" /></a>';
  } else {
    debugLog('PrintHomepageImage: No images found in album path "' . $imageRoot .'"');
  }
 }

/**
 * Returns latest image from the album or its subalbums. (May be NULL if none exists. Cannot be used on dynamic albums.)
 *
 * @param mixed $rootAlbum optional album object/folder from which to get the image.
 *
 * @return object
 */
function getLatestImagesAlbum($rootAlbum = '') {
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

/**
 * Returns the latest selected image from the gallery. (May be NULL if none exists)
 *
 * @return object
 */
function getLatestImages() {
  global $_zp_gallery;
  if (zp_loggedin()) {
    $imageWhere = '';
  } else {
    $imageWhere = " AND " . prefix('images') . ".show=1";
  }
  $result = query('SELECT `folder`, `filename` ' .
          ' FROM ' . prefix('images') . ', ' . prefix('albums') .
          ' WHERE ' . prefix('albums') . '.folder!="" AND ' . prefix('images') . '.albumid = ' .
          prefix('albums') . '.id ' . $imageWhere . ' ORDER BY '.prefix("images").'.date DESC');

  $image = filterImageQuery($result, NULL);
  if ($image) {
    return $image;
  }
  return NULL;
}

function printFormattedGalleryDesc($galleryDesc = "") {
  $galleryDescFormatted = str_replace("[br]","<br />",$galleryDesc);
  echo $galleryDescFormatted;
  return;
}

/**
 * Javascript to resize the image whenever the browser is resized.
 */
function ImageJS() {
  $ImageJS = '
    <script type="text/javascript">
      // <!-- <![CDATA[
      /* Image resize functions */
      var viewportwidth;     
      var viewportheight;      
      var imgheight;      
      var headerheight = 0;
      var footerheight = 0;
      var titleheight = 0;
      function setStage(){
        if (typeof window.innerWidth != "undefined") {
          viewportwidth = window.innerWidth;
          viewportheight = window.innerHeight;
        } else if (typeof document.documentElement != "undefined" && typeof document.documentElement.clientWidth != "undefined" && document.documentElement.clientWidth != 0) {
          viewportwidth = document.documentElement.clientWidth;
          viewportheight = document.documentElement.clientHeight;
        } else {
          viewportwidth = document.getElementsByTagName("body")[0].clientWidth;
          viewportheight = document.getElementsByTagName("body")[0].clientHeight;
        }
        headerheight = $("#header").outerHeight(true);
        footerheight = $("#footer").outerHeight(true);
        titleheight = $("#imgtitle").outerHeight(true);
        if (!titleheight) {
          titleheight = 12;
        };
        if ($(".imgheight").css("max-height") !== undefined) {
          imgheight = viewportheight - headerheight - footerheight - titleheight;
          $(".imgheight").css({"max-height" : imgheight + "px"});
        };
      };
      $(document).ready(function() {
        setStage();
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
    $colorBoxJS = '    <script type="text/javascript">
      // <!-- <![CDATA[
      /* Colorbox */
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
    <a class="<?php echo $option; ?>_showless" style="display: none;"  href="javascript:toggleExtraElements('<?php echo $option; ?>',false);"><?php echo gettext('Show fewer results'); ?></a>
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
    /* Search results toggle */
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

/**
 * Cleans up the final HTML output.
 *
 * Based on code from the plugin headConsolidator by Stephan Billiard.
 *
 * Add the call to makeNeatStart() immediately after the <html> tag and a call
 * to makeNeatEnd() immediately before the </html> tag.
 *
 */
function makeNeatStart() {
  ob_start();
}

function makeNeatEnd() {
  $data = ob_get_contents();
  ob_end_clean();
  
  define("tabType", "Space"); // Can be "Space" or "Tab".
  $notJS = array();
  $notCSS = array();
  
  $theBody = makeNeat_extract($data, '~<body>(.*)</body>~msU');
  $body = $theBody[1][0];

  $matches = makeNeat_extract($data, '~<script(?:|\s*type="text/javascript"|)\s*src="(.*)"(?:|\s*type="text/javascript"|)\s*></script>~msU');
  foreach ($matches[0] as $key => $str) {
    if (strpos($str, 'text/javascript') === false) {
      $notJS[] = $matches[0][$key];
      unset($matches[1][$key]);
    }
  }
  $headJS = array();
  while (!empty($matches[1])) { // flush out the duplicates. Earliest wins
    $file = array_pop($matches[1]);
    $headJS[basename($file)] = $file;
  }
  $headJS = array_reverse($headJS);
  foreach ($headJS as $key => $headJSLine) {
    $headJS[$key] = '<script type="text/javascript" src="' . trim($headJSLine) . '"></script>';
  }

  $matches = makeNeat_extract($body, '~<script(?:|\s*type="text/javascript"|)\s*src="(.*)"(?:|\s*type="text/javascript"|)\s*></script>~msU');
  foreach ($matches[0] as $key => $str) {
    if (strpos($str, 'text/javascript') === false) {
      $notJS[] = $matches[0][$key];
      unset($matches[1][$key]);
    }
  }
  $bodyJS = array();
  while (!empty($matches[1])) { // flush out the duplicates. Earliest wins
    $file = array_pop($matches[1]);
    $bodyJS[basename($file)] = $file;
  }
  $bodyJS = array_reverse($bodyJS);
  foreach ($bodyJS as $key => $bodyJSLine) {
    $bodyJS[$key] = '<script type="text/javascript" src="' . trim($bodyJSLine) . '"></script>';
  }

  $matches = makeNeat_extract($data, '~<link\s*(?:|type="text/css"|)\s*rel="stylesheet"\s*href="(.*)"\s*(?:|type="text/css"|)(?:\s*)/>~msU');
  foreach ($matches[0] as $key => $str) {
    if (strpos($str, 'text/css') === false) {
      $notCSS[] = $matches[0][$key];
      unset($matches[1][$key]);
    }
  }
  $cs = array();
  while (!empty($matches[1])) { // flush out the duplicates. Earliest wins
    $file = array_pop($matches[1]);
    $cs[basename($file)] = $file;
  }
  $cs = array_reverse($cs);
  foreach ($cs as $key => $csLine) {
    $cs[$key] = '<link type="text/css" rel="stylesheet" href="' . trim($csLine) . '" />';
  }

  $jsi = array();
  $matches = makeNeat_extract($data, '~<script(?:\s*)type="text/javascript"(?:\s*)>(.*)</script>~msU');
  $inlinejs = $matches[1];
  if (!empty($inlinejs)) {
    if (empty($jsi)) array_push($jsi, '// <!-- <![CDATA[');
    foreach ($inlinejs as $somejs) {
      $somejs = str_replace('// <!-- <![CDATA[', '', $somejs);
      $somejs = str_replace('// ]]> -->', '', $somejs);
      $somejs = trim($somejs);
      $somejsbits = explode("\n",$somejs);
      $somejsbits = array_map('trim',$somejsbits);
      array_push($jsi, "/**/");
      foreach($somejsbits as $somejsbit) {
        if (!empty($somejsbit)) array_push($jsi, $somejsbit);
      }
    }
  }
  $matches = makeNeat_extract($body, '~<script(?:\s*)type="text/javascript"(?:\s*)>(.*)</script>~msU');
  $inlinejs = $matches[1];
  if (!empty($inlinejs)) {
    if (empty($jsi)) array_push($jsi, '// <!-- <![CDATA[');
    foreach ($inlinejs as $somejs) {
      $somejs = str_replace('// <!-- <![CDATA[', '', $somejs);
      $somejs = str_replace('// ]]> -->', '', $somejs);
      $somejs = trim($somejs);
      $somejsbits = explode("\n",$somejs);
      $somejsbits = array_map('trim',$somejsbits);
      array_push($jsi, "/**/");
      foreach($somejsbits as $somejsbit) {
        if (!empty($somejsbit)) array_push($jsi, $somejsbit);
      }
    }
  }
  if (!empty($jsi)) array_push($jsi, '// ]]> -->');

  $matches = makeNeat_extract($data, '~<title>(.*)</title>~msU');
  $title = $matches[0];
  foreach($title as $key => $line) {
    $line = trim($line);
    if (empty($line)) {
      unset($title[$key]);
    } else {
      $title[$key] = $line;
    }
  }

  $matches = makeNeat_extract($data, '~<meta (.*)>~msU');
  $meta = $matches[0];
  foreach($meta as $key => $line) {
    $line = trim($line);
    if (empty($line)) {
      unset($meta[$key]);
    } else {
      $meta[$key] = $line;
    }
  }
  asort($meta);

  $matches = makeNeat_extract($data, '~<head>(.*)</head>~msU');
  $unprocessed = explode("\n",$matches[1][0]);
  foreach ($unprocessed as $key => $line) {
    $line = trim($line);
    if (empty($line)) {
      unset($unprocessed[$key]);
    } else {
      $unprocessed[$key] = $line;
    }
  }

  $body = explode("\n", trim(preg_replace('/\s+/', ' ', $body)));
  foreach ($body as $key => $line) {
    $line = trim($line);
    if (empty($line)) {
      unset($body[$key]);
    } else {
      $body[$key] = $line;
    }
  }
  $body = array_values($body);

  $tabSize = 1;
  tabLine("<head>", $tabSize++);
  if (!empty($title) && !empty($meta)) {
    tabLine('<!-- ' . gettext('Title and Meta references') . " -->", $tabSize++);
    if (!empty($title)) {
      foreach ($title as $line) {
        tabLine($line, $tabSize);
      }
    }
    if (!empty($meta)) {
      foreach ($meta as $line) {
        tabLine($line, $tabSize);
      }
    }
    tabLine('<!-- ' . gettext('end of Title and Meta references') . " -->", --$tabSize);
  }
  if (!empty($cs)) {
    tabLine('<!-- ' . gettext('CSS references') . " -->", $tabSize++);
    foreach ($cs as $line) {
      tabLine($line, $tabSize);
    }
    tabLine('<!-- ' . gettext('end of CSS references') . " -->", --$tabSize);
  }
  if (!empty($notCSS)) {
    tabLine('<!-- ' . gettext('other Link references') . " -->", $tabSize++);
    foreach ($notCSS as $line) {
      tabLine($line, $tabSize);
    }
    tabLine('<!-- ' . gettext('end of other Link references') . " -->", --$tabSize);
  }
  if (!empty($headJS)) {
    tabLine('<!-- ' . gettext('external Javascript') . " -->", $tabSize++);
    foreach ($headJS as $line) {
      tabLine($line, $tabSize);
    }
    tabLine('<!-- ' . gettext('end of external Javascript') . " -->", --$tabSize);
  }
  if (!empty($notJS)) {
    tabLine('<!-- ' . gettext('other Script') . " -->", $tabSize++);
    foreach ($notJS as $line) {
      tabLine($line, $tabSize);
    }
    tabLine('<!-- ' . gettext('end of other Script') . " -->", --$tabSize);
  }
  if (!empty($unprocessed)) {
    tabLine('<!-- ' . gettext('unprocessed head items') . " -->", $tabSize++);
    foreach ($unprocessed as $line) {
      tabLine($line, $tabSize);
    }
    tabLine('<!-- ' . gettext('end of unprocessed head items') . " -->", --$tabSize);
  }
  tabLine("</head>", --$tabSize);
  tabLine("<body>", $tabSize++);
  tabBody($body, $tabSize);
  tabLine("</body>", --$tabSize);
  if (!empty($jsi)) {
    tabLine('<!-- ' . gettext('in-line Javascript') . " -->", $tabSize++);
    tabLine('<script type="text/javascript">', $tabSize++);
    tabScript($jsi, $tabSize);
    tabLine('</script>',--$tabSize);
    tabLine('<!-- ' . gettext('end of in-line Javascript') . " -->", --$tabSize);
  }
  if (!empty($bodyJS)) {
    tabLine('<!-- ' . gettext('external Javascript') . " -->", $tabSize++);
    foreach ($bodyJS as $line) {
      tabLine($line, $tabSize);
    }
    tabLine('<!-- ' . gettext('end of external Javascript') . " -->", --$tabSize);
  }
}

function makeNeat_extract(&$data, $pattern) {
  preg_match_all($pattern, $data, $matches);
  foreach ($matches[0] as $found) {
    $data = trim(str_replace($found, '', $data));
  }
  return $matches;
}

function tabLine($theLine, $tabSize) {
  switch (strtolower(tabType)) {
    case "space":
      echo str_pad($theLine, strlen($theLine) + $tabSize * 2, " ", STR_PAD_LEFT) . "\n";
      break;
    case "tab":
      echo str_pad($theLine, strlen($theLine) + $tabSize, "\t", STR_PAD_LEFT) . "\n";
      break;
  }
}

function tabScript($theLines,$tabSize) {
  // Pass 1: Split lines on ';' or '{'.
  $cnt1 = 0;
  $quoting = false;
  while ($cnt1 < count($theLines)) {
    $theLine = $theLines[$cnt1];
    $cnt2 = 0;
    while ($cnt2 < strlen($theLine)) {
      $char = $theLine[$cnt2];
      if ($char == '"' || $char == '"' || $quoting) {
        if (!$quoting) {
          $quote = $char;
          $quoting = true;
          $cnt2++;
        }
        do {
          if ($theLine[$cnt2++] == $quote) {
            $quoting = false;
            break;
          }
        } while ($cnt2 < strlen($theLine));
      } else {
        if ($char == '{' && strlen($theLine) == 1) {
          $theLines[$cnt1 - 1] = $theLines[$cnt1 - 1] . " " . $theLines[$cnt1];
          unset($theLines[$cnt1]);
          $theLines = array_values($theLines);
          $cnt1--;
          break;
        }
        if (($char == ';') && $cnt2 < strlen($theLine) - 1) {
          $theLines[$cnt1] = trim(substr($theLine, 0, $cnt2+1));
          array_splice($theLines, $cnt1+1, 0, trim(substr($theLine, $cnt2+1)));
          break;
        }
        $cnt2++;
      }
    }
    $cnt1++;
  }
  //Pass 2: Output lines with tabs.
  foreach ($theLines as $theLine) {
    if (substr($theLine,0,1) == "}" || substr($theLine,-1) == "}") $tabSize--;
    tabLine($theLine, $tabSize);
    if (substr($theLine,0,1) == "{" || substr($theLine,-1) == "{") $tabSize++;
  }
}

function tabBody($theLines,$tabSize) {
  // Pass 1: put all tags on their own line.
  $cnt1 = 0;
  $quoting = false;
  while ($cnt1 < count($theLines)) {
    $theLine = $theLines[$cnt1];
    $cnt2 = 0;
    while ($cnt2 < strlen($theLine)) {
      $char = $theLine[$cnt2];
      if ($char == '"' || $char == '"' || $quoting) {
        if (!$quoting) {
          $quote = $char;
          $quoting = true;
          $cnt2++;
        }
        do {
          if ($theLine[$cnt2++] == $quote) {
            $quoting = false;
            break;
          }
        } while ($cnt2 < strlen($theLine));
      } else {
        if ($char == ">" && $cnt2 + 1 < strlen($theLine)) {
          $theLines[$cnt1] = trim(substr($theLine, 0, $cnt2 + 1));
          array_splice($theLines, $cnt1+1, 0, trim(substr($theLine, $cnt2 + 1)));
          $theLines = array_values($theLines);
          break;
        }
        if ($char == "<" && $cnt2 > 0) {
          $theLines[$cnt1] = trim(substr($theLine, 0, $cnt2));
          array_splice($theLines, $cnt1+1, 0, trim(substr($theLine, $cnt2)));
          $theLines = array_values($theLines);
          break;
        }
        $cnt2++;
      }
    }
    $cnt1++;
  }

  //Pass 2: Concatenate selected tags back to single line.
  $openTags = array("<a ","<h1","<h2","<h3","<h4","<h5","<h6","<strong","<label","<textarea","<td","<tr>","<tr ","<p>","<p ","<li>","<li ","<option");
  $closeTags = array("</a>","</h1>","</h2>","</h3>","</h4>","</h5>","</h6>","</strong>","</label>","</textarea>","</td>","</tr>","</tr>","</p>","</p>","</li>","</li>","</option>");
  foreach ($openTags as $key => $openTag) {
    $closeTag = $closeTags[$key];
    $cnt1 = 0;
    $newLines = array();
    while ($cnt1 < count($theLines)) {
      $theLine = $theLines[$cnt1];
      if (substr($theLine,0,strlen($openTag)) == $openTag) {
        do {
          if (($openTag == "<li>" || $openTag == "<li ") && substr($theLines[$cnt1 + 1], 0, 3) == "<ul") break;
          $theLine = $theLine . $theLines[++$cnt1];
        } while ($theLines[$cnt1] != $closeTag);
      }
      $newLines[] = $theLine;
      $cnt1++;
    }
    $theLines = $newLines;
  }
  
  //Pass 3: Output lines with tabs.
  $openTags = array("<div","<table","<form","<span","<ul","<ol","<select");
  $closeTags = array("</div","</table","</form","</span","</ul","</ol","</select");
  foreach ($theLines as $theLine) {
    foreach ($closeTags as $closeTag) {
      if (substr($theLine, 0, strlen($closeTag)) == $closeTag) {
        $tabSize--;
        break;
      }
    }
    tabLine($theLine, $tabSize);
    foreach ($openTags as $openTag) {
      if (substr($theLine, 0, strlen($openTag)) == $openTag) {
        $tabSize++;
        break;
      }
    }
  }
}

/**
 * Records a raw Var to the debug log
 *
 * @param string $message message to insert in log [optional]
 * @param mixed $var the variable to record
 */
function debugLogRaw($message) {
	$args = func_get_args();
	if (count($args) == 1) {
		$var = $message;
		$message = '';
	} else {
		$message .= ' ';
		$var = $args[1];
	}
	ob_start();
	var_dump($var);
	$str = ob_get_contents();
	ob_end_clean();
	debugLog($message . $str);
}

?>