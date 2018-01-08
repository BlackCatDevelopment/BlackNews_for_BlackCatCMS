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

$backend	= CAT_Backend::getInstance('Pages', 'pages_modify', false);

$val		= CAT_Helper_Validate::getInstance();
$userHelper	= CAT_Users::getInstance();
$dateHelper	= CAT_Helper_DateTime::getInstance();
$PageHelper	= CAT_Helper_Page::getInstance();

header('Content-type: application/json');

// ===============
// ! Get page id
// ===============
$page_id		= $val->sanitizePost('page_id', 'numeric');
$section_id		= $val->sanitizePost('section_id', 'numeric');
$news_id		= $val->sanitizePost('news_id', 'numeric');
$options		= $val->sanitizePost('options');
$entry_options	= $val->sanitizePost('entry_options');

// =============
// ! Get perms
// =============
if ( !$section_id || !$page_id || ( !$news_id && !$options ) )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate('You sent an invalid value'),
		'news_id'	=> $news_id,
		'page_id'	=> $page_id,
		'section_id'	=> $section_id,
		'success'	=> true
	);
	print json_encode( $ajax );
	exit();
}

if ( $PageHelper->getPagePermission( $page_id, 'admin' ) !== true )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate( 'You do not have permissions to modify this page!' ),
		'success'	=> false
	);
	print json_encode( $ajax );
	exit();
}

include_once( '../classes/class.news.php' );

$BlackNews	= new BlackNews( $news_id );

$auto_generate			= $val->sanitizePost('auto_generate','numeric') != '' ? 1 : 0;
$auto_generate_size		= $val->sanitizePost('auto_generate_size','numeric');


$title					= addslashes( $val->sanitizePost('title') );
$subtitle				= addslashes( $val->sanitizePost('subtitle') );
$url					= addslashes( $val->sanitizePost('url') );
$category				= implode(',', array_filter( explode(',', addslashes( $val->sanitizePost('category') ) ) ) );
$short_check			= $val->sanitizePost('short_check','numeric') != '' ? 1 : 0;

$start					= $val->sanitizePost('start');
$end					= $val->sanitizePost('end');

$start					= $start != '' && $start > 0 ? strtotime( $start ) : '';
$end					= $end != '' && $end > 0 ? strtotime( $end ) : '';

$short_cont				= addslashes( $val->sanitizePost( 'blacknews_short_' . $section_id ) );
$long_cont				= addslashes( $val->sanitizePost( 'blacknews_long_' . $section_id ) );
$text					= strip_tags( $short_cont ) . ' ' . strip_tags( $long_cont );

// Bilder hochladen und speichern
if ( isset( $_FILES['image']['name'] ) && $_FILES['image']['name'] != '' )
{
	$folder_path	= CAT_PATH . MEDIA_DIRECTORY . '/blacknews/';
	if ( !file_exists( $folder_path ) )
	{
		CAT_Helper_Directory::createDirectory( $folder_path, NULL, true );
	}
	$allowed_file_types		= array( 'png', 'jpg', 'jpeg', 'gif' );
	// =========================================== 
	// ! Get file extension of the uploaded file   
	// =========================================== 
	$file_extension	= (strtolower( pathinfo( $_FILES['image']['name'], PATHINFO_EXTENSION ) ) == '')
				? false
				: strtolower( pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION))
				;
	// ====================================== 
	// ! Check if file extension is allowed   
	// ====================================== 
	if ( isset( $file_extension ) && in_array( $file_extension, $allowed_file_types ) )
	{
		$current = CAT_Helper_Upload::getInstance( $_FILES['image'] );
		if ( $current->uploaded )
		{
			$current->file_overwrite		= true;
			$current->file_new_name_body	= 'news_' . $section_id . '_' . $news_id;
			$current->process( $folder_path . '/' );
			if ( $current->processed )
			{
				$old_thumbs		= glob(CAT_PATH . '/temp/media/blacknews_news_' . $section_id . '_' . $news_id . '_*');
				if ( is_array($old_thumbs) )
				{
					foreach( $old_thumbs as $thumb ){
						CAT_Helper_Directory::removeDirectory( $thumb );
					}
				}
				CAT_Helper_Image::getInstance()->make_thumb(
					$folder_path . '/' . $current->file_dst_name,
					$folder_path . '/' . $current->file_dst_name,
					1024,
					1024,
					'fit'
				);
				$picture	= $current->file_dst_name;
				$current->clean();
			}
			else
			{
				$ajax	= array(
					'message'	=> $backend->lang()->translate( 'File upload error: {{error}}',array('error'=>$current->error) ),
					'success'	=> false
				);
				print json_encode( $ajax );
				exit();
			}
		}
		else
		{
			$ajax	= array(
				'message'	=> $backend->lang()->translate( 'File upload error: {{error}}',array('error'=>$current->error) ),
				'success'	=> false
			);
			print json_encode( $ajax );
			exit();
		}
	}
}

if ( $options != '' )
{
	foreach( array_filter( explode(',', $options) ) as $option )
	{
		if( !$BlackNews->saveOptions( $option, $val->sanitizePost( $option ) )) $error = true;
	}
}
else
{
	$time	= time();

	$old_url	= $BlackNews->getEntryOptions('url');

	$PageHelper->db()->query("UPDATE `" . CAT_TABLE_PREFIX . "mod_blacknews_entry` SET 
		`updated`		= '$time',
		`categories`	= '$category',
		`start`			= '$start',
		`end`			= '$end'
		WHERE `section_id` = '$section_id'
		AND `page_id` = '$page_id'
		AND `news_id` = '$news_id'"
	);
	
	$sql	= "UPDATE `" . CAT_TABLE_PREFIX . "mod_blacknews_content` SET
			`title`					= '$title',
			`subtitle`				= '$subtitle',
			`auto_generate`			= '$auto_generate',
			`auto_generate_size`	= '$auto_generate_size',";



	$sql	.= isset( $picture ) ? 
			"`image`				= '" . $picture . "'," : "";
	
	$sql	.= "
			`short`				= '$short_cont',
			`content`			= '$long_cont',
			`text`				= '$text'
			WHERE `section_id` = '$section_id' AND
				`page_id` = '$page_id' AND
				`news_id` = '$news_id'";

	$PageHelper->db()->query( $sql );

	if ( $entry_options != '' )
	{
		foreach( array_filter( explode(',', $entry_options) ) as $option )
		{
			if( !$BlackNews->saveEntryOptions( $option, $val->sanitizePost( $option ) )) $error = true;
		}
	}
	if ( $old_url != $url )
	{
		$BlackNews->removeAccessFolder( $old_url );
		$url	= $BlackNews->createAccessFile( $url );
	}
}


// ================================================================ 
// ! Check if there is a database error, otherwise say successful   
// ================================================================ 
if ( $backend->is_error() || isset($error) )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate( $backend->get_error() ),
		'success'	=> false
	);
	print json_encode( $ajax );
	exit();
}
else
{
	$BlackNews->createRSS();

	$update_when_modified = true;
	CAT_Backend::updateWhenModified();

	$ajax	= array(
		'message'	=> $options ? 
			$backend->lang()->translate( 'Options saved successfully!' ) :
			$backend->lang()->translate( 'Entry saved successfully!' ),
		'title'		=> $title,
		'subtitle'	=> $subtitle,
		'category'	=> $category,
		'pageurl'	=> $url,
		'news_id'	=> $news_id,
		'image_url'	=> isset($picture) ? CAT_URL . MEDIA_DIRECTORY . '/blacknews/' . $picture : '',
		'time'		=> isset($time) ? CAT_Helper_DateTime::getInstance()->getDateTime( $time ) : '',
		'success'	=> true
	);
	print json_encode( $ajax );
	exit();
}

?>