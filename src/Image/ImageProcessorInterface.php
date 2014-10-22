<?php
namespace Image;


interface ImageProcessorInterface
{
    /**
     * @param $file_name
     * @return resource
     */
    public function createImage($file_name);

    /**
     * @param resource $image
     * @param string   $filename [optional]
     * @param integer  $quality  [optional]
     * @param integer  $filters  [optional]
     * @return bool true on success or false on failure.
     */
    public function save($image, $filename = null, $quality = null, $filters = null);
}
