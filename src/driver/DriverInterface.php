<?php

namespace vakata\image\driver;

interface DriverInterface
{
    public function width(): int;
    public function height(): int;
    /**
     * Resize the image, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the resized image
     * @param  int|integer $height the height of the resized image
     */
    public function resize(int $width = 0, int $height = 0);
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     * @param  array $keep optional array of x, y, w, h of the import part of the image
     * @param  bool $keepEnlarge should the keep zone be enlarged to fit the thumbnail - defaults to false
     */
    public function thumbnail(int $width = 0, int $height = 0, array $keep = [], bool $keepEnlarge = false);
    public function crop(int $width = 0, int $height = 0, int $x = 0, int $y = 0);
    /**
     * Rotate the image.
     * @param  float  $degrees clockwise angle to rotate
     */
    public function rotate(float $degrees);
    /**
     * Convert the image to grayscale.
     */
    public function grayscale();
    /**
     * Get the image in a specific format
     * @param  string|null $format        optional format to get the image in, if null the source image format is used
     * @return string binary string of the converted image
     */
    public function getImage(?string $format = null) : string;
}