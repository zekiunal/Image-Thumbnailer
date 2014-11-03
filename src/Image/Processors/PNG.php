<?php
namespace Image\Processors;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image
 * @name        PNG
 * @version     0.1
 */
class PNG implements ProcessorInterface
{
    public static $mimetype = 'image/png';
    public static $extensions = array('.png');

    /**
     * @param $file_name
     * @return resource
     */
    public function createImage($file_name)
    {
        return imagecreatefrompng($file_name);
    }

    /**
     * @param resource $image
     * @param string   $filename [optional]
     * @param integer  $quality  [optional]
     * @param integer  $filters  [optional]
     * @return bool true on success or false on failure.
     */
    public function save($image, $filename = null, $quality = null, $filters = null)
    {
        /**
         * Invert quality setting as 0 is best, not 9
         */
        $quality = 9 - round(($quality / 100) * 9);

        return imagepng($image, $filename, $quality);
    }
}
