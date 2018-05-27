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

class CAT_Addon_Template extends CAT_Addon_Module
{

	/**
	 * @var void
	 */
	protected static $instance = NULL;

	/**
	 *
	 */
	public static function getInstance():void
	{
		// TODO: implement here
	}

	/**
	 * get form for special areas of the template
	 * login_form, search_form, forgot_form, preferences_form, signup_form, forgotpw_mail_body_html, forgotpw_mail_body, signup_mail_admin_body, signup_mail_body
	 * @param void $$value
	 */
	public static function getForm($$value = login):void
	{
		// TODO: implement here
	}
}
