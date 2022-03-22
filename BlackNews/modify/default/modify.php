<?php
/**
 * This file is part of an ADDON for use with Black Cat CMS Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module			blacknews
 * @version			see info.php of this module
 * @author			Matthias Glienke, creativecat
 * @copyright		2013, Black Cat Development
 * @link			http://blackcat-cms.org
 * @license			http://www.gnu.org/licenses/gpl.html
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined("CAT_PATH")) {
  include CAT_PATH . "/framework/class.secure.php";
} else {
  $oneback = "../";
  $root = $oneback;
  $level = 1;
  while ($level < 10 && !file_exists($root . "framework/class.secure.php")) {
    $root .= $oneback;
    $level += 1;
  }
  if (file_exists($root . "/framework/class.secure.php")) {
    include $root . "/framework/class.secure.php";
  } else {
    trigger_error(
      sprintf(
        "[ <b>%s</b> ] Can't include class.secure.php!",
        $_SERVER["SCRIPT_NAME"]
      ),
      E_USER_ERROR
    );
  }
}
// end include class.secure.php

global $page_id;

$gal = [];

$getGal = CAT_Helper_Page::getInstance()
  ->db()
  ->query(
    "SELECT DISTINCT main.`gallery_id`, opt.`value` as 'title' FROM `:prefix:mod_cc_catgallery` main " .
      "LEFT JOIN `:prefix:mod_cc_catgallery_options` opt " .
      "ON opt.`gallery_id` = main.`gallery_id` " .
      "WHERE main.`section_id` IN " .
      "(SELECT `section_id` FROM `:prefix:sections` se LEFT JOIN `:prefix:pages` pa ON pa.`page_id` = se.`page_id` WHERE pa.`parent`= :parent ) " .
      "AND opt.`name` = 'title' ORDER BY main.`gallery_id` DESC",
    [
      "parent" => $page_id,
    ]
  );

if ($getGal && $getGal->rowCount() > 0) {
  while (!false == ($id = $getGal->fetch())) {
    $gal[$id["gallery_id"]] = $id["title"];
  }
}

blackNews::setParserValue("galleries", $gal);

?>
