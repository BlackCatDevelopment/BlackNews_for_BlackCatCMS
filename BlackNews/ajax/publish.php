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

$val		= CAT_Helper_Validate::getInstance();
$backend	= CAT_Backend::getInstance('Pages', 'pages_modify', false);
$PageHelper	= CAT_Helper_Page::getInstance();

header('Content-type: application/json');

// ===============
// ! Get page id
// ===============
$page_id		= $val->sanitizePost('page_id', 'numeric');
$section_id		= $val->sanitizePost('section_id', 'numeric');
$news_id		= $val->sanitizePost('news_id', 'numeric');

// =============
// ! Get perms
// =============
if ( !$section_id || !$page_id || !$news_id )
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

include_once( '../classes/class.news.php' );

$BlackNews	= new BlackNews( $news_id );
$active		= $val->sanitizePost('publish','numeric');



$action		= $BlackNews->setPublished( $active );


$ajax	= array(
	'message'	=> $backend->lang()->translate( sprintf( 'Entry %s successfully!', $action ) ),
	'active'	=> $active != 0 ? 1 : 0,
	'news_id'	=> $news_id,
	'success'	=> true
);
print json_encode( $ajax );
exit();


?>