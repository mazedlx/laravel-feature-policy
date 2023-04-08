<?php

namespace Mazedlx\FeaturePolicy;

use Illuminate\Support\ServiceProvider;

final class FeaturePolicyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        if (! function_exists('config_path')) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/feature-policy.php' => config_path('feature-policy.php'),
        ], 'config');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/feature-policy.php', 'feature-policy');
    }
}
