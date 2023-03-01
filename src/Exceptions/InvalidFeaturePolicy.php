<?php

namespace CodebarAg\FeaturePolicy\Exceptions;

use CodebarAg\FeaturePolicy\Policies\Policy;
use Exception;

class InvalidFeaturePolicy extends Exception
{
    public static function create($class): self
    {
        $className = get_class($class);

        return new self("The Feature-Policy class '{$className}' is nit valid. A valid policy extends ".Policy::class);
    }
}
