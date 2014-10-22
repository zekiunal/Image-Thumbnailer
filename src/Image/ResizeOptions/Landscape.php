<?php
namespace Image\ResizeOptions;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image\ResizeOptions
 * @name        Landscape
 * @version     0.1
 */
class Landscape extends ResizeOptionAbstract implements ResizeOptionInterface
{
    /**
     * @param integer      $width
     * @param integer      $height
     * @param integer|null $original_width
     * @param integer|null $original_height
     * @return array
     */
    public static function getOptimalSize($width, $height, $original_width = null, $original_height = null)
    {
        $optimal_height = self::getSizeByFixedWidth($width, $original_width, $original_height);
        return array('optimal_width' => $width, 'optimal_height' => $optimal_height);
    }
}
