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
    public function width(): int
    {
        return $this->info[0];
    }
    public function height(): int
    {
        return $this->info[1];
    }
    /**
     * Resize the image, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the resized image
     * @param  int|integer $height the height of the resized image
     */
    public function resize(int $width = 0, int $height = 0)
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
        $di = imagecreatetruecolor((int)$width, (int)$height);

        imagealphablending($di, false);
        $transparency = imagecolorallocatealpha($di, 0, 0, 0, 127);
        imagefill($di, 0, 0, $transparency);
        imagesavealpha($di, true);

        imagecopyresized($di, $this->data, 0, 0, 0, 0, (int)$width, (int)$height, (int)$iw, (int)$ih);
        $this->data = $di;
    }
    /**
     * Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.
     * @param  int|integer $width  the width of the thumbnail
     * @param  int|integer $height the height of the thumbnail
     * @param  array $keep optional array of x, y, w, h of the import part of the image
     * @param  array $keepEnlarge should the keep zone be enlarged to fit the thumbnail - defaults to false
     */
    public function crop(int $width = 0, int $height = 0, array $keep = [], bool $keepEnlarge = false)
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
        $hasKeep = isset($keep['x']) && isset($keep['y']) && isset($keep['w']) && isset($keep['h']);
        if ($hasKeep && (!(int)$keep['w'] || !(int)$keep['h'])) {
            throw new ImageException('Invalid keep params');
        }
        if ($hasKeep) {
            if ($keepEnlarge === false && $keep['w'] < $width && $keep['h'] < $height) {
                $dw = ($width - $keep['w']) / 2;
                $dh = ($height - $keep['h']) / 2;
                $dw = min($keep['x'], $dw);
                $nkx = $keep['x'] - $dw;
                $ekx = $nkx + $keep['w'] + $dw * 2;
                $nky = $keep['y'] - $dh;
                $eky = $nky + $keep['h'] + $dh * 2;
                if ($nkx < 0) {
                    $ekx += $nkx * -1;
                    $ekx = min($iw, $ekx);
                    $nkx = 0;
                }
                if ($ekx > $iw) {
                    $nkx = $nkx - ($ekx - $iw);
                    $nkx = max(0, $nkx);
                    $ekx = $iw;
                }
                if ($nky < 0) {
                    $eky += $nky * -1;
                    $eky = min($ih, $eky);
                    $nky = 0;
                }
                if ($eky > $ih) {
                    $nky = $nky - ($eky - $ih);
                    $nky = max(0, $nky);
                    $eky = $ih;
                }
                $keep = ['x'=>$nkx, 'y'=>$nky, 'w'=>$ekx - $nkx, 'h'=>$eky - $nky];
            }
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
            $di = imagecreatetruecolor((int)($ex - $nx), (int)($ey - $ny));
            
            imagealphablending($di, false);
            $transparency = imagecolorallocatealpha($di, 0, 0, 0, 127);
            imagefill($di, 0, 0, $transparency);
            imagesavealpha($di, true);

            imagecopyresampled(
                $di,
                $this->data,
                0,
                0,
                (int)$nx,
                (int)$ny,
                (int)($ex - $nx),
                (int)($ey - $ny),
                (int)($ex - $nx),
                (int)($ey - $ny)
            );
            $this->data = $di;
            $iw = $ex - $nx;
            $ih = $ey - $ny;
        }
        $mr = max($width / $iw, $height / $ih);
        $tm = imagecreatetruecolor((int)($iw * $mr), (int)($ih * $mr));

        imagealphablending($tm, false);
        $transparency = imagecolorallocatealpha($tm, 0, 0, 0, 127);
        imagefill($tm, 0, 0, $transparency);
        imagesavealpha($tm, true);

        imagecopyresized(
            $tm,
            $this->data,
            0,
            0,
            0,
            0,
            (int)($iw * $mr),
            (int)($ih * $mr),
            (int)$iw,
            (int)$ih
        );
        imagedestroy($this->data);
        $this->data = $tm;
        $iw = $iw * $mr;
        $ih = $ih * $mr;

        $di = imagecreatetruecolor((int)$width, (int)$height);

        imagealphablending($di, false);
        $transparency = imagecolorallocatealpha($di, 0, 0, 0, 127);
        imagefill($di, 0, 0, $transparency);
        imagesavealpha($di, true);

        imagecopyresampled(
            $di,
            $this->data,
            0,
            0,
            (int)(($iw-$width)/2),
            (int)(($ih-$height)/2),
            (int)$width,
            (int)$height,
            (int)$width,
            (int)$height
        );
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