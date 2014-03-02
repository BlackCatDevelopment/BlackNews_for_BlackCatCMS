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

if ( ! class_exists( 'BlackNews', false ) ) {
	class BlackNews
	{

		protected static $news_id		= NULL;
		protected static $page_id		= NULL;
		protected static $section_id	= NULL;
		protected $epp					= NULL;
		protected $rss_counter			= NULL;


		public $options			= NULL;
		public $entries			= array();
		public $news_ids		= array();
		public $permalink		= NULL;
		public $RSS				= array();

		public static function getInstance()
		{
			if (!self::$instance)
				self::$instance = new self();
			else
				self::reset();
			return self::$instance;
		}

		public function __construct( $news_id	= NULL )
		{
			global $page_id, $section_id;
			if ( $news_id === true )
			{
			}
			elseif ( is_numeric($news_id) )
			{
				self::$news_id	= $news_id;
			}
			self::$section_id	= intval($section_id);
			self::$page_id		= intval($page_id);

			$this->permalink	= $this->getOptions( 'permalink' );

		}

		public function __destruct() {}



		/**
		 * get all offers from database
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
				"SELECT * FROM `%smod_%s`
					WHERE `%s` = '%s'%s
					ORDER BY `position` %s
					%s",

					CAT_TABLE_PREFIX,
					'blacknews_entry',
					'section_id',
					self::$section_id,
					$option ? 
						( $option === true ? ' AND `active` = \'1\'
								AND ( `start` < \'' . time() . '\' )
								AND ( ( `end` != 0 AND `end` > \'' . time() . '\') OR `end` = 0 )'
							: ' AND `news_id` = \'' . intval($option) . '\'' )
						: '',
					$rss ? ( $rss == 'backend' ? 'DESC' : 'ASC' ) : 'DESC',
					$rss ? ( $rss == 'backend' ? '' : 'LIMIT ' . $this->setRSSCounter() ) : 
						 'LIMIT ' . $this->setEPP()
				)
			);

			if ( isset($entries) && $entries->numRows() > 0)
			{
				while( !false == ($row = $entries->fetchRow( MYSQL_ASSOC ) ) )
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
					$select	.= ' OR news_id = ' . $id;
				}
				$select		= 'AND (' . substr($select, 3) . ')';

				$options	= CAT_Helper_Page::getInstance()->db()->query( sprintf(
					"SELECT * FROM `%smod_%s`
						WHERE `%s` = '%s'%s",
				
						CAT_TABLE_PREFIX,
						'blacknews_content_options',
						'section_id',
						self::$section_id,
						$select
					)
				);
	
				if ( isset($options) && $options->numRows() > 0)
				{
					while( !false == ($row = $options->fetchRow( MYSQL_ASSOC ) ) )
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
				"SELECT * FROM `%smod_%s`
					WHERE `%s` = '%s'%s",

					CAT_TABLE_PREFIX,
					'blacknews_content',
					'section_id',
					self::$section_id,
					isset($select) ? $select : ''
				)
			);
	
			if ( isset($entries) && $entries->numRows() > 0)
			{
				while( !false == ($row = $entries->fetchRow( MYSQL_ASSOC ) ) )
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
				"SELECT * FROM `%smod_%s`
					WHERE `%s` = '%s'
					AND `%s` = '%s'%s",
					CAT_TABLE_PREFIX,
					'blacknews_content_options',
					'section_id',
					self::$section_id,
					'news_id',
					$news_id,
					$name ? ' AND `name` = \'' . $name . '\'' : ''
				)
			);

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow( MYSQL_ASSOC ) ) )
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
			if ( CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"REPLACE INTO `%smod_%s` SET
					`page_id`		= '%s',
					`section_id`	= '%s',
					`news_id`		= '%s',
					`name`			= '%s',
					`value`			= '%s'",
					CAT_TABLE_PREFIX,
					'blacknews_content_options',
					self::$page_id,
					self::$section_id,
					self::$news_id,
					addslashes( $name ),
					addslashes( $value )
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

			$getOptions		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"SELECT * FROM `%smod_%s`
					WHERE `%s` = '%s'%s",
					CAT_TABLE_PREFIX,
					'blacknews_options',
					'section_id',
					self::$section_id,
					$name ? ' AND `name` = \'' . addslashes( $name ) . '\'' : ''
				)
			);

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow( MYSQL_ASSOC ) ) )
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
			if ( CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"REPLACE INTO `%smod_%s` SET
					`page_id`		= '%s',
					`section_id`	= '%s',
					`name`			= '%s',
					`value`			= '%s'",
					CAT_TABLE_PREFIX,
					'blacknews_options',
					self::$page_id,
					self::$section_id,
					addslashes($name),
					addslashes($value)
				)
			) ) return true;
			else return false;
		} // end saveOptions()




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

			$getOptions		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"SELECT `categories` FROM `%smod_%s`
					WHERE `%s` = '%s'
					AND `%s` = '%s'",
					CAT_TABLE_PREFIX,
					'blacknews_entry',
					'section_id',
					self::$section_id,
					'news_id',
					$news_id
				)
			);

			$this->options['categories']	= array();

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow( MYSQL_ASSOC ) ) )
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

			$getOptions		= CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"SELECT DISTINCT `categories` FROM `%smod_%s`
					WHERE `%s` = '%s'",
					CAT_TABLE_PREFIX,
					'blacknews_entry',
					'section_id',
					self::$section_id
				)
			);

			$this->options['allCategories']	= array();

			if ( isset($getOptions) && $getOptions->numRows() > 0)
			{
				while( !false == ($row = $getOptions->fetchRow( MYSQL_ASSOC ) ) )
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

			if ( CAT_Helper_Page::getInstance()->db()->query( sprintf(
				"UPDATE `%smod_%s`
					SET `active`		= '%s'
					WHERE `news_id`		= '%s'
					AND `section_id`	= '%s'
					AND `page_id`		= '%s'",
					CAT_TABLE_PREFIX,
					'blacknews_entry',
					$status,
					self::$news_id,
					self::$section_id,
					self::$page_id
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
			if ( !$dir || strpos( $dir,'../' ) ) return false;
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
			$curURL	= array_values(
				array_filter(
					explode('/', str_replace( CAT_URL, '', $this->getPageURL() ) )
				)
			);

			if ( $curURL[0] != str_replace( '/', '', self::getOptions( 'permalink' ) ) )
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
				'RSSdocs'			=> $this->sanitizeURL( CAT_URL . $this->getOptions( 'permalink' ) ) . 'rss.xml',
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
	xmlns:dc="http://purl.org/dc/elements/1.1/"
>
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