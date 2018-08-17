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









