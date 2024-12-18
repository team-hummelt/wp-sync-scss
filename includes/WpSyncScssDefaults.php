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
                    'name' => __('Subscriber', 'autocompiler-scss'),
                    'cap' => 'subscriber'
                ],
                "1" => [
                    'value' => 'edit_posts',
                    'name' => __('Employees', 'autocompiler-scss'),
                    'cap' => 'contributor'
                ],
                "2" => [
                    'value' => 'publish_posts',
                    'name' => __('Author', 'autocompiler-scss'),
                    'cap' => 'author'
                ],
                "3" => [
                    'value' => 'publish_pages',
                    'name' => __('Editor', 'autocompiler-scss'),
                    'cap' => 'editor'
                ],
                "4" => [
                    'value' => 'manage_options',
                    'name' => __('Administrator', 'autocompiler-scss'),
                    'cap' => 'administrator'
                ],
            ],
            'select_formatter_mode' => [
                '0' => [
                    'value' => 'expanded',
                    'label' => __('expanded', 'autocompiler-scss'),
                ],
                '1' => [
                    'value' => 'compressed',
                    'label' => __('compressed', 'autocompiler-scss'),
                ]
            ],
            'select_map_option' => [
                '0' => [
                    'value' => 'file',
                    'label' => __('File', 'autocompiler-scss'),
                ],
                '1' => [
                    'value' => 'inline',
                    'label' => __('Inline', 'autocompiler-scss'),
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
            'Settings' => __('Settings', 'autocompiler-scss'),
            'Minimum requirement for using this plugin' => __('Minimum requirement for using this plugin', 'autocompiler-scss'),
            'Plugin Info' => __('Plugin Info', 'autocompiler-scss'),
            'Plugin settings' => __('Plugin settings', 'autocompiler-scss'),
            'Cache active' => __('Cache active', 'autocompiler-scss'),
            'SCSS Compiler' => __('SCSS Compiler', 'autocompiler-scss'),
            'SCSS AutoCompiler' => __('AutoCSS Builder', 'autocompiler-scss'),
            'Version' => __('Version', 'autocompiler-scss'),
            'Set up paths' => __('Set up paths', 'autocompiler-scss'),
            'scss_location' => __('SCSS / SASS Location', 'autocompiler-scss'),
            'css_location' => __('CSS Location', 'autocompiler-scss'),
            'SCSS Compiler active' =>  __('SCSS Compiler active', 'autocompiler-scss'),
            'Select location' => __('Select location', 'autocompiler-scss'),
            'SCSS compiler active' => __('SCSS compiler active', 'autocompiler-scss'),
            'Cache Settings' => __('Cache Setting', 'autocompiler-scss'),
            'Output settings' => __('Output settings', 'autocompiler-scss'),
            'Create source map' => __('Create source map', 'autocompiler-scss'),
            'Create enqueue stylesheets' => __('Create enqueue stylesheets', 'autocompiler-scss'),
            'Compiler only active at login' => __('Compiler only active at login', 'autocompiler-scss'),
            'stylesheets_are_automatically' => __('CSS stylesheets are automatically added to the header.', 'autocompiler-scss'),
            'if_activated' => __('If activated, the SCSS compiler is only active when a user is logged in.', 'autocompiler-scss'),
            'Source Map Optionen' => __('Source Map Optionen', 'autocompiler-scss'),
            'Output' => __('Output', 'autocompiler-scss'),
            'Select folder' => __('Select folder', 'autocompiler-scss'),
            'Folder name' => __('Folder name', 'autocompiler-scss'),
            'cancel' => __('cancel', 'autocompiler-scss'),
            'Cache path' => __('Cache path', 'autocompiler-scss'),
            'Empty cache' => __('Empty cache', 'autocompiler-scss'),
            'Plugin name' => __('Plugin name', 'autocompiler-scss'),
            'Plugin description' => __('Plugin description', 'autocompiler-scss'),
            'description_txt' => __('AutoCSS Builder is the ideal tool for developers and designers who want to use SCSS in their WordPress projects. This plugin automatically converts SCSS files to CSS and offers flexible map output options, including inline maps, external files or no maps - depending on your needs.', 'autocompiler-scss'),
            'Features' => __('Features', 'autocompiler-scss'),
            'features1' => __('<span class="fw-semibold">Automatic SCSS compilation:</span> SCSS files are converted directly into CSS.', 'autocompiler-scss'),
            'features2' => __('<span class="fw-semibold">Flexible map options:</span> Choose between inline maps, separate map files or deactivated maps.', 'autocompiler-scss'),
            'features3' => __('<span class="fw-semibold">Simple configuration:</span> Intuitive settings for quick adjustments.', 'autocompiler-scss'),
            'features4' => __('<span class="fw-semibold">Seamless integration:</span> Optimised for use in WordPress themes and plugins.', 'autocompiler-scss'),
            'features5' => __('<span class="fw-semibold">Efficient and reliable:</span> Reduces development effort through automated processes.', 'autocompiler-scss'),
            'Advantages' => __('Advantages', 'autocompiler-scss'),
            'advantages1' => __('Save time with automatic SCSS-to-CSS compilation.', 'autocompiler-scss'),
            'advantages2' => __('Customise your workflow to suit your preferences.', 'autocompiler-scss'),
            'advantages3' => __('Stay in control of your styles with clear debugging options.', 'autocompiler-scss'),
            'end_txt' => __('AutoCSS Builder - Your helper for clean and optimised CSS code in WordPress. 🚀', 'autocompiler-scss'),
            //Todo Welcome
            'Welcome to WP-SCSS-Sync!' => __('🎉 Welcome to AutoCSS Builder!', 'autocompiler-scss'),
            'welcome_txt' => __('Thank you for installing <span class="fw-semibold">AutoCSS Builder!</span> We look forward to supporting you in your WordPress development process. With this plugin, you can easily convert SCSS files to CSS and optimise your workflow.', 'autocompiler-scss'),
            'First steps' => __('First steps', 'autocompiler-scss'),
            'first_steps_head1' => __('Configure settings', 'autocompiler-scss'),
            'first_steps_head2' => __('Add SCSS files', 'autocompiler-scss'),
            'first_steps_head3' => __('Test and enjoy', 'autocompiler-scss'),
            'first_steps1' => __('Go to the plugin settings to specify paths to your SCSS and CSS files and select your preferred map option.', 'autocompiler-scss'),
            'first_steps2' => __('Upload your SCSS files to the corresponding directory. AutoCSS Builder will do the rest!', 'autocompiler-scss'),
            'first_steps3' => __("Change your SCSS files and view the automatically generated CSS files - it couldn't be quicker or easier.", 'autocompiler-scss'),
            'Useful functions' => __('Useful functions', 'autocompiler-scss'),
            'useful_functions1' => __('<span class="fw-semibold">Live compilation:</span> Changes in SCSS files are applied directly to CSS.', 'autocompiler-scss'),
            'useful_functions2' => __('<span class="fw-semibold">Flexible map options:</span> Choose from inline maps, external maps or no maps at all.', 'autocompiler-scss'),
            'useful_functions3' => __('<span class="fw-semibold">WordPress integration:</span> Simple workflow, especially for WordPress themes and plugins.', 'autocompiler-scss'),
            'spende_headline' => __('💖 Support the further development of AutoCSS Builder!', 'autocompiler-scss'),
            'spende_txt' => __('Thank you for using AutoCSS Builder! This plugin was developed to make your life as a developer easier - and it is constantly being improved. Your support helps us to develop new features, fix bugs and maintain the quality of the plugin.', 'autocompiler-scss'),
            'Why donate' => __('Why donate?', 'autocompiler-scss'),
            'why_donate1' => __('<span class="fw-semibold">Promotion of new features:</span> Your donation enables us to integrate even more helpful functions.', 'autocompiler-scss'),
            'why_donate2' => __('<span class="fw-semibold">Continuous updates:</span> We ensure that the plugin remains compatible with future WordPress versions.', 'autocompiler-scss'),
            'why_donate3' => __('<span class="fw-semibold">Community support:</span> With your support, we can respond more quickly to questions and problems.', 'autocompiler-scss'),
            'How can you help' => __('How can you help?', 'autocompiler-scss'),
            'how_can_help_txt1' => __('Every contribution - big or small - makes a difference!', 'autocompiler-scss'),
            'how_can_help_txt2' => __('Simply click on the button below to support us:', 'autocompiler-scss'),
            'Thank you very much for your support!' => __('Thank you very much for your support!', 'autocompiler-scss'),
            'Together we make WP-SCSS-Sync even better.' => __('Together we make AutoCSS Builder even better.', 'autocompiler-scss'),
        ];
    }
}