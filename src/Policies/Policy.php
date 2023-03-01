<?php

namespace Mazedlx\FeaturePolicy\Policies;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;
use Symfony\Component\HttpFoundation\Response;
use Mazedlx\FeaturePolicy\Exceptions\InvalidDirective;

abstract class Policy
{
    protected $directives = [];

    abstract public function configure();

    public function addDirective(string $directive, $values): self
    {
        $this->guardAgainstInvalidDirective($directive);

        $rules = Arr::flatten(array_map(function ($values) {
            return array_filter(explode(' ', $values));
        }, Arr::wrap($values)));

        foreach ($rules as $rule) {
            $sanitizedValue = $this->sanitizeValue($rule);

            if (!in_array($sanitizedValue, $this->directives[$directive] ?? [])) {
                $this->directives[$directive][] = $sanitizedValue;
            }
        }

        return $this;
    }

    public function shouldBeApplied(Request $request, Response $response): bool
    {
        return config('feature-policy.enabled');
    }

    public function applyTo(Response $response)
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

    protected function guardAgainstInvalidDirective(string $directive)
    {
        if (!Directive::isValid($directive)) {
            throw InvalidDirective::notSupported($directive);
        }
    }

    protected function isSpecialDirectiveValue(string $value)
    {
        $specialDirectiveValues = [
            Value::NONE,
            Value::SELF,
            Value::ALL,
        ];

        return in_array($value, $specialDirectiveValues);
    }

    protected function sanitizeValue(string $value): string
    {
        if ($this->isSpecialDirectiveValue($value)) {
            return $value;
        }

        return "\"{$value}\"";
    }
}
