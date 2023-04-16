<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Formatter;

use Stringable;

interface FormatContract extends Stringable
{
    public function __toString(): string;
}
