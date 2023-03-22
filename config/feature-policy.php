<?php

return [
    // Feature-policy headers will only be added if this is set to true
    'enabled' => env('FPH_ENABLED', true),

    /*
     * A policy will determine which Feature-Policy headers will be set.
     * A valid policy extends `Mazedlx\FeaturePolicy\Policies\Policy`
     */
    'policy' => Mazedlx\FeaturePolicy\Policies\Basic::class,

    'directives' => [
        'proposal' => env('FPH_PROPOSAL_ENABLED', false),
        'experimental' => env('FPH_EXPERIMENTAL_ENABLED', false),
    ],
];
