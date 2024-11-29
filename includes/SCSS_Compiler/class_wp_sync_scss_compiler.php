<?php

namespace WpSyncScss\Plugin;
defined('ABSPATH') or die();

use Exception;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\Exception\SassException;
use ScssPhp\ScssPhp\OutputStyle;
use Wp_Sync_Scss;

class WP_Sync_Scss_Compiler
{
    use WpSynScssDefaults;
    private static $instance;
    private array $settings;

    protected string $scss_file_name;
    protected string $css_file_name;
    protected string $destination_dir;
    protected string $destination_uri;
    protected string $regExUriPath = '/(wp-content.+|wp-include.+)/i';


    /**
     * The ID of this Plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $basename The ID of this theme.
     */
    protected string $basename;

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
    public static function instance(string $basename, Wp_Sync_Scss $main): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($basename, $main);
        }
        return self::$instance;
    }

    public function __construct(string $basename, Wp_Sync_Scss $main)
    {
        $this->basename = $basename;
        $this->main = $main;

        $this->settings = get_option($this->basename . '/settings');
    }

    public function fn_wp_sync_scss_compile_single_file($source, $destination): void
    {

    }

    public function fn_wp_sync_scss_compile_files()
    {
        if(!$this->settings['scss_active']) {
            return null;
        }
        if (!is_dir($this->settings['source'])) {
            return null;
        }

        $source_dir = $this->settings['source'];
        if(!preg_match( '~/$|\$~', $source_dir, $matches)) {
            $source_dir = $source_dir . DIRECTORY_SEPARATOR;
        }
        if (!$this->check_if_dir($this->settings['destination'])) {
            return null;
        }
        $dest_dir =  $this->settings['destination'];
        if(!preg_match( '~/$|\$~', $dest_dir, $matches)) {
            $dest_dir = $dest_dir . DIRECTORY_SEPARATOR;
        }

        $src = array_diff(scandir($source_dir), array('..', '.'));
        if($src) {
            foreach ($src as $tmp) {
                if(str_starts_with($tmp, '_')) {
                    continue;
                }
                $file = $source_dir . $tmp;
                if (!is_file($file)) {
                    continue;
                }
                $pathInfo = pathinfo($file);
                if($pathInfo['extension'] == 'scss') {
                    $this->scss_file_name = $pathInfo['basename'];
                    $this->css_file_name = $pathInfo['filename'] . '.css';
                    $cssDestination = $dest_dir . $this->css_file_name;
                    $source = $source_dir . $pathInfo['basename'];
                    $this->destination_dir = $dest_dir;
                    preg_match($this->regExUriPath, $dest_dir, $matches);
                    if (!$matches) {
                        continue;
                    }
                    $this->destination_uri = site_url() . '/' . str_replace('\\', '/', $matches[0]);
                    if(!function_exists('is_user_logged_in')) {
                        require_once ABSPATH . 'wp-includes/pluggable.php';
                    }
                    try {
                        $isLogin = true;
                        if($this->settings['scss_login_aktiv'] && !is_user_logged_in() ){
                            $isLogin = false;
                        }
                        if($isLogin) {
                            $this->syncScssCompiler($source, $cssDestination);
                        }
                    } catch (Exception|SassException $e) {
                        echo '<div class="d-flex justify-content-center flex-column position-absolute start-50 translate-middle bg-light p-3" style="z-index: 99999;width:95%;top:10rem;min-height: 150px; border: 2px solid #dc3545; border-radius: .5rem"> <span class="text-danger fs-5 fw-bolder d-flex align-items-center"><i class="bi bi-cpu fs-4 me-1"></i>SCSS Compiler Error:</span>   ' . $e->getMessage() . '</div>';
                    }
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    private function syncScssCompiler($source, $out = null)
    {
        ignore_user_abort(true);
        //set_time_limit(0);
        $cacheArr = null;
        if($this->settings['cache_active'] && $this->settings['cache_dir']) {
            if(is_dir($this->settings['cache_dir'])) {
                $cacheArr = ['cacheDir' => $this->settings['cache_dir']];
            }
        }

        $scssCompiler = new Compiler($cacheArr);
        $pathInfo = pathinfo($source);

        $scssCompiler->addImportPath($pathInfo['dirname'] . DIRECTORY_SEPARATOR);
        switch ($this->settings['formatter_mode']) {
            case 'expanded':
                $scssCompiler->setOutputStyle(OutputStyle::EXPANDED);
                break;
            case 'compressed':
                $scssCompiler->setOutputStyle(OutputStyle::COMPRESSED);
                break;
        }
        if($this->settings['map_active']) {
            switch ($this->settings['map_option']) {
                case 'file':
                    $scssCompiler->setSourceMap(Compiler::SOURCE_MAP_FILE);
                    $scssCompiler->setSourceMapOptions(array(
                        'sourceMapWriteTo' => $this->destination_dir . str_replace("/", "_", $this->css_file_name) . ".map",
                        'sourceMapURL' => $this->destination_uri . str_replace("/", "_", $this->css_file_name) . ".map",
                        'sourceMapFilename' => $this->css_file_name,
                        'sourceMapBasepath' => ABSPATH,
                    ));
                    break;
                case 'inline':
                    $scssCompiler->setSourceMap(Compiler::SOURCE_MAP_INLINE);
                    break;
            }
        } else {
            $scssCompiler->setSourceMap(Compiler::SOURCE_MAP_NONE);
        }
        $compiled = '';
        try {
            $compiled = $scssCompiler->compileString(file_get_contents($source), $source);
            if($this->settings['map_option'] == 'file') {
                $mapDest = $this->destination_dir . str_replace("/", "_", $this->css_file_name) . ".map";
                file_put_contents($mapDest, $compiled->getSourceMap());
            }
            if ($out !== null) {
                return file_put_contents($out, $compiled->getCss());
            }

        } catch (Exception|SassException $e) {
            echo '<div class="d-flex justify-content-center flex-column position-absolute start-50 translate-middle bg-light p-3" style="z-index: 99999;width:95%;top:10rem;min-height: 150px; border: 2px solid #dc3545; border-radius: .5rem"> <span class="text-danger fs-5 fw-bolder d-flex align-items-center"><i class="bi bi-cpu fs-4 me-1"></i>SCSS Compiler Error:</span>   ' . $e->getMessage() . '</div>';
        }
        return $compiled;
    }

    private function check_if_dir($dir): bool
    {
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                return false;
            }
        }
        return true;
    }
}