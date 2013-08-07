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

$PageHelper	= CAT_Helper_Page::getInstance();
$userHelper	= CAT_Users::getInstance();
$dateHelper	= CAT_Helper_DateTime::getInstance();


$parser_data	= array(
	'CAT_URL'				=> CAT_URL,
	'CAT_PATH'				=> CAT_PATH,
	'CAT_ADMIN_URL'			=> CAT_ADMIN_URL,
	'page_id'				=> $page_id,
	'section_id'			=> $section_id,
	'version'				=> CAT_Helper_Addons::getModuleVersion('blacknews'),
	'variants'				=> array(
		'default',
		'custom'
	)
);


// =============================== 
// ! Get columns in this section   
// =============================== 

$entries	= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_entry
					WHERE section_id = '$section_id' ORDER BY created DESC");

if ( isset($entries) && $entries->numRows() > 0)
{
	$parser_data['entries']	= array();

	while( !false == ($row = $entries->fetchRow( MYSQL_ASSOC ) ) )
	{
		$user	= $userHelper->get_user_details( $row['created_by'] );

		$parser_data['entries'][$row['news_id']]	= array(
			'news_id'		=> $row['news_id'],
			'active'		=> $row['active'] == 0 ? false : true,
			'start'			=> $dateHelper->getDateTime( $row['start'] ),
			'end'			=> $dateHelper->getDateTime( $row['end'] ),
			'created'		=> $dateHelper->getDateTime( $row['created'] ),
			'updated'		=> $dateHelper->getDateTime( $row['updated'] ),
			'created_by'	=> $user['username'],
			'categories'	=> $row['categories'],
			'highlight'		=> $row['highlight']
		);
	}
}



$contents	= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_content
					WHERE section_id = '$section_id'");

if ( isset($contents) && $contents->numRows() > 0)
{
	while( !false == ($row = $contents->fetchRow( MYSQL_ASSOC ) ) )
	{
		$parser_data['entries'][$row['news_id']]	= array_merge(
			$parser_data['entries'][$row['news_id']],
			array(
				'title'					=> htmlspecialchars( $row['title'] ),
				'subtitle'				=> htmlspecialchars( $row['subtitle'] ),
				'image'					=> $row['image'],
				'auto_generate_size'	=> $row['auto_generate_size'],
				'auto_generate'			=> $row['auto_generate'] == 1 ? true : false,
				'short'					=> htmlspecialchars( $row['short'] ),
				'content'				=> htmlspecialchars( $row['content'] )
			)
		);
	}
}

$options	= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_options
					WHERE section_id = '$section_id'");

if ( isset($options) && $options->numRows() > 0)
{
	$parser_data['options']	= array();

	while( !false == ($row = $options->fetchRow( MYSQL_ASSOC ) ) )
	{
		$parser_data['options'][$row['name']]	= $row['value'];
	}
}

$options	= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_content_options
					WHERE section_id = '$section_id'");

if ( isset($options) && $options->numRows() > 0)
{
	while( !false == ($row = $options->fetchRow( MYSQL_ASSOC ) ) )
	{
		$parser_data['entries'][$row['news_id']]	= array(
			$row['name']		=> $row['value']
		);
	}
}

$parser_data['WYSIWYG']		= array(
	'long'			=> 'blacknews_long_' . $section_id,
	'short'			=> 'blacknews_short_' . $section_id,
	'short_width'	=> '100%',
	'short_height'	=> '150px',
	'long_width'	=> '100%',
	'long_height'	=> '300px'

);

$parser->setPath( dirname(__FILE__) . '/templates/default' );

$parser->output(
	'modify',
	$parser_data
);

?>