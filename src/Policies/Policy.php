<?php

namespace Mazedlx\FeaturePolicy\Policies;

use Illuminate\Http\Request;
use Mazedlx\FeaturePolicy\FeatureGroups\DefaultFeatureGroup;
use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;
use Symfony\Component\HttpFoundation\Response;

abstract class Policy implements PolicyContract
{
    protected array $directives = [];

    abstract public function configure();

    public function addDirective(string $directive, $values, ?string $type = DefaultFeatureGroup::class): self
    {
        $currentDirective = Directive::make($directive, type: $type);

        collect($values)
            ->map(fn ($values) => array_filter(explode(' ', (string) $values)))
            ->flatten()
            ->map(fn (string $rule) => $this->isSpecialDirectiveValue($rule) ? $rule : "\"{$rule}\"")
            ->each(fn (string $rule) => $currentDirective->addRule($rule));

        $this->directives[$directive] = [
            ...$this->directives[$directive] ?? [],
            ...$currentDirective->rules(),
        ];

        return $this;
    }

    public function shouldBeApplied(Request $request, Response $response): bool
    {
        return config('feature-policy.enabled');
    }

    public function applyTo(Response $response): void
    {
        $this->configure();

        $headerName = 'Permissions-Policy';

        if ($response->headers->has($headerName)) {
            return;
        }

        $response->headers->set($headerName, (string) $this);
    }

    public function __toString(): string
    {
        return collect($this->directives)
            ->map(function (array $rules, string $directive) {
                $formattedRules = implode(' ', $rules);

                if (count($rules) === 1) {
                    return "{$directive}={$formattedRules}";
                }

                return "{$directive}=({$formattedRules})";
            })->implode(',');
    }

    protected function isSpecialDirectiveValue(string $value): bool
    {
        $specialDirectiveValues = [
            Value::NONE,
            Value::SELF,
            Value::ALL,
        ];

        return in_array($value, $specialDirectiveValues, true);
    }
}
