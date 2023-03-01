<?php

namespace CodebarAg\FeaturePolicy\Tests;

use CodebarAg\FeaturePolicy\FeaturePolicyServiceProvider;
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
