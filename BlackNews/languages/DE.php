<?php
/**
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
 *   @copyright			2018, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			blackNews
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('CAT_PATH')) {
	include(CAT_PATH.'/framework/class.secure.php');
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) {
		include($root.'/framework/class.secure.php');
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

$LANG = array(
	'Add entry' => 'Neuer Eintrag',
	'Additional information' => 'Weitere Informationen',
	'Automatic publish' => 'Automatisches Veröffentlichen',
	'Automatically generate short content...' => 'Kurztext automatisch erzeugen...',
	'Category' => 'Kategorie',
	'Created by' => 'Erzeugt von',
	'Deleting entry' => 'Lösche Eintrag',
	'Description of RSS' => 'RSS Beschreibung',
	'Do you really want to delete this entry?' => 'Soll dieser Eintrag wirklich gelöscht werden?',
	'Entries in RSS file' => 'Einträge in RSS',
	'Entries per pages' => 'Einträge pro Seite',
	'Entry added successfully' => 'Eintrag erfolgreich hinzugefügt',
	'Full content' => 'Inhalt',
	'General options' => 'Allgemeine Einstellungen',
	'Image' => 'Bild',
	'Last update' => 'Letzte Änderung',
	'Main title' => 'Hauptüberschrift',
	'More options' => 'Weitere Optionen',
	'New entry'	=> 'Neuer Eintrag',
	'Number of characters for preview' => 'Anzahl Zeichen für Vorschau',
	'Options for RSS'	=> 'Optionen für RSS',
	'Published' => 'Veröffentlicht',
	'Publish on' => 'Veröffentlichen am',
	'Publish until' => 'Veröffentlichen bis',
	'Save options' => 'Einstellungen speichern',
	'Subtitle' => 'Unterzeile',
	'There was no picture added.' => 'Es wurde kein Bild hinzugefügt',
	'Title of RSS' => 'RSS Titel',
	'Unpublished' => 'Unveröffentlicht',
	'Last Update'	=> 'Aktualisiert am',
	'Read more'	=> 'Mehr lesen'
);
?>