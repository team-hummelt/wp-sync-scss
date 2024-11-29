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

use WpSyncScss\Plugin\WpSynScssDefaults;

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
class Wp_Sync_Scss_Admin
{

    use WpSynScssDefaults;

    /**
     * Store plugin main class to allow public access.
     *
     * @since    1.0.0
     * @var Wp_Sync_Scss The main class.
     */
    protected Wp_Sync_Scss $main;

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $basename The ID of this plugin.
     */
    private $basename;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $basename The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct(string $basename, string $version, Wp_Sync_Scss $main)
    {

        $this->basename = $basename;
        $this->version = $version;
        $this->main = $main;

    }

    public function register_wp_sync_scss_admin_menu(): void
    {
        $settings = get_option($this->basename . '/settings');
        $hook_suffix = add_management_page(
            __('SCSS Compiler', 'wp-sync-scss'),
            __('SCSS Compiler', 'wp-sync-scss'),
            $settings['user_role'],
            'wp-sync-scss-options',
            array($this, 'wp_sync_scss_start')
        );

        add_action('load-' . $hook_suffix, array($this, 'wp_sync_scss_admin_options_script'));

        $hook_suffix = add_plugins_page(
            __('About WP-Sync-SCSS', 'wp-sync-scss'),
            __('About WP-Sync-SCSS', 'wp-sync-scss'),
            'manage_options',
            'wp-sync-scss-welcome',
            array( $this, 'wp_sync_scss_render_welcome_page' ) );

        add_action('load-' . $hook_suffix, array($this, 'wp_sync_scss_admin_options_script'));
    }



    public function wp_sync_scss_add_settings_link($links)
    {
        $settings_link = '<a href="' . admin_url( 'tools.php?page=wp-sync-scss-options' ) . '">'.__('Settings', 'wp-sync-scss').'</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }


    public function wp_sync_scss_start(): void
    {
        echo '<div class="wp-sync-scss" id="wp-sync-scss"></div>';
    }

    public function wp_sync_scss_render_welcome_page():void
    {
        echo '<div class="wp-sync-scss" id="wp-sync-scss"></div>';
    }

    public function wp_sync_scss_admin_options_script(): void
    {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        $title_nonce = wp_create_nonce('wp_sync_scss_admin_handle');

        wp_register_script('wp-sync-scss-admin-ajax-script', '', [], '', true);
        wp_enqueue_script('wp-sync-scss-admin-ajax-script');
        wp_localize_script('wp-sync-scss-admin-ajax-script', 'synCssClient', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => $title_nonce,
            'handle' => 'ScssAdminCompiler',
            'lang' => $this->wp_sync_scss_language()
        ));
    }

    public function wp_scss_sync_modify_plugin_description($plugin_meta, $plugin_file, $plugin_data, $status) {
        if (str_contains($plugin_file, 'wp-sync-scss.php')) {
            $new_links = array(
                'donate' => '<a href="https://www.paypal.com/donate/?hosted_button_id=WRZJAC9L2GYNJ" target="_blank">'.__('Donate', 'wp-sync-scss').'</a>',
            );

            $plugin_meta = array_merge( $plugin_meta, $new_links );
        }
        return $plugin_meta;
    }

    public function wp_scss_sync_plugin_description( $all_plugins ) {
        foreach ( $all_plugins as $plugin_file => &$plugin_data ) {
            if ( 'WP-Sync-SCSS' === $plugin_data['Name'] ) {
                $plugin_data['Description'] = __('WP-Sync-SCSS is a powerful WordPress plugin that converts SCSS files to CSS - directly in your admin area. Choose between different map output options (inline, separate file, or no map) to customise your workflow. Ideal for developers who value efficiency and customisability.', 'wp-sync-scss');
            }
        }
        return $all_plugins;
    }

    public function fn_wp_sync_scss_redirect_about_page():void
    {
        if ( ! current_user_can( 'manage_options' ) )
            return;
        if ( ! get_transient( 'wp_sync_scss_show_welcome_page' ) )
            return;
        delete_transient( 'wp_sync_scss_show_welcome_page' );
        wp_safe_redirect( admin_url( 'plugins.php?page=wp-sync-scss-welcome') );
        exit;
    }

    /**
     * @throws Exception
     */
    public function admin_ajax_ScssAdminCompiler(): void
    {
        check_ajax_referer('wp_sync_scss_admin_handle');
        require 'Ajax/WP_Sync_Scss_Admin_Ajax.php';
        $adminAjaxHandle = wp_sync_scss_admin_ajax::admin_ajax_instance($this->basename, $this->main, $this->version);
        wp_send_json($adminAjaxHandle->admin_ajax_handle());
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

        wp_enqueue_style($this->basename, plugin_dir_url(__FILE__) . 'css/wp-sync-scss-admin.css', array(), $this->version, 'all');

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


        wp_enqueue_script('jquery');
        wp_enqueue_style($this->basename . '-admin-bs-style', plugin_dir_url(__FILE__) . 'css/bs/bootstrap.min.css', array(), $this->version);
        wp_enqueue_style($this->basename . '-bootstrap-icons-style', WP_SYNC_SCSS_PLUGIN_URL . 'includes/vendor/twbs/bootstrap-icons/font/bootstrap-icons.css', array(), $this->version);
        //wp_enqueue_style($this->basename . '-admin-bs-style', plugin_dir_url(__FILE__) . 'css/admin-dashboard-style.css', array(), $this->version);

        wp_enqueue_style('wp-sync-scss-react-style', plugin_dir_url(__FILE__) . 'react/dist/main.css', array(), $this->version, false);
        wp_enqueue_script($this->basename, plugin_dir_url(__FILE__) . 'react/dist/main.js', array('jquery'), $this->version, true);

        //wp_enqueue_script($this->basename, plugin_dir_url(__FILE__) . 'js/wp-sync-scss-admin.js', array('jquery'), $this->version, false);

    }

}
