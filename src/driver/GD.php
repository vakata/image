<?php

namespace vakata\image\driver;

use vakata\image\ImageException;

class GD implements DriverInterface
{
    protected $data;
    protected $info;

    public function __construct(string $imagedata)
    {
        if (!extension_loaded('gd') || !function_exists('gd_info')) {
            throw new ImageException('GD extension not available');
        }
        $this->data = imagecreatefromstring($imagedata);
        $this->info = getimagesizefromstring($imagedata);
    }
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     */
    public function crop(int $width = 0, int $height = 0)
    {
        if (!$width && !$height) {
            throw new ImageException('You must supply at least one dimension');
        }
        $iw = $this->info[0];
        $ih = $this->info[1];
        if (!$height || !$width) {
            if (!$width) {
                $width  = $height / $ih * $iw;
            }
            if (!$height) {
                $height = $width  / $iw * $ih;
            }
        }

        $mr = max($width / $iw, $height / $ih);
        $tm = imagecreatetruecolor($iw * $mr, $ih * $mr);
        imagecopyresized($tm, $this->data, 0, 0, 0, 0, $iw * $mr, $ih * $mr, $iw, $ih);
        imagedestroy($this->data);
        $this->data = $tm;
        $iw = $iw * $mr;
        $ih = $ih * $mr;

        $di = imagecreatetruecolor($width, $height);
        imagecopyresampled($di, $this->data, 0, 0, ($iw-$width)/2, ($ih-$height)/2, $width, $height, $width, $height);
        $this->data = $di;
    }
    /**
     * Rotate the image.
     * @param  float  $degrees clockwise angle to rotate
     */
    public function rotate(float $degrees)
    {
        $degrees = 360 - $degrees; // match imagick
        $this->data = imagerotate($this->data, $degrees, 0);
    }
    /**
     * Convert the image to grayscale.
     */
    public function grayscale()
    {
        imagefilter($this->data, IMG_FILTER_GRAYSCALE);
    }
    /**
     * Get the image in a specific format
     * @param  string|null $format        optional format to get the image in, if null the source image format is used
     * @return string binary string of the converted image
     */
    public function getImage(string $format = null) : string
    {
        if (!$format) {
            $format = explode('/', $this->info['mime'], 2)[1];
        }
        switch (strtolower($format)) {
            case 'jpg':
            case 'jpeg':
                ob_start();
                imagejpeg($this->data);
                return ob_get_clean();
            case 'bitmap':
            case 'bmp':
                ob_start();
                imagewbmp($this->data);
                return ob_get_clean();
            case 'png':
                ob_start();
                imagepng($this->data);
                return ob_get_clean();
            case 'gif':
                ob_start();
                imagegif($this->data);
                return ob_get_clean();
            case 'webp':
                ob_start();
                imagewebp($this->data, null);
                return ob_get_clean();
            default:
                throw new ImageException('Unsupported format');
        }
    }
}