<?php

namespace vakata\image\driver;

use vakata\image\ImageException;
use \Imagick;
use \ImagickPixel;

class IM implements DriverInterface
{
    protected $instance;
    
    public function __construct(string $imagedata)
    {
        if (!extension_loaded('imagick')) {
            throw new ImageException('Imagick extension not available');
        }
        $this->instance = new Imagick();
        $this->instance->readImageBlob($imagedata);
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
        if (!$height || !$width) {
            $iw = $this->instance->getImageWidth();
            $ih = $this->instance->getImageHeight();
            if (!$width) {
                $width  = $height / $ih * $iw;
            }
            if (!$height) {
                $height = $width  / $iw * $ih;
            }
        }
        $this->instance->cropThumbnailImage($width, $height);
    }
    /**
     * Rotate the image.
     * @param  float  $degrees clockwise angle to rotate
     */
    public function rotate(float $degrees)
    {
        $this->instance->rotateImage(new ImagickPixel(), $degrees);
    }
    /**
     * Convert the image to grayscale.
     */
    public function grayscale()
    {
        $this->instance->transformimagecolorspace(imagick::COLORSPACE_GRAY);
        $this->instance->separateImageChannel(1);
    }
    /**
     * Get the image in a specific format
     * @param  string|null $format        optional format to get the image in, if null the source image format is used
     * @return string binary string of the converted image
     */
    public function getImage(string $format = null) : string
    {
        if (!$format) {
            $format = $this->instance->getImageFormat();
        }
        switch (strtolower($format)) {
            case 'jpg':
            case 'jpeg':
                $this->instance->setImageFormat('jpg');
                break;
            case 'bitmap':
            case 'bmp':
                $this->instance->setImageFormat('bmp');
                break;
            case 'png':
                $this->instance->setImageFormat('png');
                break;
            case 'gif':
                $this->instance->setImageFormat('gif');
                break;
            case 'webp':
                $this->instance->setImageFormat('webp');
                break;
            default:
                throw new ImageException('Unsupported format');
        }
        return $this->instance->getImageBlob();
    }
}