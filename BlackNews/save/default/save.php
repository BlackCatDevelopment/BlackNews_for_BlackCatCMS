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

if ( CAT_Helper_Page::getPagePermission( $page_id, 'admin' ) !== true )
{
	$backend->print_error( 'You do not have permissions to modify this page!' );
}

// ============================= 
// ! Get the current news_id 
// ============================= 
if ( $action = $val->sanitizePost( 'action' ) )
{
	// ====================================== 
	// ! Upload images and save to database
	// ====================================== 
	switch ( $action )
	{
		case 'addEntry':
			$return		= $BlackNews->addEntry();
			$ajax_return	= array(
				'message'		=> is_array($return) ? $PageHelper->lang()->translate('Entry added successfully') :
									$PageHelper->lang()->translate('An error occured'),
				'page_id'		=> $page_id,
				'section_id'	=> $section_id,
				'values'		=> $return,
				'success'		=> is_array($return) ? true : false
			);
			break;

		case 'deleteEntry':
			$success	= $BlackNews->removeEntry();
			if ( $success )
			{
				$ajax_return	= array(
					'message'	=> $backend->lang()->translate('Entry deleted successfully'),
					'news_id'	=> $news_id,
					'success'	=> true
				);
			}
			else {
				$ajax_return	= array(
					'message'	=> $backend->lang()->translate( $backend->get_error() ),
					'success'	=> false
				);
			}
			break;

		case 'getInfo':
			$getValues			= $BlackNews->getEntries( $news_id );
			$ajax_return	= array(
				'values'		=> $getValues[$news_id],
				'section_id'	=> $section_id,
				'message'		=> $backend->lang()->translate( 'Loading successful' ),
				'success'		=> true
			);
			break;

		case 'publish':
			$pub	= $val->sanitizePost('publish','numeric');
			$set	= $BlackNews->setPublished( $pub );
			$ajax_return	= array(
				'active'	=> $pub != 0 ? 1 : 0,
				'news_id'	=> $news_id,
				'message'	=> $lang->translate(sprintf( 'Entry %s successfully!', $set ) ),
				'success'	=> true
			);
			break;

		case 'reorder':
			$success	= $BlackNews->reorderEntries( $val->sanitizePost('positions','array') );

			$ajax_return	= array(
				'message'	=> $success === true ?
						$lang->translate( 'Entries sorted successfully' )
						: $lang->translate( 'Sort failed' ),
				'success'	=> $success
			);
			break;

		case 'saveEntry':
			$short_check			= $val->sanitizePost('short_check','numeric') != '' ? 1 : 0;
#$url					= addslashes( $val->sanitizePost('url') );
			$success	= $BlackNews->saveEntry(
				array(
					'time'					=> $val->sanitizePost('time'),
					'category'				=> $val->sanitizePost('category'),
					'start'					=> $val->sanitizePost('start'),
					'end'					=> $val->sanitizePost('end'),
					'title'					=> $val->sanitizePost('title'),
					'subtitle'				=> $val->sanitizePost('subtitle'),
					#'url'					=> $val->sanitizePost('url'),
					'auto_generate'			=> $val->sanitizePost('auto_generate','numeric'),
					'auto_generate_size'	=> $val->sanitizePost('auto_generate_size','numeric'),
					'short_cont'			=> $val->sanitizePost( 'bN_short_' . $section_id ),
					'long_cont'				=> $val->sanitizePost( 'bN_long_' . $section_id )
				)
			);

			$entry_options	= $val->sanitizePost('entry_options');
			$url			= $BlackNews->getEntryOptions('url');
			if ( $entry_options != '' )
			{
				foreach( array_filter( explode(',', $entry_options) ) as $option )
				{
					if( !$BlackNews->saveEntryOptions( $option, $val->sanitizePost( $option ) )) $error = true;
					if ( $option == 'url' && $url != $val->sanitizePost( $option ) )
					{
						$BlackNews->removeAccessFolder( $url );
						$url	= $BlackNews->createAccessFile( $val->sanitizePost( $option ) );
					}
				}
			}

			$ajax_return	= array(
				'message'	=> $success === true ?
						$lang->translate( 'Entry saved successfully' )
						: $lang->translate( 'Save failed' ),
				'pageurl'	=> $url,
				'success'	=> $success
			);

			break;

		case 'saveOptions':
			$options		= $val->sanitizePost('options');

			// =========================== 
			// ! save options for gallery   
			// =========================== 
			if ( $options != '' )
			{
				foreach( array_filter( explode(',', $options) ) as $option )
				{
					if( !$BlackNews->saveOptions( $option, $val->sanitizePost( $option ) )) $error = true;
				}
			}
			$ajax_return	= array(
				'message'	=> $lang->translate( 'Options saved successfully!' ),
				'success'	=> true
			);
			break;

		default:
			// =========================== 
			// ! save variant of blacknews   
			// =========================== 
			$BlackNews->saveOptions( 'variant', $val->sanitizePost('variant') );

			$ajax_return	= array(
				'message'	=> $lang->translate( 'Variant saved successfully!' ),
				'success'	=> true
			);

			break;
	}
} else {
	$ajax_return	= array(
		'message'	=> $lang->translate( 'You sent an invalid ID' ),
		'success'	=> false,
	);
}



?>