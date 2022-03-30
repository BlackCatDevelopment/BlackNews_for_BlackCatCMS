<?php
/**
 *
 *
 * ,-----.  ,--.              ,--.    ,-----.          ,--.       ,-----.,--.   ,--. ,---.
 * |  |) /_ |  | ,--,--. ,---.|  |,-.'  .--./ ,--,--.,-'  '-.    '  .--./|   `.'   |'   .-'
 * |  .-.  \|  |' ,-.  || .--'|     /|  |    ' ,-.  |'-.  .-'    |  |    |  |'.'|  |`.  `-.
 * |  '--' /|  |\ '-'  |\ `--.|  \  \'  '--'\\ '-'  |  |  |      '  '--'\|  |   |  |.-'    |
 * `------' `--' `--`--' `---'`--'`--'`-----' `--`--'  `--'       `-----'`--'   `--'`-----'
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 3 of the License, or (at
 *   your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful, but
 *   WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 *   General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program; if not, see <http://www.gnu.org/licenses/>.
 *
 *   @author			Matthias Glienke
 *   @copyright		2022, Black Cat Development
 *   @link				https://github.com/BlackCatDevelopment/BlackNews_for_BlackCatCMS
 *   @license			https://www.gnu.org/licenses/gpl-3.0.html
 *   @category		CAT_Modules
 *   @package			blackNews
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

global $backend, $val, $users;

require_once "../../inc/class.blackNews.php";

blackNewsEntry::saveEntry();

$backend = CAT_Backend::getInstance("start", "start", false, false);
$val = CAT_Helper_Validate::getInstance();
$users = CAT_Users::getInstance();

$page_id = $val->sanitizePost("page_id", "numeric");
$section_id = $val->sanitizePost("section_id", "numeric");
$entryID = $val->sanitizePost("entryID", "numeric");
$values = $val->sanitizePost("values");

if (!$page_id || !$section_id || !$entryID) {
    exit();
}

$options = [
    "admin_groups" => "1,2",
    "description" => "",
    "keywords" => "",
    "language" => "DE",
    "level" => 0, // just a default here
    "link" => "/",
    "menu" => 1,
    "menu_title" => htmlspecialchars(
        $values["title"],
        ENT_QUOTES,
        "UTF-8",
        false
    ),
    "modified_by" => $users->get_user_id(),
    "modified_when" => time(),
    "page_title" => "",
    "parent" => $page_id,
    "position" => 1, // just a default here
    "searching" => "0",
    "target" => "_self",
    "template" => "",
    "variant" => null,
    "viewing_groups" => 1,
    "visibility" => "none",
];

// check titles
if (CAT_Helper_Page::sanitizeTitles($options) === false) {
    CAT_Object::json_error(
        $backend->lang()->translate("Please enter a menu title")
    );
    exit();
}

// changes the values in the options array
CAT_Helper_Page::sanitizeLink($options);
CAT_Helper_Page::sanitizeTemplate($options);
CAT_Helper_Page::sanitizeLanguage($options);

// Check if page already exists; checks access file, directory, and database
if (CAT_Helper_Page::exists($options["link"])) {
    CAT_Object::json_error(
        $backend
            ->lang()
            ->translate("A page with the same or similar link exists")
    );
    exit();
}

// ========================
// ! Validate page position
// ========================
require CAT_PATH . "/framework/class.order.php";
$order = new order(CAT_TABLE_PREFIX . "pages", "position", "page_id", "parent");

// First clean order
$order->clean($options["parent"]);

// Get new order
$options["position"] = $order->get_new($options["parent"]);

// ================================
// ! Insert page into pages table
// ================================
$newPage_id = CAT_Helper_Page::addPage($options);
if (!$newPage_id) {
    CAT_Object::json_error(
        $backend->lang()->translate("Unable to create the page: ") .
            $backend->db()->getError()
    );
    exit();
}

// Work out root parent
$root_parent = 12; //CAT_Helper_Page::getRootParent($newPage_id);
// Work out page trail
$page_trail = "12,12," . $newPage_id; //CAT_Helper_Page::getPageTrail($newPage_id);

$result = CAT_Helper_Page::updatePage($newPage_id, [
    "root_parent" => $root_parent,
    "page_trail" => $page_trail,
]);
if (!$result) {
    // try to recover = delete page
    CAT_Helper_Page::deletePage($newPage_id);
    CAT_Object::json_error($backend->db()->getError());
    exit();
}

// ====================
// ! Create access file
// ====================
$result = CAT_Helper_Page::createAccessFile(
    $options["link"],
    $newPage_id,
    $options["level"]
);
if (!$result) {
    // try to recover = delete page
    CAT_Helper_Page::deletePage($newPage_id);
    CAT_Object::json_error(
        $backend
            ->lang()
            ->translate(
                "Error creating access file in the pages directory, cannot open file"
            )
    );
    exit();
}

$module = "cc_catgallery";

// ==========================================
// ! Add new record into the sections table
// ==========================================
$backend
    ->db()
    ->query(
        sprintf(
            "INSERT INTO `%ssections` (`page_id`,`position`,`module`,`block`) VALUES ('%d','1', '%s','1')",
            CAT_TABLE_PREFIX,
            $newPage_id,
            $module
        )
    );

// ======================
// ! Get the section id
// ======================
$oldSection_id = $section_id;
$section_id = $backend->db()->lastInsertId();

// ======================================================
// ! Include the selected modules add file if it exists
// ======================================================
require_once "../../../cc_catgallery/inc/class.catgallery.php";
$catGallery = new catGallery(true);

// ==========================================
// ! Add new gallery _id to entry
// ==========================================
if ($catGallery) {
    $backend
        ->db()
        ->query(
            "INSERT INTO `:prefix:mod_blackNewsEntryOptions` " .
                '(`entryID`, `name`, `value`) VALUES ( :entryID, "catGallery", :value ) ' .
                "ON DUPLICATE KEY UPDATE `value` = :value",
            [
                "entryID" => $entryID,
                "value" => $catGallery->getGalleryID(),
            ]
        );
    foreach (
        [
            "title" => $values["title"],
            "variant" => "cubicGallery",
            "resize_y" => "240",
            "resize_x" => "240",
        ]
        as $k => $v
    ) {
        $backend
            ->db()
            ->query(
                "REPLACE INTO `:prefix:mod_cc_catgallery_options` " .
                    "SET `gallery_id`	= :gallery_id, " .
                    "`name`			= :name, " .
                    "`value`		= :value",
                [
                    "gallery_id" => $catGallery->getGalleryID(),
                    "name" => $k,
                    "value" => $v,
                ]
            );
    }
}
$section_id = $oldSection_id;
// ==============================
// ! Check if there is a db error
// ==============================
if ($backend->db()->isError()) {
    CAT_Object::json_error($backend->db()->getError());
    exit();
} else {
    // print success and redirect
    $ajax = [
        "message" => $backend->lang()->translate("Page added successfully"),
        "url" => CAT_ADMIN_URL . "/pages/modify.php?page_id=" . $newPage_id,
        "success" => true,
    ];
    echo json_encode($ajax);
    exit();
}
exit();

?>
