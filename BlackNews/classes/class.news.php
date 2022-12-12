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

if ( ! class_exists( 'BlackNews', false ) ) {
	class BlackNews
	{

		protected static $news_id		= NULL;
		protected static $page_id		= NULL;
		protected static $section_id	= NULL;
		protected $epp					= NULL;
		protected $rss_counter			= NULL;


		protected static $initOptions		= array(
			'entries_per_page'		=> '10',
			'variant'				=> 'default',
			'permalink'				=> '/news/',
			'rss_counter'			=> '15',
			'rss_title'				=> '',
			'rss_description'		=> ''
		);

		public $options			= NULL;
		public $entries			= array();
		public $news_ids		= array();
		public $module_variants	= array();
		public $permalink		= '/news/';
		public $RSS				= array();

		public static function getInstance()
		{
			if (!self::$instance)
				self::$instance = new self();
			else
				self::reset();
			return self::$instance;
		}

		public function __construct( $news_id	= NULL, $is_header = false )
		{
			global $page_id, $section_id;
			
			if ( $is_header || ( !$is_header && !is_array($news_id)) )
			{
				global $page_id, $section_id;
			}
			require_once(CAT_PATH . '/framework/functions.php');

			// This is a workaround for headers.inc.php as there is no $section_id defined yet
			if ( !isset($section_id) || $is_header )
			{
				$section_id	= is_numeric($news_id) ? $news_id : $news_id['section_id'];
			}
			if ( !isset($page_id) && isset($news_id['page_id'] ) )
			{
				$page_id	= is_numeric($news_id) ? $news_id : $news_id['page_id'];
			}

			$this->setPageID( intval($page_id) );
			$this->setSectionID( intval($section_id) );

			if ( $news_id === true )
			{
				$this->initAdd();
			}
			elseif ( is_numeric($news_id) && !$is_header )
			{
				self::$news_id	= intval($news_id);
			}
			elseif ( is_array($news_id) && !$is_header )
			{
				self::$news_id	= intval($news_id['news_id']);
			}
			elseif ( is_numeric($section_id) && $section_id > 0 )
			{
				$this->setNewsID();
			}
			else return false;

			$this->permalink	= $this->getOptions( 'permalink' );

			CAT_Helper_I18n::getInstance()->lang()->addFile( LANGUAGE . '.php', CAT_PATH . '/modules/blacknews/languages');
		}

		public function __destruct() {}

		/**
		 * set the $page_id
		 */
		public function setPageID( $page_id )
		{
			self::$page_id		= intval($page_id);
			return $this;
		}
		
		/**
		 * set the $section_id
		 */
		public function setSectionID( $section_id )
		{
			self::$section_id	= intval($section_id);
			return $this;
		}

		/**
		 * set the $news_id by self:$section_id
		 *
		 * @access public
		 * @return integer
		 *
		 **/
		public function setNewsID()
		{
			// Get columns in this section
			self::$news_id	= CAT_Helper_Page::getInstance()->db()->query(
					'SELECT `news_id`
						FROM `:prefix:mod_blacknews_entry`' .
						' WHERE `page_id` = :page_id AND' .
							' `section_id` = :section_id' .
							' LIMIT 1,0',
				array(
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id
				)
			)->fetchColumn();

			return self::$news_id;
		} // end setNewsID()


		/**
		 * add new BlackNews
		 *
		 * @access public
		 * @return integer
		 *
		 **/
		private function initAdd()
		{
			if ( !self::$section_id || !self::$page_id ) return false;

			$counter	= 0;
			while( file_exists( CAT_PATH . $this->permalink ) )
			{
				$this->permalink = '/news-' . ++$counter . '/';
			}

			if( CAT_PATH . $this->permalink )
			{
				CAT_Helper_Directory::getInstance()->createDirectory( CAT_PATH . $this->permalink, NULL, false );
			}

			// Add initial options for gallery
			foreach( self::$initOptions as $name => $val )
			{
				if( !$this->saveOptions( $name, $val ) )
					$return	= false;
			}

			$this->createAccessFile( true, false );

			return true;
		} // initAdd()

		/**
		 * delete a catGallery
		 *
		 * @access public
		 * @return integer
		 *
		 **/
		public function deleteNews()
		{
			if ( !self::$section_id || !self::$page_id ) return false;

			// Delete record from the database
			foreach (
				array( 'entry', 'content', 'content_options', 'options' ) as $table
			)
			{
				if( !CAT_Helper_Page::getInstance()->db()->query( sprintf(
						'DELETE FROM `:prefix:mod_blacknews_%s`' .
							' WHERE section_id = :section_id',
						$table
					),
					array(
						'section_id'	=> self::$section_id
					)
				) ) return false;
				$return	= true;
			}

			// Delete folder
			if ( $return )
				if( $this->removeAccessFolder( '/' ) );
					else return true;
				else return false;
			return false;
		}


		/**
		 * add new entry
		 *
		 * @access public
		 * @return integer
		 *
		 **/
		public function addEntry( $title = '' )
		{
			if ( !self::$section_id || !self::$page_id ) return false;

			$PageHelper	= CAT_Helper_Page::getInstance();
			$user_id	= CAT_Users::getInstance()->get_user_id();
			$lang		= CAT_Helper_I18n::getInstance();
			$time		= time();

			// Get position of next entry
			$position		= CAT_Helper_Page::getInstance()->db()->query(
				'SELECT `position` FROM `:prefix:mod_blacknews_entry`' .
					' WHERE `page_id` = :page_id' .
							' AND `section_id` = :section_id' .
					' ORDER BY `position` DESC LIMIT 1',
				array(
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id
				)
			)->fetchColumn();

			$position++;

			// Add new entry to database
			if ( $PageHelper->db()->query(
				'INSERT INTO `:prefix:mod_blacknews_entry`
					(`page_id`, `section_id`, `active`, `updated`, `created`, `created_by`, `position`)
					VALUES (:page_id, :section_id, :active, :updated, :created, :created_by, :position)',
				array(
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id,
					'active'		=> 0,
					'updated'		=> $time,
					'created'		=> $time,
					'created_by'	=> $user_id,
					'position'		=> $position
				)
			) ) {
				// default values
				self::$news_id	= $PageHelper->db()->lastInsertId();

				$this->getOptions( 'permalink' );

				$title				= $title == '' ? $lang->lang()->translate('New entry') : $title;
				$url_title			= $lang->lang()->translate('New entry');
				$subtitle			= '';
				$auto_generate_size	= 300;
				$auto_generate		= 1;
				$url				= $this->createTitleURL( $url_title );

				$counter		= 0;
				while( file_exists( CAT_PATH . '/' . $this->permalink . '/' . $url ) )
				{
					$url	= $this->createTitleURL( $url_title . '-' . ++$counter );
				}
				$this->createAccessFile( $url );

				$PageHelper->db()->query(
					'INSERT INTO `:prefix:mod_blacknews_content`
						(`page_id`, `section_id`, `news_id`, `title`, `subtitle`, `auto_generate_size`, `auto_generate` , `content`, `short`)
						VALUES (:page_id, :section_id, :news_id, :title, :subtitle, :auto_generate_size, :auto_generate, :content, :short )',
					array(
						'page_id'				=> self::$page_id,
						'section_id'			=> self::$section_id,
						'news_id'				=> self::$news_id,
						'title'					=> $title,
						'subtitle'				=> $subtitle,
						'auto_generate_size'	=> $auto_generate_size,
						'auto_generate'			=> $auto_generate,
						'content'				=> '',
						'short'					=> ''
					)
				);
				return array(
					'news_id'				=> self::$news_id,
					'title'					=> $title,
					'subtitle'				=> $subtitle,
					'url'					=> $url,
					'auto_generate_size'	=> $auto_generate_size,
					'auto_generate'			=> $auto_generate == 0 ? false : true,
					'position'				=> $position,
					'active'				=> 0,
					'updated'				=> CAT_Helper_DateTime::getInstance()->getDateTime( $time ),
					'created'				=> CAT_Helper_DateTime::getInstance()->getDateTime( $time ),
					'created_by'			=> CAT_Users::getInstance()->get_username(),
					'content'				=> '',
					'short'					=> ''
				);
			} else return false;
		} // addEntry()

		/**
		 * add new entry
		 *
		 * @access public
		 * @return integer
		 *
		 **/
		public function removeEntry()
		{
			if ( !self::$section_id || !self::$page_id || !self::$news_id ) return false;

			$return	= false;
			$this->getEntryOptions('url');
			foreach (
				array( 'entry', 'content', 'content_options' ) as $table
			)
			{
				if( !CAT_Helper_Page::getInstance()->db()->query( sprintf(
						'DELETE FROM `:prefix:mod_blacknews_%s` WHERE `news_id` = :news_id',
						$table
					),
					array(
						'news_id'	=> self::$news_id
					)
				) ) return false;
				else $return = true;
			}

			if ($return) $this->removeAccessFolder( $this->options[self::$news_id]['url'] );
			return $return;
		} // removeEntry()

		/**
		 * reorder entries
		 *
		 * @access public
		 * @param  array			$entIDs - Strings from jQuery sortable()
		 * @return bool true/false
		 *
		 **/
		public function reorderEntries( $entIDs = array() )
		{
			if ( ( !self::$section_id || !self::$page_id )
				|| !is_array($entIDs)
				|| count($entIDs) == 0
			) return false;

			$return		= true;
			$counter	= count($entIDs);

			foreach( $entIDs as $entStr )
			{
				$entID	= explode('_', $entStr);
				if( !CAT_Helper_Page::getInstance()->db()->query(
					'UPDATE `:prefix:mod_blacknews_entry`
						SET `position` = :position
						WHERE `news_id`		= :news_id
							AND `page_id`		= :page_id
							AND `section_id`	= :section_id',
					array(
						'position'		=> $counter--,
						'news_id'		=> $entID[count($entID)-1],
						'page_id'		=> self::$page_id,
						'section_id'	=> self::$section_id
					)
				) ) $return = false;
			}
			return $return;
		} // end reorderEntries()

		/**
		 * get all entries from database
		 *
		 * @access public
		 * @param  string  $option		-
		 									true => get all active posts
		 									NULL => get all inactive and active posts
		 									numeric => get all inactive and active posts
		 * @param  string  $addContent	- if table to print - default false
		 * @return array()
		 *
		 **/
		public function getEntries( $option = true, $addContent = true, $rss = NULL )
		{
			$entries	= CAT_Helper_Page::getInstance()->db()->query( sprintf(
				'SELECT * FROM `:prefix:mod_blacknews_entry`' .
					' WHERE `section_id` = :section_id' .
					' %s' .
					' ORDER BY `position` %s' .
					' %s',
					$option ? 
						( $option === true ? " AND `active` >= 1" .
								" AND `start` < '" . time() . "'" .
								" AND ( `end` > '" . time() . "' OR `end` = 0 )"
							: " AND `news_id` = '" . intval($option) . "'" )
						: '',
					$rss ? ( $rss == 'backend' ? 'DESC' : 'ASC' ) : 'DESC',
					$rss ? ( $rss == 'backend' ? '' : 'LIMIT ' . $this->setRSSCounter() ) : 
						 'LIMIT ' . $this->setEPP()
				),
				array(
					'section_id'	=> self::$section_id
				)
			);

			if ( isset($entries) && $entries->numRows() > 0)
			{
				while( !false == ($row = $entries->fetchRow() ) )
				{
					$user	= CAT_Users::getInstance()->get_user_details( $row['created_by'] );

					$this->news_ids[]	= $row['news_id'];
					$this->entries[$row['news_id']]	= array(
						'news_id'		=> $row['news_id'],
						'active'		=> $row['active'] == 0 ? false : true,
						'start'			=> $row['start'] > 0 ?
								CAT_Helper_DateTime::getInstance()->getDateTime( $row['start'] ) : '',
						'end'			=> $row['end'] > 0 ?
								CAT_Helper_DateTime::getInstance()->getDateTime( $row['end'] ) : '',
						'created_TS'	=> $row['created'],
						'created'		=> CAT_Helper_DateTime::getInstance()->getDateTime( $row['created'] ),
						'updated_TS'	=> $row['updated'],
						'updated'		=> CAT_Helper_DateTime::getInstance()->getDateTime( $row['updated'] ),
						'created_by'	=> $user['username'],
						'categories'	=> $row['categories'],
						'highlight'		=> $row['highlight']
					);
				}
			}

			if ( $addContent )
			{
				$this->getEntryContent();
			}
			return $this->entries;
		} // end getEntries()


		/**
		 * save entry
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function saveEntry( $options = array() )
		{
			if ( !self::$page_id || !self::$section_id || !self::$news_id ) return false;
			if ( !is_array($options) || count($options) == 0 ) return false;

#$short_check			= $val->sanitizePost('short_check','numeric') != '' ? 1 : 0;

			if ( CAT_Helper_Page::getInstance()->db()->query(
				'UPDATE `:prefix:mod_blacknews_entry` SET ' .
					'`updated`		= :time, ' .
					'`categories`	= :categories, ' .
					'`start`		= :start, ' .
					'`end`			= :end ' .
					'WHERE ' .
					'`news_id`		= :news_id AND ' .
					'`page_id`		= :page_id AND ' .
					'`section_id`	= :section_id',
				array(
					'time'			=> time(),#$options['time'],
					'categories'	=> implode(',', array_filter( explode(',', $options['category'] ) ) ) ,
					'start'			=> $options['start'] != '' && $options['start'] > 0 ? strtotime( $options['start'] ) : '',
					'end'			=> $options['end'] != '' && $options['end'] > 0 ? strtotime( $options['end'] ) : '',
					'news_id'		=> self::$news_id,
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id
				)
			) && CAT_Helper_Page::getInstance()->db()->query(
				'UPDATE `:prefix:mod_blacknews_content` SET ' .
					'`title`				= :title, ' .
					'`subtitle`				= :subtitle, ' .
					'`image`				= :image, ' .
					'`auto_generate`		= :auto_generate, ' .
					'`auto_generate_size`	= :auto_generate_size, ' .
					'`short`				= :short_cont, ' .
					'`content`				= :long_cont, ' .
					'`text`					= :text ' .
					'WHERE ' .
					'`news_id`				= :news_id AND ' .
					'`page_id`				= :page_id AND ' .
					'`section_id`			= :section_id',
				array(
					'title'					=> addslashes( $options['title'] ),
					'subtitle'				=> addslashes( $options['subtitle'] ),
					'image'					=> '',
					'auto_generate'			=> $options['auto_generate'] != '' ? 1 : 0,
					'auto_generate_size'	=> intval( $options['auto_generate_size'] ),
					'short_cont'			=> addslashes( $options['short_cont'] ),
					'long_cont'				=> addslashes( $options['long_cont'] ),
					'text'					=> umlauts_to_entities(
						strip_tags( $options['long_cont'] ) . ' ' . strip_tags( $options['short_cont'] ),
						strtoupper(DEFAULT_CHARSET), 0
					),
					'news_id'				=> self::$news_id,
					'page_id'				=> self::$page_id,
					'section_id'			=> self::$section_id
				)
			) ) return true;
			else return false;
		} // end saveEntry()

		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		private function getEntryContent( $option = true )
		{
		
			if ( count($this->news_ids) > 0 )
			{
				$select	= '';
				foreach ( $this->news_ids as $id )
				{
					$select				.= " OR `news_id` = '" . intval( $id ) . "'";
				}
				$select		= ' AND (' . substr($select, 3) . ')';

				$options	= CAT_Helper_Page::getInstance()->db()->query(
					'SELECT * FROM `:prefix:mod_blacknews_content_options`
						WHERE `section_id` = :section_id ' . $select,
					array(
						'section_id'	=> self::$section_id
					)
				);
	
				if ( isset($options) && $options->numRows() > 0)
				{
					while( !false == ($row = $options->fetchRow() ) )
					{
						if ( isset($this->entries[$row['news_id']]) )
							$this->entries[$row['news_id']]	= array_merge(
								$this->entries[$row['news_id']],
								array(
									$row['name']		=> $row['value']
								)
							);
					}
				}
			}
		
			$entries	= CAT_Helper_Page::getInstance()->db()->query( sprintf(
				'SELECT * FROM `:prefix:mod_blacknews_content`
					WHERE `section_id` = :section_id %s',
					isset($select) ? $select : ''
				),
				array(
					'section_id'	=> self::$section_id
				)
			);
	
			if ( isset($entries) && $entries->numRows() > 0)
			{
				while( !false == ($row = $entries->fetchRow() ) )
				{
					if ( isset($this->entries[$row['news_id']]) )
						$this->entries[$row['news_id']]	= array_merge(
							$this->entries[$row['news_id']],
							array(
								'news_id'				=> $row['news_id'],
								'title'					=> stripcslashes( htmlspecialchars( $row['title'] ) ),
								'subtitle'				=> stripcslashes( htmlspecialchars( $row['subtitle'] ) ),
								'image_path'			=> $row['image'] != '' ? 
															CAT_PATH . MEDIA_DIRECTORY . '/blacknews/' . $row['image'] : '',
								'image_url'				=> $row['image'] != '' ?
															$this->sanitizeURL( CAT_URL . MEDIA_DIRECTORY . '/blacknews/' . $row['image'] ) : '',
								'auto_generate'			=> $row['auto_generate'] == 0 ? false : true,
								'auto_generate_size'	=> $row['auto_generate_size'],
								'short'					=> $row['auto_generate'] == 0 ?
																	strip_tags( $row['short'] ) : false,
								'content'				=> $row['content'],
								'pageurl'				=> $this->sanitizeURL( $this->getEntryOptions('url' , $row['news_id'] ) ),
								'url'					=> $this->sanitizeURL( $this->getOptions( 'permalink' ) . $this->getEntryOptions('url', $row['news_id']) )
							)
						);
				}
			}

			return $this->entries;
		} // end getEntryContent()

		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function getEntryOptions( $name = NULL, $news_id = NULL )
		{
			$news_id	= $news_id ? $news_id : self::$news_id;
			if ( $name && isset($this->options[$news_id][$name]) ) return $this->options[$news_id][$name];

			$getOptions		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
				'SELECT * FROM `:prefix:mod_blacknews_content_options`
					WHERE `section_id` = :section_id
					AND `news_id` = :news_id %s',
					$name ? ' AND `name` = \'' . $name . '\'' : ''
				),
				array(
					'section_id'	=> self::$section_id,
					'news_id'		=> $news_id
				)
			);

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow() ) )
				{
					$this->options[$row['news_id']][$row['name']]	= $row['value'];
				}
			}
			if ( $name
				&& $news_id
				&& isset($this->options[$news_id][$name]) )
					return $this->options[$news_id][$name];
			if ( $news_id 
				&& isset($this->options[$news_id][$name]) )
					return $this->options[$news_id];
			return $this->options;
		} // end getEntryOptions()


		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function saveEntryOptions( $name = NULL, $value = '' )
		{
			if ( !$name ) return false;
			if ( CAT_Helper_Page::getInstance()->db()->query(
				'REPLACE INTO `:prefix:mod_blacknews_content_options` SET
					`page_id`		= :page_id,
					`section_id`	= :section_id,
					`news_id`		= :news_id,
					`name`			= :name,
					`value`			= :value',
				array(
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id,
					'news_id'		=> self::$news_id,
					'name'			=> $name,
					'value'			=> is_null($value) ? '' : $value
				)
			) ) return true;
			else return false;

		} // end saveEntryOptions()

		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function getOptions( $name = NULL )
		{
			if ( $name && isset($this->options[$name]) ) return $this->options[$name];

			$sqlVal	= array(
				'section_id'	=> self::$section_id
			);
			if($name) $sqlVal['name']	= $name;

			$getOptions		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
				'SELECT * FROM `:prefix:mod_blacknews_options`
					WHERE `section_id` = :section_id %s',
					$name ? ' AND `name` = :name' : ''
				),
				$sqlVal
			);
				

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow() ) )
				{
					$this->options[$row['name']]	= $row['value'];
				}
			}
			if ( $name )
			{
				if ( isset( $this->options[$name] ) ) return $this->options[$name];
				else return NULL;
			}
			return $this->options;
		} // end getOptions()


		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function saveOptions( $name = NULL, $value = '' )
		{
			if ( !$name ) return false;
			if ( $name == 'permalink' 
				&& $value != ''
			) {
				if ( self::getOptions( 'permalink' ) != ''
					&& str_replace( '/', '', $value ) != str_replace( '/', '', self::getOptions( 'permalink' ) )
					&& !$this->renameAccessFolder(
						CAT_PATH . '/' . self::getOptions( 'permalink' ),
						CAT_PATH . '/' . $value
					)
				) return false;
				else{
					if ( substr($value, 0,1)	!= '/' ) $value	= '/' . $value;
					if ( substr($value, -1,1)	!= '/' ) $value	.= '/';
				}
			}
			if ( CAT_Helper_Page::getInstance()->db()->query(
				'REPLACE INTO `:prefix:mod_blacknews_options` SET
					`page_id`		= :page_id,
					`section_id`	= :section_id,
					`name`			= :name,
					`value`			= :value',
				array(
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id,
					'name'			=> $name,
					'value'			=> is_null($value) ? '' : $value
				)
			) ) return true;
			else return false;
		} // end saveOptions()





		/**
		 * get variant of gallery
		 *
		 * @access public
		 * @return string
		 *
		 **/
		public function getVariant()
		{
			if ( isset( $this->options['_variant'] ) )
				return $this->options['_variant'];

			$this->getModuleVariants();
			$this->getOptions('variant');

			$variant	= $this->options['variant'] != ''
				&& isset($this->module_variants[$this->options['variant']]) ?
						$this->module_variants[$this->options['variant']] : 
						'default';

			$this->options['_variant']	= $variant;

			return $this->options['_variant'];
		} // getVariant()



		/**
		 * get all possible variants for gallery
		 *
		 * @access public
		 * @return array
		 *
		 **/
		public function getModuleVariants()
		{
			if ( count($this->module_variants) > 0 ) return $this->module_variants;
			$getInfo	= CAT_Helper_Addons::checkInfo( CAT_PATH . '/modules/blacknews/' );

			$this->module_variants	= $getInfo['module_variants'];

			return $this->module_variants;
		} // getModuleVariants()


		/**
		 * get all categories for an entry
		 *
		 * @access public
		 * @return string
		 *
		 **/
		public function getCategories( $news_id = NULL )
		{
			$news_id	= $news_id ? $news_id : self::$news_id;

			$getOptions		= CAT_Helper_Page::getInstance()->db()->query(
				'SELECT `categories` FROM `:prefix:mod_blacknews_entry`
					WHERE `section_id` = :section_id
					AND `news_id` = :news_id',
				array(
					'section_id'	=> self::$section_id,
					'news_id'		=> $news_id
				)
			);

			$this->options['categories']	= array();

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow() ) )
				{
					$this->options['categories'][]	= $row['categories'];
				}
			}
			return $this->options['categories'];
		} // end getCategories()



		/**
		 * get all categories for an entry
		 *
		 * @access public
		 * @return string
		 *
		 **/
		public function getAllCategories()
		{
			if ( !self::$section_id ) return false;

			$getOptions		= CAT_Helper_Page::getInstance()->db()->query(
				'SELECT DISTINCT `categories` FROM `:prefix:mod_blacknews_entry`
					WHERE `section_id` = :section_id',
				array(
					'section_id'	=> self::$section_id
				)
			);

			$this->options['allCategories']	= array();

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow() ) )
				{
					$this->options['allCategories']	= array_merge(
						$this->options['allCategories'],
						explode( ',', $row['categories'])
					);
				}
			}
			return array_unique( array_filter( $this->options['allCategories'] ) );
		} // end getAllCategories()


		/**
		 * set entry to (un)published
		 *
		 * @access public
		 * @param  number  $status
		 * @return array()
		 *
		 **/
		public function setPublished( $status = NULL )
		{
			if ( $status === NULL || !self::$news_id ) return false;

			$status	= intval( $status );

			if ( CAT_Helper_Page::getInstance()->db()->query(
				'UPDATE `:prefix:mod_blacknews_entry`' .
					' SET `active`			= :active' .
					' WHERE `news_id`		= :news_id' .
						' AND `section_id`	= :section_id' .
						' AND `page_id`		= :page_id',
				array(
					'active'		=> $status,
					'news_id'		=> self::$news_id,
					'section_id'	=> self::$section_id,
					'page_id'		=> self::$page_id
			) ) )
			{
				if ( $status != 1 ) $this->removeAccessFolder( $this->getEntryOptions('url' , self::$news_id ) );
				else $this->createAccessFile( $this->getEntryOptions('url' , self::$news_id ) );

				return $status == 1 ? 'published' : 'unpublished';
			}
			else return false;
		} // end setPublished()

		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function setEPP()
		{
			$getOption	= self::getOptions( 'entries_per_page' );
			$this->epp	= $getOption > 0 ? $getOption : 10;

			return $this->epp;
		} // end setEPP()


		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function setRSSCounter()
		{
			$getOption	= self::getOptions( 'rss_counter' );
			$this->rss_counter	= $getOption > 0 ? $getOption : 10;

			return $this->rss_counter;
		} // end setEPP()


		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function createAccessFile( $title = NULL, $createDir = true, $recreate = NULL )
		{
			if ( !$title ) return false;
			elseif ( $title === true ) $title	= ''; // This is only for the root folder

			$dir	= $this->createTitleURL( $title );

			if ( self::$news_id > 0 )
			{
				$old_dir	= $this->getEntryOptions( 'url' );
				if ( $dir == $old_dir
					&& file_exists( CAT_PATH . $this->getOptions( 'permalink' ) . $dir )
					&& !$recreate
				) return true;
			}
			$counter	= 0;
			if ($title !== '' )
			{
				while ( file_exists( CAT_PATH . $this->getOptions( 'permalink' ) . $dir ) )
				{
					$dir	= $this->createTitleURL( $title . '-' . ++$counter );
				}
			}
			if ( $createDir )
			{
				$this->createAccessFolder( $dir );
			}
			
			if ( $this->createIndex( $dir ) )
			{
				return $dir;
			}
			else return false;
		} // end createAccessFile()

        /**
         * This method creates index.php files in every subdirectory of a given path
         *
         * @access public
         * @param  string  directory to start with
         * @return void
         *
         **/
        private function createIndex( $dir, $overwrite = true )
        {
			$level	= $dir != '' ? 2 : 1;

			// Prevent default index.php from beeing overwritten
			if ( $this->getOptions( 'permalink' ) == '' ) return false;

			$create_dir	= CAT_PATH . $this->getOptions( 'permalink' ) . $dir;

			if ( file_exists( $create_dir . '/index.php' ) && $overwrite === true )
				unlink ($create_dir . '/index.php');

            if ( $handle = dir( $create_dir ) )
            {
                if ( ! file_exists( $create_dir . '/index.php' ) )
                {
                    $fh = fopen( $create_dir . '/index.php', 'w' );
                    fwrite( $fh, '<' . '?' . 'php' . "\n" );
        	        fwrite( $fh, self::_access_file_code( $level ) );
        	        fclose( $fh );
                }

                $handle->close();
                return true;
            }
            else {
                return false;
            }
        }   // end function recursiveCreateIndex()



		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		private function createAccessFolder( $title = NULL )
		{
			if ( !$title ) return false;

			$counter	= 0;
			$folder		= $title;
			while( file_exists( CAT_PATH . '/' . $title ) )
			{
				$title	= $folder . '-' . ++$counter;
			}
			$this->saveEntryOptions( 'url', $title );
			if ( CAT_Helper_Directory::createDirectory( CAT_PATH  . $this->getOptions( 'permalink' ) . $title, NULL, false ) )
				return true;
			else return false;
		} // end createAccessFolder()

		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		public function createTitleURL( $title = NULL )
		{
			if ( !$title ) return false;

			return CAT_Helper_Page::getFilename( $title );
		} // end createTitleURL()

		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string/array  $id - id/ids of offer
		 * @param  string  $output - if table to print - default false
		 * @return array()
		 *
		 **/
		private function renameAccessFolder( $old_dir = NULL, $new_dir = NULL )
		{
			if ( !$old_dir || !$new_dir ) return false;
			if ( $old_dir == $new_dir ) return true;
			if ( file_exists($new_dir) && is_dir($new_dir) ) return false;

			if ( rename( $old_dir, $new_dir ) ){
				$this->permalink			= $new_dir;
				$this->options['permalink']	= $new_dir;
				return true;
			}
			else return false;
		} // end createTitleURL()

		/**
		 * get all offers from database
		 *
		 * @access public
		 * @param  string	$dir - name of the dir to be deleted
		 * @return array()
		 *
		 **/
		public function removeAccessFolder( $dir = NULL )
		{
			if ( !$dir || strpos( $dir,'../' || $dir == '' || $this->getOptions( 'permalink' ) == '' ) ) return false;
			if ( substr( $dir, 0, 1 ) != '/' ) $dir	= '/' . $dir;
			
			if ( CAT_Helper_Directory::removeDirectory( CAT_PATH  . $this->getOptions( 'permalink' ) . $dir, NULL, false ) )
				return true;
			else return false;
		} // end deleteAccessFolder()



		/**
		 *
		 *
		 *
		 *
		 **/
		public function checkRedirect()
		{
			if ( !defined('NEWS_SECTION') || !NEWS_SECTION || NEWS_SECTION == 'NEWS_SECTION' )
			{
				header("HTTP/1.1 301 Moved Permanently");
				// Weiterleitungsziel. Wohin soll eine permanente Weiterleitung erfolgen?
				header("Location:" . CAT_URL . self::getOptions( 'permalink' ) );
			}
		}   // end checkRedirect()



		/**
		 *
		 *
		 *
		 *
		 **/
		private static function getPageURL()
		{
			$isHTTPS	= (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
			$port		= (isset($_SERVER["SERVER_PORT"])
							&& (
								(!$isHTTPS && $_SERVER["SERVER_PORT"] != "80")
								|| ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")
							)
			);
			$port	= ($port) ? ':' . $_SERVER["SERVER_PORT"] : '';
			$url	= ($isHTTPS ? 'https://' : 'http://') . $_SERVER["SERVER_NAME"] . $port . $_SERVER["REQUEST_URI"];
			return $url;
		}   // end getPageURL()



		/**
		 * This method creates the rss-xml
		 *
		 * @access public
		 * @param  string  directory to start with
		 * @return void
		 *
		 **/
		public function createRSS()
		{
			// Prevent default index.php from beeing overwritten
			if ( $this->getOptions( 'permalink' ) == '' ) return false;

			$create_dir	= CAT_PATH . $this->getOptions( 'permalink' );

			if ( file_exists( $create_dir . '/rss.xml' ) )
				unlink ($create_dir . '/rss.xml');

			if ( file_exists($create_dir) && $handle = dir( $create_dir ) )
			{
				$fh = fopen( $create_dir . '/rss.xml', 'w' );
				fwrite( $fh, $this->_rss_file_code() );
				fclose( $fh );

				$handle->close();
				return true;
			}
			else {
				return false;
			}
		}   // end function createRSS()


		/**
		 *
		 *
		 *
		 *
		 **/
		private function validateRSScontent($data)
		{
			$newData = str_replace("&nbsp;", " ", $data);
			return '<![CDATA[ ' . utf8_encode( $newData ) . ' ]]>';
		}   // end validateRSScontent()

		/**
		 *
		 *
		 *
		 *
		 **/
		private function getRSSitems()
		{
			$this->RSS	= array(
				'items'				=> $this->getEntries( true, true, true ),
			
				'RSStitle'			=> $this->getOptions( 'rss_title' ),
				'RSSlink'			=> $this->sanitizeURL( CAT_URL . $this->getOptions( 'permalink' ) ),
				'RSSdescription'	=> $this->validateRSScontent( $this->getOptions( 'rss_description' ) ),
				'RSSpubDate'		=> date("D, d M Y H:i:s O", time()),
				'RSSlastDate'		=> date("D, d M Y H:i:s O", time()),
				'RSSdocs'			=> $this->sanitizeURL( CAT_URL . $this->getOptions( 'permalink' ) ) . '/rss.xml',
				'RSSEdit'			=> '',
				'copyright'			=> WEBSITE_TITLE,
				'managingEditor'	=> SERVER_EMAIL . ' (' . CATMAILER_DEFAULT_SENDERNAME . ')',
				'webMaster'			=> SERVER_EMAIL . ' (' . CATMAILER_DEFAULT_SENDERNAME . ')'
			);

			return $this->RSS['items'];
		}   // end getRSSitems()

		/**
		 *
		 *
		 *
		 *
		 **/
		private static function _access_file_code( $level = 2 )
		{
			$recursive	= '';
			for( $i=0; $i < $level; $i++)
			{
				$recursive	.= '../';
			}
			return sprintf(
				'
/**
 *	This file is autogenerated by the BlackNews
 *	Do not modify this file!
 */
$page_id		= %s;
$section_id		= %s;
%s

define( "NEWS_SECTION", $section_id);
%s

require(\'%sindex.php\');
?>',
				self::$page_id,
				self::$section_id,
				self::$news_id ? '$news_id		= ' . self::$news_id . ';' : '',
				self::$news_id ? 'define( "NEWS_ID", $news_id);' : '',
				$recursive
			);
		}   // end _access_file_code()

		/**
		 *
		 *
		 *
		 *
		 **/
		private function _rss_file_code()
		{
			$RSScontent	= '';
			//print_r($this->getRSSitems());
			foreach ( $this->getRSSitems() as $item )
			{
				$RSScontent	.= sprintf(
				'
		<item> 
			<title>%s</title>
			<description>%s</description>
			<content:encoded>%s</content:encoded>
			<guid>%s</guid>
			<link>%s</link>
			<pubDate>%s</pubDate>
			<dc:creator>%s</dc:creator>
			<category>[BETA]</category>
		</item>
',
					$this->validateRSScontent( $item['title'] ),
					$item['short'],
					$item['image_url'] != '' ? 
						$this->validateRSScontent( '<a href="' . CAT_URL . $this->getOptions( 'permalink' ) . $this->createTitleURL( $item['title'] ) .'"><img src="' . $item['image_url'] . '"></img></a>' . $item['content'] ) :
						$this->validateRSScontent( $item['content'] ),
					CAT_URL . $this->getOptions( 'permalink' ) . $this->getEntryOptions( 'url', $item['news_id'] ) ,
					CAT_URL . $this->getOptions( 'permalink' ) . $this->getEntryOptions( 'url', $item['news_id'] ) ,//$item['link'],
					date("D, d M Y H:i:s O", $item['updated_TS'] ),
					$item['created_by']
				);
			}
			return sprintf(
				'<?xml version="1.0" encoding="ISO-8859-1" ?>
<rss version="2.0" 
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/">
	<channel>
		<title>%s</title>
		<link>%s</link>
		<description>%s</description>
		<language>de-de</language>
		<pubDate>%s</pubDate>
		<lastBuildDate>%s</lastBuildDate>
		<docs>%s</docs>
		<managingEditor>%s</managingEditor>
		<generator>BlackCat CMS</generator>
		<webMaster>%s</webMaster>
		<copyright>Copyright (C) %s</copyright>
		<atom:link href="%s" rel="self" type="application/rss+xml" />
		%s
	</channel>
</rss>
',
					$this->RSS['RSStitle'],
					$this->RSS['RSSlink'],
					$this->RSS['RSSdescription'],
					$this->RSS['RSSpubDate'],
					$this->RSS['RSSlastDate'],
					$this->RSS['RSSdocs'],
					$this->RSS['managingEditor'],
					$this->RSS['webMaster'],
					$this->RSS['copyright'],
					$this->RSS['RSSdocs'],
					$RSScontent
			);
		}   // end _rss_file_code()
		/**
		 *
		 *
		 *
		 *
		 **/
		public function sanitizeURL( $url = NULL )
		{
			if ( !$url ) return false;
			$parts	= array_filter( explode( '/', $url ) );
			return	implode('/', $parts);
		}

	}
}

?>