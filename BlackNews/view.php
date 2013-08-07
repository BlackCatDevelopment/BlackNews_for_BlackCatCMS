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
$val		= CAT_Helper_Validate::getInstance();

$parser_data	= array(
	'CAT_URL'				=> CAT_URL,
	'CAT_PATH'				=> CAT_PATH,
	'page_id'				=> $page_id,
	'section_id'			=> $section_id
);

$news_id		= $val->sanitizeGet('news_id','numeric');
$page			= $val->sanitizeGet('page','numeric');

$options		= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_options
					WHERE section_id = '$section_id'");

if ( isset($options) && $options->numRows() > 0)
{
	$parser_data['options']	= array();

	while( !false == ($row = $options->fetchRow( MYSQL_ASSOC ) ) )
	{
		$parser_data['options'][$row['name']]	= $row['value'];
	}
}

if ( !$news_id )
{
	$entries_per_page	= $parser_data['options']['entries_per_page'] > 0 ?
							$parser_data['options']['entries_per_page'] : 10;

	$entries			= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_entry
							WHERE section_id = '$section_id' AND
							active = '1'
							ORDER BY created DESC
							LIMIT " . $entries_per_page );
}
else {
	$entries			= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_entry
							WHERE section_id = '$section_id' AND news_id = '$news_id'");
}

if ( isset($entries) && $entries->numRows() > 0)
{
	$parser_data['entries']	= array();
	$news_ids				= array();

	while( !false == ($row = $entries->fetchRow( MYSQL_ASSOC ) ) )
	{
		$user	= $userHelper->get_user_details( $row['created_by'] );

		$news_ids[]		= $row['news_id'];

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


if ( isset($news_ids) && count($news_ids) > 0 )
{
	$select	= '';
	foreach ( $news_ids as $id )
	{
		$select	.= ' OR news_id = ' . $id;
	}
	$select		= 'AND (' . substr($select, 3) . ')';
	
	$options	= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_content_options
						WHERE section_id = '$section_id'" . $select );
	
	if ( isset($options) && $options->numRows() > 0)
	{
		while( !false == ($row = $options->fetchRow( MYSQL_ASSOC ) ) )
		{
			$parser_data['entries'][$row['news_id']]	= array(
				$row['name']		=> $row['value']
			);
		}
	}

	$contents	= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_content
						WHERE section_id = '$section_id'" . $select );
	
	if ( isset($contents) && $contents->numRows() > 0)
	{
		while( !false == ($row = $contents->fetchRow( MYSQL_ASSOC ) ) )
		{
			$parser_data['entries'][$row['news_id']]	= array_merge(
				$parser_data['entries'][$row['news_id']],
				array(
					'title'					=> stripcslashes( htmlspecialchars( $row['title'] ) ),
					'subtitle'				=> stripcslashes( htmlspecialchars( $row['subtitle'] ) ),
					'image_path'			=> $row['image'] != '' ? 
												CAT_PATH . MEDIA_DIRECTORY . '/blacknews/' . $row['image'] : '',
					'image_url'				=> $row['image'] != '' ?
												CAT_URL . MEDIA_DIRECTORY . '/blacknews/' . $row['image'] : '',
					'auto_generate'			=> $row['auto_generate'] == 0 ? false : true,
					'auto_generate_size'	=> $row['auto_generate_size'],
					'short'					=> $row['auto_generate'] == 0 ?
														stripcslashes( $row['short'] ) :
														substr( stripcslashes ( $row['content'] ), 0, $row['auto_generate_size'] ) . '...',
					'content'				=> stripcslashes( $row['content'] )
				)
			);
		}
	}
}
$parser_data['pagelink']	= $PageHelper->getLink( $page_id );


$variant	= $parser_data['options']['variant'] != '' ? $parser_data['options']['variant'] : 'default';
$template	= $news_id != '' ? 'entry' : 'overview';

$parser_data['entry']	= $news_id != '' ? $parser_data['entries'][$news_id] : NULL;

$parser->setPath( dirname(__FILE__) . '/templates/' . $variant );

$parser->output(
	$template,
	$parser_data
);


?>
