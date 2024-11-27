<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wiecker.eu
 * @since      1.0.0
 *
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/admin
 * @author     Jens Wiecker <plugins@wiecker.eu>
 */
class Wp_Sync_Scss_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $basename    The ID of this plugin.
	 */
	private $basename;

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
	 * @param      string    $basename   The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( string $basename, string $version ) {

		$this->basename = $basename;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void
    {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Sync_Scss_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Sync_Scss_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->basename, plugin_dir_url( __FILE__ ) . 'css/wp-sync-scss-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void
    {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Sync_Scss_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Sync_Scss_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->basename, plugin_dir_url( __FILE__ ) . 'js/wp-sync-scss-admin.js', array( 'jquery' ), $this->version, false );

	}

}
