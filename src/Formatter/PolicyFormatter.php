<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Formatter;

use Stringable;
use Illuminate\Support\Collection;
use Mazedlx\FeaturePolicy\FeatureGroups\DirectiveContract;

final class PolicyFormatter implements FormatContract
{
    private readonly Collection $directives;

    public function __construct(array $directives)
    {
        $this->directives = collect($directives);
    }

    public function __toString(): string
    {
        return $this->directives
            ->map(function (DirectiveContract $directive) {
                $formattedRules = implode(' ', $directive->rules());

                if (count($directive->rules()) === 1) {
                    return "{$directive->name()}={$formattedRules}";
                }

                return "{$directive->name()}=({$formattedRules})";
            })
            ->implode(',');
    }
}
