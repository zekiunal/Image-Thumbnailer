<?php
namespace Image\ResizeOptions;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image\ResizeOptions
 * @name        ResizeOptionAbstract
 * @version     0.1
 */
abstract class ResizeOptionAbstract
{
    /**
     * @param integer $height
     * @param integer $original_width
     * @param integer $original_height
     * @return integer
     */
    protected static function getSizeByFixedHeight($height, $original_width, $original_height)
    {
        $ratio = $original_width / $original_height;
        return $height * $ratio;
    }

    /**
     * @param integer $width
     * @param integer $original_width
     * @param integer $original_height
     * @return integer
     */
    protected static function getSizeByFixedWidth($width, $original_width, $original_height)
    {
        $ratio = $original_height / $original_width;
        return $width * $ratio;
    }
}
