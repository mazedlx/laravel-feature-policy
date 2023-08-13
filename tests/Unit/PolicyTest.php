<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Tests\Unit;

use Illuminate\Http\Response;
use Mazedlx\FeaturePolicy\Directive;
use Mazedlx\FeaturePolicy\FeatureGroups\DeprecatedDirective;
use Mazedlx\FeaturePolicy\FeatureGroups\DirectiveContract;
use Mazedlx\FeaturePolicy\Policies\Policy;
use Mazedlx\FeaturePolicy\Tests\TestCase;
use Mazedlx\FeaturePolicy\Value;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class PolicyTest extends TestCase
{
    #[Test]
    public function it_can_format_the_directives(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, Value::NONE);
            }
        };
        config()->set('feature-policy.policy', $policy::class);
        $policy->configure();

        $this->assertSame('camera=()', (string) $policy);
    }

    #[Test]
    public function it_outputs_a_empty_string_without_directives(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                //
            }
        };
        config()->set('feature-policy.policy', $policy::class);
        $policy->configure();

        $this->assertEmpty((string) $policy);
    }

    #[Test]
    public function it_can_add_the_header_using_apply_to(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, Value::SELF);
            }
        };
        config()->set('feature-policy.policy', $policy::class);

        $response = new Response();

        $this->assertFalse($response->headers->has('Permissions-Policy'));

        $policy->applyTo($response);

        $this->assertTrue($response->headers->has('Permissions-Policy'));

        $this->assertSame('camera=(self)', $response->headers->get('Permissions-Policy'));
    }

    #[Test]
    public function it_can_add_a_directive_with_add_directive(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                //
            }
        };
        config()->set('feature-policy.policy', $policy::class);

        $this->assertEmpty((string) $policy);

        $policy->addDirective(Directive::CAMERA, Value::SELF);

        $this->assertSame('camera=(self)', (string) $policy);
    }

    public static function provide_directives(): \Generator
    {
        $directiveClass = new \ReflectionClass(Directive::class);
        $directives = array_unique(array_values($directiveClass->getConstants()));
        foreach ($directives as $directive) {
            yield $directive => [$directive];
        }
    }

    #[Test]
    #[DataProvider('provide_directives')]
    public function deprecated_directives_must_have_a_specification_url(string $directive): void
    {
        self::assertNotSame('', Directive::make($directive)->specificationUrl());
    }

    #[Test]
    public function it_can_add_the_deprecation_header_using_the_apply_deprecation_notice(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::SPEAKER, Value::NONE);
                $this->addDirective(Directive::DOCUMENT_DOMAIN, Value::ALL);
            }
        };
        config()->set('feature-policy.policy', $policy::class);

        $response = new Response();

        $policy->applyDeprecationNotice($response);

        $deprecationHeaders = $response->headers->all('Link');

        /** @var DirectiveContract&DeprecatedDirective $speaker */
        $speaker = Directive::make('speaker');
        /** @var DirectiveContract&DeprecatedDirective $documentDomain */
        $documentDomain = Directive::make('document-domain');
        $expectedDirectiveNotes = [
            sprintf(
                '<%s>; rel="deprecation"; feature="%s"; title="%s"; since="%s"',
                $speaker->specificationUrl(),
                $speaker->name(),
                $speaker->note(),
                $speaker->deprecatedSince()->format('Y-m-d'),
            ),
            sprintf(
                '<%s>; rel="deprecation"; feature="%s"; title="%s"; since="%s"',
                $documentDomain->specificationUrl(),
                $documentDomain->name(),
                $documentDomain->note(),
                $documentDomain->deprecatedSince()->format('Y-m-d'),
            ),
        ];
        $this->assertSame($expectedDirectiveNotes, $deprecationHeaders);
    }
}
