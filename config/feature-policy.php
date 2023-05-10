<?php

return [
    'enabled' => env('FPH_ENABLED', true),

    /*
     * A policy will determine which Feature-Policy headers will be set.
     * A valid policy extends `Mazedlx\FeaturePolicy\Policies\Policy`
     */
    'policy' => Mazedlx\FeaturePolicy\Policies\Basic::class,

    /** @see https://github.com/w3c/webappsec-permissions-policy/blob/main/features.md */
    'directives' => [
        'proposal' => env('FPH_PROPOSAL_ENABLED', false),
        'experimental' => env('FPH_EXPERIMENTAL_ENABLED', false),
    ],

    'reporting' => [
        'enabled' => env('FPH_REPORTING_ENABLED', false),
        'report_only' => env('FPH_REPORT_ONLY', false),
        'url' => env('FPH_REPORTING_URL', 'https://reportingapi.tools/public/submit'),
    ],
];
