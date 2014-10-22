<?php
namespace Image;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image
 * @name        GIF
 * @version     0.1
 */
class GIF implements ImageProcessorInterface
{
    /**
     * @param $file_name
     * @return resource
     */
    public function createImage($file_name)
    {
        return imagecreatefromgif($file_name);
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
        return imagegif($image, $filename);
    }
}
