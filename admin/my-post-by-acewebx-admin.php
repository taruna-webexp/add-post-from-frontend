<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.web-xperts.xyz
 * @since      1.0.0
 *
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/admin
 * @author     acewebx
 */
class User_Post_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/my-post-by-acewebx-admin.css', array(), $this->version, 'all' );
        wp_enqueue_style('bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css');
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/my-post-by-acewebx-admin.js', array( 'jquery' ), $this->version, false );
    }

    /**
     * Register custom post type 'my-post_by_acewebx'.
     *
     * @since    1.0.0
     */
    function custom_user_post() {
        // Add settings submenu under 'default post' post type
        add_action('admin_menu', function() {
            add_submenu_page(
                'edit.php', 
                'User Post Settings', 
                'My Post', 
                'manage_options',
                'custom_post_setting', 
                array($this, 'custom_post_setting_page_callback') // Callback function
            );
        });
    }

    /**
     * Callback function for custom post settings page.
     *
     * @since    1.0.0
     */
    public function custom_post_setting_page_callback() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/my-post-by-acewebx-admin-display.php';
    }
}

?>