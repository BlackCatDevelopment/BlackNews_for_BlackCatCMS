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

$info			= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/blacknews/' );

$parser_data	= array(
	'CAT_URL'				=> CAT_URL,
	'CAT_PATH'				=> CAT_PATH,
	'CAT_ADMIN_URL'			=> CAT_ADMIN_URL,
	'page_id'				=> $page_id,
	'section_id'			=> $section_id,
	'version'				=> CAT_Helper_Addons::getModuleVersion('blacknews'),
	'module_variants'		=> $info['module_variants'],
);


// =============================== 
// ! Get columns in this section   
// =============================== 
include_once( 'classes/class.news.php' );

$BlackNews	= new BlackNews();

$parser_data['options']			= $BlackNews->getOptions();
$parser_data['allCategories']	= $BlackNews->getAllCategories();

$entries_per_page		= $BlackNews->setEPP();

$parser_data['entries']	= $BlackNews->getEntries( NULL, true, 'backend' );

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