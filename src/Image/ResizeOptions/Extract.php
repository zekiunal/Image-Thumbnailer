<?php
namespace Image\ResizeOptions;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image\ResizeOptions
 * @name        Extract
 * @version     0.1
 */
class Extract extends ResizeOptionAbstract implements ResizeOptionInterface
{
    /**
     * @param integer $width
     * @param integer $height
     * @param integer $original_width
     * @param integer $original_height
     * @return array
     */
    public static function getOptimalSize($width, $height, $original_width = null, $original_height = null)
    {
        return array('optimal_width' => $width, 'optimal_height' => $height);
    }
}
