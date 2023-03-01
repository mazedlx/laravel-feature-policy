<?php

namespace Mazedlx\FeaturePolicy\Tests;

use Mazedlx\FeaturePolicy\FeaturePolicyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            FeaturePolicyServiceProvider::class,
        ];
    }
}
