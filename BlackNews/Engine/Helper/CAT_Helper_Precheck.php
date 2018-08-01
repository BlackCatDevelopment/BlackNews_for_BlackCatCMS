<?php

/*
   ____  __      __    ___  _  _  ___    __   ____     ___  __  __  ___
  (  _ \(  )    /__\  / __)( )/ )/ __)  /__\ (_  _)   / __)(  \/  )/ __)
   ) _ < )(__  /(__)\( (__  )  (( (__  /(__)\  )(    ( (__  )    ( \__ \
  (____/(____)(__)(__)\___)(_)\_)\___)(__)(__)(__)    \___)(_/\/\_)(___/

   @author          Black Cat Development
   @copyright       2016 Black Cat Development
   @link            http://blackcat-cms.org
   @license         http://www.gnu.org/licenses/gpl.html
   @category        CAT_Core
   @package         CAT_Core

*/


/**
 * is used by precheck() in CAT_Addons
 */
class CAT_Helper_Precheck
{
	/**
	 * is used by precheck() in CAT_Addons
	 */
	public function __construct()
	{
	}

	/**
	 * @var void
	 */
	private static $instance = NULL;

	/**
	 * @var void
	 */
	private static $states;


	/**
	 *
	 */
	public static function getInstance()
	{
		// TODO: implement here
	}

	/**
	 * PHP_EXTENSIONS, PHP_VERSION, PHP_SETTINGS, CAT_VERSION, CAT_ADDONS
	 */
	public function getVersion()
	{
		// TODO: implement here
	}

	/**
	 * set version to verify
	 * return instance();
	 */
	public function setVersion()
	{
		// TODO: implement here
	}

	/**
	 *
	 */
	private function versionCompare()
	{
		// TODO: implement here
	}

	/**
	 *
	 */
	public static function verifyVersion()
	{
		// TODO: implement here
	}

	/**
	 *
	 */
	public static function verifyCMSVersion()
	{
		// TODO: implement here
	}
}
