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

$module_directory	= 'blacknews';
$module_name		= 'BlackNews';
$module_function	= 'page';
$module_version		= '0.2';
$module_platform	= '1.x';
$module_author		= 'Matthias Glienke, creativecat';
$module_license		= '<a href="http://www.gnu.org/licenses/gpl.html">GNU General Public License</a>';
$module_description	= 'With the add on "BlackNews" you publish news on your side in a simple way. For details see <a href="https://github.com/BlackCatDevelopment/BlackNews_for_BlackCatCMS" target="_blank">GitHub</a>.<br/><br/>Done by Matthias Glienke, <a class="icon-creativecat" href="http://creativecat.de"> creativecat</a>';
$module_guid		= '9ee2f6b5-ccfb-49c5-8a12-417b67cfe367';
$module_variants	= array( 'default', 'gold' );

?>