<?php

use WpSyncScss\Plugin\WpSynScssDefaults;

class wp_sync_scss_admin_ajax
{
    private static $admin_ajax_instance;
    private string $method;
    private object $responseJson;

    use WpSynScssDefaults;

    /**
     * The ID of this Plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $basename The ID of this theme.
     */
    protected string $basename;

    protected string $version;

    /**
     * Store plugin main class to allow public access.
     *
     * @since    1.0.0
     * @var Wp_Sync_Scss The main class.
     */
    protected Wp_Sync_Scss $main;

    /**
     * @return static
     */
    public static function admin_ajax_instance(string $basename, Wp_Sync_Scss $main, string $version): self
    {
        if (is_null(self::$admin_ajax_instance)) {
            self::$admin_ajax_instance = new self($basename, $main, $version);
        }
        return self::$admin_ajax_instance;
    }

    public function __construct(string $basename, Wp_Sync_Scss $main, string $version)
    {
        $this->main = $main;
        $this->basename = $basename;
        $this->version = $version;
        $this->method = filter_input(INPUT_POST, 'method', FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_HIGH);
        $this->responseJson = (object)['status' => false, 'msg' => date('H:i:s', current_time('timestamp')), 'type' => $this->method];
    }


    /**
     * @throws Exception
     */
    public function admin_ajax_handle()
    {
        if (!method_exists($this, $this->method)) {
            throw new Exception("Method not found!#Not Found");
        }
        return call_user_func_array(self::class . '::' . $this->method, []);
    }

    private function get_settings():object
    {
        $is_file = filter_input(INPUT_POST, 'is_file', FILTER_VALIDATE_BOOLEAN);
        if(!get_option($this->basename . '/settings')) {
            $settings = [
                'source' => '',
                'destination' => '',
                'user_role' => $this->default_user_role,
                'scss_active' => $this->scss_active,
                'cache_active' => $this->cache_active,
                'formatter_mode' => $this->formatter_mode,
                'map_option' => $this->map_option,
                'map_active' => $this->map_active,
                'enqueue_aktiv' => $this->enqueue_aktiv,
                'scss_login_aktiv' => $this->scss_login_aktiv,
                'cache_dir' => WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'sync_scss_cache'
            ];
            update_option($this->basename . '/settings', $settings);
        }
        $rootDir = dirname(get_template_directory());
        global $folderThree;
        $folder = $folderThree->file_node($rootDir, $is_file);
        global $wpSyncScssHelper;
        $wpSyncScssHelper->check_if_dir(WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'sync_scss_cache');

        $this->responseJson->settings = get_option($this->basename . '/settings');
        $this->responseJson->root_dir = $rootDir;
        $this->responseJson->file_three = $folder;
        $this->responseJson->version = $this->version;
        $this->responseJson->selects = $this->wp_sync_scss_defaults();
        $this->responseJson->status = true;
        return $this->responseJson;
    }

    private function set_location():object
    {
        $path = filter_input(INPUT_POST, 'path', FILTER_UNSAFE_RAW);
        $location = filter_input(INPUT_POST, 'location', FILTER_UNSAFE_RAW);
        $is_file = filter_input(INPUT_POST, 'is_file', FILTER_VALIDATE_BOOLEAN);
        if(!$path || !$location) {
            $this->responseJson->msg = __('Ajax transmission error', 'wp-sync-scss') . ' (Ajx-'.__LINE__.')';
            return $this->responseJson;
        }

        $settings = get_option($this->basename . '/settings');
        $location = filter_var($location, FILTER_UNSAFE_RAW);
        $path = filter_var($path, FILTER_UNSAFE_RAW);
        $settings[$location] = $path;
        update_option($this->basename. '/settings', $settings);
        $rootDir = dirname(get_template_directory());
        global $folderThree;
        $folder = $folderThree->file_node($rootDir, $is_file);
        $this->responseJson->file_three = $folder;
        $this->responseJson->settings = $settings;
        $this->responseJson->status = true;

        return $this->responseJson;
    }

    private function update_wp_sync_scss_settings(): object
    {
        $data = filter_input(INPUT_POST, 'data', FILTER_UNSAFE_RAW);
        if(!$data){
            $this->responseJson->msg = __('Ajax transmission error', 'wp-sync-scss') . ' (Ajx-'.__LINE__.')';
            return $this->responseJson;
        }
        global $wpSyncScssHelper;
        $data = json_decode($data, true);

        $source = $data['source'] ?? '';
        $destination = $data['destination'] ?? '';
        $scss_active = $data['scss_active'] ?? false;
        $cache_active = $data['cache_active'] ?? false;
        $formatter_mode = $data['formatter_mode'] ?? false;
        $map_option = $data['map_option'] ?? '';
        $map_active = $data['map_active'] ?? false;
        $enqueue_aktiv = $data['enqueue_aktiv'] ?? false;
        $scss_login_aktiv = $data['scss_login_aktiv'] ?? false;
        $user_role = $data['user_role'] ?? 'manage_options';
        $cache_dir = $data['cache_dir'] ?? WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'sync_scss_cache';
        $cache_dir = filter_var($wpSyncScssHelper->pregWhitespace($cache_dir), FILTER_UNSAFE_RAW);
        $wpSyncScssHelper->check_if_dir($cache_dir);

        $settings = [
            'source' => filter_var($wpSyncScssHelper->pregWhitespace($source), FILTER_UNSAFE_RAW),
            'destination' => filter_var($wpSyncScssHelper->pregWhitespace($destination), FILTER_UNSAFE_RAW),
            'user_role' => filter_var($wpSyncScssHelper->pregWhitespace($user_role), FILTER_UNSAFE_RAW),
            'scss_active' => filter_var($scss_active, FILTER_VALIDATE_BOOLEAN),
            'cache_active' => filter_var($cache_active, FILTER_VALIDATE_BOOLEAN),
            'formatter_mode' => filter_var($wpSyncScssHelper->pregWhitespace($formatter_mode), FILTER_UNSAFE_RAW),
            'map_option' =>  filter_var($wpSyncScssHelper->pregWhitespace($map_option), FILTER_UNSAFE_RAW),
            'map_active' => filter_var($map_active, FILTER_VALIDATE_BOOLEAN),
            'enqueue_aktiv' => filter_var($enqueue_aktiv, FILTER_VALIDATE_BOOLEAN),
            'scss_login_aktiv' => filter_var($scss_login_aktiv, FILTER_VALIDATE_BOOLEAN),
            'cache_dir' => filter_var($wpSyncScssHelper->pregWhitespace($cache_dir), FILTER_UNSAFE_RAW)
        ];


        update_option($this->basename . '/settings', $settings);
        $this->responseJson->status = true;
        return $this->responseJson;
    }

    private function delete_cache():object
    {
        $settings = get_option($this->basename . '/settings');
        if(is_dir($settings['cache_dir'])) {
            global $wpSyncScssHelper;
            $wpSyncScssHelper->destroyDirRecursive($settings['cache_dir']);
            $wpSyncScssHelper->check_if_dir($settings['cache_dir']);
        }

        $this->responseJson->status = true;
        $this->responseJson->msg = __('Cache cleared', 'wp-sync-scss');
        return $this->responseJson;
    }


}
