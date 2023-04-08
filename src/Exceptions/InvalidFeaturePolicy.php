<?php

namespace Mazedlx\FeaturePolicy\Exceptions;

use Exception;
use Mazedlx\FeaturePolicy\Policies\Policy;

final class InvalidFeaturePolicy extends Exception
{
    public static function create($class): self
    {
        $className = $class::class;

        return new self("The Feature-Policy class '{$className}' is not valid. A valid policy extends " . Policy::class);
    }
}
