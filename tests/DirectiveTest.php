<?php

namespace Mazedlx\FeaturePolicy\Tests;

use PHPUnit\Framework\Attributes\Test;
use Mazedlx\FeaturePolicy\Directive;
use Mazedlx\FeaturePolicy\Exceptions\InvalidDirective;
use Mazedlx\FeaturePolicy\Value;

final class DirectiveTest extends TestCase
{
    #[Test]
    public function it_can_make_an_directive_from_name(): void
    {
        $directive = Directive::make(Directive::GEOLOCATION);

        $this->assertSame(Directive::GEOLOCATION, $directive->name());
        $this->assertIsArray($directive->rules());
        $this->assertEmpty($directive->rules());
    }

    #0Test]
    public function it_will_throw_an_invalid_directive_exception_for_unknown_directive(): void
    {
        $this->expectException(InvalidDirective::class);
        Directive::make('invalid-directive');
    }

    #[Test]
    public function it_can_add_an_rule(): void
    {
        $directive = Directive::make(Directive::GEOLOCATION);
        $this->assertEmpty($directive->rules());
        $directive->addRule(Value::SELF);
        $this->assertNotEmpty($directive->rules());
        $this->assertCount(1, $directive->rules());
        $this->assertSame(Value::SELF, $directive->rules()[0]);
    }
}
