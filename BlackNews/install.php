<?php
/**
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
 *   @copyright			2016, Black Cat Development
 *   @link				http://blackcat-cms.org
 *   @license			http://www.gnu.org/licenses/gpl.html
 *   @category			CAT_Modules
 *   @package			blacknews
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

if(defined('CAT_URL'))
{
	$page_helper	= CAT_Helper_Page::getInstance();

	// Create table
	$page_helper->db()->query("DROP TABLE IF EXISTS `" . CAT_TABLE_PREFIX . "mod_blacknews_entry`");
	$mod_create_table = 'CREATE TABLE  `'.CAT_TABLE_PREFIX.'mod_blacknews_entry` ('
		. ' `news_id` INT NOT NULL AUTO_INCREMENT,'
		. ' `page_id` INT NOT NULL DEFAULT \'0\','
		. ' `section_id` INT NOT NULL DEFAULT \'0\','
		. ' `active` TINYINT(1) NOT NULL,'
		. ' `start` INT NOT NULL,'
		. ' `end` INT NOT NULL,'
		. ' `created` INT NOT NULL,'
		. ' `updated` INT NOT NULL,'
		. ' `created_by` INT NOT NULL,'
		. ' `categories` VARCHAR(2048) NOT NULL DEFAULT \'\','
		. ' `highlight` TINYINT(1) NOT NULL,'
		. ' `position` INT NOT NULL,'
		. ' PRIMARY KEY ( `news_id` )'
		. ' )';
	$page_helper->db()->query($mod_create_table);

	// Create table
	$page_helper->db()->query("DROP TABLE IF EXISTS `" . CAT_TABLE_PREFIX . "mod_blacknews_content`");
	$mod_create_table = 'CREATE TABLE  `'.CAT_TABLE_PREFIX.'mod_blacknews_content` ('
		. ' `id` INT NOT NULL AUTO_INCREMENT,'
		. ' `news_id` INT NOT NULL DEFAULT \'0\','
		. ' `page_id` INT NOT NULL DEFAULT \'0\','
		. ' `section_id` INT NOT NULL DEFAULT \'0\','
		. ' `title` VARCHAR(1024) NOT NULL DEFAULT \'\','
		. ' `subtitle` VARCHAR(2047) NOT NULL DEFAULT \'\','
        . '	`image` VARCHAR(2047) NOT NULL DEFAULT \'\','
		. ' `auto_generate` TINYINT(1) NOT NULL DEFAULT \'1\','
		. ' `auto_generate_size` INT NOT NULL DEFAULT \'300\','
		. ' `short` TEXT NOT NULL,'
		. ' `content` TEXT NOT NULL,'
		. ' `text` TEXT NOT NULL ,'
		. ' PRIMARY KEY ( `id` )'
		. ' )';
	$page_helper->db()->query($mod_create_table);

	// Create table
	$page_helper->db()->query("DROP TABLE IF EXISTS `" . CAT_TABLE_PREFIX . "mod_blacknews_content_options`");
	$mod_create_table = 'CREATE TABLE  `'.CAT_TABLE_PREFIX.'mod_blacknews_content_options` ('
		. ' `news_id` INT NOT NULL DEFAULT \'0\','
		. ' `page_id` INT NOT NULL DEFAULT \'0\','
		. ' `section_id` INT NOT NULL DEFAULT \'0\','
		. ' `name` VARCHAR(127) NOT NULL DEFAULT \'\','
		. ' `value` VARCHAR(2047) NOT NULL DEFAULT \'\','
		. ' PRIMARY KEY ( `news_id`, `page_id`, `section_id`, `name` )'
		. ' )';
	$page_helper->db()->query($mod_create_table);

	// Create table
	$page_helper->db()->query("DROP TABLE IF EXISTS `" . CAT_TABLE_PREFIX . "mod_blacknews_options`");
	$mod_create_table = 'CREATE TABLE  `'.CAT_TABLE_PREFIX.'mod_blacknews_options` ('
		. ' `page_id` INT NOT NULL DEFAULT \'0\','
		. ' `section_id` INT NOT NULL DEFAULT \'0\','
		. ' `name` VARCHAR(127) NOT NULL DEFAULT \'\','
		. ' `value` VARCHAR(2047) NOT NULL DEFAULT \'\','
		. ' PRIMARY KEY ( `page_id`, `section_id`, `name` )'
		. ' )';
	$page_helper->db()->query($mod_create_table);

	$mod_search = "SELECT * FROM " . CAT_TABLE_PREFIX . "search  WHERE value = 'blacknews'";
	$insert_search = $database->query($mod_search);
	if( $insert_search->numRows() == 0 )
	{
		// Insert info into the search table
		// Module query info
		$field_info = array();
		$field_info['page_id']			= 'page_id';
		$field_info['title']			= 'page_title';
		$field_info['link']				= 'link';
		$field_info['description']		= 'description';
		$field_info['modified_when']	= 'modified_when';
		$field_info['modified_by']		= 'modified_by';

		$field_info = serialize($field_info);

		$database->query("INSERT INTO " . CAT_TABLE_PREFIX . "search
			(name,value,extra) VALUES
			('module', 'blacknews', '$field_info')");
		// Query start
		$query_start_code = "SELECT [TP]pages.page_id, [TP]pages.page_title, [TP]pages.link, [TP]pages.description, [TP]pages.modified_when, [TP]pages.modified_by FROM [TP]mod_blacknews_content, [TP]pages WHERE ";
		$database->query("INSERT INTO " . CAT_TABLE_PREFIX . "search (name,value,extra) VALUES ('query_start', '$query_start_code', 'blacknews')");
		// Query body
		$query_body_code = " [TP]pages.page_id = [TP]mod_blacknews_content.page_id AND [TP]mod_blacknews_content.text [O] \'[W][STRING][W]\' AND [TP]pages.searching = \'1\'";
		$database->query("INSERT INTO " . CAT_TABLE_PREFIX . "search
			(name,value,extra) VALUES
			('query_body', '$query_body_code', 'mod_blacknews_content')");

		// Query end
		$query_end_code = "";
		$database->query("INSERT INTO " . CAT_TABLE_PREFIX . "search
			(name,value,extra) VALUES
			('query_end', '$query_end_code', 'mod_blacknews_content')");

		// Insert blank row (there needs to be at least on row for the search to work)
		$database->query("INSERT INTO " . CAT_TABLE_PREFIX . "mod_blacknews_content
			(`page_id`, `section_id`, `content`, `text`) VALUES
			('0','0', '', '')");
	}
	// add files to class_secure
	$addons_helper = new CAT_Helper_Addons();
	foreach(
		array(
		/*	'ajax/add_entry.php',
			'ajax/delete_entry.php',
			'ajax/get_info.php',
			'ajax/publish.php',
			'ajax/reorder.php',
			'ajax/save.php'*/
			'save.php'
		)
		as $file
	) {
		if ( false === $addons_helper->sec_register_file( 'blacknews', $file ) )
		{
			 error_log( "Unable to register file -$file-!" );
		}
	}
}

?>