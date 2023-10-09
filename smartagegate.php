<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://axelerant.com
 * @since             1.0.0
 * @package           SmartAgeGate
 *
 * @wordpress-plugin
 * Plugin Name:       Smart Age Gate
 * Plugin URI:        https://axelerant.com
 * Description:       Ensure legal compliance and restrict mature content with our Age Verification Plugin. Prompt visitors to verify their age before accessing your site, providing a seamless and secure experience.
 * Version:           1.0.0
 * Author:            Axelerant
 * Author URI:        https://axelerant.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       smartagegate
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('AGEGATE_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-smartagegate-activator.php
 */
function activate_smartagegate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-smartagegate-activator.php';
	SmartAgeGate_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-smartagegate-deactivator.php
 */
function deactivate_smartagegate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-smartagegate-deactivator.php';
	SmartAgeGate_Deactivator::deactivate();
}
/**
 * The code that runs during plugin uninstall.
 * This action is documented in includes/class-smartagegate-uninstall.php
 */
function uninstall_smartagegate()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-smartagegate-deactivator.php';
	SmartAgeGate_Uninstaller::uninstall();
}

register_activation_hook(__FILE__, 'activate_smartagegate');
register_deactivation_hook(__FILE__, 'deactivate_smartagegate');
register_uninstall_hook(__FILE__, 'uninstall_smartagegate');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-smartagegate.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_smartagegate()
{

	$plugin = new SmartAgeGate();
	$plugin->run();
}
run_smartagegate();
