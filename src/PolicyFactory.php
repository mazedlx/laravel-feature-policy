<?php

namespace Mazedlx\FeaturePolicy;

use Mazedlx\FeaturePolicy\Policies\Policy;
use Mazedlx\FeaturePolicy\Exceptions\InvalidFeaturePolicy;

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
