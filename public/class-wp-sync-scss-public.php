<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wiecker.eu
 * @since      1.0.0
 *
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Sync_Scss
 * @subpackage Wp_Sync_Scss/public
 * @author     Jens Wiecker <plugins@wiecker.eu>
 */
class Wp_Sync_Scss_Public
{

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
     * @param string $basename The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct(string $basename, string $version)
    {

        $this->basename = $basename;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        $settings = get_option($this->basename . '/settings');
        if ($settings && $settings['scss_active']) {
            $dir = $settings['destination'];
            if (is_dir($dir)) {
                if (!preg_match('~/$|\$~', $dir)) {
                    $dir = $dir . DIRECTORY_SEPARATOR;
                }
                $isFiles = [];
                global $wp_styles;
                $destination_dir = array_diff(scandir($dir), array('..', '.'));
                foreach ($destination_dir as $file) {
                    $pathInfo = pathinfo($dir . $file);
                    if ($pathInfo['extension'] === 'css') {
                        foreach ($wp_styles->queue as $handle) {
                            $style = $wp_styles->registered[$handle];
                            if (str_contains($style->src, $file)) {
                                $isFiles[] = $file;
                            }
                        }
                    }
                }
                foreach ($destination_dir as $file) {
                    $pathInfo = pathinfo($dir . $file);
                    if ($pathInfo['extension'] === 'css' && !in_array($file, $isFiles)) {
                        preg_match('/(wp-content.+|wp-include.+)/i', $dir, $matches);
                        if (!isset($matches[0])) {
                            continue;
                        }
                        $url = site_url() . '/' . str_replace('\\', '/', $matches[0]);
                        $url = $url . $pathInfo['basename'];
                        $id = 'wp-sync-css-compiler-file-' . $pathInfo['filename'];
                        $modificated =  gmdate('YmdHi', filemtime($dir . $pathInfo['basename']));
                        wp_enqueue_style($id, $url, [], $modificated);
                    }
                }
            }
        }
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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
    }

}
