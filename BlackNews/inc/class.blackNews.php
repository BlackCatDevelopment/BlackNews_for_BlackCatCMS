<?php

/*
   ____  __      __    ___  _  _  ___    __   ____     ___  __  __  ___
  (  _ \(  )    /__\  / __)( )/ )/ __)  /__\ (_  _)   / __)(  \/  )/ __)
   ) _ < )(__  /(__)\( (__  )  (( (__  /(__)\  )(    ( (__  )    ( \__ \
  (____/(____)(__)(__)\___)(_)\_)\___)(__)(__)(__)    \___)(_/\/\_)(___/

	@author			Black Cat Development
	@copyright		2016 Black Cat Development
	@link			http://blackcat-cms.org
	@license		http://www.gnu.org/licenses/gpl.html
	@category		CAT_Core
	@package		CAT_Core

*/

require_once 'class.blackNewsEntry.php' ;

if (!class_exists('blackNews', false))
{
	if (!class_exists('CAT_Addon_Page', false))
	{
		include(dirname(__FILE__) . '/../Engine/CAT_Addons/CAT_Addon_Page.php');
	}

	class blackNews extends CAT_Addon_Page
	{
		/**
		 * @var void
		 */
		protected static	$instance = NULL;


		protected static	$template		= 'modify';
		private static		$SEOUrl;
		private static		$categories		= array();
		protected static	$options		= array();
		private static		$routeUrl		= NULL;
		private static		$routeQuery		= NULL;
		protected static	$imageDir		= '/media/blacknews/';
		protected static	$imageName		= 'bNimage';
		private static		$parsed			= NULL;

		/**
		 * @var void
		 */
		protected static $name			= 'blackNews';
		protected static $directory		= 'blacknews';
		protected static $version		= '0.6';
		protected static $author		= 'Matthias Glienke, creativecat';
		protected static $license		= 'GNU General Public License';
		protected static $description	= 'Module for implementing news';
		protected static $guid			= '3cf5feb8-7873-4d55-a6f4-33aafed211da';
		protected static $home			= 'https://creativecat.de';
		protected static $platform		= '2.x';

		public function __construct()
		{
			parent::__construct();
		}
		public function __destruct()
		{
			parent::__destruct();
		}

		public static function getInstance()
		{
			if (!self::$instance)
			{
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 *
		 */
		public static function getVariant()
		{
			// set and get variant of module
			static::$variant	= self::getOption('variant');
			return static::$variant;
		}


		/**
		 * @param void $name
		 * @param void $value
		 */
		private static function saveOption()
		{
			if ($options = CAT_Helper_Validate::sanitizePost('options') )
				foreach($options as $opt)
				{
					self::setOption($opt['name'],$opt['value']);
				}
				return array(
					'message'	=> 'Eintrag gespeichert',
					'success'	=> true
				);
		} // end saveOption()

		/**
		 * @param void $name
		 * @param void $value
		 */
		private static function setOption($name, $value)
		{
			self::setIDs();

			if ($name=='permalink')
			{
				$value	= trim($value,'/');
				#$oldDir	= self::getOption('permalink');
				// IF directory is renamed, change directory
				/*if ( $oldDir != $value )
				{
					if ( file_exists(CAT_URL . '/' . $oldDir )
						&& is_dir(CAT_URL . '/' . $oldDir)
					) {
						self::renamePermalink( $oldDir, $value );
					} else {
						self::createPermalink( $value );
					}
				}*/
			}

			// Set info into table
			if( self::db()->query(
				'INSERT INTO `:prefix:mod_blackNewsOptions` ' .
					'(`section_id`, `name`, `value`) VALUES ( :section_id, :name, :value ) ' .
					'ON DUPLICATE KEY UPDATE `value` = :value',
				array(
					'section_id'	=> self::$section_id,
					'name'			=> $name,
					'value'			=> $value
				)
			)) return true;
			else return false;
		} // end setOption()


		/**
		 *
		 */
		public static function getOption($name=NULL)
		{
			if ( $name
				&& isset(self::$options[$name]) ) return self::$options[$name];

			self::setIDs();

			// Get all options
			$result = self::db()->query(
				'SELECT `value`, `name` FROM `:prefix:mod_blackNewsOptions` ' .
					'WHERE `section_id` = :section_id',
				array(
					'section_id'	=> self::$section_id
				)
			);
			if( $result && $result->rowCount() > 0 )
			{
				while ( false !== ( $option = $result->fetch() ) )
				{
					self::$options[$option['name']]	= $option['value'];
				}
			}
			if ( $name ) return static::$options[$name];
			return self::$options;
		}

		/**
		 *
		 */
		protected function getTemplate()
		{
			// TODO: implement here
			return 'view';
		}

		/**
		 *
		 */
		protected function setTemplate()
		{
			// TODO: implement here
		}

		/**
		 *
		 */
	/*	public static function getID()
		{
			self::setIDs();
			// Add a new blackNews
			self::$bnID	= self::db()->query(
				'SELECT `bnID` ' .
					'FROM `:prefix:mod_blackNews` ' .
						'WHERE `section_id` = :section_id ',
				array(
					'section_id'	=> self::$section_id
				)
			)->fetchColumn();

			return self::$bnID;
		}*/

		/**
		 *
		 */
		public static function getOverview($addOpt=NULL)
		{
			// Get all entries
			$result = self::db()->query(
				'SELECT * ' .
					'FROM `:prefix:mod_blackNewsEntry` ' .
						'WHERE `section_id` = :section_id ' .
						'ORDER BY position DESC',
				array(
					'section_id'		=> self::$section_id
				)
			);
			if( $result && $result->rowCount() > 0 )
			{
				$i	= 0;
				while ( false !== ( $entry = $result->fetch() ) )
				{
					$entries[++$i]	= $entry;
					if($addOpt)
					{
						foreach( blackNewsEntry::getInstance($entry['entryID'])->getOption() as $name => $value )
						{
							$entries[$i][$name]	= $value;
						}
						$entries[$i]['username']	= CAT_Users::getInstance()->get_user_details($entries[$i]['userID'],'username');
						$entries[$i]['display_name']	= CAT_Users::getInstance()->get_user_details($entries[$i]['userID'],'display_name');
						$entries[$i]['image']			= blackNewsEntry::getInstance($entry['entryID'])->getImage();
					}
				}
			}
			return $entries;
		}

		/**
		 *
		 */
		public static function getByCategory($addOpt=NULL,$category)
		{
			// Get all entries
			$result = self::db()->query(
				'SELECT * FROM `bc_eps_mod_blackNewsEntry` E ' .
					'INNER JOIN `bc_eps_mod_blackNewsCategoryEntries` EC ON E.entryID = EC.entryID ' .
					'INNER JOIN `bc_eps_mod_blackNewsCategory` C ON EC.catID = C.catID ' .
					'WHERE C.catID = :catID ' .
						'AND E.`section_id` = :section_id ' .
						'ORDER BY E.`position` DESC',
				array(
					'section_id'		=> self::$section_id,
					'catID'				=> $category
				)
			);
			if( $result && $result->rowCount() > 0 )
			{
				$i	= 0;
				while ( false !== ( $entry = $result->fetch() ) )
				{
					$entries[++$i]	= $entry;
					if($addOpt)
					{
						foreach( blackNewsEntry::getInstance($entry['entryID'])->getOption() as $name => $value )
						{
							$entries[$i][$name]	= $value;
						}
						$entries[$i]['username']	= CAT_Users::getInstance()->get_user_details($entries[$i]['userID'],'username');
						$entries[$i]['display_name']	= CAT_Users::getInstance()->get_user_details($entries[$i]['userID'],'display_name');
						$entries[$i]['image']			= blackNewsEntry::getInstance($entry['entryID'])->getImage();
					}
				}
			}
			return $entries;
		}

		/**
		 *
		 */
		private static function getEntry()
		{
			// TODO: Check if route is in database, else return 404
			// TODO: Add route to extra table with trigger to get history of files and automatically set 301

			return blackNewsEntry::getEntryByURL(trim( str_replace(self::getOption('permalink'),'',self::$routeUrl), '/' ));

		}

		/**
		 *
		 */
		public static function getCategories(int $section_id = NULL)
		{
			if ( count(self::$categories) > 0 ) return self::$categories;

			// Get all categories
			$r = self::db()->query(
				'SELECT * ' .
					'FROM `:prefix:mod_blackNewsCategory` ' .
						'WHERE `section_id` = :section_id',
				array(
					'section_id'		=> $section_id ? $section_id : self::$section_id
				)
			);
			if( $r && $r->rowCount() > 0 )
			{
				while ( false !== ( $c = $r->fetch() ) )
				{
					self::$categories[]	= $c;
				}
			}
			return self::$categories;
		}

		/**
		 * @param void $dir
		 */
		private static function createPermalink( $dir = '' )
		{
			if ( trim( $dir, '/' ) != ''
				&& CAT_Helper_Directory::createDirectory( CAT_PATH . '/' . trim( $dir, '/' ), NULL, false ) )
				return true;
			else return false;
		}

		/**
		 * @param void $old
		 * @param void $new
		 */
		private static function renamePermalink( $old = NULL, $new = NULL )
		{
			if ( !$old || !$new ) return false;
			if ( trim( $new, '/' ) == trim( $old, '/' ) ) return true;

			$nDir	= CAT_PATH . '/' . trim( $new, '/' );
			$oDir	= CAT_PATH . '/' . trim( $old, '/' );

			if ( ( file_exists($nDir) && is_dir($nDir))
				|| !is_dir($oDir) )
					return false;

			if ( rename( $oDir, $nDir ) )
			{
				self::setOption('permalink',$new);
				return true;
			}
			else return false;
		}


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
		 *
		 * @access public
		 * @param  array  $arr - array( date (dd.mm.yyyy), start (hh:mm), end (hh:mm) )
		 * @return
		 **/
		public function toTimestamp( $arr = NULL )
		{
			if ( !$arr || !is_array($arr) ) return false;
		
			$ts	= array();
			foreach( $arr as $date )
			{
				if ( strpos( $date['date'], '-' ) !== false ) list($y,$m,$d)	= explode( '-', $date['date'] );
				else list($d,$m,$y)	= explode( '.', $date['date'] );
				list($sh,$sm)	= explode( ':', $date['time_start'] );
				list($eh,$em)	= explode( ':', $date['time_end'] );
				$ts[]	= array(
					mktime( $sh, $sm, 0, $m, $d, $y ),
					mktime( $eh, $em, 0, $m, $d, $y ),
				);
			}
			return $ts;
		}   // end function toTimestamp()


		/**
		 *
		 */
		public static function add()
		{
			// Add a new blackNews
			return true;
			if ( self::db()->query(
					'INSERT INTO `:prefix:mod_blackNews` ' .
						'( `section_id` ) VALUES ' .
						'( :section_id )',
					array(
						'section_id'	=> self::$section_id
					)
				)
			) {
				#self::$bnID	= self::db()->lastInsertId();
				if ( self::db()->query(
						'INSERT INTO `:prefix:mod_blackNewsOptions` ' .
							'( `section_id`, `name`, `value` ) VALUES ' .
							'( :section_id, "variant", "default" )',
						array(
							'section_id'		=> self::$section_id
						)
					)
				) return $this;
			}
			else return NULL;
		}

		/**
		 *
		 */
		public static function update()
		{
			// Currently empty - placeholder for future updates
		}
		public static function checkRedirect()
		{
			$rUrl	= CAT_Registry::get('USE_SHORT_URLS') ?
					CAT_URL . '/' . self::$routeUrl
					: CAT_URL . '/' . trim(PAGES_DIRECTORY,'/') . '/' . self::$routeUrl;
			$sUrl	= CAT_Helper_Page::getLink(self::$page_id);

			if( self::getOption('permalink') . '.php' == self::$routeUrl )
			{
				$redirect	= CAT_Registry::get('USE_SHORT_URLS') ?
					CAT_URL  . '/' . self::getOption('permalink')
					: CAT_URL . '/' . trim(PAGES_DIRECTORY,'/') . '/' . self::getOption('permalink');
				header("HTTP/1.1 301 Moved Permanently");
				header("Location:" . $redirect );
				exit();
			}

/*			if( $rUrl == $sUrl && ( $rUrl == CAT_URL . $_SERVER['REQUEST_URI'] ) )
			{
				$redirect	= CAT_Registry::get('USE_SHORT_URLS') ?
					CAT_URL  . '/' . self::getOption('permalink') . '/'
					: CAT_URL . '/' . trim(PAGES_DIRECTORY,'/') . '/' . self::getOption('permalink') . '/';
				header("HTTP/1.1 301 Moved Permanently");
				header("Location:" . $redirect );
				exit();
			}*/
		}

		/**
		 *
		 */
		public static function view()
		{
			global $parser;

			self::setIDs();
			self::getRoute(PAGES_DIRECTORY);

			self::checkRedirect();

			$rUrl	= CAT_Registry::get('USE_SHORT_URLS') ?
					CAT_URL . '/' . self::$routeUrl
					: CAT_URL . '/' . trim(PAGES_DIRECTORY,'/') . '/' . self::$routeUrl;

			if ( self::$routeUrl == self::getOption('permalink') )
				#|| !self::$routeQuery )#$rUrl == CAT_Helper_Page::getLink(self::$page_id) )
			{
				self::setParserValue('entries',self::getOverview(true));
				static::$template	= 'view';
			} else {
				self::setParserValue('entry',self::getEntry());
				static::$template	= 'viewEntry';
			}

			self::setParserValue('options',self::getOption());

			if( file_exists( CAT_PATH . '/modules/' . static::$directory . '/view/' . self::getVariant() . '/view.php' ) )
				include CAT_PATH . '/modules/' . static::$directory . '/view/' . self::getVariant() . '/view.php';


			$parser->setPath( CAT_PATH . '/modules/' . static::$directory . '/templates/' . self::getVariant() );
			$parser->setFallbackPath( CAT_PATH . '/modules/' . static::$directory . '/templates/default' );

			if( !self::$parsed )
				$parser->output(
					static::$template,
					self::getParserValue()
				);

			self::$parsed = true;
		}



		/**
		 *
		 */
		public static function includeNews(int $section_id=NULL)
		{
			global $parser;
			$options	= self::getOption();

			self::setIDs($section_id);
			self::getVariant();
/*			self::getRoute(PAGES_DIRECTORY);

			self::checkRedirect();

			$rUrl	= CAT_Registry::get('USE_SHORT_URLS') ?
					CAT_URL . '/' . self::$routeUrl
					: CAT_URL . '/' . trim(PAGES_DIRECTORY,'/') . '/' . self::$routeUrl;

			if ( self::$routeUrl == self::getOption('permalink') )
				#|| !self::$routeQuery )#$rUrl == CAT_Helper_Page::getLink(self::$page_id) )
			{
				self::setParserValue('entries',self::getOverview(true));
				static::$template	= 'view';
			} else {
				self::setParserValue('entry',self::getEntry());
				static::$template	= 'viewEntry';
			}
*/

			if($options['category']) self::setParserValue('entries',self::getByCategory(true,$options['category']));
			else self::setParserValue('entries',self::getOverview(true));

			static::$template	= 'view';

			self::setParserValue('options',self::getOption());

			// Muss ich noch checken... weiß ich selbst gerade nicht mehr, warum das gesetzt sein muss
			self::$options['variant']	= $options['variant'];

			$parser->setPath( CAT_PATH . '/modules/' . static::$directory . '/templates/' . self::getVariant() );
			$parser->setFallbackPath( CAT_PATH . '/modules/' . static::$directory . '/templates/default' );

			if( !self::$parsed )
				$parser->output(
					static::$template,
					self::getParserValue()
				);

			self::$parsed = true;

		}


		/**
		 * retrieve the route
		 *
		 * @access private
		 * @return
		 **/
		private static function getRoute($remove_prefix=NULL)
		{
			foreach(array_values(array('REQUEST_URI','REDIRECT_SCRIPT_URL','SCRIPT_URL','ORIG_PATH_INFO','PATH_INFO')) as $key)
			{
				if(isset($_SERVER[$key]))
				{
					self::$routeUrl = parse_url($_SERVER[$key],PHP_URL_PATH);
					self::$routeQuery = parse_url($_SERVER[$key],PHP_URL_QUERY);
					if ( self::$routeQuery > '' ) self::$routeUrl = self::getOption('permalink') .'/'. str_replace('q=','',self::$routeQuery);
					break;
				}
			}
			if(!self::$routeUrl) { self::$routeUrl = '/'; }
			
			// remove params
			if(stripos(self::$routeUrl,'?'))
				list(self::$routeUrl,$ignore) = explode('?',self::$routeUrl,2);
			
			$path_prefix = str_ireplace(
				CAT_Helper_Directory::sanitizePath($_SERVER['DOCUMENT_ROOT']),
				'',
				CAT_Helper_Directory::sanitizePath(CAT_PATH)
			);


			// if there's a prefix to remove
			if($remove_prefix)
			{
				self::$routeUrl = str_replace(trim( $remove_prefix, '/' ),'',self::$routeUrl);
			}

			// Remove leading and ending "/"
			self::$routeUrl	= trim( self::$routeUrl, '/');

			return array(self::$routeUrl,self::$routeQuery);
		}   // end function initRoute()

		/**
		 *
		 */
		protected static function order($entryIDs=array())
		{
			$counter	= count($entryIDs);
			if ( $counter > 0 )
			{
				foreach( $entryIDs as $entry)
				{
					self::db()->query(
						'UPDATE `:prefix:mod_blackNewsEntry` ' .
							'SET `position` = :position '.
						'WHERE `entryID` = :entryID',
						array(
							'entryID'	=> $entry,
							'position'	=> $counter--
						)
					);
				}
			}
			return true;
		}

		/**
		 *
		 */
		public static function modify()
		{
			global $parser;

			self::setIDs();
			self::setParserValue('options',self::getOption());
			self::setParserValue('entries',self::getOverview());
			self::setParserValue('categories',self::getCategories());
			self::setParserValue('categories',self::getCategories(self::$parserValues['options']['setNews']));

			if ( file_exists(  CAT_PATH . '/modules/' . static::$directory . '/modify/' . self::getVariant() . '/modify.php' ) )
				include(  CAT_PATH . '/modules/' . static::$directory . '/modify/' . self::getVariant() . '/modify.php' );
			elseif ( file_exists( CAT_PATH . '/modules/' . static::$directory . '/modify/default/modify.php' ) )
				include( CAT_PATH . '/modules/' . static::$directory . '/modify/default/modify.php' );
			

			$parser->setPath( CAT_PATH . '/modules/' . static::$directory . '/templates/' . self::getVariant() );
			$parser->setFallbackPath( CAT_PATH . '/modules/' . static::$directory . '/templates/default' );

			if( !self::$parsed )
				$parser->output(
					static::$template,
					self::getParserValue()
				);

			self::$parsed = true;
		}


		/**
		 *
		 */
		public static function setParserValue($name=NULL,$value=NULL)
		{
			if( count(self::$parserValues) == 0 )
				self::$parserValues	= array(
					'CAT_ADMIN_URL'		=> CAT_ADMIN_URL,
					'CAT_PATH'			=> CAT_PATH,
					'CAT_URL'			=> CAT_URL,
					'page_id'			=> self::$page_id,
					'section_id'		=> self::$section_id,
					'version'			=> CAT_Helper_Addons::getModuleVersion(static::$directory),
					'variants'			=> self::getAllVariants(),
					'variant'			=> self::getVariant(),
					'bc_WYSIWYG'		=> array(
						'width'		=> '100%',
						'height'	=> '150px',
						'name'		=> 'wysiwyg_' . self::$section_id
					)
				);
			if ($name)
			{
				self::$parserValues[$name]	= ( isset(self::$parserValues[$name]) && is_array(self::$parserValues[$name])) ?
					array_merge(self::$parserValues[$name],$value) : $value;
			}
		}

		/**
		 *
		 */
		public static function getParserValue()
		{
			if( count(self::$parserValues) == 0 ) self::setParserValue();
			return self::$parserValues;
		}

		/**
		 *
		 */
		public static function save()
		{
			if ( CAT_Helper_Validate::sanitizePost('_cat_ajax') == 1 )
			{
				header('Content-type: application/json');
				$backend	= CAT_Backend::getInstance('Pages', 'pages_modify', false);
			} else
				$backend	= CAT_Backend::getInstance('Pages', 'pages_modify');

			$backend->updateWhenModified();

			$action		= CAT_Helper_Validate::sanitizePost( 'action' );
			$return		= array();
			self::setIDs();

			switch($action)
			{
				case 'setSkin':
					$return = self::setOption('variant',CAT_Helper_Validate::sanitizePost('variant'));
					break;
				case 'get':
					$return = blackNewsEntry::getEntry();
					break;
				case 'add':
					$return = blackNewsEntry::addEntry();
					break;
				case 'copy':
					$return = blackNewsEntry::copyEntry();
					break;
				case 'publish':
					$return = blackNewsEntry::publishEntry();
					break;
				case 'remove':
					$return = blackNewsEntry::removeEntry();
					break;
				case 'saveOptions':
					$return = self::saveOption();
					break;
				case 'orderEntries':
					$return = array(
						'message'	=> 'Einträge sortiert',
						'success'	=> self::order( CAT_Helper_Validate::sanitizePost('positions') )
					);
					break;
				case 'uploadIMG':
					if ( isset( $_FILES['bNimage']['name'] ) && $_FILES['bNimage']['name'] != '' )
					{
						$return	= array(
							'message'	=> $backend->lang()->translate( 'Image uploaded successfully!' ),
							'success'	=> blackNewsEntry::saveImage( $_FILES )
						);
					} else {
						$ajax_return	= array(
							'message'	=> $backend->lang()->translate( 'No images to upload' ),
							'success'	=> false
						);
					}
					break;
				case 'removeIMG':
					/*$deleted	= blackNewsEntry::removeImage();
					$return	= array(
						'message'	=> $deleted === true
							? $lang->translate( 'Image deleted successfully!' )
							: $lang->translate( 'An error occoured!' ),
						'success'	=> $deleted
					);*/
					$return	= array(
						'message'	=> 'delete',
						'success'	=> true
					);
					break;

				default: // save
					$return = blackNewsEntry::saveEntry();
					break;
			}

			if( CAT_Helper_Validate::sanitizePost('_cat_ajax') == 1 )
			{
				print json_encode( $return );
				exit();
			} else {
				global $page_id;
				$backend->print_success(
					isset($return['message']) ? $return['message'] : $backend->lang()->translate('Saved successfully'),
					CAT_ADMIN_URL . '/pages/modify.php?page_id=' . $page_id
				);
			}
		}

		/**
		 *
		 */
		public static function uninstall()
		{
			$errors	= self::sqlProcess($CAT_PATH . '/modules/' . static::$directory . '/inc/uninstall.sql');
			return $errors;
		}

		/**
		 *
		 */
		public static function upgrade()
		{
			// TODO: implement here
		}

	}
}