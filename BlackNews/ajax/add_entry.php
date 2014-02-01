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

$time		= time();
$user_id	= $user->get_user_id();

$position	= $PageHelper->db()->get_one( sprintf(
	"SELECT `%s` FROM %smod_%s
	ORDER BY `%s` DESC LIMIT 1",
	'position',
	CAT_TABLE_PREFIX,
	'blacknews_entry',
	'position'
	)
);

if ( $position == '' ) $position = 0;
$position++;

if ( $PageHelper->db()->query( sprintf(
			"INSERT INTO `%smod_%s`
			(%s) VALUES (%s)",
			CAT_TABLE_PREFIX,
			'blacknews_entry',
			'`page_id`, `section_id`, `active`, `updated`, `created`, `created_by`, `position`',
			"'$page_id', '$section_id', '0', '$time', '$time', '$user_id', '$position'"
		)
	)
)
{
	$backend->lang()->addFile( LANGUAGE . '.php', sanitize_path(CAT_PATH . '/modules/blacknews/languages') );

	$news_id				= $PageHelper->db()->get_one("SELECT LAST_INSERT_ID()");

	include_once( '../class.news.php' );

	$BlackNews				= new BlackNews( $news_id );

	$permalink				= $BlackNews->getOptions( 'permalink' );

	$title					= $backend->lang()->translate('New entry');
	$url_title				= $backend->lang()->translate('New entry');
	$url					= $BlackNews->createTitleURL($url_title);
	$counter				= 0;
	while( file_exists( CAT_PATH . '/' . $permalink . '/' . $url ) )
	{
		$url				= $BlackNews->createTitleURL( $url_title . '-' . ++$counter );
	}
	$BlackNews->createAccessFile( $url );
	$subtitle				= '';//$backend->lang()->translate('New subtitle');
	$auto_generate_size		= 300;
	$auto_generate			= 1;

	$PageHelper->db()->query( sprintf(
			"INSERT INTO `%smod_%s`
			(%s) VALUES (%s)",
			CAT_TABLE_PREFIX,
			'blacknews_content',
			'`page_id`, `section_id`, `news_id`, `title`, `subtitle`, `url`, `auto_generate_size`, `auto_generate`, `content`, `short`',
			"'$page_id', '$section_id', '$news_id', '$title', '$subtitle', '$url', '$auto_generate_size', '$auto_generate', '', ''"
		)
	);
}

$ajax	= array(
	'message'	=> $backend->lang()->translate('Entry added successfully'),
	'section_id'	=> $section_id,
	'values'	=> array(
		'news_id'				=> $news_id,
		'title'					=> $title,
		'subtitle'				=> $subtitle,
		'pageurl'				=> $url,
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