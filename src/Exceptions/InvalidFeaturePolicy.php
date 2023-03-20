<?php

namespace Mazedlx\FeaturePolicy\Exceptions;

use Exception;
use Mazedlx\FeaturePolicy\Policies\Policy;

class InvalidFeaturePolicy extends Exception
{
    public static function create($class): self
    {
        $className = get_class($class);

        return new self("The Feature-Policy class '{$className}' is not valid. A valid policy extends " . Policy::class);
    }
}
