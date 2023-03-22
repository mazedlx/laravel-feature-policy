# Configure the browsers abilities

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mazedlx/laravel-feature-policy.svg?style=flat-square)](https://packagist.org/packages/mazedlx/laravel-feature.policy)
[![Tests](https://github.com/mazedlx/laravel-feature-policy/actions/workflows/test.yml/badge.svg)](https://github.com/mazedlx/laravel-feature-policy/actions/workflows/test.yml)
[![Analyse and format](https://github.com/mazedlx/laravel-feature-policy/actions/workflows/code-quality.yml/badge.svg)](https://github.com/mazedlx/laravel-feature-policy/actions/workflows/code-quality.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/mazedlx/laravel-feature-policy.svg?style=flat-square)](https://packagist.org/packages/mazedlx/laravel-feature-policy)


The Permissions-Policy, which [previously](https://docs.w3cub.com/http/headers/feature-policy) was known as the Feature-Policy.
But since it came out of draft, it was renamed to "Permissions-Policy".  
The "Permissions-Policy" is an HTTP header which can be used to restrict the abilities of a browser.

Where the Content-Security-Policy focuses on security, the "Permissions-Policy" focuses on allowing or disabling the abilities of the browser.  
This can be done though the HTTP header, which this package focuses on, but it can also do this through the `allows` attribute on the `iframe` element.

<details>
<summary>iframe example</summary>

```html
<iframe width="643" height="360" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
```

</details>

More on the header itself can be found on the following sites.
- [Feature Policy | Smashing Magazine](https://www.smashingmagazine.com/2018/12/feature-policy/)
- [Feature Policy | Google Developers](https://developer.chrome.com/blog/feature-policy/)
- [W3C](https://www.w3.org/TR/permissions-policy/)

## Installation

**Laravel 10 users should use v2.0 or newer, otherwise stick to v1.3**

The package can be installed though composer:
```bash
$ composer require mazedlx/laravel-feature-policy
```
After which the config file needs to be published:
```bash
$ php artisan vendor:publish --provider="Mazedlx\FeaturePolicy\FeaturePolicyServiceProvider" --tag="config"
```

Which looks like this:
<details>
<summary>Config file</summary>

```php
<?php

return [
    /*
     * A policy will determine which "Permissions-Policy" headers will be set.
     * A valid policy extends `Mazedlx\FeaturePolicy\Policies\Policy`
     */
    'policy' => Mazedlx\FeaturePolicy\Policies\Basic::class,

    /*
     * "Feature-Policy" headers will only be added if this is set to true
     */
    'enabled' => env('FPH_ENABLED', true),
];
```
</details>

## Middleware

You can add "Feature-Policy" headers to all responses by registering `Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders::class` in the HTTP kernel:
<details>
<summary>Middleware example</summary>

```php
// app/Http/Kernel.php

...

protected $middlewareGroups = [
    'web' => [
        ...
        \Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders::class,
    ]
];
```
</details>

Alternatively you can add the middleware to a single route and route group:
<details>
<summary>Route example</summary>

```php
// in a routes file
use App\Http\Controllers\HomeController;
use Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders;

Route::get('/home', HomeController::class)
    ->middleware(AddFeaturePolicyHeaders::class);
```

You could even pass a policy as a parameter and override the policy specified in the config file:

```php
// in a routes file
use App\Http\Controllers\HomeController;
use Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders;

Route::get('/home', HomeController::class)
    ->middleware(AddFeaturePolicyHeaders::class . ':' . MyFeaturePolicy::class);
```
</details>

## Usage

This package allows you to configure the policies that end up in the "Permissions-Policy" header. 

This policy determines which directives will be set in the "Permissions-Policy" header of the response.

It uses the following syntax;
```text
Feature-Policy: <directive> <allowlist>
```

An example of a "Permissions-Policy" directive is `microphone`:

`Permissions-Policy: microphone=(self "https://spatie.be")`

In the above example by specifying `microphone` and allowing it for `self` makes the permission disabled for all origins except our own and https://spatie.be.

The current list of directives can be found [here](https://github.com/w3c/webappsec-permissions-policy/blob/main/features.md).
Some of these are:
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

You can add multiple policy options as an array or as a single string with space-separated options:

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

<details>
<summary>Basic policy</summary>

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

</details>

Let's say you're happy with allowing `geolocation` and `fullscreen` but also wanted to add `www.awesomesite.com` to gain access to this feature, then you can easily extend the class:

<details>
<summary>MyFeature policy</summary>

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
</details>

Don't forget to change the `policy` key in the `feature-policy` config file to the class name fo your policy (e.g. `App\Services\Policies\MyFeaturePolicy`).

## Testing

You can run all tests with:

```bash
$ composer test
```

## Changelog
Please see [CHANGELOG](https://github.com/mazedlx/laravel-feature-policy/blob/master/CHANGELOG.md) for more information what has changed recently.

## Contributing
Please see [CONTRIBUTING](https://github.com/mazedlx/laravel-feature-policy/blob/master/CONTRIBUTING.md) for details.

## Security
If you discover any security related issues please email mazedlx@gmail.com instead of using the issue tracker.

## Credits
This package is strongly inspired by [Spatie](https://spatie.be) [laravel-csp](https://github.com/spatie/laravel-csp) package.
Thanks to [Freek van der Herten](https://github.com/freekmurze) and [Thomas Verhelst](https://github.com/TVke) for creating such an awesome package and doing all the heavy lifting!

- [Freek van der Herten](https://github.com/freekmurze)
- [Thomas Verhelst](https://github.com/TVke)
- [All Contributors](https://github.com/mazedlx/laravel-feature-policy/contributors)

## Support
If you like this package please feel free to star it.

## License
The MIT License (MIT). Please see [LICENSE](https://github.com/mazedlx/laravel-feature-policy/blob/master/LICENSE.md) for more information.
