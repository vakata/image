# vakata\image\Image


## Methods

| Name | Description |
|------|-------------|
|[fromPath](#vakata\image\imagefrompath)|Create an instance from a path. If a driver is not specified the most suitable one will be autodetected.|
|[__construct](#vakata\image\image__construct)|Create an instance. If a driver is not specified the most suitable one will be autodetected.|
|[resize](#vakata\image\imageresize)|Resize the image, if one dimension is skipped it will be automatically calculated.|
|[crop](#vakata\image\imagecrop)|Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.|
|[rotate](#vakata\image\imagerotate)|Rotate the image.|
|[grayscale](#vakata\image\imagegrayscale)|Convert the image to grayscale.|
|[toString](#vakata\image\imagetostring)|Get the converted image|
|[toJPG](#vakata\image\imagetojpg)|Get the image in JPG format|
|[toPNG](#vakata\image\imagetopng)|Get the image in PNG format|
|[toGIF](#vakata\image\imagetogif)|Get the image in GIF format|
|[toBMP](#vakata\image\imagetobmp)|Get the image in BMP format|
|[toWEBP](#vakata\image\imagetowebp)|Get the image in WEBP format|

---



### vakata\image\Image::fromPath
Create an instance from a path. If a driver is not specified the most suitable one will be autodetected.  


```php
public static function fromPath (  
    string $data,  
    array $drivers  
) : \ImageInterface    
```

|  | Type | Description |
|-----|-----|-----|
| `$data` | `string` | the path to an image |
| `$drivers` | `array` | optional array of drivers to use, leaving `null` will autodetect the best driver |
|  |  |  |
| `return` | `\ImageInterface` |  |

---


### vakata\image\Image::__construct
Create an instance. If a driver is not specified the most suitable one will be autodetected.  


```php
public function __construct (  
    string $data,  
    array $drivers  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$data` | `string` | the raw image data |
| `$drivers` | `array` | optional array of drivers to use, leaving `null` will autodetect the best driver |

---


### vakata\image\Image::resize
Resize the image, if one dimension is skipped it will be automatically calculated.  


```php
public function resize (  
    int|integer $width,  
    int|integer $height  
) : $this    
```

|  | Type | Description |
|-----|-----|-----|
| `$width` | `int`, `integer` | the width of the resized image |
| `$height` | `int`, `integer` | the height of the resized image |
|  |  |  |
| `return` | `$this` |  |

---


### vakata\image\Image::crop
Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.  


```php
public function crop (  
    int|integer $width,  
    int|integer $height,  
    array $keep  
) : $this    
```

|  | Type | Description |
|-----|-----|-----|
| `$width` | `int`, `integer` | the width of the thumbnail |
| `$height` | `int`, `integer` | the height of the thumbnail |
| `$keep` | `array` | optional array of x, y, w, h of the import part of the image |
|  |  |  |
| `return` | `$this` |  |

---


### vakata\image\Image::rotate
Rotate the image.  


```php
public function rotate (  
    float $degrees  
) : $this    
```

|  | Type | Description |
|-----|-----|-----|
| `$degrees` | `float` | clockwise angle to rotate |
|  |  |  |
| `return` | `$this` |  |

---


### vakata\image\Image::grayscale
Convert the image to grayscale.  


```php
public function grayscale () : $this    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `$this` |  |

---


### vakata\image\Image::toString
Get the converted image  


```php
public function toString (  
    string|null $format  
) : string    
```

|  | Type | Description |
|-----|-----|-----|
| `$format` | `string`, `null` | the format to use (optional, if null the current format will be used) |
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\Image::toJPG
Get the image in JPG format  


```php
public function toJPG () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\Image::toPNG
Get the image in PNG format  


```php
public function toPNG () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\Image::toGIF
Get the image in GIF format  


```php
public function toGIF () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\Image::toBMP
Get the image in BMP format  


```php
public function toBMP () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\Image::toWEBP
Get the image in WEBP format  


```php
public function toWEBP () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---

