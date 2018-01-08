<?php


/**
 *
 */
class CC_SEOUrl
{
	/**
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * @var void
	 */
	private static $instance	= NULL;
	private $seoPath			= '';
	private $seoUrl				= '';
	private $fileName			= '';
	private $title				= '';

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
	 * get all offers from database
	 *
	 * @access public
	 * @param  string/array  $id - id/ids of offer
	 * @param  string  $output - if table to print - default false
	 * @return array()
	 *
	 **/
	public static function createAccessFile( $title = NULL, $recreate = NULL )
	{
		if ( !$title ) return false;
		elseif ( $title === true ) $title	= ''; // This is only for the root folder

		$dir	= self::getFileName( $title );

		if ( self::$news_id > 0 )
		{
			$old_dir	= self::getEntryOptions( 'url' );
			if ( $dir == $old_dir
				&& file_exists( CAT_PATH . self::getOptions( 'permalink' ) . $dir )
				&& !$recreate
			) return true;
		}
		$counter	= 0;
		if ($title !== '' )
		{
			while ( file_exists( CAT_PATH . self::getOptions( 'permalink' ) . $dir ) )
			{
				$dir	= self::getFileName( $title . '-' . ++$counter );
			}
		}

		if ( !file_exists($dir) )
		{
			self::createFolder( $dir );
		}

		if ( self::createIndex( $dir ) )
		{
			return $dir;
		}
		else return false;
	} // end createAccessFile()

	/**
	 *
	 */
	public static function removeAccessFile()
	{
		// TODO: implement here
	}

	/**
	 *
	 */
	public static function renameAccessFile()
	{
		// TODO: implement here
	}

	/**
	 *
	 */
	public static function setPath()
	{
		// TODO: implement here
	}

	/**
	 *
	 */
	public static function setURL()
	{
		// TODO: implement here
	}

	/**
	 *
	 */
	private static function getPath()
	{
		// TODO: implement here
	}

	/**
	 *
	 */
	private static function getURL()
	{
		// TODO: implement here
	}


	/**
	 *
	 */
	private static function createFolder($folder=NULL)
	{
		if ( !$folder ) return false;

		$counter	= 0;
		$temp		= $folder;
		while( file_exists( CAT_PATH . '/' . $folder ) )
		{
			$folder	= $temp . '-' . ++$counter;
		}
#		self::saveEntryOptions( 'url', $folder );
		if ( CAT_Helper_Directory::createDirectory( CAT_PATH . self::getOptions( 'permalink' ) . $folder, NULL, false ) )
			return $folder;
		else return false;
	} // end createFolder()

	/**
	 *
	 */
	private static function renameFolder($old_dir = NULL, $new_dir = NULL )
	{
		if ( !$old_dir || !$new_dir ) return false;
		if ( $old_dir == $new_dir ) return true;
		if ( file_exists($new_dir) && is_dir($new_dir) ) return false;

		if ( rename( $old_dir, $new_dir ) ){
			self::$permalink			= $new_dir;
			self::$options['permalink']	= $new_dir;
			return true;
		}
		else return false;
	} // end renameFolder()

	/**
	 *
	 */
	private static function removeFolder($dir=NULL)
	{
		if ( !$dir || strpos( $dir,'../' || $dir == '' || self::getOptions( 'permalink' ) == '' ) ) return false;
		if ( substr( $dir, 0, 1 ) != '/' ) $dir	= '/' . $dir;
		
		if ( CAT_Helper_Directory::removeDirectory( CAT_PATH  . self::getOptions( 'permalink' ) . $dir, NULL, false ) )
			return true;
		else return false;
	} // end removeFolder()



	/**
	 *
	 */
	public static function getFileName()
	{
		// TODO: implement here
		return self::$fileName;
	}

	/**
	 *
	 */
	public static function setFileName( $name )
	{
		if ( !$name ) return false;

		self::$fileName = CAT_Helper_Page::getFilename( $name );
		return self::$fileName;
	}

	/**
	 * This method creates index.php files in every subdirectory of a given path
	 *
	 * @access public
	 * @param  string  directory to start with
	 * @return void
	 *
	 **/
	private static function createIndex( $dir, $overwrite = true )
	{
		$level	= $dir != '' ? 2 : 1;

		// Prevent default index.php from beeing overwritten
		if ( self::getOptions( 'permalink' ) == '' ) return false;
		
		$create_dir	= CAT_PATH . self::getOptions( 'permalink' ) . $dir;
		
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
	}
	// end function recursiveCreateIndex()



	/**
	 *
	 *
	 *
	 *
	 **/
	public static function checkRedirect()
	{
		if ( !NEWS_SECTION || NEWS_SECTION == 'NEWS_SECTION' )
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
		public static function sanitizeURL( $url = NULL )
		{
			if ( !$url ) return false;
			$parts	= array_filter( explode( '/', $url ) );
			return	implode('/', $parts);
		}


}
