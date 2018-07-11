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
     * Resize the image, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the resized image
     * @param  int|integer $height the height of the resized image
     */
    public function resize(int $width = 0, int $height = 0)
    {
        $this->instance->scaleImage($width, $height);
    }
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     * @param  array $keep optional array of x, y, w, h of the import part of the image
     */
    public function crop(int $width = 0, int $height = 0, array $keep = [])
    {
        if (!$width && !$height) {
            throw new ImageException('You must supply at least one dimension');
        }
        $iw = $this->instance->getImageWidth();
        $ih = $this->instance->getImageHeight();
        if (!$height || !$width) {
            if (!$width) {
                $width  = $height / $ih * $iw;
            }
            if (!$height) {
                $height = $width  / $iw * $ih;
            }
        }
        $hasKeep = isset($keep['x']) && isset($keep['y']) && isset($keep['w']) && isset($keep['h']);
        if ($hasKeep && (!(int)$keep['w'] || !(int)$keep['h'])) {
            throw new ImageException('Invalid keep params');
        }
        if ($hasKeep) {
            // get the higher coeficient
            $coef = max($keep['w'] / $width, $keep['h'] / $height);
            // calculate new width / height so that the keep zone will fit in the crop
            $nw = $width * $coef;
            $nh = $height * $coef;
            $dx = ($nw - $keep['w']) / 2;
            $dy = ($nh - $keep['h']) / 2;
            $nx = $keep['x'] - $dx;
            $ex = $nx + $nw;
            $ny = $keep['y'] - $dy;
            $ey = $ny + $nh;
            if ($nx < 0) {
                $ex += $nx * -1;
                $ex = min($iw, $ex);
                $nx = 0;
            }
            if ($ex > $iw) {
                $nx = $nx - ($ex - $iw);
                $nx = max(0, $nx);
                $ex = $iw;
            }
            if ($ny < 0) {
                $ey += $ny * -1;
                $ey = min($ih, $ey);
                $ny = 0;
            }
            if ($ey > $ih) {
                $ny = $ny - ($ey - $ih);
                $ny = max(0, $ny);
                $ey = $ih;
            }
            $this->instance->cropImage($ex - $nx, $ey - $ny, $nx, $ny);
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