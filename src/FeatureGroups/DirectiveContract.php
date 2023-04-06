<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\FeatureGroups;

interface DirectiveContract
{
    public function name(): string;

    public function rules(): array;

    public function addRule(string $rule): static;

    public function note(): string;

    public function isDeprecated(): bool;

    public function specificationName(): string;

    public function specificationUrl(): string;

    public function browserSupport(): string;

    public function browserSupportUrl(): string;
}
