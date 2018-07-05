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


if (!class_exists('CAT_Addon_Module', false))
{
	if (!class_exists('CAT_Addons', false))
	{
		include(dirname(__FILE__) . '/../CAT_Addons.php');
	}
	if (!interface_exists('CAT_Addon_Module_Int', false))
	{
		interface CAT_Addon_Module_Int {
			public static function save();
			public static function modify();
			public static function install();
			public static function uninstall();
			public static function upgrade();
		}
	}
	abstract class CAT_Addon_Module extends CAT_Addons implements CAT_Addon_Module_Int
	{
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
		 * Default install routine
		 */
		public static function install()
		{
			self::uninstall();

			$errors	= self::sqlProcess( CAT_PATH . '/modules/' . static::$directory . '/inc/db/structure.sql' );

			$addons_helper = new CAT_Helper_Addons();
			foreach(
				array(
					'save.php'
				)
				as $file
			) {
				if ( false === $addons_helper->sec_register_file( static::$directory, $file ) )
				{
					 error_log( "Unable to register file -$file-!" );
				}
			}
			return $errors;
		}

		/**
		 * Default uninstall routine
		 */
		public static function uninstall()
		{
			$errors	= self::sqlProcess( CAT_PATH . '/modules/' . static::$directory . '/inc/db/uninstall.sql');
			return $errors;
		}

		/**
		 *
		 */
		public abstract static function upgrade();
		/**
		 *
		 */
		public abstract static function save();

		/**
		 * Default modify routine
		 */
		public static function modify()
		{
			global $parser;

			self::setIDs();

			// Should be moved to the Object
			self::setParserValue();

			$parser->setPath( CAT_PATH . '/modules/' . static::$directory . '/templates/' . self::getVariant() );
			$parser->setFallbackPath( CAT_PATH . '/modules/' . static::$directory . '/templates/default' );

			$parser->output(
				static::$template,
				static::getParserValue()
			);
		}

	}
}