# dyimagefu
This is an image manipulation project.


### Setup

* Run `composer install` to install the dependencies.


### Getting started

Create an instance of the DYImageFu class. 

```PHP
$obj = new DYImageFu();
```

Now use the different methods to get the desired output.

# Methods

# `resize()`

This method will resize the image based on the configurations.

```PHP
$obj->resize(config);
```

Where, `config` is an array of configurations.


Can resize the following image files.

* jpeg
* jpg
* png



## Example

### 1: Resize width

In the following example the `source.png` image width is resized to `600px`.

Aspect ratio is maintained so, height is auto-adjusted.

Quality of the image is 100% (default).

```PHP
$obj->resize([
  'src' => '/image/source.png',
  'destDir' => '/image',
  'config' => [
    'resize' => 'width',
    'dimension' => 600
  ]
]);
```

Output file

```
/image/source_resize_600.png
```

Note! Output file name is in the following format.

```
{source_filename}_resize_{new_width}.{file_extension}
```

Example: If the input filename is `image.png` and the new resized width is `200px` then, output filename will be the following.

```
image_resize_200.png
```

### 2: Resize width to multiple values

In the following example `source.png` image width is resized to multiple values.

Aspect ratio is maintained so, height is auto-adjusted.

Quality of the image is set to 80%.

```PHP
$obj->resize([
  'src' => '/image/source.png',
  'destDir' => '/image',
  'config' => [
    'resize' => 'width',
    'dimension' => [100, 200, 300, 400, 500],
    'quality' => 80
  ]
]);
```

Output file

```
/image/source_resize_100.png
/image/source_resize_200.png
/image/source_resize_300.png
/image/source_resize_400.png
/image/source_resize_500.png
```

### 3: Resize width to multiple values and quality 

In the following example `source.png` image width is resized to multiple values and quality.

Aspect ratio is maintained so, height is auto-adjusted.

```PHP
$obj->resize([
  'src' => '/image/source.png',
  'destDir' => '/image',
  'config' => [
    'resize' => 'width',
    'dimension' => [100, 200, 300, 400, 500],
    'quality' => [100, 95, 90, 85, 80]
  ]
]);
```

Output file

```
/image/source_resize_100.png
/image/source_resize_200.png
/image/source_resize_300.png
/image/source_resize_400.png
/image/source_resize_500.png
```

### 4: Resize height

In the following example the `source.png` image height is resized to `200px`.

Aspect ratio is maintained so, width is auto-adjusted.

Quality of the image is 100% (default).

```PHP
$obj->resize([
  'src' => '/image/source.png',
  'destDir' => '/image',
  'config' => [
    'resize' => 'height',
    'dimension' => 200
  ]
]);
```

Output file

Assuming the original widthxheigth = 1000x500 in pixels.
So, resized widthxheight = 400x200 in pixels.

```
/image/source_resize_400.png
```

### 5: Resize height to multiple values

In the following example `source.png` image height is resized to multiple values.

Aspect ratio is maintained so, width is auto-adjusted.

Quality of the image is set to 80%.

```PHP
$obj->resize([
  'src' => '/image/source.png',
  'destDir' => '/image',
  'config' => [
    'resize' => 'height',
    'dimension' => [200, 400, 600],
    'quality' => 80
  ]
]);
```

Output file

Assuming the original widthxheigth = 1000x500 in pixels.
So, resized dimensions are the following.

= 400x200

= 800x400

= 1200x600

```
/image/source_resize_400.png
/image/source_resize_800.png
/image/source_resize_1200.png
```

### 6: Resize height to multiple values and quality 

In the following example `source.png` image height is resized to multiple values and quality.

Aspect ratio is maintained so, width is auto-adjusted.

```PHP
$obj->resize([
  'src' => '/image/source.png',
  'destDir' => '/image',
  'config' => [
    'resize' => 'height',
    'dimension' => [200, 400],
    'quality' => [100, 70]
  ]
]);
```

Output file

Assuming the original widthxheigth = 1000x500 in pixels.
So, resized dimensions are the following.

= 400x200

= 800x400


```
/image/source_resize_400.png
/image/source_resize_800.png
```

