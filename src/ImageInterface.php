<?php

namespace vakata\image;

interface ImageInterface
{
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @method crop
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     * @return self
     */
    public function crop(int $width = 0, int $height = 0) : ImageInterface;
    /**
     * Rotate the image.
     * @method rotate
     * @param  float  $degrees clockwise angle to rotate
     * @return self
     */
    public function rotate(float $degrees) : ImageInterface;
    /**
     * Convert the image to grayscale.
     * @method grayscale
     * @return self
     */
    public function grayscale() : ImageInterface;
    /**
     * Get the converted image
     * @method toString
     * @param  string|null   $format the format to use (optional, if null the current format will be used)
     * @return string binary string of the converted image
     */
    public function toString(string $format = null) : string;
    /**
     * Get the image in JPG format
     * @method toJPG
     * @return string binary string of the converted image
     */
    public function toJPG() : string;
    /**
     * Get the image in PNG format
     * @method toPNG
     * @return string binary string of the converted image
     */
    public function toPNG() : string;
    /**
     * Get the image in GIF format
     * @method toGIF
     * @return string binary string of the converted image
     */
    public function toGIF() : string;
    /**
     * Get the image in BMP format
     * @method toBMP
     * @return string binary string of the converted image
     */
    public function toBMP() : string;
    /**
     * Get the image in WEBP format
     * @method toWEBP
     * @return string binary string of the converted image
     */
    public function toWEBP() : string;
}