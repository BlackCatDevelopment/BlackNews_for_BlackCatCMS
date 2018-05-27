<?php

/*
 * ,-----.  ,--.              ,--.    ,-----.          ,--.       ,-----.,--.   ,--. ,---.   
 * |  |) /_ |  | ,--,--. ,---.|  |,-.'  .--./ ,--,--.,-'  '-.    '  .--./|   `.'   |'   .-'  
 * |  .-.  \|  |' ,-.  || .--'|     /|  |    ' ,-.  |'-.  .-'    |  |    |  |'.'|  |`.  `-.  
 * |  '--' /|  |\ '-'  |\ `--.|  \  \'  '--'\\ '-'  |  |  |      '  '--'\|  |   |  |.-'    | 
 * `------' `--' `--`--' `---'`--'`--'`-----' `--`--'  `--'       `-----'`--'   `--'`-----'  
 *   @author          Black Cat Development
   @copyright       2016 Black Cat Development
   @link            http://blackcat-cms.org
   @license         http://www.gnu.org/licenses/gpl.html
   @category        CAT_Core
   @package         CAT_Core

*/


if (!class_exists('CAT_Addon_Page', false))
{
	if (!class_exists('CAT_Addon_Module', false))
	{
		include(dirname(__FILE__) . '/CAT_Addon_Module.php');
	}
	if (!interface_exists('CAT_Addon_Page_Int', false))
	{
		interface CAT_Addon_Page_Int {
			public static function add();
			public static function remove();
			public static function view();
		}
	}
	abstract class CAT_Addon_Page extends CAT_Addon_Module implements CAT_Addon_Page_Int
	{
		/**
		 * @var void
		 */
		protected static $type		= 'page';
		protected static $addonID	= NULL;

		public function __construct()
		{
			parent::__construct();
		}
		public function __destruct()
		{
			parent::__destruct();
		}

		public static function add()
		{
			self::setIDs();

			// Add a new news section
			if ( self::db()->query(
					'INSERT INTO `:prefix:mod_' . static::$directory . '`
						( `page_id`, `section_id` ) VALUES
						( :page_id, :section_id )',
					array(
						'page_id'		=> self::$page_id,
						'section_id'	=> self::$section_id
					)
				)
			) {
				self::$addonID	= self::db()->lastInsertId();
				return self::$addonID;
			}
			else return NULL;
		}

		public static function view()
		{
			global $parser;

			self::$template	= 'view';

			$parser->setPath( CAT_PATH . '/modules/' . static::$directory . '/templates/' . self::getVariant() );
			$parser->setFallbackPath( CAT_PATH . '/modules/' . static::$directory . '/templates/default' );
			
			$parser->output(
				self::$template,
				self::getParserValue()
			);
		}

		public static function remove()
		{
			// Remove from database 
			if( self::db()->query(
				'DELETE FROM `:prefix:mod_' . static::$directory . '` ' .
					'WHERE `page_id` =:page_id ' .
					'AND `section_id` =:section_id',
				array(
					'page_id'		=> self::$page_id,
					'section_id'	=> self::$section_id
				)
			) ) return true;
			else return false;
		}

	}
}