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

$val		= CAT_Helper_Validate::getInstance();
//$userHelper	= CAT_Users::getInstance();
$backend	= CAT_Backend::getInstance('Pages', 'pages_modify', false);
//$dateHelper	= CAT_Helper_DateTime::getInstance();
//$PageHelper	= CAT_Helper_Page::getInstance();

header('Content-type: application/json');

$news_id				= $val->sanitizePost('news_id','numeric');
$section_id				= $val->sanitizePost('section_id','numeric');

// Get page id
if ( !$news_id || !$section_id )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate('You sent an invalid value'),
		'success'	=> false
	);
	print json_encode( $ajax );
	exit();
}

include_once( '../class.news.php' );

$BlackNews	= new BlackNews( $news_id );


// Get the content and options of the entry by news_id
$getValues			= $BlackNews->getEntries( $news_id );
$ajax['values']		= $getValues[$news_id];

// Set section_id
$ajax['section_id']	= $section_id;

/*
$ajax['options']	= $BlackNews->getOptions();

$entries	= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_entry
					WHERE news_id = '$news_id'");

if ( isset($entries) && $entries->numRows() > 0)
{
	if ( !false == ($row = $entries->fetchRow( MYSQL_ASSOC ) ) )
	{
		$user	= $userHelper->get_user_details( $row['created_by'] );

		$ajax['values']	= array(
			'news_id'		=> $news_id,
			'section_id'	=> $section_id,
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
					WHERE news_id = '$news_id'");

if ( isset($contents) && $contents->numRows() > 0)
{
	while( !false == ($row = $contents->fetchRow( MYSQL_ASSOC ) ) )
	{
		$ajax['values']	= array_merge(
			$ajax['values'], array (
				'title'					=> stripcslashes( $row['title'] ),
				'subtitle'				=> stripcslashes( $row['subtitle'] ),
				'image'					=> $row['image'] != '' ?
											CAT_URL . MEDIA_DIRECTORY . '/blacknews/' . $row['image'] : '',
				'auto_generate'			=> $row['auto_generate'] == 0 ? false : true,
				'auto_generate_size'	=> $row['auto_generate_size'],
				'content_short'			=> stripcslashes( $row['short'] ),
				'content'				=> stripcslashes( $row['content'] )
			)
		);
	}
}
*/


/*$options	= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_content_options
					WHERE news_id = '$news_id'");

if ( isset($options) && $options->numRows() > 0)
{
	while( !false == ($row = $options->fetchRow( MYSQL_ASSOC ) ) )
	{
		$ajax['options'][]	= array(
			$row['name']		=> $row['value']
		);
	}
}*/

$ajax['message']	= $backend->lang()->translate('Loading successful');
$ajax['success']	= true;

print json_encode( $ajax );
exit();

?>