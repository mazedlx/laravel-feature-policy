<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Exceptions;

use Exception;

final class DisabledFeatureGroupException extends Exception
{
    public function __construct(string $directive)
    {
        parent::__construct("The directive ($directive) is disabled.");
    }
}
