<?php

return [
    /*
     * A policy will determine which Feature-Policy headers will be set.
     * A valid policy extends `CodebarAg\FeaturePolicy\Policies\Policy`
     */
    'policy' => CodebarAg\FeaturePolicy\Policies\Basic::class,

    /*
     * Feature-policy headers will only be added if this is set to true
     */
    'enabled' => env('FPH_ENABLED', true),
];
