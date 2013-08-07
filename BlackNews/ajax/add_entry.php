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
$user		= CAT_Users::getInstance();
$PageHelper	= CAT_Helper_Page::getInstance();
$backend	= CAT_Backend::getInstance('Pages', 'pages_modify', false);


header('Content-type: application/json');

$section_id		= $val->sanitizePost('section_id','numeric');
$page_id		= $val->sanitizePost('page_id','numeric');

// Get page id
if ( !$section_id || !$page_id )
{
	$ajax	= array(
		'message'	=> $backend->lang()->translate('You sent an invalid value'),
		'success'	=> false
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

$check_options		= $PageHelper->db()->query("SELECT * FROM " . CAT_TABLE_PREFIX . "mod_blacknews_options
					WHERE section_id = '$section_id'");
if ( !$check_options )
{
	$PageHelper->db()->query("INSERT INTO " . CAT_TABLE_PREFIX . "mod_blacknews_options 
		(page_id, section_id, name, value ) VALUES
		('$page_id', '$section_id', 'entries_per_page', '10' )"
	);

	$PageHelper->db()->query("INSERT INTO " . CAT_TABLE_PREFIX . "mod_blacknews_options 
		(page_id, section_id, name, value ) VALUES
		('$page_id', '$section_id', 'variant', 'default' )"
	);
}


$time		= time();
$user_id	= $user->get_user_id();

if ( $PageHelper->db()->query("INSERT INTO " . CAT_TABLE_PREFIX . "mod_blacknews_entry
	(page_id, section_id, active, updated, created, created_by) VALUES
	('$page_id', '$section_id', '0', '$time', '$time', '$user_id' )") )
	{
		$news_id				= $PageHelper->db()->get_one("SELECT LAST_INSERT_ID()");
		$title					= $backend->lang()->translate('New title');
		$subtitle				= '';//$backend->lang()->translate('New subtitle');
		$auto_generate_size		= 300;
		$auto_generate			= 1;

		$PageHelper->db()->query("INSERT INTO " . CAT_TABLE_PREFIX . "mod_blacknews_content
			(page_id, section_id, news_id, title, subtitle, auto_generate_size, auto_generate, content, short) VALUES
			('$page_id', '$section_id', '$news_id', '$title', '$subtitle', '$auto_generate_size', '$auto_generate', '', '' )");
	}

$ajax	= array(
	'message'	=> $backend->lang()->translate('Entry added successfully'),
	'values'	=> array(
		'section_id'			=> $section_id,
		'news_id'				=> $news_id,
		'title'					=> $title,
		'subtitle'				=> $subtitle,
		'auto_generate_size'	=> $auto_generate_size,
		'auto_generate'			=> $auto_generate == 0 ? false : true,
		'time'					=> CAT_Helper_DateTime::getInstance()->getDateTime( $time ),
		'user'					=> $user->get_username(),
		'image'					=> '',
		'content_short'			=> '',
		'content'				=> ''
	),
	'success'	=> true
);

print json_encode( $ajax );
exit();

?>