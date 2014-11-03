<?php
namespace Image\Processors;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image
 * @name        JPEG
 * @version     0.1
 */
class JPEG implements ProcessorInterface
{
    /**
     * @var string
     */
    public static $mime_type = 'image/jpeg';

    /**
     * @var array
     */
    public static $extensions = array(
        '.jpg',
        '.jpe',
        '.jpeg'
    );
    
    /**
     * @param $file_name
     * @return resource
     */
    public function createImage($file_name)
    {
        return imagecreatefromjpeg($file_name);
    }

    /**
     * if (imagetypes() & IMG_JPG)
     *
     * @param resource $image
     * @param string   $filename [optional]
     * @param integer  $quality  [optional]
     * @param integer  $filters  [optional]
     * @return bool true on success or false on failure.
     */
    public function save($image, $filename = null, $quality = null, $filters = null)
    {
        return imagejpeg($image, $filename, $quality);
    }
}
