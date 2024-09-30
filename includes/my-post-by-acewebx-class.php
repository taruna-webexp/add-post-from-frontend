<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wordpress.web-xperts.xyz
 * @since      1.0.0
 *
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/includes
 * @author     acewebx  
 */
class User_Post {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      User_Post_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		// Check if the plugin version is defined, else set a default value
		if ( defined( 'MY-POST_BY_ACEWEBX_VERSION' ) ) {
			$this->version = MY-POST_BY_ACEWEBX_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'my-post_by_acewebx';

		// Load the required dependencies
		$this->load_dependencies();
		// Set the locale for internationalization
		$this->set_locale();
		// Define hooks related to the admin area
		$this->define_admin_hooks();
		// Define hooks related to the public-facing side
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - User_Post_Loader. Orchestrates the hooks of the plugin.
	 * - User_Post_i18n. Defines internationalization functionality.
	 * - User_Post_Admin. Defines all hooks for the admin area.
	 * - User_Post_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		// Include the loader class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/my-post-by-acewebx-loader.php';

		// Include the internationalization class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/my-post-by-acewebx-post-i18n.php';

		// Include the admin-specific functionality class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/my-post-by-acewebx-admin.php';

		// Include the public-facing functionality class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/my-post-by-acewebx-public.php';

		// Instantiate the loader
		$this->loader = new User_Post_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the User_Post_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new User_Post_i18n();

		// Add action to load plugin textdomain for internationalization
		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new User_Post_Admin( $this->get_plugin_name(), $this->get_version() );

		// Add actions to enqueue admin styles and scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		// Add action to initialize custom post type
		$this->loader->add_action('init', $plugin_admin, 'custom_user_post');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new User_Post_Public( $this->get_plugin_name(), $this->get_version() );

		// Add actions to enqueue public styles and scripts
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		// Add actions for AJAX callbacks to delete posts
		$this->loader->add_action('wp_ajax_delete_post', $plugin_public, 'delete_post_callback');
		$this->loader->add_action('wp_ajax_nopriv_delete_post', $plugin_public, 'delete_post_callback');

		// Add action to enqueue custom scripts
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public,'enqueue_custom_scripts');

		// Add shortcodes for displaying current user posts and customer posts
		add_shortcode('currentuserpost', array($plugin_public, 'current_user_post_Shortcode'));
		add_shortcode('Customer_post', array($plugin_public, 'Customer_post_Shortcode'));
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    User_Post_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
