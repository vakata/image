# vakata\image\driver\IM


## Methods

| Name | Description |
|------|-------------|
|[crop](#vakata\image\driver\imcrop)|Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.|
|[rotate](#vakata\image\driver\imrotate)|Rotate the image.|
|[grayscale](#vakata\image\driver\imgrayscale)|Convert the image to grayscale.|
|[getImage](#vakata\image\driver\imgetimage)|Get the image in a specific format|

---



### vakata\image\driver\IM::crop
Crop a thumbnail with hardcoded dimensions, if one dimension is skipped it will be automatically calculated.  


```php
public function crop (  
    int|integer $width,  
    int|integer $height  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$width` | `int`, `integer` | the width of the thumbnail |
| `$height` | `int`, `integer` | the height of the thumbnail |

---


### vakata\image\driver\IM::rotate
Rotate the image.  


```php
public function rotate (  
    float $degrees  
)   
```

|  | Type | Description |
|-----|-----|-----|
| `$degrees` | `float` | clockwise angle to rotate |

---


### vakata\image\driver\IM::grayscale
Convert the image to grayscale.  


```php
public function grayscale ()   
```


---


### vakata\image\driver\IM::getImage
Get the image in a specific format  


```php
public function getImage (  
    string|null $format  
) : string    
```

|  | Type | Description |
|-----|-----|-----|
| `$format` | `string`, `null` | optional format to get the image in, if null the source image format is used |
|  |  |  |
| `return` | `string` | binary string of the converted image |

---
