<?php
namespace Image\ResizeOptions;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image\ResizeOptions
 * @name        Auto
 * @version     0.1
 */
class Auto extends ResizeOptionAbstract implements ResizeOptionInterface
{
    /**
     * @param integer $width
     * @param integer $height
     * @param integer|null $original_width
     * @param integer|null $original_height
     * @return array
     */
    public static function getOptimalSize($width, $height, $original_width=null, $original_height=null)
    {
        return self::getSizeByAuto($width, $height, $original_width, $original_height);
    }

    protected static function getSizeByAuto($width, $height, $original_width, $original_height)
    {
        if ($original_height < $original_width) {
            $optimal_width = $width;
            $optimal_height = self::getSizeByFixedWidth($optimal_width, $original_width, $original_height);
            if ($optimal_height > $height) {
                $optimal_height = $height;
                $optimal_width = self::getSizeByFixedHeight($optimal_height, $original_width, $original_height);
            }
        } elseif ($original_height > $original_width) {
            $optimal_width = self::getSizeByFixedHeight($height, $original_width, $original_height);
            $optimal_height = $height;
            if ($optimal_width > $width) {
                $optimal_width = $width;
                $optimal_height = self::getSizeByFixedWidth($optimal_width, $original_width, $original_height);
            }
        } else {
            if ($height > $width) {
                $optimal_width = $width;
                $optimal_height = self::getSizeByFixedWidth($width, $original_width, $original_height);
            } elseif ($height < $width) {
                $optimal_width = self::getSizeByFixedHeight($height, $original_width, $original_height);
                $optimal_height = $height;
            } else {
                $optimal_width = $width;
                $optimal_height = $height;
            }
        }
        return array('optimal_width' => $optimal_width, 'optimal_height' => $optimal_height);
    }
}
