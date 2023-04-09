<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Exceptions;

use Exception;

final class UnknownPermissionGroupException extends Exception
{
    public function __construct(string $type)
    {
        parent::__construct("The directive type '${type}' is unknown.");
    }
}
