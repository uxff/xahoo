yii-easyimage
=============
You don't need to create many types of thumbnails for images in your project.
You can create a thumbnail directly in the `View`. Thumbnail will automatically cached. It's easy!

Features:
- Easy to use
- Support `GD` and `Imagick`
- Automaticly thumbnails caching
- Cache sorting to subdirectories
- Support `Retina` displays
- Based on Kohana Image Library.

##Installing and configuring
Extract the `EasyImage` folder under `protected/extensions`

Add the following to your config file `components` section:

```php
'components'=>array(
//...
  'easyImage' => array(
    'class' => 'application.extensions.easyimage.EasyImage',
    //'driver' => 'GD',
    //'quality' => 100,
    //'cachePath' => '/assets/easyimage/',
    //'cacheTime' => 2592000,
    //'retinaSupport' => false,
  ),
```
and the following to `import` section:
```php

'import' => array(
  //...
  'ext.easyimage.EasyImage'
),
```

##Usage
###InstanceOf
```php
$image = new EasyImage('/path/to/image.jpg');
$image->resize(100, 100);
$image->save('/full/path/to/thumb.jpg');
```
####Parameters
- string `$file` required - Image file path
- string `$driver` - Driver: `GD`, `Imagick`

### ThumbOf
You can create a thumbnail directly in the `View`:

```php
// Create and autocache
Yii::app()->easyImage->thumbOf('/path/to/image.jpg', array('rotate' => 90));

// or
Yii::app()->easyImage->thumbOf('image.jpg', array('rotate' => 90),  array('class' => 'image'));

// or
Yii::app()->easyImage->thumbOf('image.png',
  array(
    'resize' => array('width' => 100, 'height' => 100),
    'type' => 'jpg',
    'quality' => 60,
  ),
  $someModel->updatedAt //cache version modifier
);

// or
Yii::app()->easyImage->thumbOf('image.png',
  array(
    'resize' => array('width' => 100, 'height' => 100),
    'rotate' => array('degrees' => 90),
    'sharpen' => 50,
    'background' => '#ffffff',
    'type' => 'jpg',
    'quality' => 60,
  ));
```
**Note.** This method return [CHtml::image()](http://www.yiiframework.com/doc/api/1.1/CHtml)

####Parameters
- string `$file` required - Image file path
- array `$params` - Image manipulation methods. See [Methods](README.md#methods)
- array `$htmlOptions` - options for CHtml::image()

### ThumbSrcOf
```php
Yii::app()->easyImage->thumbSrcOf('image.jpg', array('crop' => array('width' => 100, 'height' => 100)));
```
**Note.** This method return path to image cached.
####Parameters
- string `$file` required - Image file path
- array `$params` - Image manipulation methods. See [Methods](README.md#methods)

##Methods
###Resize
```php
$image->resize(100, 100, EasyImage::RESIZE_AUTO);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('resize' => array('width' => 100, 'height' => 100)));
```
####Parameters
- integer `$width` - New width
- integer `$height` - New height
- integer `$master` - Master dimension: `EasyImage::RESIZE_NONE`, `EasyImage::RESIZE_WIDTH`, `EasyImage::RESIZE_HEIGHT`, `EasyImage::RESIZE_AUTO`, `EasyImage::RESIZE_INVERSE`, `EasyImage::RESIZE_PRECISE`

###Crop
```php
$image->crop(100, 100);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('crop' => array('width' => 100, 'height' => 100)));
```
####Parameters
- integer `$width` required - New width
- integer `$height` required - New height
- mixed `$offset_x` = `NULL` - Offset from the left
- mixed `$offset_y` = `NULL` - Offset from the top

###Scale and Crop
```php
$image->scaleAndCrop(100, 100);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('scaleAndCrop' => array('width' => 100, 'height' => 100)));
```
####Parameters
- integer `$width` required - New width
- integer `$height` required - New height

###Rotate
```php
$image->rotate(45);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('rotate' => array('degrees' => 45)));
// or
Yii::app()->easyImage->thumbOf('image.jpg', array('rotate' => 45));
```
####Parameters
- integer `$degrees` required - Degrees to rotate: -360-360

###Flip
```php
$image->flip(EasyImage::FLIP_HORIZONTAL);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('flip' => array('direction' => EasyImage::FLIP_HORIZONTAL)));
// or
Yii::app()->easyImage->thumbOf('image.jpg', array('flip' => EasyImage::FLIP_VERTICAL));
```
####Parameters
- integer `$direction` required - Direction: `EasyImage::RESIZE_NONE`, `EasyImage::RESIZE_WIDTH`.

###Sharpen
```php
$image->sharpen(20);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('sharpen' => array('amount' => 20)));
// or
Yii::app()->easyImage->thumbOf('image.jpg', array('sharpen' => 20));
```
####Parameters
- integer `$amount` required - Amount to sharpen (percent): 1-100

###Reflection
```php
// Create a 50 pixel reflection that fades from 0-100% opacity
$image->reflection(50);

// Create a 50 pixel reflection that fades from 100-0% opacity
$image->reflection(50, 100, TRUE);

// Create a 50 pixel reflection that fades from 0-60% opacity
$image->reflection(50, 60, TRUE);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('reflection' => array('height' => 50)));
// or
Yii::app()->easyImage->thumbOf('image.jpg', array('reflection'));
```
**Note.** By default, the reflection will be go from transparent at the top to opaque at the bottom.
####Parameters
- integer `$height` = `NULL` - Reflection height
- integer `$opacity` = `100` - Reflection opacity: 0-100
- boolean `$fade_in` = `FALSE` - `TRUE` to fade in, `FALSE` to fade out

###Watermark
```php
$mark = new EasyImage('watermark.png');
$image->watermark($mark, TRUE, TRUE);
// or
$image->watermark('watermark.png', 20, 20);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('watermark' => array('watermark' => 'mark.png', 'opacity' => 50)));
```
**Note.** If no offset is specified, the center of the axis will be used. If an offset of `TRUE` is specified, the bottom of the axis will be used.
####Parameters
- mixed `$watermark` required - Watermark `EasyImage` instance or path to Image
- integer `$offset_x` = `NULL` - Offset from the left
- integer `$offset_y` = `NULL` - Offset from the top
- integer `$opacity` = `100` - Opacity of watermark: 1-100

###Background
```php
$image->background('#000', 50);
```
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('background' => array('color' => '#ffffff', 'opacity' => 50)));
// or
Yii::app()->easyImage->thumbOf('image.jpg', array('background' => '#ffffff'));
```
**Note** This is only useful for images with alpha transparency.
####Parameters
- string `$color` required - Hexadecimal color value
- integer `$opacity` = `100` - Background opacity: 0-100

###Quality
```php
Yii::app()->easyImage->thumbOf('image.jpg', array('quality' => 60)));
```
```php
//not support: $image->quality(60);
// see $image->render(NULL, 60);
```
**Note** This is only useful for `JPG` images.
####Parameters
- integer required - Quality of image: 1-100

###Type
```php
Yii::app()->easyImage->thumbOf('image.png', array('type' => 'jpg')));
```
```php
//not support: $image->type('jpg');
// see $image->render('jpg');
```

####Parameters
- string required - Image type to return: `png`, `jpg`, `gif`, etc

###Save
```php
// Save the image as a PNG
$image->save('image.png');

// Overwrite the original image
$image->save();
```
####Parameters
- string `$file` = `NULL` - New image path
- integer `$quality` = `100` - Quality of image: 1-100

###Render
```php

// Render the image at 50% quality
$data = $image->render(NULL, 50);

// Render the image as a PNG
$data = $image->render('png');
```
####Parameters
- string `$type` = `NULL` - Image type to return: `png`, `jpg`, `gif`, etc
- integer `$quality` = `100` - Quality of image: 1-100


