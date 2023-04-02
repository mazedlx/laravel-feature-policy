<?php declare(strict_types=1);

namespace Mazedlx\FeaturePolicy;

interface DirectiveContract
{
    public function name(): string;

    public function rules(): array;

    public function addRule(string $rule): static;
}
