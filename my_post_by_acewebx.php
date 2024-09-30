<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://wordpress.web-xperts.xyz
 * @since             1.0.0
* @package            my-post_by_acewebx
 *
 * @wordpress-plugin
 * Plugin Name:       My posts by Acewebx
 * Plugin URI:        https://my-post_by_acewebx
 * Description:       This plugin gives users the feature to add and view their posts from front end.
 * Version:           1.0.0
 * Author:            acewebx 
 * Author URI:        https://https://wordpress.web-xperts.xyz/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       my-post_by_acewebx
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'my_post_by_acewebx', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-user-post-activator.php
 */
function activate_user_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/my-post-by-acewebx-activator.php';
	User_Post_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-user-post-deactivator.php
 */
function deactivate_user_post() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/my-post-by-acewebx-deactivator.php';
	User_Post_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_user_post' );
register_deactivation_hook( __FILE__, 'deactivate_user_post' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/my-post-by-acewebx-class.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_user_post() {

	$plugin = new User_Post();
	$plugin->run();

}
run_user_post();
