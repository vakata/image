# vakata\image\ImageInterface


## Methods

| Name | Description |
|------|-------------|
|[resize](#vakata\image\imageinterfaceresize)|Resize the image, if one dimension is skipped it will be automatically calculated.|
|[crop](#vakata\image\imageinterfacecrop)|Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.|
|[rotate](#vakata\image\imageinterfacerotate)|Rotate the image.|
|[grayscale](#vakata\image\imageinterfacegrayscale)|Convert the image to grayscale.|
|[toString](#vakata\image\imageinterfacetostring)|Get the converted image|
|[toJPG](#vakata\image\imageinterfacetojpg)|Get the image in JPG format|
|[toPNG](#vakata\image\imageinterfacetopng)|Get the image in PNG format|
|[toGIF](#vakata\image\imageinterfacetogif)|Get the image in GIF format|
|[toBMP](#vakata\image\imageinterfacetobmp)|Get the image in BMP format|
|[toWEBP](#vakata\image\imageinterfacetowebp)|Get the image in WEBP format|

---



### vakata\image\ImageInterface::resize
Resize the image, if one dimension is skipped it will be automatically calculated.  


```php
public function resize (  
    int|integer $width,  
    int|integer $height  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$width` | `int`, `integer` | the width of the resized image |
| `$height` | `int`, `integer` | the height of the resized image |
|  |  |  |
| `return` | `self` |  |

---


### vakata\image\ImageInterface::crop
Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.  


```php
public function crop (  
    int|integer $width,  
    int|integer $height  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$width` | `int`, `integer` | the width of the thumbnail |
| `$height` | `int`, `integer` | the height of the thumbnail |
|  |  |  |
| `return` | `self` |  |

---


### vakata\image\ImageInterface::rotate
Rotate the image.  


```php
public function rotate (  
    float $degrees  
) : self    
```

|  | Type | Description |
|-----|-----|-----|
| `$degrees` | `float` | clockwise angle to rotate |
|  |  |  |
| `return` | `self` |  |

---


### vakata\image\ImageInterface::grayscale
Convert the image to grayscale.  


```php
public function grayscale () : self    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `self` |  |

---


### vakata\image\ImageInterface::toString
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


### vakata\image\ImageInterface::toJPG
Get the image in JPG format  


```php
public function toJPG () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\ImageInterface::toPNG
Get the image in PNG format  


```php
public function toPNG () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\ImageInterface::toGIF
Get the image in GIF format  


```php
public function toGIF () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\ImageInterface::toBMP
Get the image in BMP format  


```php
public function toBMP () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---


### vakata\image\ImageInterface::toWEBP
Get the image in WEBP format  


```php
public function toWEBP () : string    
```

|  | Type | Description |
|-----|-----|-----|
|  |  |  |
| `return` | `string` | binary string of the converted image |

---

