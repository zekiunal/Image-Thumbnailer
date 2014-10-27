Image-Thumbnailer
=================

Create thumbnail images, convert image types.

### Installation

You can install via [composer](http://getcomposer.org/download/).

Run
```
php composer.phar require --prefer-dist "zekiunal/imagethumbnailer" "dev-master"
```

or add to require section of `composer.json:`

```
"zekiunal/imagethumbnailer": "dev-master"
```
### 2.Basic Usage Example
```
$image = new Image\Thumbnail('your_image_file.jpg');
$image->resize(100,100);
$image->save('destination_file.jpg');
```


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/zekiunal/image-thumbnailer/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

