<?php

namespace vakata\image;

interface ImageInterface
{
    public function width(): int;
    public function height(): int;
    public function isSquare(): bool;
    public function isPortrait(): bool;
    public function isLandscape(): bool;
    public function resizeLongEdge(int $size, bool $enlarge = true): ImageInterface;

    /**
     * Resize the image, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the resized image
     * @param  int|integer $height the height of the resized image
     * @return self
     */
    public function resize(int $width = 0, int $height = 0) : ImageInterface;
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     * @param  array $keep optional array of x, y, w, h of the import part of the image
     * @param  array $keepEnlarge should the keep zone be enlarged to fit the thumbnail - defaults to false
     * @return self
     */
    public function thumbnail(int $width = 0, int $height = 0, array $keep = [], bool $keepEnlarge = false) : ImageInterface;
    public function crop(int $width = 0, int $height = 0, int $x = 0, int $y = 0) : ImageInterface;
    /**
     * Rotate the image.
     * @param  float  $degrees clockwise angle to rotate
     * @return self
     */
    public function rotate(float $degrees) : ImageInterface;
    /**
     * Convert the image to grayscale.
     * @return self
     */
    public function grayscale() : ImageInterface;
    /**
     * Get the converted image
     * @param  string|null   $format the format to use (optional, if null the current format will be used)
     * @return string binary string of the converted image
     */
    public function toString(string $format = null) : string;
    /**
     * Get the image in JPG format
     * @return string binary string of the converted image
     */
    public function toJPG() : string;
    /**
     * Get the image in PNG format
     * @return string binary string of the converted image
     */
    public function toPNG() : string;
    /**
     * Get the image in GIF format
     * @return string binary string of the converted image
     */
    public function toGIF() : string;
    /**
     * Get the image in BMP format
     * @return string binary string of the converted image
     */
    public function toBMP() : string;
    /**
     * Get the image in WEBP format
     * @return string binary string of the converted image
     */
    public function toWEBP() : string;
}