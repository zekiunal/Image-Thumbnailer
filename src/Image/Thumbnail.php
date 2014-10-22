<?php
namespace Image;

use Image\ResizeOptions\ResizeOptionInterface;

/**
 * @author      Zeki Unal <zekiunal@gmail.com>
 * @description
 *
 * @package     Image
 * @name        Thumbnail
 * @version     0.1
 */
class Thumbnail
{
    const IMAGE_JPEG = 'Image\JPEG';

    const IMAGE_JPG = 'Image\JPEG';

    const IMAGE_GIF = 'Image\GIF';

    const IMAGE_PNG = 'Image\PNG';

    /**
     * @var array
     */
    protected $mime_type_class_map = array(
        'image/jpeg' => Thumbnail::IMAGE_JPEG,
        'image/jpg'  => Thumbnail::IMAGE_JPG,
        'image/gif'  => Thumbnail::IMAGE_GIF,
        'image/png'  => Thumbnail::IMAGE_PNG
    );

    /**
     * @var array
     */
    protected $extension_class_map = array(
        '.jpeg' => Thumbnail::IMAGE_JPEG,
        '.jpg'  => Thumbnail::IMAGE_JPG,
        '.gif'  => Thumbnail::IMAGE_GIF,
        '.png'  => Thumbnail::IMAGE_PNG
    );

    /**
     * @var array
     */
    protected $resize_option_class_map = array(
        'exact'     => 'Image\ResizeOptions\Exact',
        'portrait'  => 'Image\ResizeOptions\Portrait',
        'landscape' => 'Image\ResizeOptions\Landscape',
        'auto'      => 'Image\ResizeOptions\Auto',
        'crop'      => 'Image\ResizeOptions\Crop',
        'default'   => 'Image\ResizeOptions\DefaultSize',
    );

    /**
     * @var resource
     */
    private $image;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var resource
     */
    private $image_resize;

    /**
     * @param integer $width
     * @param integer $height
     * @param string  $destination
     */
    public static function whiteImage($width, $height, $destination)
    {
        $canvas = self::createCanvas($width, $height);
        $bg = imagecolorallocate($canvas, 255, 255, 255);
        imagefilledrectangle($canvas, 0, 0, $width, $height, $bg);
        imagejpeg($canvas, $destination, 100);
    }

    /**
     * @param integer $width
     * @param integer $height
     * @return resource
     */
    protected static function createCanvas($width, $height)
    {
        return imagecreatetruecolor($width, $height);
    }

    /**
     * @param string $file_name
     */
    public function __construct($file_name)
    {
        $this->image = $this->createImage($file_name);
        if ($this->image === false) {
            $image_info = $this->getImageInfo($file_name);
            $processor = $this->getImageProcessorByMimeType($image_info['mime']);
            $this->image = $processor->createImage($file_name);
            $this->width = $image_info['width'];
            $this->height = $image_info['height'];
        } else {
            $this->width = imagesx($this->image);
            $this->height = imagesy($this->image);
        }
    }

    /**
     * @param string $file_name
     * @return array
     */
    protected function getImageInfo($file_name)
    {
        $image = getimagesize($file_name);
        $info = array(
            'mime'   => $image['mime'],
            'width'  => $image[0],
            'height' => $image[1]
        );
        return $info;
    }

    /**
     * @param string $mime_type
     * @return ImageProcessorInterface
     */
    protected function getImageProcessorByMimeType($mime_type)
    {
        return new $this->mime_type_class_map[$mime_type]();
    }

    /**
     * @param string $extension
     * @return ImageProcessorInterface
     */
    protected function getImageProcessorByExtension($extension)
    {
        return new $this->extension_class_map[$mime_type]();
    }

    /**
     * @param string $file_name
     * @return resource
     */
    protected function createImage($file_name)
    {
        $processor = $this->getImageProcessorByExtension($this->getExtension($file_name));
        return $processor->createImage($file_name);
    }

    /**
     * @param string $file_name
     * @return string
     */
    protected function getExtension($file_name)
    {
        return strtolower(strrchr($file_name, '.'));
    }

    /**
     * @param integer $width
     * @param integer $height
     * @param string  $option
     * @return void
     */
    public function resize($width, $height, $option = 'auto')
    {
        $dimensions = $this->getDimensions($width, $height, $option);
        $this->image_resize = self::createCanvas($dimensions['optimal_width'], $dimensions['optimal_height']);
        $this->reSample(
            $this->image_resize,
            $this->image,
            0,
            0,
            0,
            0,
            $dimensions['optimal_width'],
            $dimensions['optimal_height'],
            $this->width,
            $this->height
        );

        if ($option == 'crop') {
            $this->crop($dimensions['optimal_width'], $dimensions['optimal_height'], $width, $height);
        }
    }

    /**
     * @param integer $width
     * @param integer $height
     * @param string  $option
     * @return array
     */
    private function getDimensions($width, $height, $option)
    {
        /**
         * @var ResizeOptionInterface $type
         */
        $type = $this->resize_option_class_map[$option];
        return $type::getOptimalSize($width, $height, $this->width, $this->height);
    }

    /**
     * @param integer $optimal_width
     * @param integer $optimal_height
     * @param integer $width
     * @param integer $height
     */
    private function crop($optimal_width, $optimal_height, $width, $height)
    {
        $cropStartX = ($optimal_width / 2) - ($width / 2);
        $cropStartY = ($optimal_height / 2) - ($height / 2);
        $crop = $this->image_resize;
        $this->image_resize = self::createCanvas($width, $height);
        $this->reSample(
            $this->image_resize,
            $crop,
            0,
            0,
            $cropStartX,
            $cropStartY,
            $width,
            $height,
            $width,
            $height
        );
    }

    /**
     * Copy and resize part of an image with re-sampling
     *
     * @param resource $dst_img
     * @param resource $src_img
     * @param integer  $dst_x x-coordinate of destination point.
     * @param integer  $dst_y y-coordinate of destination point.
     * @param integer  $src_x x-coordinate of source point.
     * @param integer  $src_y y-coordinate of source point.
     * @param integer  $dst_w Destination width.
     * @param integer  $dst_h Destination height.
     * @param integer  $src_w Source width.
     * @param integer  $src_h Source height.
     * @return bool true on success or false on failure.
     */
    protected function reSample($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h)
    {
        return imagecopyresampled($dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
    }

    /**
     * @param string  $file_name
     * @param integer $quality
     */
    public function save($file_name, $quality = 100)
    {
        $temp_file = tempnam(sys_get_temp_dir(), 'Tux');
        $processor = $this->getImageProcessorByExtension($this->getExtension($file_name));
        $processor->save($this->image_resize, $temp_file, $quality);
        copy($temp_file, $file_name);
        unlink($temp_file);
        imagedestroy($this->image_resize);
    }
}
