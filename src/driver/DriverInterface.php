<?php

namespace vakata\image\driver;

interface DriverInterface
{
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @method crop
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     */
    public function crop(int $width = 0, int $height = 0);
    /**
     * Rotate the image.
     * @method rotate
     * @param  float  $degrees clockwise angle to rotate
     */
    public function rotate(float $degrees);
    /**
     * Convert the image to grayscale.
     * @method grayscale
     */
    public function grayscale();
    /**
     * Get the image in a specific format
     * @method getImage
     * @param  string|null $format        optional format to get the image in, if null the source image format is used
     * @return string binary string of the converted image
     */
    public function getImage(string $format = null) : string;
}