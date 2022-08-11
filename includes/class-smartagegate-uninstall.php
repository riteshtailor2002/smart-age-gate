<?php

/**
 * Fired during plugin activation
 *
 * @link       https://axelerant.com
 * @since      1.0.0
 *
 * @package    SmartAgeGate
 * @subpackage SmartAgeGate/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    SmartAgeGate
 * @subpackage SmartAgeGate/includes
 * @author     Axelerant <ritesh.tailor@axelerant.com>
 */
class SmartAgeGate_Uninstaller
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function uninstall()
	{
		if (!current_user_can('activate_plugins'))
			return;
		check_admin_referer('bulk-plugins');
		if (__FILE__ != WP_UNINSTALL_PLUGIN)
			return;
	}
}
