<?php

namespace WpSyncScss\Plugin;

trait WpSynScssDefaults
{
    protected string $default_user_role = 'manage_options';
    protected bool $scss_active = false;
    protected string $formatter_mode = 'expanded';
    protected string $map_option = 'file';
    protected bool $map_active = false;
    protected bool $enqueue_aktiv = false;
    protected bool $scss_login_aktiv = false;
    protected bool $cache_active = false;

    protected function wp_sync_scss_defaults($args = null): array
    {
        $return = [
            'select_user_role' => [
                "0" => [
                    'value' => 'read',
                    'name' => __('Subscriber', 'wp-sync-scss'),
                    'cap' => 'subscriber'
                ],
                "1" => [
                    'value' => 'edit_posts',
                    'name' => __('Employees', 'wp-sync-scss'),
                    'cap' => 'contributor'
                ],
                "2" => [
                    'value' => 'publish_posts',
                    'name' => __('Author', 'wp-sync-scss'),
                    'cap' => 'author'
                ],
                "3" => [
                    'value' => 'publish_pages',
                    'name' => __('Editor', 'wp-sync-scss'),
                    'cap' => 'editor'
                ],
                "4" => [
                    'value' => 'manage_options',
                    'name' => __('Administrator', 'wp-sync-scss'),
                    'cap' => 'administrator'
                ],
            ],
            'select_formatter_mode' => [
                '0' => [
                    'value' => 'expanded',
                    'label' => __('expanded', 'wp-sync-scss'),
                ],
                '1' => [
                    'value' => 'compressed',
                    'label' => __('compressed', 'wp-sync-scss'),
                ]
            ],
            'select_map_option' => [
                '0' => [
                    'value' => 'file',
                    'label' => __('File', 'wp-sync-scss'),
                ],
                '1' => [
                    'value' => 'inline',
                    'label' => __('Inline', 'wp-sync-scss'),
                ]
            ]
        ];

        if ($args) {
            return $return[$args];
        }
        return $return;
    }

    protected function wp_sync_scss_language(): array
    {
        return [
            'Settings' => __('Settings', 'wp-sync-scss'),
            'Minimum requirement for using this plugin' => __('Minimum requirement for using this plugin', 'wp-sync-scss'),
            'Plugin Info' => __('Plugin Info', 'wp-sync-scss'),
            'Plugin settings' => __('Plugin settings', 'wp-sync-scss'),
            'Cache active' => __('Cache active', 'wp-sync-scss'),
            'SCSS Compiler' => __('SCSS Compiler', 'wp-sync-scss'),
            'WP SYNC SCSS' => __('WP SYNC SCSS', 'wp-sync-scss'),
            'Version' => __('Version', 'wp-sync-scss'),
            'Set up paths' => __('Set up paths', 'wp-sync-scss'),
            'scss_location' => __('SCSS / SASS Location', 'wp-sync-scss'),
            'css_location' => __('CSS Location', 'wp-sync-scss'),
            'SCSS Compiler active' =>  __('SCSS Compiler active', 'wp-sync-scss'),
            'Select location' => __('Select location', 'wp-sync-scss'),
            'SCSS compiler active' => __('SCSS compiler active', 'wp-sync-scss'),
            'Cache Settings' => __('Cache Setting', 'wp-sync-scss'),
            'Output settings' => __('Output settings', 'wp-sync-scss'),
            'Create source map' => __('Create source map', 'wp-sync-scss'),
            'Create enqueue stylesheets' => __('Create enqueue stylesheets', 'wp-sync-scss'),
            'Compiler only active at login' => __('Compiler only active at login', 'wp-sync-scss'),
            'stylesheets_are_automatically' => __('CSS stylesheets are automatically added to the header.', 'wp-sync-scss'),
            'if_activated' => __('If activated, the SCSS compiler is only active when a user is logged in.', 'wp-sync-scss'),
            'Source Map Optionen' => __('Source Map Optionen', 'wp-sync-scss'),
            'Output' => __('Output', 'wp-sync-scss'),
            'Select folder' => __('Select folder', 'wp-sync-scss'),
            'Folder name' => __('Folder name', 'wp-sync-scss'),
            'cancel' => __('cancel', 'wp-sync-scss'),
            'Cache path' => __('Cache path', 'wp-sync-scss'),
            'Empty cache' => __('Empty cache', 'wp-sync-scss'),
            'Plugin name' => __('Plugin name', 'wp-sync-scss'),
            'Plugin description' => __('Plugin description', 'wp-sync-scss'),
            'description_txt' => __('WP-SCSS-Sync is the ideal tool for developers and designers who want to use SCSS in their WordPress projects. This plugin automatically converts SCSS files to CSS and offers flexible map output options, including inline maps, external files or no maps - depending on your needs.', 'wp-sync-scss'),
            'Features' => __('Features', 'wp-sync-scss'),
            'features1' => __('<span class="fw-semibold">Automatic SCSS compilation:</span> SCSS files are converted directly into CSS.', 'wp-sync-scss'),
            'features2' => __('<span class="fw-semibold">Flexible map options:</span> Choose between inline maps, separate map files or deactivated maps.', 'wp-sync-scss'),
            'features3' => __('<span class="fw-semibold">Simple configuration:</span> Intuitive settings for quick adjustments.', 'wp-sync-scss'),
            'features4' => __('<span class="fw-semibold">Seamless integration:</span> Optimised for use in WordPress themes and plugins.', 'wp-sync-scss'),
            'features5' => __('<span class="fw-semibold">Efficient and reliable:</span> Reduces development effort through automated processes.', 'wp-sync-scss'),
            'Advantages' => __('Advantages', 'wp-sync-scss'),
            'advantages1' => __('Save time with automatic SCSS-to-CSS compilation.', 'wp-sync-scss'),
            'advantages2' => __('Customise your workflow to suit your preferences.', 'wp-sync-scss'),
            'advantages3' => __('Stay in control of your styles with clear debugging options.', 'wp-sync-scss'),
            'end_txt' => __('WP-SCSS-Sync - Your helper for clean and optimised CSS code in WordPress. 🚀', 'wp-sync-scss'),
            //Todo Welcome
            'Welcome to WP-SCSS-Sync!' => __('🎉 Welcome to WP-SCSS-Sync!', 'wp-sync-scss'),
            'welcome_txt' => __('Thank you for installing <span class="fw-semibold">WP-SCSS-Sync!</span> We look forward to supporting you in your WordPress development process. With this plugin, you can easily convert SCSS files to CSS and optimise your workflow.', 'wp-sync-scss'),
            'First steps' => __('First steps', 'wp-sync-scss'),
            'first_steps_head1' => __('Configure settings', 'wp-sync-scss'),
            'first_steps_head2' => __('Add SCSS files', 'wp-sync-scss'),
            'first_steps_head3' => __('Test and enjoy', 'wp-sync-scss'),
            'first_steps1' => __('Go to the plugin settings to specify paths to your SCSS and CSS files and select your preferred map option.', 'wp-sync-scss'),
            'first_steps2' => __('Upload your SCSS files to the corresponding directory. WP-SCSS-Sync will do the rest!', 'wp-sync-scss'),
            'first_steps3' => __("Change your SCSS files and view the automatically generated CSS files - it couldn't be quicker or easier.", 'wp-sync-scss'),
            'Useful functions' => __('Useful functions', 'wp-sync-scss'),
            'useful_functions1' => __('<span class="fw-semibold">Live compilation:</span> Changes in SCSS files are applied directly to CSS.', 'wp-sync-scss'),
            'useful_functions2' => __('<span class="fw-semibold">Flexible map options:</span> Choose from inline maps, external maps or no maps at all.', 'wp-sync-scss'),
            'useful_functions3' => __('<span class="fw-semibold">WordPress integration:</span> Simple workflow, especially for WordPress themes and plugins.', 'wp-sync-scss'),
            'spende_headline' => __('💖 Support the further development of WP-SCSS-Sync!', 'wp-sync-scss'),
            'spende_txt' => __('Thank you for using WP-SCSS-Sync! This plugin was developed to make your life as a developer easier - and it is constantly being improved. Your support helps us to develop new features, fix bugs and maintain the quality of the plugin.', 'wp-sync-scss'),
            'Why donate' => __('Why donate?', 'wp-sync-scss'),
            'why_donate1' => __('<span class="fw-semibold">Promotion of new features:</span> Your donation enables us to integrate even more helpful functions.', 'wp-sync-scss'),
            'why_donate2' => __('<span class="fw-semibold">Continuous updates:</span> We ensure that the plugin remains compatible with future WordPress versions.', 'wp-sync-scss'),
            'why_donate3' => __('<span class="fw-semibold">Community support:</span> With your support, we can respond more quickly to questions and problems.', 'wp-sync-scss'),
            'How can you help' => __('How can you help?', 'wp-sync-scss'),
            'how_can_help_txt1' => __('Every contribution - big or small - makes a difference!', 'wp-sync-scss'),
            'how_can_help_txt2' => __('Simply click on the button below to support us:', 'wp-sync-scss'),
            'Thank you very much for your support!' => __('Thank you very much for your support!', 'wp-sync-scss'),
            'Together we make WP-SCSS-Sync even better.' => __('Together we make WP-SCSS-Sync even better.', 'wp-sync-scss'),
        ];
    }
}