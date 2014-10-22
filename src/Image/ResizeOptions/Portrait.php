<?php
namespace Image\ResizeOptions;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image\ResizeOptions
 * @name        Portrait
 * @version     0.1
 */
class Portrait extends ResizeOptionAbstract implements ResizeOptionInterface
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
        $optimal_width = self::getSizeByFixedHeight($height, $original_width, $original_height);
        return array('optimal_width' => $optimal_width, 'optimal_height' => $height);
    }
}
