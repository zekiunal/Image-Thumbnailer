<?php
namespace Image\ResizeOptions;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image\ResizeOptions
 * @name        ResizeOptionInterface
 * @version     0.1
 */
interface ResizeOptionInterface
{
    /**
     * @param integer $width
     * @param integer $height
     * @param integer|null $original_width
     * @param integer|null $original_height
     * @return array
     */
    public static function getOptimalSize($width, $height, $original_width=null, $original_height=null);
}
