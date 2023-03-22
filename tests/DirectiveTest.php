<?php

namespace Mazedlx\FeaturePolicy\Tests;

use Mazedlx\FeaturePolicy\Directive;

final class DirectiveTest extends TestCase
{
    /** @test */
    public function it_can_determine_if_a_directive_is_valid(): void
    {
        $this->assertTrue(Directive::isValid(Directive::GEOLOCATION));

        $this->assertFalse(Directive::isValid('invalid-directive'));
    }
}
