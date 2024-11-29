<?php
namespace WpSyncScss\Plugin;

use DirectoryIterator;
use Wp_Sync_Scss;

class Folder_Three
{
    use WpSynScssDefaults;

    private $folder = '';
    private int $i = 0;
    public array $files;


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

    public function __construct(string $basename, Wp_Sync_Scss $main)
    {
        $this->main = $main;
        $this->basename = $basename;
    }

    public function get_folder_three($path): array
    {
        $files = [];
        $folder = '';
        if ( file_exists( $path ) ) {
            if ( $path[ strlen( $path ) - 1 ] == '/' ) {
                $folder = $path;
            } else {
                $folder = $path . '/';
            }
            $scanned_directory = array_diff(scandir($path), array('..', '.'));
            foreach ($scanned_directory as $dir) {
                $files[] = $dir;
            }
        }

     return $this->create_tree($folder, $files);

    }
    private function create_tree($folder, $files):array
    {
        natcasesort( $files );
        $folderArr = [];

        foreach ( $files as $file ) {
            if ( file_exists( $folder . $file ) && is_dir( $folder . $file ) ) {
                $root = $this->folder . $file;
                $a = strlen( wp_get_theme()->get_theme_root());
                $e = strlen($root);
                $selectPath = substr($root,$a,$e) . DIRECTORY_SEPARATOR;

                $item = [
                    'id' => uniqid(),
                    'root' => $root,
                    'selectPath' => $selectPath,
                    'open' => false,
                    'active' => false,
                    'file' => $file,
                    'folder' => $folder,
                    'children' => [
                        'id' => uniqid(),
                        'root' => $root,
                        'selectPath' => $selectPath,
                        'open' => false,
                        'active' => false,
                        'file' => $file,
                        'folder' => $folder,
                        'children' => []
                    ]
                ];
                $folderArr[] = $item;
            }
        }
     //   print_r($folderArr);
        return $folderArr;

    }

    public function fillArrayWithFileNodes(DirectoryIterator $dir,  $setFile = false, $first = true): array
    {

        $data = array();
        foreach ($dir as $node) {
            if ($node->isDir() && !$node->isDot()) {
                $this->folder = $node->getFilename();
                $data[] = [
                    'id' => uniqid(),
                    'name' => $node->getFilename(),
                    'isOpen' => false,
                    'path' => $node->getPathname(),
                    'isFolder' => true,
                    'type' => 'dir',
                    'first' => $first,
                    'children' => $this->fillArrayWithFileNodes(new DirectoryIterator($node->getPathname()), $setFile, false)
                ];

            } else if ($setFile && $node->isFile()) {
                $data[] = [
                    'id' => uniqid(),
                    'name' => $node->getFilename(),
                    'type' => 'file',
                    'isFolder' => false,
                    'folder' => dirname($node->getPathname()),
                    'ext' => strtolower($node->getExtension()),
                ];
            }
        }
        global $wpSyncScssHelper;
        return $wpSyncScssHelper->order_by_args_string($data, 'type', 2);
    }

    public function file_node($dir,  $setFile = false): array
    {
        return $this->fillArrayWithFileNodes(new DirectoryIterator($dir), $setFile);
    }

}