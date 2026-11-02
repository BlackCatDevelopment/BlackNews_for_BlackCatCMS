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
$bnLog = function (string $msg) {
    @file_put_contents(
        CAT_PATH . "/temp/logs/bn_prof.log",
        date("H:i:s") . " save.php " . $msg . "\n",
        FILE_APPEND | LOCK_EX
    );
};
$bnLog("start action=" . ($_POST["action"] ?? "?") . " entryID=" . ($_POST["entryID"] ?? "-") . " session=" . (session_status() === PHP_SESSION_ACTIVE ? "active" : "none"));

// save.php ist ein reiner AJAX/Formular-Endpunkt: Session immer sofort
// freigeben, sonst blockiert der Session-File-Lock parallele Requests.
if (session_status() === PHP_SESSION_ACTIVE) {
    session_write_close();
    $bnLog("session closed");
}

global $section_id;

$t0 = microtime(true);
register_shutdown_function(function () use ($bnLog, $t0) {
    $bnLog("done in " . round((microtime(true) - $t0) * 1000, 1) . "ms");
});
$blackNews = new blackNews($section_id);
$blackNews->save();

?>
