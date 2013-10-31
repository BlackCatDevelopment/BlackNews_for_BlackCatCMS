<?php

/**
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
 *   @author          Black Cat Development
 *   @copyright       2013, Black Cat Development
 *   @link            http://blackcat-cms.org
 *   @license         http://www.gnu.org/licenses/gpl.html
 *   @category        CAT_Modules
 *   @package         blackcatFilter
 *
 */

if (defined('CAT_PATH')) {	
	include(CAT_PATH.'/framework/class.secure.php'); 
} else {
	$root = "../";
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= "../";
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}

$module_description	  = 'Blacknews - ein Newsmodul für Blackcat CMS';

$LANG = array(
// --- overview descriptions ---
    'Read more...' => 'weiterlesen...',
// --- modify ---
    'Options' => 'Optionen',
    'Entries per pages' => 'Eintr&auml;ge pro Seite',
    'Variant' => 'Variante',
    'General options' => 'Allgemeine Einstellungen',
    'Add entry' => 'Neuer Artikel',
    'Saving entry' => 'Eintrag Speichern',
    'Save' => 'Speichern',
    'Published' => 'Ver&ouml;ffentlicht',
    'Unpublished' => 'Unver&uuml;ffentlicht',
    'Search' => 'Suche',
    'Delete' => 'L&ouml;schen',
    'Main title' => 'Titel',
    'Subtitle' => 'Untertitel',
    'More options' => 'Weitere Optionen',
    'Automatic publish' => 'Automatisch ver&ouml;ffentlichen',
    'Publish on' => 'Ver&ouml;ffentlichen ab',
    'Publish until' => 'Ver&ouml;ffentlichen bis',
    'Additional information' => 'Zus&auml;tzliche Informationen',
    'Category' => 'Kategorie',
    'Image' => 'Bild',
    'Automatically generate short content...' => 'Automatisch Kurztext generieren...',
    'Number of characters for preview' => 'Anzahl der Zeichen f&uuml;r die Vorschau',
    'Short content' => 'Kurztext',
    'Full content' => 'Langtext',
    'Created by' => 'Autor',
    'Last update' => 'Zuletzt ge&auml;ndert',
    'Version' => 'Version',
// --- modify ---
	'Back' => 'Zur&uuml;ck',
	'Nothing to show' => 'Keine Artikel vorhanden',

);