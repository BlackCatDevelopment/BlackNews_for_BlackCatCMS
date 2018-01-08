<?php


/**
 *
 */
class CC_Form extends blackNews
{

	/**
	 * @var void
	 */
	protected static $instance		= NULL;
	protected static $entryID		= NULL;
	protected static $fieldID		= NULL;
	private static $values			= array();
	private static $missing			= array();

	private static $timestamp		= NULL;
	private static $timeToFill		= 8;
	private static $check_bot	= 0;

	public function __construct()
	{
		self::$check_bot	= CAT_Helper_Validate::getInstance()->sanitizePost( 'see_' . self::getTime() );
	}
	public function __destruct()
	{
	}



	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public static function getTime()
	{
		self::$timestamp	= CAT_Helper_Validate::getInstance()->sanitizePost( 'bot_temp','numeric' ) == '' ?
		self::setNewTime() : self::setTime();

		return self::$timestamp;
	}

	private static function checkTime()
	{
		if ( !self::$timestamp ) self::getTime();
		if ( self::$timestamp > 0
			&& ( self::$timestamp < ( time() - self::$timeToFill ) )
		) return true;
		else return false;
	}

	private static function setNewTime()
	{
		return rand(1000,9999) . time();
	}

	private static function setTime()
	{
		return intval( substr( trim( CAT_Helper_Validate::getInstance()->sanitizePost( 'bot_temp','numeric' ) ), 4) );
	}


	/**
	 *
	 */

	public function setFieldID($fieldID)
	{
		$this->fieldID	= $fieldID;
		return self::$instance;
	}


	/**
	 *
	 */

	public function getFieldID()
	{
		return $this->fieldID;
	}

	/**
	 *
	 */

	public function getEntryID()
	{
		return $this->entryID;
	}

	/**
	 *
	 */

	public function setEntryID($entryID)
	{
		$this->entryID	= $entryID;
		return self::$instance;
	}


	/**
	 *
	 */
	public function getFields($fieldID=NULL)
	{
		if(!$this->entryID) return false;
		$this->fields	= array();
		// Get all options
		$result = self::db()->query(
			'SELECT * FROM `:prefix:mod_blackNewsForm`
				WHERE `entryID` = :entryID
				ORDER BY `position` DESC',
			array(
				'entryID'		=> $this->entryID
			)
		);
		if( isset($result) && $result->rowCount() > 0 )
		{
			while ( false !== ( $field = $result->fetch() ) )
			{
				$this->fields[$field['fieldID']]	= $field;
			}
		}
		if ( $fieldID ) return $this->fields[$fieldID];
		return $this->fields;
	}

	/**
	 *
	 */
	public function addField($val=array())
	{
		if (!$this->entryID || count($val) == 0) return false;
		// set all info to table
		if( self::db()->query(
				'INSERT INTO `:prefix:mod_blackNewsForm` ' .
					'SET `entryID` = :entryID, `name` = :name, `type` = :type, `require` = :require, ' .
						'`values` = :values, `placeholder` = :placeholder, `width` = :width',
				array(
					'entryID'		=> $this->entryID,
					'name'			=> $val['name'],
					'type'			=> $val['type'],
					'require'		=> !$val['require'] || $val['require'] == 'false' ? 0 : 1,
					'values'		=> $val['values'],
					'placeholder'	=> $val['placeholder'],
					'width'			=> $val['width']
				)
			)
		) {
			$this->fieldID	= self::db()->lastInsertId();
			return true;
		} else return false;
	}

	/**
	 *
	 */
	public function saveField($val=array())
	{
		if (!$this->fieldID) return false;
		if( count($val) > 2 ) {
			// set all info to table
			if( self::db()->query(
				'UPDATE `:prefix:mod_blackNewsForm` ' .
					'SET `name` = :name, `type` = :type, `require` = :require, ' .
						'`values` = :values, `placeholder` = :placeholder, `width` = :width ' .
						'WHERE `fieldID` = :fieldID',
				array(
					'fieldID'		=> $this->fieldID,
					'name'			=> $val['name'],
					'type'			=> $val['type'],
					'require'		=> !$val['require'] || $val['require'] == 'false' ? 0 : 1,
					'values'		=> $val['values'],
					'placeholder'	=> $val['placeholder'],
					'width'			=> $val['width']
				)
			)) return true;
		} else if ( in_array($val['field'],
			array( 'type','require','values','placeholder','width','position' ) )
		) {
			// Set single info to table
			if( self::db()->query(
				'UPDATE `:prefix:mod_blackNewsForm` ' .
					'SET `' . $val['field'] . '` = :value ' .
					'WHERE `fieldID` = :fieldID',
				array(
					'fieldID'		=> $this->fieldID,
					'value'			=> $val['value']
				)
			)) return true;
		}
		return false;
	}

	/**
	 *
	 */
	public static function removeField( $fieldID = NULL )
	{
		if ( !$fieldID ) return false;
		else if (self::db()->query(
			'DELETE FROM `:prefix:mod_blackNewsForm`
				WHERE `fieldID` = :fieldID',
			array(
				'fieldID'	=> $fieldID
			)
		)) return true;
		return false;
	}

	/**
	 *
	 */
	public static function order($fieldIDs=array())
	{
		$counter	= count($fieldIDs);
		if ( $counter > 0 )
		{
			$obj	= self::getInstance();
			foreach( $fieldIDs as $field)
			{
				$obj->setFieldID($field);
				$obj->saveField(
					array(
						'field'	=> 'position',
						'value'	=> $counter--
					)
				);
			}
		}
	}


	/**
	 *
	 */
	public function setMail($send=true)
	{
		// Only for BC 1.x ... remove with support for 2.x only
		$val	=  CAT_Helper_Validate::getInstance();

		foreach( $this->getFields() as $field )
		{
			$getVal	= $val->sanitizePost( 'field_' . $field['fieldID'] );
			// check if field is required and if value is send
			if( $field['require'] )
			{
				// IF no value is send
				if ( $getVal == '' )
				{
					$this->missing[$field['fieldID']] = $field['fieldID'];
					continue;
				}
				// IF type is Email
				if ( $field['type'] == 5 && !$val->validate_email( $getVal ) ) 
				{
					$this->missing[$field['fieldID']] = $field['fieldID'];
					continue;
				}
			}
			if ( self::checkEmailValues($getVal) )
			{
				$this->values[$field['fieldID']]	= htmlspecialchars( strip_tags( $getVal ) );
				// Specials for ik
				switch ( $field['name'] )
				{
					case 'Anrede':
						self::setParserValue('anrede',$getVal);
						break;
					case 'E-Mail':
						self::setParserValue('email',$getVal);
						break;
					case 'Nachname':
						if( $getVal != '' ) self::setParserValue('nachname',$getVal);
						break;
				}
			}
			else $this->missing[$field['fieldID']]	= $field['fieldID'];
		}

		self::setParserValue('values',$this->values);
		self::setParserValue('missing',$this->missing);

		if ( !count($this->missing) )
		{
			self::setParserValue('SERVER_EMAIL', SERVER_EMAIL);
			self::setParserValue('CATMAILER_DEFAULT_SENDERNAME', CATMAILER_DEFAULT_SENDERNAME);
			if ($send===true) $this->sendMail();
			
		}

	} // end setMail();

	/**
	 *
	 */
	public function sendMail()
	{
		global $parser;
		$MailHelper	= CAT_Helper_Mail::getInstance( 'Swift' );

		$path	= CAT_PATH . '/modules/' . parent::$directory . '/templates/' . parent::getVariant() . '/mail/';

		$parser->setPath( $path );

		self::setParserValue('IP',
			empty($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER["REMOTE_ADDR"] : $_SERVER['HTTP_X_FORWARDED_FOR'] );
		self::setParserValue('BROWSER',$_SERVER['HTTP_USER_AGENT']);

		$values	= self::getParserValue();

		// Email an Kunden
		$MailHelper->sendMail(
			SERVER_EMAIL,
			$values['email'],
			$values['entry']['options']['formularMailTitelKunde'],
			$parser->get( 'mail_sender.tpl', $values ),
			CATMAILER_DEFAULT_SENDERNAME,
			$parser->get( 'mail_sender_html.tpl', $values )
		);
		// Email an Anbieter
		$MailHelper->sendMail(
			$values['email'],
			SERVER_EMAIL,
			$values['entry']['options']['formularMailTitelAnbieter'],
			$parser->get( 'mail_provider.tpl', $values ),
			CATMAILER_DEFAULT_SENDERNAME,
			$parser->get( 'mail_provider_html.tpl', $values )
		);

		self::setParserValue('sendMail',true);
	} // end sendMail();

	private function getMailer()
	{
		
	}

	/**
	 *
	 */
	public function getHTML($template='formularFormItem',$for='backend')
	{
		global $parser, $section_id;

		$return =	'';

		switch ($for)
		{
			case 'backend':
				$folder	= 'modify';
				break;
			case 'mail':
				$folder	= 'mail';
				break;
			default:
				$folder	= 'view';
				break;
		}

		$parser->setPath( CAT_PATH . '/modules/' . static::$directory . '/templates/' . parent::getVariant() . '/'.$folder.'/' );
		$parser->setFallbackPath( CAT_PATH . '/modules/' . static::$directory . '/templates/default/'.$folder.'/' );

		$template = 'formularFormItem';#$for == 'backend' ? 'modify' : 'view' EMAIL_KUNDE, EMAIL_ANBIETER;

		foreach( $this->getFields() as $field) 
		{
			$return	.= $parser->get(
				$template,
				array( 'field' => $field )
			);
		}
		return $return;
	}

	public function isSend()
	{
		if( CAT_Helper_Validate::getInstance()->sanitizePost( 'bot_temp','numeric' ) > 0 ) return true;
		else return false;
	}

	public function checkBot()
	{
		if( self::checkTime() && !self::$check_bot ) return true;
		else return false;
	}

	/**
	 *
	 * @access public
	 * @return
	 **/
	private static function checkEmailValues( $val )
	{
		if ( preg_match("/(to:|cc:|bcc:|from:|subject:|reply-to:|content-type:|MIME-Version:|multipart\/mixed|Content-Transfer-Encoding:)/ims", $val) )
		{
			return false;
		}
		if (preg_match("/%0A|%0D|%00|\\0|%09|\\t|%01|%02|%03|%04|%05|%06|%07|%08|%09|%0B|%0C|%0E|%0F|%10|%11|%12|%13/i", $val))
		{
			return false;
		}
		return true;
	}

}
