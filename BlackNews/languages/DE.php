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
	'Last Update'	=> 'Aktualisiert am'
);
?>