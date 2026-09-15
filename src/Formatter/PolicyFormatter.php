<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Formatter;

use Stringable;
use Illuminate\Support\Collection;
use Mazedlx\FeaturePolicy\FeatureGroups\DirectiveContract;
use Mazedlx\FeaturePolicy\Value;

final class PolicyFormatter implements FormatContract
{
    private readonly Collection $directives;

    public function __construct(array $directives)
    {
        $this->directives = collect($directives);
    }

    public function __toString(): string
    {
        $policy = $this->directives
            ->map(function (DirectiveContract $directive) {
                $rules = $directive->rules();
                $formattedRules = implode(' ', $rules);

                // `*` and `()` are written bare; every other allowlist is an inner list
                // and must be parenthesised. See https://www.w3.org/TR/permissions-policy/
                if ($rules === [Value::ALL] || $rules === [Value::NONE]) {
                    return "{$directive->name()}={$formattedRules}";
                }

                return "{$directive->name()}=({$formattedRules})";
            })
            ->implode(',');

        if (config('feature-policy.reporting.enabled')) {
            $policy .= '; report-to=violation-reports';
        }

        return $policy;
    }

}
