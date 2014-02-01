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

$getInfo		= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/blacknews/' );

$news_id		= defined( 'NEWS_ID' ) ? NEWS_ID : $val->sanitizeGet('news_id','numeric');

// only to be sure, that $news_id is an integer
settype( $news_id, 'int' );

$page			= $val->sanitizeGet('page','numeric');


include_once( 'class.news.php' );

$BlackNews	= new BlackNews( $news_id );

$parser_data['options']	= $BlackNews->getOptions();

$entries_per_page		= $BlackNews->setEPP();

if ($news_id) $parser_data['entries']	= $BlackNews->getEntries( $news_id );
$parser_data['entries']	= $BlackNews->getEntries( true );


$parser_data['entry']		= $news_id > 0 ? $parser_data['entries'][$news_id] : NULL;

//$parser_data['entries']		= array_reverse( $parser_data['entries'] );
$parser_data['entries_ci']	= array_values( $parser_data['entries'] );

$parser_data['pagelink']	= CAT_URL . $BlackNews->permalink;

$BlackNews->checkRedirect();

/*
header("HTTP/1.1 301 Moved Permanently");
// Weiterleitungsziel. Wohin soll eine permanente Weiterleitung erfolgen?
header("Location:" . CAT_URL . $BlackNews->permalink);
*/
$variant	= $parser_data['options']['variant'] != ''
				&& isset($getInfo['module_variants'][$parser_data['options']['variant']]) ?
						$getInfo['module_variants'][$parser_data['options']['variant']] : 
						'default';

$template	= $news_id ? 'entry' : 'overview';

$parser->setPath( dirname(__FILE__) . '/templates/' . $variant );

$parser->output(
	$template,
	$parser_data
);


?>
