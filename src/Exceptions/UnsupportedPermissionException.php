<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Exceptions;

use Exception;

final class UnsupportedPermissionException extends Exception
{
    public function __construct(string $directive)
    {
        parent::__construct("The directive '${directive}' is not valid in a Feature-Policy header.");
    }
}
