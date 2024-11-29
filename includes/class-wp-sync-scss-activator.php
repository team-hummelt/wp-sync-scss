<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wiecker.eu
 * @since      1.0.0
 *
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/includes
 * @author     Jens Wiecker <plugins@wiecker.eu>
 */
class Wp_Sync_Scss_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate(): void
    {
       // update_option('wp_sync_scss_show_welcome_page', true);
        set_transient( 'wp_sync_scss_show_welcome_page', 1, 30 );
	}

}
