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

$mod_headers = array(
	'backend' => array(
		'css' => array(
			array(
				'media'		=> 'all',
				'file'		=> 'modules/blacknews/css/default/backend.css'
			)
		),
		'js' => array(
			'/modules/blacknews/js/default/backend.js',
		),
		'jquery' => array(
			array(
				'core'			=> true,
				'all'			=> array ( 'jquery.timepicker' )
			)
		),
	),
	'frontend' => array(
		'css' => array(
			array(
				'media'		=> 'all',
				'file'		=> 'modules/blacknews/css/gold/frontend.css'
			)
		),
		'js' => array(
			'/modules/blacknews/js/default/frontend.js'
		),
		'jquery' => array(
			array(
				'core'			=> true
			)
		)
	)
);
?>