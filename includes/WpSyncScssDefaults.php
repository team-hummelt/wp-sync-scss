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
                    'name' => __('Subscriber', 'scss-auto-compiler'),
                    'cap' => 'subscriber'
                ],
                "1" => [
                    'value' => 'edit_posts',
                    'name' => __('Employees', 'scss-auto-compiler'),
                    'cap' => 'contributor'
                ],
                "2" => [
                    'value' => 'publish_posts',
                    'name' => __('Author', 'scss-auto-compiler'),
                    'cap' => 'author'
                ],
                "3" => [
                    'value' => 'publish_pages',
                    'name' => __('Editor', 'scss-auto-compiler'),
                    'cap' => 'editor'
                ],
                "4" => [
                    'value' => 'manage_options',
                    'name' => __('Administrator', 'scss-auto-compiler'),
                    'cap' => 'administrator'
                ],
            ],
            'select_formatter_mode' => [
                '0' => [
                    'value' => 'expanded',
                    'label' => __('expanded', 'scss-auto-compiler'),
                ],
                '1' => [
                    'value' => 'compressed',
                    'label' => __('compressed', 'scss-auto-compiler'),
                ]
            ],
            'select_map_option' => [
                '0' => [
                    'value' => 'file',
                    'label' => __('File', 'scss-auto-compiler'),
                ],
                '1' => [
                    'value' => 'inline',
                    'label' => __('Inline', 'scss-auto-compiler'),
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
            'Settings' => __('Settings', 'scss-auto-compiler'),
            'Minimum requirement for using this plugin' => __('Minimum requirement for using this plugin', 'scss-auto-compiler'),
            'Plugin Info' => __('Plugin Info', 'scss-auto-compiler'),
            'Plugin settings' => __('Plugin settings', 'scss-auto-compiler'),
            'Cache active' => __('Cache active', 'scss-auto-compiler'),
            'SCSS Compiler' => __('SCSS Compiler', 'scss-auto-compiler'),
            'SCSS AutoCompiler' => __('SCSS AutoCompiler', 'scss-auto-compiler'),
            'Version' => __('Version', 'scss-auto-compiler'),
            'Set up paths' => __('Set up paths', 'scss-auto-compiler'),
            'scss_location' => __('SCSS / SASS Location', 'scss-auto-compiler'),
            'css_location' => __('CSS Location', 'scss-auto-compiler'),
            'SCSS Compiler active' =>  __('SCSS Compiler active', 'scss-auto-compiler'),
            'Select location' => __('Select location', 'scss-auto-compiler'),
            'SCSS compiler active' => __('SCSS compiler active', 'scss-auto-compiler'),
            'Cache Settings' => __('Cache Setting', 'scss-auto-compiler'),
            'Output settings' => __('Output settings', 'scss-auto-compiler'),
            'Create source map' => __('Create source map', 'scss-auto-compiler'),
            'Create enqueue stylesheets' => __('Create enqueue stylesheets', 'scss-auto-compiler'),
            'Compiler only active at login' => __('Compiler only active at login', 'scss-auto-compiler'),
            'stylesheets_are_automatically' => __('CSS stylesheets are automatically added to the header.', 'scss-auto-compiler'),
            'if_activated' => __('If activated, the SCSS compiler is only active when a user is logged in.', 'scss-auto-compiler'),
            'Source Map Optionen' => __('Source Map Optionen', 'scss-auto-compiler'),
            'Output' => __('Output', 'scss-auto-compiler'),
            'Select folder' => __('Select folder', 'scss-auto-compiler'),
            'Folder name' => __('Folder name', 'scss-auto-compiler'),
            'cancel' => __('cancel', 'scss-auto-compiler'),
            'Cache path' => __('Cache path', 'scss-auto-compiler'),
            'Empty cache' => __('Empty cache', 'scss-auto-compiler'),
            'Plugin name' => __('Plugin name', 'scss-auto-compiler'),
            'Plugin description' => __('Plugin description', 'scss-auto-compiler'),
            'description_txt' => __('SCSS AutoCompiler is the ideal tool for developers and designers who want to use SCSS in their WordPress projects. This plugin automatically converts SCSS files to CSS and offers flexible map output options, including inline maps, external files or no maps - depending on your needs.', 'scss-auto-compiler'),
            'Features' => __('Features', 'scss-auto-compiler'),
            'features1' => __('<span class="fw-semibold">Automatic SCSS compilation:</span> SCSS files are converted directly into CSS.', 'scss-auto-compiler'),
            'features2' => __('<span class="fw-semibold">Flexible map options:</span> Choose between inline maps, separate map files or deactivated maps.', 'scss-auto-compiler'),
            'features3' => __('<span class="fw-semibold">Simple configuration:</span> Intuitive settings for quick adjustments.', 'scss-auto-compiler'),
            'features4' => __('<span class="fw-semibold">Seamless integration:</span> Optimised for use in WordPress themes and plugins.', 'scss-auto-compiler'),
            'features5' => __('<span class="fw-semibold">Efficient and reliable:</span> Reduces development effort through automated processes.', 'scss-auto-compiler'),
            'Advantages' => __('Advantages', 'scss-auto-compiler'),
            'advantages1' => __('Save time with automatic SCSS-to-CSS compilation.', 'scss-auto-compiler'),
            'advantages2' => __('Customise your workflow to suit your preferences.', 'scss-auto-compiler'),
            'advantages3' => __('Stay in control of your styles with clear debugging options.', 'scss-auto-compiler'),
            'end_txt' => __('SCSS AutoCompiler - Your helper for clean and optimised CSS code in WordPress. 🚀', 'scss-auto-compiler'),
            //Todo Welcome
            'Welcome to WP-SCSS-Sync!' => __('🎉 Welcome to SCSS AutoCompiler!', 'scss-auto-compiler'),
            'welcome_txt' => __('Thank you for installing <span class="fw-semibold">SCSS AutoCompiler!</span> We look forward to supporting you in your WordPress development process. With this plugin, you can easily convert SCSS files to CSS and optimise your workflow.', 'scss-auto-compiler'),
            'First steps' => __('First steps', 'scss-auto-compiler'),
            'first_steps_head1' => __('Configure settings', 'scss-auto-compiler'),
            'first_steps_head2' => __('Add SCSS files', 'scss-auto-compiler'),
            'first_steps_head3' => __('Test and enjoy', 'scss-auto-compiler'),
            'first_steps1' => __('Go to the plugin settings to specify paths to your SCSS and CSS files and select your preferred map option.', 'scss-auto-compiler'),
            'first_steps2' => __('Upload your SCSS files to the corresponding directory. SCSS AutoCompiler will do the rest!', 'scss-auto-compiler'),
            'first_steps3' => __("Change your SCSS files and view the automatically generated CSS files - it couldn't be quicker or easier.", 'scss-auto-compiler'),
            'Useful functions' => __('Useful functions', 'scss-auto-compiler'),
            'useful_functions1' => __('<span class="fw-semibold">Live compilation:</span> Changes in SCSS files are applied directly to CSS.', 'scss-auto-compiler'),
            'useful_functions2' => __('<span class="fw-semibold">Flexible map options:</span> Choose from inline maps, external maps or no maps at all.', 'scss-auto-compiler'),
            'useful_functions3' => __('<span class="fw-semibold">WordPress integration:</span> Simple workflow, especially for WordPress themes and plugins.', 'scss-auto-compiler'),
            'spende_headline' => __('💖 Support the further development of SCSS AutoCompiler!', 'scss-auto-compiler'),
            'spende_txt' => __('Thank you for using SCSS AutoCompiler! This plugin was developed to make your life as a developer easier - and it is constantly being improved. Your support helps us to develop new features, fix bugs and maintain the quality of the plugin.', 'scss-auto-compiler'),
            'Why donate' => __('Why donate?', 'scss-auto-compiler'),
            'why_donate1' => __('<span class="fw-semibold">Promotion of new features:</span> Your donation enables us to integrate even more helpful functions.', 'scss-auto-compiler'),
            'why_donate2' => __('<span class="fw-semibold">Continuous updates:</span> We ensure that the plugin remains compatible with future WordPress versions.', 'scss-auto-compiler'),
            'why_donate3' => __('<span class="fw-semibold">Community support:</span> With your support, we can respond more quickly to questions and problems.', 'scss-auto-compiler'),
            'How can you help' => __('How can you help?', 'scss-auto-compiler'),
            'how_can_help_txt1' => __('Every contribution - big or small - makes a difference!', 'scss-auto-compiler'),
            'how_can_help_txt2' => __('Simply click on the button below to support us:', 'scss-auto-compiler'),
            'Thank you very much for your support!' => __('Thank you very much for your support!', 'scss-auto-compiler'),
            'Together we make WP-SCSS-Sync even better.' => __('Together we make SCSS AutoCompiler even better.', 'scss-auto-compiler'),
        ];
    }
}