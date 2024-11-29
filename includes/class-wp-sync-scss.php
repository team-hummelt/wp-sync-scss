<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wiecker.eu
 * @since      1.0.0
 *
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/includes
 */

use JetBrains\PhpStorm\NoReturn;

use WpSyncScss\Plugin\Folder_Three;
use WpSyncScss\Plugin\WP_Sync_Scss_Compiler;
use WpSyncScss\Plugin\WP_Sync_Scss_Helper;

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
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/includes
 * @author     Jens Wiecker <plugins@wiecker.eu>
 */
class Wp_Sync_Scss
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Wp_Sync_Scss_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;


    /**
     * Store plugin main class to allow public access.
     *
     * @since    1.0.0
     * @var object The main class.
     */
    protected object $main;

    /**
     * The plugin Slug Path.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_slug plugin Slug Path.
     */
    protected string $plugin_slug;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version = '';

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->plugin_name = WP_SYNC_SCSS_BASENAME;
        $this->plugin_slug = WP_SYNC_SCSS_SLUG_PATH;
        /**
         * Currently plugin version.
         * Start at version 1.0.0 and use SemVer - https://semver.org
         * Rename this for your plugin and update it as you release new versions.
         */
        $plugin = get_file_data(plugin_dir_path(dirname(__FILE__)) . $this->plugin_name . '.php', array('Version' => 'Version'), false);
        if (!$this->version) {
            $this->version = $plugin['Version'];
        }


        $this->main = $this;
        $this->check_dependencies();
        $this->load_dependencies();

        if(!get_option($this->plugin_name . '/settings')) {
            $cacheDir =  WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'sync_scss_cache';
            $settings = [
                'source' => '',
                'destination' => '',
                'user_role' => 'manage_options',
                'scss_active' => false,
                'cache_active' => false,
                'formatter_mode' => 'expanded',
                'map_option' => 'file',
                'map_active' => false,
                'enqueue_aktiv' => false,
                'scss_login_aktiv' => false,
                'cache_dir' => $cacheDir
            ];
            if(!is_dir($cacheDir)) {
                mkdir($cacheDir, 0777, true);
            }
            update_option($this->plugin_name . '/settings', $settings);
        }

        $this->define_plugin_helper();
        $this->define_folder_three();
        $this->set_locale();
        $this->register_wp_sync_scss_compiler();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Wp_Sync_Scss_Loader. Orchestrates the hooks of the plugin.
     * - Wp_Sync_Scss_i18n. Defines internationalization functionality.
     * - Wp_Sync_Scss_Admin. Defines all hooks for the admin area.
     * - Wp_Sync_Scss_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies(): void
    {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-sync-scss-loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/WpSyncScssDefaults.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class_wp_sync_scss_helper.php';

        /**
         * Composer-Autoload
         * Composer Vendor for Theme|Plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/vendor/autoload.php';


        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class_folder_thee.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-wp-sync-scss-i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/SCSS_Compiler/class_wp_sync_scss_compiler.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-wp-sync-scss-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-wp-sync-scss-public.php';

        $this->loader = new Wp_Sync_Scss_Loader();

    }

    /**
     * Check PHP and WordPress Version
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function check_dependencies(): void
    {
        global $wp_version;
        if (version_compare(PHP_VERSION, WP_SYNC_SCSS_MIN_PHP_VERSION, '<') || $wp_version < WP_SYNC_SCSS_MIN_WP_VERSION) {
            $this->maybe_self_deactivate();
        }
    }

    /**
     * Self-Deactivate
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function maybe_self_deactivate(): void
    {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
        deactivate_plugins($this->plugin_slug);
        add_action('admin_notices', array($this, 'self_deactivate_notice'));
    }

    /**
     * Self-Deactivate Admin Notiz
     * of the plugin.
     *
     * @since    1.0.0
     * @access   public
     */
    #[NoReturn] public function self_deactivate_notice(): void
    {
        echo sprintf('<div class="notice notice-error is-dismissible" style="margin-top:5rem"><p>' . __('This plugin has been disabled because it requires a PHP version greater than %s and a WordPress version greater than %s. Your PHP version can be updated by your hosting provider.', 'wp-cache-flow') . '</p></div>', WP_SYNC_SCSS_MIN_PHP_VERSION, WP_SYNC_SCSS_MIN_WP_VERSION);
        exit();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Wp_Sync_Scss_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale(): void
    {

        $plugin_i18n = new Wp_Sync_Scss_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks(): void
    {

        $plugin_admin = new Wp_Sync_Scss_Admin($this->get_plugin_name(), $this->get_version(), $this->main);

        $this->loader->add_action('admin_menu', $plugin_admin, 'register_wp_sync_scss_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'fn_wp_sync_scss_redirect_about_page');
        $this->loader->add_filter('plugin_action_links_'.WP_SYNC_SCSS_SLUG_PATH, $plugin_admin, 'wp_sync_scss_add_settings_link',10 ,5 );

        $this->loader->add_action('wp_ajax_nopriv_ScssAdminCompiler', $plugin_admin, 'admin_ajax_ScssAdminCompiler');
        $this->loader->add_action('wp_ajax_ScssAdminCompiler', $plugin_admin, 'admin_ajax_ScssAdminCompiler');

        $this->loader->add_filter('plugin_row_meta', $plugin_admin, 'wp_scss_sync_modify_plugin_description', 10, 4);
        $this->loader->add_filter('all_plugins', $plugin_admin, 'wp_scss_sync_plugin_description');
        //

        //$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        //$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks(): void
    {

        $plugin_public = new Wp_Sync_Scss_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        //$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_plugin_helper(): void
    {
        global $wpSyncScssHelper;
        $wpSyncScssHelper = WP_Sync_Scss_Helper::instance($this->plugin_name, $this->get_version(), $this->main);
        $this->loader->add_filter($this->plugin_name .'/pregWhitespace', $wpSyncScssHelper, 'pregWhitespace');
    }
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_folder_three(): void
    {
        global $folderThree;

        $folderThree = new Folder_Three($this->plugin_name, $this->main);
        $this->loader->add_filter($this->plugin_name .'/get_file_node', $folderThree, 'fn_get_file_node', 10, 3);
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function register_wp_sync_scss_compiler(): void
    {
        global $syncScssCompiler;
        $syncScssCompiler = WP_Sync_Scss_Compiler::instance($this->plugin_name, $this->main);
        $syncScssCompiler->fn_wp_sync_scss_compile_files();
        $this->loader->add_filter($this->plugin_name .'/wp_sync_scss_compile_files', $syncScssCompiler, 'fn_wp_sync_scss_compile_files');
        $this->loader->add_filter($this->plugin_name .'/wp_sync_scss_compile_single_file', $syncScssCompiler, 'fn_wp_sync_scss_compile_single_file', 10, 2);
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run(): void
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @return    string    The name of the plugin.
     * @since     1.0.0
     */
    public function get_plugin_name(): string
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Wp_Sync_Scss_Loader    Orchestrates the hooks of the plugin.
     * @since     1.0.0
     */
    public function get_loader(): Wp_Sync_Scss_Loader
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version(): string
    {
        return $this->version;
    }

}
