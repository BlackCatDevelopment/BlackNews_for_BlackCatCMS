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
 *   @module			blacknews
 *   @version			see info.php of this module
 *   @author			Matthias Glienke, letima development
 *   @copyright		2026, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
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
    if (file_exists($root . "framework/class.secure.php")) {
        include $root . "framework/class.secure.php";
    } else {
        throw new \RuntimeException(
            sprintf(
                "Cannot include class.secure.php at %s",
                $_SERVER["SCRIPT_NAME"]
            )
        );
    }
}
// end include class.secure.php

require_once "inc/class.blackNews.php";
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Request-Logging fuer Hanging-Diagnose (immer aktiv, eine Zeile pro Call)
    @file_put_contents(
        date("H:i:s") . " save.php " . $msg . "\n",
        FILE_APPEND | LOCK_EX
    );
};

// Nur bei echten AJAX-Requests die Session sofort freigeben (Session-Lock).
// Bei Nicht-AJAX darf sie nicht geschlossen werden, sonst greift das CMS
// danach auf Session-Daten zu und routet auf die Backend-Seite (volle HTML-
// Antwort statt JSON).
if (isset($_POST["_cat_ajax"]) && session_status() === PHP_SESSION_ACTIVE) {
    session_write_close();
}

global $section_id;

$blackNews = new blackNews($section_id);
$blackNews->save();

?>
