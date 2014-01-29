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

global $page_id;

$getVariant	= CAT_Helper_Page::getInstance()->db()->query(
			sprintf(
				'SELECT `value` FROM `%smod_%s` WHERE `%s` = \'%s\' AND `%s` = \'%s\'',
					CAT_TABLE_PREFIX,
					'blacknews_options',
					'page_id',
					$page_id,
					'name',
					'variant'
			)
);

$getInfo	= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/blacknews/' );

$variants	= array();
$f_css		= array();
$f_js		= array();
$b_css		= array();
$b_js		= array();

$module_path	= '/modules/blacknews/';

if ( isset($getVariant) && $getVariant->numRows() > 0 )
{
	while ( !false == ( $row = $getVariant->fetchRow( MYSQL_ASSOC ) ) )
	{
		$variant	= isset($row['value']) ?
			$row['value'] : 
			'default';

		if ( file_exists( CAT_PATH . $module_path .'css/' . $variant . '/frontend.css' ) )
			$f_css[]	= array(
				'media'		=> 'all',
				'file'		=> $module_path . 'css/' . $variant . '/frontend.css'
			);
		elseif ( file_exists( CAT_PATH . $module_path .'css/default/frontend.css' ) )
			$f_css[]	= array(
				'media'		=> 'all',
				'file'		=> $module_path . 'css/default/frontend.css'
			);

		if ( file_exists( CAT_PATH . $module_path .'css/' . $variant . '/backend.css' ) )
			$b_css[]	= array(
				'media'		=> 'all',
				'file'		=> $module_path . 'css/' . $variant . '/backend.css'
			);
		elseif ( file_exists( CAT_PATH . $module_path .'css/default/backend.css' ) )
			$b_css[]	= array(
				'media'		=> 'all',
				'file'		=> $module_path . 'css/default/backend.css'
			);

		if ( file_exists( CAT_PATH . $module_path .'js/' . $variant . '/frontend.js' ) )
			$f_js[]	= $module_path . 'js/' . $variant . '/frontend.js';
		elseif ( file_exists( CAT_PATH . $module_path .'js/default/frontend.js' ) )
			$f_js[]	= $module_path . 'js/default/frontend.js';

		if ( file_exists( CAT_PATH . $module_path .'js/' . $variant . '/backend.js' ) )
			$b_js[]	= $module_path . 'js/' . $variant . '/backend.js';
		elseif ( file_exists( CAT_PATH . $module_path .'js/default/backend.js' ) )
			$b_js[]	= $module_path . 'js/default/backend.js';
	}
}
else {
	$f_css		= array(
		'media'		=> 'all',
		'file'		=> $module_path . 'css/default/frontend.css'
	);
	$f_js		= array(
		$module_path . 'js/default/frontend.js'
	);
	$b_css		= array(
		'media'		=> 'all',
		'file'		=> $module_path . 'css/default/backend.css'
	);
	$b_js		= array(
		$module_path . 'js/default/backend.js'
	);
}

$mod_headers = array(
	'backend' => array(
		'css'	=> $b_css,
		'js'	=> $b_js,
		'jquery' => array(
			array(
				'core'			=> true
			),
            array(
                'all' => array( 'cattranslate' )
            ),
		)
	),
	'frontend' => array(
		'css'	=> $f_css,
		'js'	=> $f_js,
		'meta' => array(
			array( '<link rel="alternate" type="application/rss+xml" title="RSS" href="" />' )
		),
		'jquery' => array(
			array(
				'core'			=> true
			)
		)
	)
);

