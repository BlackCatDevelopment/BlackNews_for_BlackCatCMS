<?php
/**
 *
 *
 * ,-----.  ,--.              ,--.    ,-----.          ,--.       ,-----.,--.   ,--. ,---.
 * |  |) /_ |  | ,--,--. ,---.|  |,-.'  .--./ ,--,--.,-'  '-.    '  .--./|   `.'   |'   .-'
 * |  .-.  \|  |' ,-.  || .--'|     /|  |    ' ,-.  |'-.  .-'    |  |    |  |'.'|  |`.  `-.
 * |  '--' /|  |\ '-'  |\ `--.|  \  \'  '--'\\ '-'  |  |  |      '  '--'\|  |   |  |.-'    |
 * `------' `--' `--`--' `---'`--'`--'`-----' `--`--'  `--'       `-----'`--'   `--'`-----'
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
 *   @copyright		2022, Black Cat Development
 *   @link				https://github.com/BlackCatDevelopment/BlackNews_for_BlackCatCMS
 *   @license			https://www.gnu.org/licenses/gpl-3.0.html
 *   @category		CAT_Modules
 *   @package			blackNews
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined("CAT_PATH")) {
    include CAT_PATH . "/framework/class.secure.php";
} else {
    $oneback = "../";
    $root = $oneback;
    $level = 1;
    while ($level < 10 && !file_exists($root . "framework/class.secure.php")) {
        $root .= $oneback;
        $level += 1;
    }
    if (file_exists($root . "/framework/class.secure.php")) {
        include $root . "/framework/class.secure.php";
    } else {
        trigger_error(
            sprintf(
                "[ <b>%s</b> ] Can't include class.secure.php!",
                $_SERVER["SCRIPT_NAME"]
            ),
            E_USER_ERROR
        );
    }
}
// end include class.secure.php

// include class.secure.php to protect this file and the whole CMS!
if (defined("CAT_PATH")) {
    include CAT_PATH . "/framework/class.secure.php";
} else {
    $oneback = "../";
    $root = $oneback;
    $level = 1;
    while ($level < 10 && !file_exists($root . "framework/class.secure.php")) {
        $root .= $oneback;
        $level += 1;
    }
    if (file_exists($root . "/framework/class.secure.php")) {
        include $root . "/framework/class.secure.php";
    } else {
        trigger_error(
            sprintf(
                "[ <b>%s</b> ] Can't include class.secure.php!",
                $_SERVER["SCRIPT_NAME"]
            ),
            E_USER_ERROR
        );
    }
}
// end include class.secure.php

$bN	= blackNews::getParserValue();

$entry	= array_shift($bN['entries']);

if ( $entry['catGallery'] > 0 )
{
	include_once CAT_PATH . "/modules/cc_catgallery/inc/class.catgallery.php";
	$catGallery	= new catGallery( $entry['catGallery'] );

	$parser_data	= array(
		'folder_url'		=> $catGallery->getFolder( false ),
		'CAT_ADMIN_URL'		=> CAT_ADMIN_URL,
		'CAT_URL'			=> CAT_URL,
		'page_id'			=> $page_id,
		'section_id'		=> $section_id,
		'gallery_id'		=> $catGallery->getID(),
		'version'			=> CAT_Helper_Addons::getModuleVersion('cc_catgallery'),
		'module_variants'	=> $catGallery->getAllVariants(),
		'options'			=> $catGallery->getOptions(),
		'effects'			=> $catGallery->effects,
		'images'			=> $catGallery->getImage(),
		'countImg'			=> $catGallery->countImg(),
		'imgURL'			=> $catGallery->getImageURL(),
		'page_link'			=> CAT_Helper_Page::getInstance()->properties( $page_id, 'link' ),
		'section_name'		=> str_replace( array('ä', 'ö', 'ü', 'ß'), array('ae', 'oe', 'ue', 'ss'), strtolower( $section['name'] ) )
	);

	if ( $parser_data['countImg'] > 0 )
		$template		= 'view';
	else
		$template		= 'view_no_image';
	
	$module_path	= '/modules/cc_catgallery/';

	$variant		= $catGallery->getVariant();
	
/*	if ( file_exists( CAT_PATH . '/modules/lib_mdetect/mdetect/mdetect.php' ) )
	{
		require_once( CAT_PATH . '/modules/lib_mdetect/mdetect/mdetect.php' );
		$uagent_obj = new uagent_info();
		if( $uagent_obj->DetectMobileQuick() )
		{
			$parser_data['options']['is_mobile']	= true;
		}
	} else {
		$parser_data['options']['is_mobile']	= NULL;
	}
	
	if ( file_exists( CAT_PATH . $module_path .'view/' . $variant . '/view.php' ) )
		include( CAT_PATH . $module_path .'view/' . $variant . '/view.php' );
	elseif ( file_exists( CAT_PATH . $module_path .'view/default/view.php' ) )
		include( CAT_PATH . $module_path .'view/default/view.php' );
	*/
	$parser->setPath( CAT_PATH . '/modules/cc_catgallery/templates/' . $catGallery->getVariant() );
	$parser->setFallbackPath( CAT_PATH . '/modules/cc_catgallery/templates/default' );
	
	
	blackNews::setParserValue('gallery',
		$parser->get(
			$template,
			$parser_data
		)
	);
	blackNews::setParserValue('firstEntry', $entry );

}

?>