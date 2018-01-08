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

if (!class_exists('blackNewsEntry', false))
{
	if (!class_exists('blackNews', false))
	{
		include(dirname(__FILE__) . '/class.blackNews.php');
	}

	class blackNewsEntry extends blackNews
	{

		/**
		 * @var void
		 */
		private	static $entryID;
		private	static $typ;
		protected static $options	= array();
		private	static $info	= array();
		private	static $seoUrl;

		/**
		 *
		 */
		public function __construct()
		{
			parent::__construct();
		}
		public function __destruct()
		{
			parent::__destruct();
		}
		/**
		 * @param void $entryID
		 */
		public static function getInstance($entryID = NULL)
		{
			if (!self::$instance || $entryID )
			{
				self::$instance = new self();
			}
			if ( $entryID ) self::$entryID  = $entryID;
			return self::$instance;
		}

		/**
		 * @param void
		 */
		public static function getEntry()
		{
			return array_merge( self::getEntryInfo(), array(
				'entryID'	=> self::getEntryID(),
				'image'		=> self::getImage(),
				'message'	=> 'Eintrag geladen',
				'options'	=> self::getOption(),
				'success'	=> true
			));
		}
		/**
		 * @param void
		 */
		public static function getEntryByURL($seoURL=NULL)
		{
			if (!$seoURL) return false;

			self::$entryID = self::db()->query(
				'SELECT `entryID` FROM `:prefix:mod_blackNewsEntry`
					WHERE `seoURL` = :seoURL',
				array(
					'seoURL'		=> $seoURL
				)
			)->fetchColumn();
			return self::getEntry();
		} // end getEntryByURL()

		/**
		 * @param void $name
		 * @param void $value
		 */
		public static function getImage()
		{
			if( file_exists(CAT_PATH . parent::$imageDir . parent::$imageName. '_' . self::getEntryID() . '.jpg' ) )
				return CAT_URL . parent::$imageDir . parent::$imageName. '_' . self::getEntryID() . '.jpg';
			else return false;
			
		}


		/**
		 * @param void $name
		 * @param void $value
		 */
		public static function getOption($name=NULL)
		{
			if ( $name )
			{
				if (isset(self::$options[$name])) return self::$options[$name];

				// Get info from table
				return self::db()->query(
					'SELECT `value` FROM `:prefix:mod_blackNewsEntryOptions` ' .
						'WHERE `entryID` = :entryID AND `name` = :name',
					array(
						'entryID'	=> self::getEntryID(),
						'name'		=> $name
					)
				);
			} else {
				// Get all options
				$result = self::db()->query(
					'SELECT `value`, `name` ' .
						'FROM `:prefix:mod_blackNewsEntryOptions` ' .
							'WHERE `entryID` = :entryID',
					array(
						'entryID'		=> self::getEntryID()
					)
				);
				if( $result && $result->rowCount() > 0 )
				{
					while ( false !== ( $option = $result->fetch() ) )
					{
						self::$options[$option['name']]	= $option['value'];
					}
				}
				return self::$options;
			}
		}

		/**
		 * @param void $name
		 * @param void $value
		 */
		private static function setOption($name, $value)
		{
			// Get info from table
			return self::db()->query(
				'INSERT INTO `:prefix:mod_blackNewsEntryOptions` ' .
					'(`entryID`, `name`, `value`) VALUES ( :entryID, :name, :value ) ' .
					'ON DUPLICATE KEY UPDATE `value` = :value',
				array(
					'entryID'	=> self::getEntryID(),
					'name'		=> $name,
					'value'		=> $value
				)
			);
		}


		/**
		 * @param void $name
		 * @param void $value
		 */
		public function getEntryInfo($name=NULL)
		{
			// Get info from table
			self::$info = self::db()->query(
				'SELECT * FROM `:prefix:mod_blackNewsEntry` ' .
					'WHERE `entryID` = :entryID',
				array(
					'entryID'	=> self::getEntryID()
				)
			)->fetchRow();
			return $name ? self::$info[$name] : self::$info;
		}


		/**
		 * @param void $name
		 * @param void $value
		 */
		public function setEntryInfo($values)
		{
			// Add a new course
			return self::db()->query(
				'INSERT INTO `:prefix:mod_blackNewsEntry` ' .
					'( `entryID`, `title`, `content`, `text`, `seoURL` ) VALUES ' .
					'( :entryID, :title, :content, :text, :seoURL ) ' .
					'ON DUPLICATE KEY UPDATE `title` = :title, `content`= :content, `text` = :text, `seoURL` = :seoURL',
				array(
					'entryID'	=> self::getEntryID(),
					'title'		=> $values['title'],
					'content'	=> $values['wysiwyg'],
					'text'		=> strip_tags( $values['wysiwyg'] ),
					'seoURL'	=> $values['seoURL']
				)
			);
		}


		/**
		 *
		 */
		public function getEntryID()
		{
			if (!self::$entryID) self::setEntryID();
			return self::$entryID;
		}

		/**
		 *
		 */
		public static function setEntryID($entryID=NULL)
		{
			self::$entryID	= $entryID && is_numeric($entryID) ? $entryID : CAT_Helper_Validate::sanitizePost('entryID','numeric');
			return self::$entryID;
		}


		/**
		 *
		 */
		public function getDescription()
		{
			// TODO: implement here
		}

		/**
		 *
		 */
		public function setDescription($content)
		{
			// TODO: implement here
		}

		/**
		 *
		 */
		public static function publishEntry()
		{
			self::getEntryID();

			// Set publish
			if ( self::db()->query(
				'UPDATE `:prefix:mod_blackNewsEntry` ' .
					'SET `publish` = ( SELECT CASE ' .
						'WHEN `publish` = 0 THEN 1 ' .
						'ELSE 0 ' .
					'END AS publish ) ' .
					'WHERE `entryID` = :entryID',
				array(
					'entryID'	=> self::getEntryID()
				)
			) )
			{
				return array(
					'message'	=> 'Eintrag veröffentlicht',
					'publish'	=> self::getEntryInfo('publish'),
					'entryID'	=> self::getEntryID(),
					'success'	=> true
				);
			} else
				return array(
					'message'	=> 'Eintrag veröffentlicht',
					'publish'	=> self::getEntryInfo('publish'),
					'entryID'	=> self::getEntryID(),
					'success'	=> true
				);
		}

		/**
		 *
		 */
		public static function addEntry()
		{
			self::$info['title']	= self::createTitle();

			// Set publish
			if ( self::db()->query(
				'INSERT INTO `:prefix:mod_blackNewsEntry` ' .
					'( `section_id`, `userID`, `title`) VALUES ( :section_id, :userID, :title )',
				array(
					'section_id'	=> parent::$section_id,
					'userID'		=> CAT_Users::getInstance()->get_user_id(),
					'title'			=> self::$info['title']
				)
			) ) {
				self::$entryID	= self::db()->lastInsertId();

				return array(
					'message'	=> 'Eintrag angelegt',
					'html'		=> self::getHTML('entryList'),
					'entryID'	=> self::getEntryID(),
					'success'	=> true
				);
			}
		}

		/**
		 *
		 */
		public function saveEntry()
		{
			self::$entryID	= CAT_Helper_Validate::sanitizePost('entryID');

			self::setEntryInfo(CAT_Helper_Validate::sanitizePost('values'));

			if ($options = CAT_Helper_Validate::sanitizePost('options') )
				foreach($options as $opt)
				{
					self::setOption($opt['name'],$opt['value']);
				}
				return array(
					'message'	=> 'Eintrag gespeichert',
					'entryID'	=> self::getEntryID(),
					'success'	=> true
				);
		}

		/**
		 *
		 */
		public function removeEntry()
		{
			self::$entryID	= CAT_Helper_Validate::sanitizePost('entryID','numeric');

			if ( self::db()->query(
				'DELETE FROM `:prefix:mod_blackNewsEntry` ' .
					'WHERE `entryID` = :entryID',
				array(
					'entryID'		=> self::getEntryID()
				)
			) ) {
				return array(
					'message'	=> 'Eintrag gelöscht',
					'success'	=> true
				);
			}
		}

		/**
		 *
		 */
		public static function copyEntry()
		{
			$sourceID	= self::getEntryID();

			self::getEntryInfo();
			self::getOption();

			// copy main information of entry
			if ( self::db()->query(
				'INSERT INTO `:prefix:mod_blackNewsEntry` ' .
					'( `section_id`, `title`, `content`, `text`, `userID` ) ' .
					'VALUES ( :section_id, :title, :content, :text, :userID )',
				array(
					'section_id'	=> parent::$section_id,
					'title'			=> self::$info['title'],
					'content'		=> self::$info['content'],
					'text'			=> self::$info['text'],
					'userID'		=> CAT_Users::getInstance()->get_user_id(),
				)
			) ) {
				self::setEntryID( self::db()->lastInsertId() );

				// Copy options for entry
				foreach(self::$options as $key => $val)
				{
					self::setOption($key, $val);
				}



				foreach( CC_Form::getInstance()->setEntryID( $sourceID )->getFields() as $val)
				{
					CC_Form::getInstance()->setEntryID( self::getEntryID() )->addField( $val );
				}

				return array(
					'message'	=> 'Eintrag kopiert',
					'html'		=> self::getHTML( 'entryList' ),
					'entryID'	=> self::getEntryID(),
					'success'	=> true
				);
			} else return false;
		}


		/**
		 * save images
		 *
		 * @access public
		 * @param  array  $tmpFiles - images in an array
		 * @return boolean true/false
		 *
		 **/
		public function saveImage( $tmpFiles = NULL )
		{
			self::getEntryID();

			$field_name	= 'bNimage';

			if ( isset( $tmpFiles[$field_name]['name'] ) && $tmpFiles[$field_name]['name'] != '' )
			{
				// =========================================== 
				// ! Get file extension of the uploaded file   
				// =========================================== 
				$file_extension	= (strtolower( pathinfo( $tmpFiles[$field_name]['name'], PATHINFO_EXTENSION ) ) == '')
							? false
							: strtolower( pathinfo($tmpFiles[$field_name]['name'], PATHINFO_EXTENSION))
							;
				// ====================================== 
				// ! Check if file extension is allowed   
				// ====================================== 
				if ( isset( $file_extension ) && in_array( $file_extension, array( 'png', 'jpg', 'jpeg', 'gif' ) ) )
				{
					if ( ! is_array($tmpFiles) || ! count($tmpFiles) )
					{
						return CAT_Backend::getInstance('Pages', 'pages_modify')->lang()->translate('No files!');
					}
					else
					{
						$current = CAT_Helper_Upload::getInstance( $tmpFiles[$field_name] );
						if ( $current->uploaded )
						{
							$dir		= CAT_PATH . parent::$imageDir;
							$tempDir	= $dir . 'temp/';

							if( !file_exists($dir) || !is_dir($dir) )
								CAT_Helper_Directory::createDirectory( $dir, NULL, true );
							if( !file_exists($tempDir) || !is_dir($tempDir) )
								CAT_Helper_Directory::createDirectory( $tempDir, NULL, true );

							$current->file_overwrite		= true;
							$current->process( $tempDir );

							if ( $current->processed )
							{
#								$addImg	= $this->addImg( $file_extension );

								if ( !CAT_Helper_Image::getInstance()->make_thumb(
										$tempDir . $current->file_dst_name,
										$dir . parent::$imageName. '_' . self::getEntryID(),
										1400,//$resize_y,
										1400,//$resize_x,
										'fit',
										'jpg'
								) ) $return	= false;

#								$this->createImg( $addImg['image_id'], self::$thumb_x, self::$thumb_y );

#								$addImg['thumb']	= sprintf( '%s/thumbs_%s_%s/',
#									$this->galleryURL,
#									self::$thumb_x,
#									self::$thumb_y ) . $addImg['picture'];

								unlink( $tempDir . $current->file_dst_name );

								// =================================
								// ! Clean the upload class $files
								// =================================
								$current->clean();
								return true;
							}
							else
							{
								return CAT_Backend::getInstance('Pages', 'pages_modify')->lang()->translate('File upload error: {{error}}',array('error'=>$current->error));
							}
						}
						else
						{
							return CAT_Backend::getInstance('Pages', 'pages_modify')->lang()->translate('File upload error: {{error}}',array('error'=>$current->error));
						}
					}
				}
			}
		} // end saveImages()


		/**
		 *
		 */
		public function getShort()
		{
			// TODO: implement here
		}

		/**
		 *
		 */
		public function getUrl()
		{
			// TODO: implement here
		}

		/**
		 *
		 */
		public function setUrl()
		{
			// TODO: implement here
		}

		/**
		 *
		 */
		private static function createTitle()
		{
			$result = self::db()->query(
				'SELECT `title` FROM `:prefix:mod_blackNewsEntry` ' .
					'WHERE `section_id` = :section_id',
				array(
					'section_id'	=> self::$section_id
				)
			);

			$title	= 'Neuer Eintrag';
			$base	= $title;

			if( $result && $result->rowCount() > 0 )
			{
				$titles	= array();
				while ( false !== ( $name = $result->fetch() ) )
				{
					$titles[] = $name['title'];
				}
				$counter=0;
				while ( in_array($title,$titles) )
				{
					$title	= $base . '-' . ++$counter;
				}
			}
			return $title;
		}
		
		/**
		 *
		 */
		private static function getHTML($template='entryList')
		{
			global $parser, $section_id;

			$parser_data['entry']				= self::$info;
			$parser_data['section_id']			= $section_id;
			$parser_data['entry']['entryID']	= self::$entryID;
			$parser_data['CAT_URL']				= CAT_URL;

			self::$template	= $template;

			$parser->setPath( CAT_PATH . '/modules/' . static::$directory . '/templates/' . self::getVariant() . '/modify/' );
			$parser->setFallbackPath( CAT_PATH . '/modules/' . static::$directory . '/templates/default/modify/' );
			
			return $parser->get(
				self::$template,
				$parser_data
			);
		}
		
	}
}
require_once 'class.CC_Form.php';