<?php

namespace Mazedlx\FeaturePolicy;

use Illuminate\Support\ServiceProvider;

class FeaturePolicyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole() && function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/../config/feature-policy.php' => config_path('feature-policy.php'),
            ], 'config');
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/feature-policy.php', 'feature-policy');
    }
}
