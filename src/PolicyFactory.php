<?php

namespace CodebarAg\FeaturePolicy;

use CodebarAg\FeaturePolicy\Exceptions\InvalidFeaturePolicy;
use CodebarAg\FeaturePolicy\Policies\Policy;

class PolicyFactory
{
    public static function create(string $className): Policy
    {
        $policy = app($className);

        if (! is_a($policy, Policy::class, true)) {
            throw InvalidFeaturePolicy::create($policy);
        }

        return $policy;
    }
}
