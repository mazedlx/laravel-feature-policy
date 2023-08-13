<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Policies;

use Illuminate\Http\Request;
use Mazedlx\FeaturePolicy\FeatureGroups\DefaultFeatureGroup;
use Mazedlx\FeaturePolicy\FeatureGroups\DeprecatedDirective;
use Mazedlx\FeaturePolicy\FeatureGroups\DirectiveContract;
use Mazedlx\FeaturePolicy\Formatter\PolicyFormatter;
use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;
use Symfony\Component\HttpFoundation\Response;

abstract class Policy implements PolicyContract
{
    protected array $directives = [];

    private array $rules = [];

    abstract public function configure();

    public function addDirective(string $directive, $values, ?string $type = DefaultFeatureGroup::class): self
    {
        $currentDirective = Directive::make($directive, type: $type);
        collect($this->rules[$directive] ??= [])
            ->each(fn (string $rule) => $currentDirective->addRule($rule));

        collect($values)
            ->map(fn ($values) => array_filter(explode(' ', (string) $values)))
            ->flatten()
            ->map(fn (string $rule) => $this->isSpecialDirectiveValue($rule) ? $rule : "\"{$rule}\"")
            ->each(fn (string $rule) => $currentDirective->addRule($rule))
            ->each(fn (string $rule) => $this->rules[$directive][] = $rule);

        $this->directives[$directive] = $currentDirective;

        return $this;
    }

    public function shouldBeApplied(Request $request, Response $response): bool
    {
        return config('feature-policy.enabled');
    }

    public function applyTo(Response $response): void
    {
        if (! $this->directives) {
            $this->configure();
        }

        $headerName = 'Permissions-Policy';

        if ($response->headers->has($headerName)) {
            return;
        }

        $response->headers->set($headerName, (string) $this);

        if (! config('feature-policy.reporting.enabled')) {
            return;
        }

        $response->headers->set('Reporting-Endpoints', 'violation-reports="' . config('feature-policy.reporting.url') . '"');

        if (! config('feature-policy.reporting.report_only')) {
            return;
        }

        $headerName = 'Permissions-Policy-Report-Only';

        if ($response->headers->has($headerName)) {
            return;
        }

        $response->headers->set($headerName, (string) $this);
    }

    public function applyDeprecationNotice(Response $response): void
    {
        if (! $this->directives) {
            $this->configure();
        }

        $deprecatedDirectives = collect($this->directives)
            ->filter(fn (DirectiveContract $directive) => $directive instanceof DeprecatedDirective);

        if ($deprecatedDirectives->isEmpty()) {
            return;
        }

        $deprecatedDirectives->each(function (DirectiveContract&DeprecatedDirective $directive) use ($response) {
            $response->headers->set(
                'Link',
                sprintf(
                    '<%s>; rel="deprecation"; feature="%s"; title="%s"; since="%s"',
                    $directive->specificationUrl(),
                    $directive->name(),
                    $directive->note(),
                    $directive->deprecatedSince()->format('Y-m-d'),
                ),
                replace: false
            );
        });
    }

    public function __toString(): string
    {
        return (string) new PolicyFormatter($this->directives);
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
