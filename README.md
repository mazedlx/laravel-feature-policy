# Set Feature-Policy headers in a Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mazedlx/laravel-feature-policy.svg?style=flat-square)](https://packagist.org/packages/mazedlx/laravel-feature.policy)
[![Build Status](https://travis-ci.org/mazedlx/laravel-feature-policy.svg?branch=master)](https://travis-ci.org/mazedlx/laravel-feature-policy)
[![Total Downloads](https://img.shields.io/packagist/dt/mazedlx/laravel-feature-policy.svg?style=flat-square)](https://packagist.org/packages/mazedlx/laravel-feature.policy)

This package is strongly inspired by [Spaties](https://spatie.be) [laravel-csp](https://github.com/spatie/laravel-csp) package. Thanks to [Freek van der Herten](https://github.com/freekmurze) and [Thomas Verhelst](https://github.com/TVke) for creating such an awesome package and doing all the heavy lifting!

With Feature-Policy you can control which web platform features to allow and disallow within your web applications. Feature-Policy is a Security Header (like Content-Security-Policy) that is brand new. The list of things you can restrict isn't final yet, I'll add them in time when the specification evolves.

## Installation

You should install this package via composer:

```bash
$ composer require mazedlx/laravel-feature-policy
```

Next, publish the config file:

```bash
$ php artisan vendor:publish --provider="Mazedlx\FeaturePolicy\FeaturePolicyServiceProvider" --tag="config"
```

The contents of the `config/feature-policy.php` file look like this:

```php
<?php

return [
    /*
     * A policy will determine which Feature-Policy headers will be set.
     * A valid policy extends `Mazedlx\FeaturePolicy\Policies\Policy`
     */
    'policy' => Mazedlx\FeaturePolicy\Policies\Basic::class,

    /*
     * Feature-policy headers will only be added if this is set to true
     */
    'enabled' => env('FPH_ENABLED', true),
];
```

## Middleware

You can add Feature-Policy headers to all responses by registering `Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders::class` in the HTTP kernel:

```php
// app/Htpp/Kernel.php

...

protected $middlewareGroups = [
    'web' => [
        ...
        \Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders::class,
    ]
];
```

Alternatively you can add the middleware to the a single route and route group:

```php
// in a routes file
Route::get('/home', 'HomeController')->middleware(Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders::class);
```

You could even pass a policy as a parameter and override the policy specified in the config file:

```php
// in a routes file
Route::get('/home', 'HomeController')->middleware(Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders::class . ':' . MyFeaturePolicy::class);
```

## Usage

This package allows you to define Feature-Policy policies. A Feature-Policy policy determines which Feature-Policy directives will be set in the headers of the response.

An example of a Feature-Policy directive is `microphone`:

`Feature-Policy: microphone 'self' https://spatie.be`

In the above example by specifying `microphone` and allowing it for `'self'` the feature is diabled for all origins except our own and https://spatie.be.

The full list of restrictable directives isn't final yet, but here are some of the things you have access to:

- accelerometer
- ambient-light-sensor
- autoplay
- camera
- encrypted-media
- fullscreen
- geolocation
- gyroscope
- magnetometer
- microphone
- midi
- payment
- picture-in-picture
- speaker
- usb
- vr

You can find the feature definitions at [https://github.com/WICG/feature-policy/blob/master/features.md]

You can add multiple policy options as an array or as a single string with space-sepearated options:

```php
// in a policy
...
    ->addDirective(Directive::CAMERA, [
        Value::SELF,
        'spatie.be',
    ])
    ->addDirective(Directive::GYROSCOPE, 'self spatie.be')
...
```

## Creating Policies

The `policy` key of the `feature-policy` config file is set to `Mazedlx\FeaturePolicy\Policies\Basic::class` by default, which allows your site to use a few of the available features. The class looks like this:

```php
<?php

namespace Mazedlx\FeaturePolicy\Policies;

use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;

class Basic extends Policy
{
    public function configure()
    {
        $this->addDirective(Directive::GEOLOCATION, Value::SELF)
            ->addDirective(Directive::FULLSCREEN, Value::SELF);
    }
}
```

Let's say you're happy with allowing `geolocation` and `fullscreen` but also wanted to add `www.awesomesite.com` to gain access to this feature, then you can easily extend the class:

```php
<?php

namespace App\Services\FeaturePolicy\Policies;

use Mazedlx\FeaturePolicy\Directive;
use Mazedlx\FeaturePolicy\Policies\Basic;

class MyFeaturePolicy extends Basic
{
    public function configure()
    {
        parent::configure();

        $this->addDirective(Directive::GEOLOCATION, 'www.awesomesite.com')
            ->addDirective(Directive::FULLSCREEN, 'www.awesomesite.com');
    }
}
```

Don't forget to change the `policy` key in the `feature-policy` config file to the class name fo your policy (e.g. `App\Services\Policies\MyFeaturePolicy`).

## Testing

You can run all tests with:

```bash
$ composer tests
```

## Changelog

Please see [CHANGELOG](https://github.com/mazedlx/laravel-feature-policy/blob/master/CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/mazedlx/laravel-feature-policy/blob/master/CONTRIBUTING.md) for details.

### Security

If you discover any security related issues please email mazedlx@gmail.com instead of using the issue tracker.

## Credits

- [Freek van der Herten](https://github.com/freekmurze)
- [Thomas Verhelst](https://github.com/TVke)
- [All Contributors](https://github.com/mazedlx/laravel-feature-policy/contributors)

## Support

If you like this package please feel free to star it.

## License

The MIT License (MIT). Please see [LICENSE](https://github.com/mazedlx/laravel-feature-policy/blob/master/LICENSE.md) for more information.
