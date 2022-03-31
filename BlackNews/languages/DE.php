<?php
/**
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
  while ($level < 10 && !file_exists($root . "/framework/class.secure.php")) {
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

$LANG = [
  "Post" => "Eintrag",
  "Add entry" => "Neuer Eintrag",
  "Additional information" => "Weitere Informationen",
  "Automatic publish" => "Automatisches Ver&ouml;ffentlichen",
  "Automatically generate short content..." =>
    "Kurztext automatisch erzeugen...",
  "Category" => "Kategorie",
  "Created by" => "Erzeugt von",
  "Deleting entry" => "L&ouml;sche Eintrag",
  "Description of RSS" => "RSS Beschreibung",
  "Do you really want to delete this entry?" =>
    "Soll dieser Eintrag wirklich gel&ouml;scht werden?",
  "Entries in RSS file" => "Einträge in RSS",
  "Entries per pages" => "Einträge pro Seite",
  "Entry added successfully" => "Eintrag erfolgreich hinzugefügt",
  "Full content" => "Inhalt",
  "General options" => "Allgemeine Einstellungen",
  "Options saved" => "Optionen gespeichert",
  "Image" => "Bild",
  "Last update" => "Letzte Änderung",
  "Main title" => "Hauptüberschrift",
  "More options" => "Weitere Optionen",
  "New entry" => "Neuer Eintrag",
  "Number of characters for preview" => "Anzahl Zeichen für Vorschau",
  "Options for RSS" => "Optionen für RSS",
  "Published" => "Ver&ouml;ffentlicht",
  "Publish on" => "Ver&ouml;ffentlichen am",
  "Publish until" => "Ver&ouml;ffentlichen bis",
  "Save options" => "Einstellungen speichern",
  "There was no picture added." => "Es wurde kein Bild hinzugefügt",
  "Title of RSS" => "RSS Titel",
  "Unpublished" => "Unver&ouml;ffentlicht",
  "Last Update" => "Aktualisiert am",
  "Read more" => "Mehr lesen",
  "Admin categories" => "Kategorien verwalten",
  "Save categories" => "Kategorien speichern",
  "Set skin" => "Variante wählen",
  "Save skin &amp; reload" => "Speichern &amp; neuladen",
  "Title" => "Titel",
  "Subtitle" => "Untertitel",
  "Permalink" => "Permalink",
  "Usergroup of editors" => "Gruppe der Redakteure",
  "Will be set automatically on first save" =>
    "Wir beim ersten Speichern automatisch generiert",
  "your image here or click to upload" =>
    "Für Upload ein Bild in dieses Feld ziehen",
  "Description" => "Beschreibung",
  "Category" => "Kategorie",
  "No category" => "Keine Kategorie",
  "Entry" => "Eintrag",
  "Select user" => "Benutzer w&auml;hlen:",
  "<strong>Hint:</strong> The post is optionally displayed in the specified period if it was switched online using the button at the top right." =>
    "<strong>Hinweis:</strong> Der Beitrag wird optional im angegebenen Zeitraum angezeigt, wenn er über den Button oben rechts online geschalten wurde.",
];
?>
