<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\FeatureGroups;

use DateTimeImmutable;

interface DeprecatedDirective
{
    public function deprecatedSince(): DateTimeImmutable;
}
