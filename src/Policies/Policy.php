<?php

namespace Mazedlx\FeaturePolicy\Policies;

use Illuminate\Http\Request;
use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;
use Symfony\Component\HttpFoundation\Response;
use Mazedlx\FeaturePolicy\Exceptions\InvalidDirective;

abstract class Policy
{
    protected array $directives = [];

    abstract public function configure();

    public function addDirective(string $directive, ...$values): self
    {
        throw_if(! Directive::isValid($directive), InvalidDirective::notSupported($directive));

        $rules = collect(...$values)
            ->map(fn ($values) => array_filter(explode(' ', $values)))
            ->flatten()
            ->all();

        foreach ($rules as $rule) {
            $sanitizedValue = $this->isSpecialDirectiveValue($rule) ? $rule : "\"{$rule}\"";

            if (! in_array($sanitizedValue, $this->directives[$directive] ?? [], true)) {
                $this->directives[$directive][] = $sanitizedValue;
            }
        }

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

    public function __toString()
    {
        return collect($this->directives)
            ->map(function (array $values, string $directive) {
                $valueString = implode(' ', $values);

                return count($values) === 1
                    ? "{$directive}={$valueString}"
                    : "{$directive}=({$valueString})";
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
