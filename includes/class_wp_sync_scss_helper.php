<?php
namespace WpSyncScss\Plugin;

use DirectoryIterator;
use Exception;
use Wp_Sync_Scss;

class WP_Sync_Scss_Helper
{
    use WpSynScssDefaults;
    private static $instance;

    private string $folder = '';
    private int $i = 0;

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
    public static function instance(string $basename, string $version, Wp_Sync_Scss $main): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($basename, $version, $main);
        }
        return self::$instance;
    }

    public function __construct(string $basename, string $version, Wp_Sync_Scss $main)
    {
        $this->main = $main;
        $this->basename = $basename;
        $this->version = $version;
    }

    public function pregWhitespace($string): string
    {
        if (!$string) {
            return '';
        }
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    public function trim_string($string): string
    {
        if (!$string) {
            return '';
        }
        return trim(preg_replace('/\s+/', '', $string));
    }

    public function order_by_args_string($postArr,$value, $order) {
        switch ($order){
            case'1':
                usort($postArr, fn ($a, $b) => strcasecmp($a[$value] , $b[$value]));
                return  array_reverse($postArr);
            case '2':
                usort($postArr, fn ($a, $b) => strcasecmp($a[$value] , $b[$value]));
                break;
        }
        return $postArr;
    }

    public function destroyDirRecursive($dir): bool
    {
        if (!is_dir($dir) || is_link($dir))
            return unlink($dir);

        foreach (scandir($dir) as $file) {
            if ($file == "." || $file == "..")
                continue;
            if (!$this->destroyDirRecursive($dir . DIRECTORY_SEPARATOR . $file)) {
                chmod($dir . DIRECTORY_SEPARATOR . $file, 0777);
                if (!$this->destroyDirRecursive($dir . DIRECTORY_SEPARATOR . $file)) return false;
            }
        }
        return rmdir($dir);
    }

    public function check_if_dir($dir): bool
    {
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0777, true)) {
                return false;
            }
        }
        return true;
    }

}