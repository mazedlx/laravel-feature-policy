# Set Feature-Policy headers in a Laravel app

This package is strongly inspired by Spaties laravel-csp package. Thanks to Freek van der Herten and Thomas Verhelst for creating such an awesome package and doing all the heavy lifting!

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
    'enabled' => env('CSP_ENABLED', true),
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

You could even override the policy specified in the config file:

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
