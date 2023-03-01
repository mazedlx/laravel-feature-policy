<?php

namespace CodebarAg\FeaturePolicy\Tests;

use CodebarAg\FeaturePolicy\FeaturePolicyServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

    }

    protected function getPackageProviders($app)
    {
        return [
            FeaturePolicyServiceProvider::class,
        ];
    }

}
