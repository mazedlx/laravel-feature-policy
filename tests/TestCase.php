<?php

namespace Mazedlx\FeaturePolicy\Tests;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders;
use Orchestra\Testbench\TestCase as Orchestra;
use Mazedlx\FeaturePolicy\FeaturePolicyServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        app(Kernel::class)->pushMiddleware(AddFeaturePolicyHeaders::class);

        Route::get('test-route', static fn () => 'ok');
    }

    protected function getPackageProviders($app): array
    {
        return [
            FeaturePolicyServiceProvider::class,
        ];
    }
}
