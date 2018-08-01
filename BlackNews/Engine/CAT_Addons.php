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

if (!class_exists('CAT_Addons', false))
{
	class CAT_Addons extends CAT_Object
	{
		/**
		 * @var void
		 */
		private static $instance = NULL;
		protected static $_instances = array();
	
		protected static $name				= '';
		protected static $directory			= '';
		protected static $version			= '';
		protected static $author			= '';
		protected static $license			= '';
		protected static $description		= '';
		protected static $guid				= '';
		protected static $home				= '';
		protected static $platform			= '';
		protected static $type				= '';


		protected static $page_id;
		protected static $section_id;
		protected static $parserValues	= array();

		/**
		 * @var void
		 */
		protected static $precheckVersion;
	
		protected static $templatePath		= '';
		protected static $variant			= 'default';
		protected static $allVariants		= array();


		public function __construct()
		{
			self::$_instances[] = $this;
			$templatePath	= 'modules/' . static::$directory . '/templates/';
		}
	
		public function __destruct()
		{
			unset(self::$_instances[array_search($this, self::$_instances, true)]);
		}
	
	
		/**
		 * @param $includeSubclasses Optionally include subclasses in returned set
		 * @returns array array of objects
		 */
		public static function getInstances($includeSubclasses = false)
		{
			$return = array();
			foreach(self::$_instances as $inst) {
				$class	= get_class($this);
				if ($inst instanceof $class) {
					if ($includeSubclasses || (get_class($inst) === $class)) {
						$return[] = $inst;
					}
				}
			}
			return $return;
		}
	
		/**
		 *
		 */
		public static function getInstance()
		{
			if (!self::$instance)
			{
				self::$instance = new self();
			}
			return self::$instance;
		}


	
		/**
		 * currently workaround to set $section_id and $page_id
		 */
		public static function setIDs($section_id=NULL)
		{
			if (!$page_id)		$page_id	= CAT_Helper_Validate::get('_REQUEST','page_id','numeric');
			if (!$section_id)	$section_id	= CAT_Helper_Validate::get('_REQUEST','section_id','numeric');

			if ( $section_id )
			{
				if( !isset(self::$page_id) )
				{
					if( !isset($page_id) )
						global $page_id;
					self::$page_id	= $page_id;
				}
				self::$section_id	= intval($section_id);
			}
			else if( !(self::$page_id && self::$section_id) )
			{
				if( !isset($page_id) )		global $page_id;
				if (!isset($section_id) )	global $section_id;

				self::$page_id		= $page_id;
				self::$section_id	= $section_id;
			}
			if (static::$instance)
				return static::$instance;
		}

		/**
		 *
		 */
		public static function get()
		{
			// TODO: implement here
		}
	
		/**
		 * allows to get addon details by using the ID as set in the DB;
		 * returns array on success, false on fail
		 * use getInfo() with the ID
		 */
		private function getByID()
		{
			// TODO: implement here
		}



		/**
		 * get all installed addons from database
		 */
		protected static function getAll()
		{
			// TODO: implement here
		}
	
		/**
		 * get infos from  headers.inc.php
		 */
		public static function getHeader($for='backend')
		{

			$path		= CAT_PATH . '/modules/' . static::$directory . '/inc/headers/' . static::getVariant() .'/'.$for.'.ini';
			$default	= CAT_PATH . '/modules/' . static::$directory . '/inc/headers/default/'.$for.'.ini';

			if ( file_exists($path) )
				return parse_ini_file( $path, true);
			else if ( file_exists($default) )
				return parse_ini_file( $default, true);
		} // end getHeader()
	
		/**
		 * gets the details of an addons; uses the directory name to find the
		 * addon in the DB
		 * @access public
		 * @param  string  $temp_addon_file
		 * @param void $value
		 */
		public static function getInfo($value)
		{
			return static::$$value;
		}
	
		/**
		 * load info during install() or upgrade() to DB
		 */
		private static function setInfo()
		{
			// TODO: implement here
		}
	
		/**
		 * get info fro the info.php (or similar) while install(), upgrade()
		 */
		private function getInfoByFile()
		{
			// TODO: implement here
		}
	
		/**
		 *
		 */
		public static function getVariant()
		{
			// TODO: implement here
		}
	
		/**
		 * set variant of the Addon
		 */
		public static function setVariant()
		{
			// TODO: implement here
		}
	
		/**
		 * Get all available variants of an addon by checking the templates-folder
		 */
		public static function getAllVariants()
		{
			if ( count(self::$allVariants) > 0 )  return self::$allVariants;
			foreach( CAT_Helper_Directory::getInstance()->setRecursion(false)
				->scanDirectory( CAT_PATH . '/modules/' . static::$directory . '/templates/' ) as $path)
			{
				self::$allVariants[]	= basename($path);
			}
			return self::$allVariants;
		}
	
		/**
		 *
		 */
		public function precheck()
		{
			// TODO: implement here
		}
	
		/**
		 *
		 */
		public static function installAddon()
		{
			// TODO: implement here
		}
	
		/**
		 *
		 */
		public static function uninstallAddon()
		{

		}

		/**
		 * use in the  install() / upgrade()
		 */
		private function installUploaded()
		{
			// TODO: implement here
		}
	
		/**
		 *
		 */
		private static function isInstalled()
		{
			// In install() / upgrade()
		}
	
		/**
		 * check whether an addon is removeable => entry in the database
		 * is used in upgrade() / uninstall()
		 */
		private function isRemovable()
		{
			// TODO: implement here
		}

		/**
		 * gets the sections and pages a module is used on
		 */
		public function getUsage()
		{
			// TODO: implement here
		}
	
		/**
		 * get  module permissions for current user
		 * not sure, if this function should be in CAT_Addons, but in CAT_Permissions?
		 */
		public function getPermission()
		{
			// TODO: implement here
		}
		protected static function sqlProcess($file)
		{
			$errors	= array();
			$import	= file_get_contents($file);
			$import	= preg_replace( "%/\*(.*)\*/%Us", ''			  , $import );
			$import	= preg_replace( "%^--(.*)\n%mU" , ''			  , $import );
			$import	= preg_replace( "%^$\n%mU"		, ''			  , $import );
			$import	= preg_replace( "%cat_%"		, CAT_TABLE_PREFIX, $import );
			foreach (self::__split_sql_file($import, ';') as $imp){
				if ($imp != '' && $imp != ' ') {
					$ret = self::db()->query($imp);
					if ( self::db()->isError() )
						$errors[] = self::db()->getError();
				}
			}
			return $errors;
		}
		
		/**
		 * Credits: http://stackoverflow.com/questions/147821/loading-sql-files-from-within-php
		 * Copied from the install-folder
		 **/
		private static function __split_sql_file($sql, $delimiter)
		{
			// Split up our string into "possible" SQL statements.
			$tokens = explode($delimiter, $sql);
		
			// try to save mem.
			$sql = "";
			$output = array();
		
			// we don't actually care about the matches preg gives us.
			$matches = array();
		
			// this is faster than calling count($oktens) every time thru the loop.
			$token_count = count($tokens);
			for ($i = 0; $i < $token_count; $i++)
			{
			   // Don't wanna add an empty string as the last thing in the array.
			   if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
			   {
				  // This is the total number of single quotes in the token.
				  $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
				  // Counts single quotes that are preceded by an odd number of backslashes,
				  // which means they're escaped quotes.
				  $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);
		
				  $unescaped_quotes = $total_quotes - $escaped_quotes;
		
				  // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
				  if (($unescaped_quotes % 2) == 0)
				  {
					 // It's a complete sql statement.
					 $output[] = $tokens[$i];
					 // save memory.
					 $tokens[$i] = "";
				  }
				  else
				  {
					 // incomplete sql statement. keep adding tokens until we have a complete one.
					 // $temp will hold what we have so far.
					 $temp = $tokens[$i] . $delimiter;
					 // save memory..
					 $tokens[$i] = "";
		
					 // Do we have a complete statement yet?
					 $complete_stmt = false;
		
					 for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
					 {
						// This is the total number of single quotes in the token.
						$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
						// Counts single quotes that are preceded by an odd number of backslashes,
						// which means they're escaped quotes.
						$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);
		
						$unescaped_quotes = $total_quotes - $escaped_quotes;
		
						if (($unescaped_quotes % 2) == 1)
						{
						   // odd number of unescaped quotes. In combination with the previous incomplete
						   // statement(s), we now have a complete statement. (2 odds always make an even)
						   $output[] = $temp . $tokens[$j];
		
						   // save memory.
						   $tokens[$j] = "";
						   $temp = "";
		
						   // exit the loop.
						   $complete_stmt = true;
						   // make sure the outer loop continues at the right point.
						   $i = $j;
						}
						else
						{
						   // even number of unescaped quotes. We still don't have a complete statement.
						   // (1 odd and 1 even always make an odd)
						   $temp .= $tokens[$j] . $delimiter;
						   // save memory.
						   $tokens[$j] = "";
						}
		
					 } // for..
				  } // else
			   }
			}
		
			// remove empty
			for ( $i = count($output)+1; $i>=0; $i-- )
			{
				if ( isset($output[$i]) && trim($output[$i]) == '' )
				{
					array_splice($output, $i, 1);
				}
			}
		
			return $output;
		}


		/**
		 * Should be removed from this class
		 */
		public static function setParserValue($name=NULL,$value=NULL)
		{
			if( count($parserValues) == 0 )
				self::$parserValues	= array(
					'CAT_ADMIN_URL'		=> CAT_ADMIN_URL,
					'CAT_PATH'			=> CAT_PATH,
					'CAT_URL'			=> CAT_URL,
					'page_id'			=> self::$page_id,
					'section_id'		=> self::$section_id,
					'version'			=> CAT_Helper_Addons::getModuleVersion(static::$directory),
					'allVariants'		=> self::getAllVariants(),
					'variant'			=> self::getVariant()
				);
			if ($name)
				self::$parserValues[$name]	= $value;
		}

		/**
		 * Should be removed from this class
		 */

		public static function getParserValue()
		{
			if( count($parserValues) == 0 ) self::setParserValue();
			return self::$parserValues;
		}

	}
}