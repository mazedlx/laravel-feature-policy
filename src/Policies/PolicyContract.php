<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Policies;

use Stringable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface PolicyContract extends Stringable
{
    public function addDirective(string $directive, $values, ?string $type = 'default'): self;
    public function shouldBeApplied(Request $request, Response $response): bool;
    public function applyTo(Response $response): void;
}
