<?php

namespace vakata\image;

use vakata\image\driver\DriverInterface;

class Image implements ImageInterface
{
    protected $path;
    protected $drivers;
    protected $operations;

    /**
     * Create an instance. If a driver is not specified the most suitable one will be autodetected.
     * @method __construct
     * @param  string      $path the path to the image
     * @param  array       $drivers optional array of drivers to use, leaving `null` will autodetect the best driver
     */
    public function __construct(string $path, array $drivers = null)
    {
        if ($drivers === null) {
            $drivers = [
                \vakata\image\driver\IM::CLASS,
                \vakata\image\driver\GD::CLASS
            ];
        }
        $this->path = $path;
        $this->drivers = $drivers;
        $this->operations = [];
    }
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @method crop
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     * @return self
     */
    public function crop(int $width = 0, int $height = 0) : ImageInterface
    {
        $this->operations[] = [ __FUNCTION__, func_get_args() ];
        return $this;
    }
    /**
     * Rotate the image.
     * @method rotate
     * @param  float  $degrees clockwise angle to rotate
     * @return self
     */
    public function rotate(float $degrees) : ImageInterface
    {
        $this->operations[] = [ __FUNCTION__, func_get_args() ];
        return $this;
    }
    /**
     * Convert the image to grayscale.
     * @method grayscale
     * @return self
     */
    public function grayscale() : ImageInterface
    {
        $this->operations[] = [ __FUNCTION__, func_get_args() ];
        return $this;
    }
    
    protected function getDriver($imagedata)
    {
        foreach ($this->drivers as $driverClass) {
            try {
                return new $driverClass($imagedata);
            } catch (ImageException $ignore) { }
        }
        throw new ImageException('No driver found');
    }

    /**
     * Get the converted image
     * @method toString
     * @param  string|null   $format the format to use (optional, if null the current format will be used)
     * @return string binary string of the converted image
     */
    public function toString(string $format = null) : string
    {
        $operations = $this->operations;
        $operations[] = [ 'getImage', [ $format ] ];
        
        $driver = $this->getDriver(file_get_contents($this->path));
        return array_reduce($operations, function ($carry, $item) use ($driver) {
            return $driver->{$item[0]}(...$item[1]);
        });
    }
    /**
     * Get the image in JPG format
     * @method toJPG
     * @return string binary string of the converted image
     */
    public function toJPG() : string
    {
        return $this->toString('jpg');
    }
    /**
     * Get the image in PNG format
     * @method toPNG
     * @return string binary string of the converted image
     */
    public function toPNG() : string
    {
        return $this->toString('png');
    }
    /**
     * Get the image in GIF format
     * @method toGIF
     * @return string binary string of the converted image
     */
    public function toGIF() : string
    {
        return $this->toString('gif');
    }
    /**
     * Get the image in BMP format
     * @method toBMP
     * @return string binary string of the converted image
     */
    public function toBMP() : string
    {
        return $this->toString('bmp');
    }
    /**
     * Get the image in WEBP format
     * @method toWEBP
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