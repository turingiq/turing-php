# Turing PHP Library
Turing visual search and visually similar recommendations API library for PHP

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
$visual_api = new \Turing\VisualAPI($api_key, $mode);
```

`$api_key` is the API key generated when you [login](https://www.turingiq.com/login) to Turing dashboard.
`$mode` parameter selects API endpoint. It can be either `live` or `sandbox`. Default mode is `live`.

This library uses namespacing. When instantiating the object, you need to either use the fully qualified namespace:

```php
$visual_api = new \Turing\VisualAPI("your_api_key");
```

Or alias it:

```php
use \Turing\VisualAPI;

$visual_api = new VisualAPI("your_api_key");
```

### Run Tests

```sh
API_KEY=api_key vendor/bin/phpunit -c phpuint.xml
```
