<?php

namespace Mazedlx\FeaturePolicy\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Mazedlx\FeaturePolicy\FeaturePolicyServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            FeaturePolicyServiceProvider::class,
        ];
    }
}