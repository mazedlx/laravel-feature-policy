<?php

namespace Mazedlx\FeaturePolicy\Exceptions;

use Exception;

class InvalidDirective extends Exception
{
    public static function notSupported(string $directive): self
    {
        return new self("The directive '${directive}' is not valid in a Feature-Policy header.");
    }

    public static function unknownDirectiveType(?string $type): self
    {
        return new self("The directive type '${type}' is unknown.");
    }
}
