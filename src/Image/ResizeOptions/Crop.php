<?php
namespace Image\ResizeOptions;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image\ResizeOptions
 * @name        Crop
 * @version     0.1
 */
class Crop extends ResizeOptionAbstract implements ResizeOptionInterface
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
        $height_ratio = $original_height / $height;
        $width_ratio  = $original_width / $width;

        if ($height_ratio < $width_ratio) {
            $optimal_ratio = $height_ratio;
        } else {
            $optimal_ratio = $width_ratio;
        }

        return array(
            'optimal_width'  => $original_width / $optimal_ratio,
            'optimal_height' => $original_height / $optimal_ratio
        );
    }
}
