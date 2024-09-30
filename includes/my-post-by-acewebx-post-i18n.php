<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wordpress.web-xperts.xyz
 * @since      1.0.0
 *
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/includes
 * @author     acewebx  
 */
class User_Post_i18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {
		// Load the text domain for the plugin, allowing it to be translated
		load_plugin_textdomain(
			'my-post_by_acewebx', // Unique identifier for the plugin's text domain
			false, // Deprecated argument; unused in modern versions of WordPress
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' // Path to the languages directory
		);
	}

}
