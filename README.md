# Turing PHP Library

Turing visual search and visually similar recommendations API library for PHP. The REST API documentation can be found here: [https://api.turingiq.com/doc/](https://api.turingiq.com/doc/)

Setup
-----

This package is available through Packagist with the vendor and package identifier the same as this repo.

If using [Composer](https://getcomposer.org/), in your `composer.json` file add:

```json
{
    "require": {
        "turingiq/turing-php": "1.0.*"
    }
}
```

> Minimum required PHP version is 5.5.

If you are using composer for first time in your project, you need to include ```autorun.php``` file.

```php
include "vendor/autoload.php"
```

Initialize
----------

You can initialize the `VisualAPI` class with below parameters.

```php
$api_key = 'your_api_key'; // You can get API key when you login at: https://www.turingiq.com/login
$mode = 'live';            // the mode can be either `live` or `sandbox`. Default mode is `live`.
$visual_api = new \Turing\VisualAPI($api_key, $mode);
```

This library uses namespacing. When instantiating the object, you need to either use the fully qualified namespace:

```php
$visual_api = new \Turing\VisualAPI("your_api_key");
```

Or alias it:

```php
use \Turing\VisualAPI;

$visual_api = new VisualAPI("your_api_key");
```

Autocrop
--------

Detect objects in image and get bounding boxes around objects detected.

```php
// $image_url is required field.
$image_url = "https://example.com/image_url.jpg";

// now let's call the API.
$resp = $visual_api->autocrop($image_url);
```

The bounding boxes returned by this method can be given to visual search to improve visual search quality.


Insert
------

You need to insert images to our index to query on them. The insert function can be written as below.

```php
// $id is required field.
$id = 'image_id';

// $image_url is required field.
$image_url = "https://example.com/image_url.jpg";

// $filters argument is optional. You can specify upto 3 filters as per example given below.
// Filters can be useful when querying images from our index. You can apply any filter
// as per your requirement.
$filters = ["filter1" => "onefilter", "filter2" => "twofilter", "filter3" => "threefilter"];

// $metadata is optional. You can pass additional information about your image which will be
// returned when you query image from our index.
$metadata = ["title" => "Image Title"];

// now let's call the API.
$resp = $visual_api->insert($id, $image_url, $filters, $metadata);
```

Update
------

If you need to update information to indexed image, you can use update function. If you call update function for id which is not already indexed, it will insert the image to index.

```php
// $id is required field. Provide id for which you need to update the information.
$id = 'image_id';

// $image_url is optional field. You can pass `null` if you would like to keep URL unchanged.
$image_url = "https://example.com/image_url.jpg";

// $filters argument is optional. You can specify upto 3 filters as per example given below.
// Filters can be useful when querying images from our index. You can apply any filter
// as per your requirement. The filters you provide here will be overwritten.
$filters = ["filter1" => "onefilter", "filter2" => "twofilter", "filter3" => "threefilter"];

// $metadata is optional. You can pass additional information about your image which will be
// returned when you query image from our index. Existing metadata values will be overwritten
// based on keys supplied to this array.
$metadata = ["title" => "Image Title"];

// now let's call the API.
$resp = $visual_api->update($id, $image_url, $filters, $metadata);
```

Delete
------

You can delete image from index with this method.

```php
// $id is required field.
$id = 'image_id';

// now let's call the API.
$resp = $visual_api->delete($id);
```

Visual Search
-------------

Visual search can be used to search indexed images based on query image.

```php
// $image_url is required field. The API will perform visual search on the image and return
$image_url = "https://example.com/image_url.jpg";

// $crop_box is optional field. You can supply empty array if you don't want to specify crop box.
// The format of crop box is [xmin, ymin, xmax, ymax]
$crop_box = [188, 256, 656, 928];

// $filters argument is optional. You can specify upto 3 filters.
// For example, if you specify filter1 = "nike", it will only return images which are indexed with
// "nike" as filter1.
$filters = ["filter1" => "nike"];

// now let's call the API.
$resp = $visual_api->search($image_url, $crop_box, $filters);
```

Visual Recommendations
----------------------

Visual recommendations give visually similar image recommendations which can be used to display recommendation widget on e-commerce sites which greatly improved CTR and conversion rates.

```php
// $image_url is required field. The API will perform visual search on the image and return
$id = "some_product_id";

// $filters argument is optional. You can specify upto 3 filters.
// For example, if you specify filter1 = "nike", it will only return images which are indexed with
// "nike" as filter1.
$filters = ["filter1" => "nike"];

// now let's call the API.
$resp = $visual_api->recommendations($id, $filters);
```


### Run Tests

```sh
API_KEY=api_key vendor/bin/phpunit -c phpuint.xml
```
