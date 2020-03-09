<?php

namespace vakata\image;

use vakata\image\driver\DriverInterface;

class Image implements ImageInterface
{
    protected $data;
    protected $drivers;
    protected $operations;

    /**
     * Create an instance from a path. If a driver is not specified the most suitable one will be autodetected.
     * @param  string      $data the path to an image
     * @param  array       $drivers optional array of drivers to use, leaving `null` will autodetect the best driver
     * @return ImageInterface
     */
    public static function fromPath(string $path, array $drivers = null) : ImageInterface
    {
        return new static(file_get_contents($path), $drivers);
    }

    /**
     * Create an instance. If a driver is not specified the most suitable one will be autodetected.
     * @param  string      $data the raw image data
     * @param  array       $drivers optional array of drivers to use, leaving `null` will autodetect the best driver
     */
    public function __construct(string $data, array $drivers = null)
    {
        if ($drivers === null) {
            $drivers = [
                \vakata\image\driver\IM::class,
                \vakata\image\driver\GD::class
            ];
        }
        $this->data = $data;
        $this->drivers = $drivers;
        $this->operations = [];
    }

    public function width(): int
    {
        return $this->getDriver()->width();
    }
    public function height(): int
    {
        return $this->getDriver()->height();
    }
    public function isSquare(): bool
    {
        return $this->width() === $this->height();
    }
    public function isLandscape(): bool
    {
        return $this->width() > $this->height();
    }
    public function isPortrait(): bool
    {
        return $this->width() < $this->height();
    }

    public function resizeLongEdge(int $size, bool $enlarge = true): ImageInterface
    {
        $w = $this->width();
        $h = $this->height();
        if ($w > $h) {
            if (!$enlarge && $w <= $size) {
                return $this;
            }
            return $this->resize($size, 0);
        }
        if (!$enlarge && $h <= $size) {
            return $this;
        }
        return $this->resize(0, $size);
    }

    /**
     * Resize the image, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the resized image
     * @param  int|integer $height the height of the resized image
     * @return $this
     */
    public function resize(int $width = 0, int $height = 0) : ImageInterface
    {
        $this->operations[] = [ __FUNCTION__, func_get_args() ];
        return $this;
    }
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     * @param  array $keep optional array of x, y, w, h of the import part of the image
     * @param  array $keepEnlarge should the keep zone be enlarged to fit the thumbnail - defaults to false
     * @return $this
     */
    public function crop(int $width = 0, int $height = 0, array $keep = [], bool $keepEnlarge = false) : ImageInterface
    {
        $this->operations[] = [ __FUNCTION__, func_get_args() ];
        return $this;
    }
    /**
     * Rotate the image.
     * @param  float  $degrees clockwise angle to rotate
     * @return $this
     */
    public function rotate(float $degrees) : ImageInterface
    {
        $this->operations[] = [ __FUNCTION__, func_get_args() ];
        return $this;
    }
    /**
     * Convert the image to grayscale.
     * @return $this
     */
    public function grayscale() : ImageInterface
    {
        $this->operations[] = [ __FUNCTION__, func_get_args() ];
        return $this;
    }
    
    protected function getDriver()
    {
        foreach ($this->drivers as $driverClass) {
            try {
                return new $driverClass($this->data);
            } catch (ImageException $ignore) { }
        }
        throw new ImageException('No driver found');
    }

    /**
     * Get the converted image
     * @param  string|null   $format the format to use (optional, if null the current format will be used)
     * @return string binary string of the converted image
     */
    public function toString(string $format = null) : string
    {
        $operations = $this->operations;
        $operations[] = [ 'getImage', [ $format ] ];
        
        $driver = $this->getDriver();
        return array_reduce($operations, function ($carry, $item) use ($driver) {
            return $driver->{$item[0]}(...$item[1]);
        });
    }
    /**
     * Get the image in JPG format
     * @return string binary string of the converted image
     */
    public function toJPG() : string
    {
        return $this->toString('jpg');
    }
    /**
     * Get the image in PNG format
     * @return string binary string of the converted image
     */
    public function toPNG() : string
    {
        return $this->toString('png');
    }
    /**
     * Get the image in GIF format
     * @return string binary string of the converted image
     */
    public function toGIF() : string
    {
        return $this->toString('gif');
    }
    /**
     * Get the image in BMP format
     * @return string binary string of the converted image
     */
    public function toBMP() : string
    {
        return $this->toString('bmp');
    }
    /**
     * Get the image in WEBP format
     * @return string binary string of the converted image
     */
    public function toWEBP() : string
    {
        return $this->toString('webp');
    }

    public function __toString()
    {
        return $this->toString();
    }
}