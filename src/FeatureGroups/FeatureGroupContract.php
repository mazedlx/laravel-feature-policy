<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\FeatureGroups;

interface FeatureGroupContract
{
    public static function directive(string $directive): DirectiveContract;
}
