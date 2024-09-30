<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://wordpress.web-xperts.xyz
 * @since      1.0.0
 *
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    my-post_by_acewebx
 * @subpackage my-post_by_acewebx/public
 * @author     acewebx  
 */
class User_Post_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/my-post-by-acewebx-user-post-public.css', array(), $this->version, 'all' );
        // wp_enqueue_style('bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap-grid.min.css');
		wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
    }
	
    public function enqueue_scripts() {
        wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js', array(), '3.7.1', true);
		wp_enqueue_script('bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
        wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11');
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/my-post-by-acewebx-public.js', array( 'jquery' ), $this->version, true );

    }
	// Display current user login post and add the posts 
	function current_user_post_Shortcode() {
		if (is_user_logged_in()) {
			$current_user = wp_get_current_user();
			$args = array(
				'post_type'      => 'post',
				'author'         => $current_user->ID,
				'post_status'    => 'publish',
				'posts_per_page' => 6,
				'paged'          => get_query_var('paged') ? get_query_var('paged') : 1,
				'order'          => 'ASC',
			);
	
			$user_posts = new WP_Query($args);
	
			// Start output buffering
			ob_start();
			
			if ($user_posts->have_posts()) {
				require_once plugin_dir_path(dirname(__FILE__)) . '/public/partials/my-post-by-acewebx-public-display.php';
			} else {
				echo 'No posts found.';
			}
	
			// Get the buffered content and clean the buffer
			return ob_get_clean();
		} else {
			return 'You must be logged in to view your posts.';
		}
	}
	
	function Customer_post_Shortcode() {
		$number = get_option('post_display_no');
		$post_category = get_option('post_category');
		$categories_id = unserialize($post_category); 
		$categories = get_categories(array(
			'post_type'   => 'post',
			'include'     => $categories_id,
			'hide_empty'  => false,
		));
		
		$category_slugs = wp_list_pluck($categories, 'slug'); 
		$args = array(
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'posts_per_page' => $number,
			'order'          => 'ASC',
			'category_name'  => implode(',', $category_slugs),
		);
	
		$Display_post = new WP_Query($args);
	
		// Start output buffering
		ob_start();
		
		if ($Display_post->have_posts()) {
			require_once plugin_dir_path(dirname(__FILE__)) . '/public/partials/my-post-by-acewebx-Display-all-posts.php';
		} else {
			echo 'No posts found.';
		}
	
		// Get the buffered content and clean the buffer
		return ob_get_clean();
	}
	

	//function to delete the post on front end 
	function delete_post_callback() {
		check_ajax_referer('custom-ajax-nonce', 'security');
		$post_id = $_POST['post_id'];
		$post_type = 'post';
		$post_exists = get_post($post_id);
		if ($post_exists && $post_exists->post_type === $post_type) {
			$result = wp_delete_post($post_id, true);
		}
	}
	// handle the ajax of delete the post 
	function enqueue_custom_scripts() {
		wp_enqueue_script('custom-script', plugin_dir_url(__FILE__) . 'public/js/my-post-by-acewebx-public-display.php', array('jquery'), null, true);
		wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
		wp_localize_script('custom-script', 'ajax_object', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('custom-ajax-nonce')
		));
	}
}