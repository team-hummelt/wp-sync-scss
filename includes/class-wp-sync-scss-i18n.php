<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://wiecker.eu
 * @since      1.0.0
 *
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/includes
 * @author     Jens Wiecker <plugins@wiecker.eu>
 */
class Wp_Sync_Scss_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain(): void
    {

		load_plugin_textdomain(
			'autocompiler-scss',
			false,
			dirname(plugin_basename(__FILE__), 2) . '/languages/'
		);

	}



}
