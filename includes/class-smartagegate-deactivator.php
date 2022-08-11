<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://axelerant.com
 * @since      1.0.0
 *
 * @package    SmartAgeGate
 * @subpackage SmartAgeGate/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    SmartAgeGate
 * @subpackage SmartAgeGate/includes
 * @author     Axelerant <ritesh.tailor@axelerant.com>
 */
class SmartAgeGate_Deactivator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{
		if (!current_user_can('activate_plugins'))
			return;
	}
}
