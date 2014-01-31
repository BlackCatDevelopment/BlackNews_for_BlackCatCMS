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
global $page_id, $section_id;

$PageHelper	= CAT_Helper_Page::getInstance();

$folder		= '/news/';
$counter	= 0;
while( file_exists( CAT_PATH . $folder ) )
{
	$folder = '/news-' . ++$counter . '/';
}

CAT_Helper_Directory::createDirectory( CAT_PATH . $folder, NULL, false );

include_once( 'class.news.php' );

$BlackNews	= new BlackNews( );

$BlackNews->saveOptions( 'entries_per_page', '10' );
$BlackNews->saveOptions( 'variant', 'default' );
$BlackNews->saveOptions( 'permalink', $folder );
$BlackNews->saveOptions( 'rss_counter', '15' );
$BlackNews->saveOptions( 'rss_title', '' );
$BlackNews->saveOptions( 'rss_description', '' );

$BlackNews->createAccessFile( true, false );

?>