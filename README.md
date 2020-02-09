# FORK

this is a fork from https://github.com/appstract/laravel-response-macros, I change the output format to replicate the fractal standard, plus a message property:

### Success response

```json
{
    "success": true,
    "status": 200,
    "message": "congratulations!",
    "data": {
        // Some response object
    },
    "error": null
}
```

### Error response

```json
{
    "success": false,
    "status": 500,
    "message": "Bad request!",
    "data": null,
    "error": {
        // Some response object
    }
}
```

# Laravel Response Macros

[![Latest Version on Packagist](https://img.shields.io/packagist/v/appstract/laravel-response-macros.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-response-macros)
[![Total Downloads](https://img.shields.io/packagist/dt/appstract/laravel-response-macros.svg?style=flat-square)](https://packagist.org/packages/appstract/laravel-response-macros)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/appstract/laravel-response-macros/master.svg?style=flat-square)](https://travis-ci.org/appstract/laravel-response-macros)

This package is a collection of custom response macros that you can re-use in a variety of your routes and controllers.

## Installation

Since this is a fork from the original laravel-response-macros package, the best way to install it is using the VCS repositories feature. Add the following lines to your composer.json file:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/jecovier/laravel-response-macros"
        }
    ],
    "require": {
        "jecovier/laravel-response-macros": "dev-bugfix"
    }
}
```

and run:

```bash
composer install
```

## Usage

### Message

```php
return response()->message('hello world!', 200);
```

Result

```json
{
    "message": "hello world!"
}
```

With the Http `Status Code: 200`

### Error

```php
return response()->error('Something went wrong', $statuscode = 400, $errorObject = null);
```

Result

```json
{
    "success": false,
    "status": 400,
    "message": "Something went wrong",
    "data": null,
    "error": {
        // Some error object or null
    }
}
```

With the Http `Status Code: 400`

### Success

```php
return response()->success('congratulations!', ['some' => 'data'], $statuscode = 200);
```

Result

```json
{
    "success": true,
    "status": 200,
    "message": "congratulations!",
    "data": {
        "some": "data"
    },
    "error": null
}
```

With the Http `Status Code: 200`

## Testing

```bash
$ composer test
```

## Contributing

Contributions are welcome, [thanks to y'all](https://github.com/appstract/laravel-blade-directives/graphs/contributors) :)

## About Appstract

Appstract is a small team from The Netherlands. We create (open source) tools for webdevelopment and write about related subjects on [Medium](https://medium.com/appstract). You can [follow us on Twitter](https://twitter.com/teamappstract), [buy us a beer](https://www.paypal.me/teamappstract/10) or [support us on Patreon](https://www.patreon.com/appstract).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
