<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wiecker.eu
 * @since             1.0.0
 * @package           Wp_Sync_Scss
 *
 * @wordpress-plugin
 * Plugin Name:       WP-Sync-SCSS
 * Plugin URI:        https://plugins.wiecker.eu
 * Description:       WP-Sync-SCSS ist ein leistungsstarkes WordPress-Plugin, das SCSS-Dateien in CSS umwandelt – direkt in deinem Admin-Bereich. Wähle zwischen verschiedenen Map-Ausgabeoptionen (inline, separate Datei, oder keine Map), um deinen Workflow flexibel zu gestalten. Ideal für Entwickler, die Effizienz und Anpassungsfähigkeit schätzen.
 * Version:           1.0.0
 * Author:            Jens Wiecker
 * Author URI:        https://wiecker.eu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-sync-scss
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * PHP minimum requirement for the plugin.
 */
const WP_SYNC_SCSS_MIN_PHP_VERSION = '7.4';

/**
 * WordPress minimum requirement for the plugin.
 */
const WP_SYNC_SCSS_MIN_WP_VERSION = '5.6';


/**
 * PLUGIN ROOT PATH.
 */
define('WP_SYNC_SCSS_PLUGIN_DIR', dirname(__FILE__));


/**
 * PLUGIN URL.
 */
define('WP_SYNC_SCSS_PLUGIN_URL', plugins_url('wp-sync-scss') . '/');

/**
 * PLUGIN SLUG.
 */
define('WP_SYNC_SCSS_SLUG_PATH', plugin_basename(__FILE__));

/**
 * PLUGIN Basename.
 */
define('WP_SYNC_SCSS_BASENAME', plugin_basename(__DIR__));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-sync-scss-activator.php
 */
function activate_wp_sync_scss(): void
{
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-sync-scss-activator.php';
	Wp_Sync_Scss_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-sync-scss-deactivator.php
 */
function deactivate_wp_sync_scss(): void
{
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-sync-scss-deactivator.php';
	Wp_Sync_Scss_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_sync_scss' );
register_deactivation_hook( __FILE__, 'deactivate_wp_sync_scss' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-sync-scss.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_sync_scss(): void
{

	$plugin = new Wp_Sync_Scss();
	$plugin->run();

}
run_wp_sync_scss();
