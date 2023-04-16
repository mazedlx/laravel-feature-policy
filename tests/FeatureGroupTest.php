<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Tests;

use Mazedlx\FeaturePolicy\Exceptions\DisabledFeatureGroupException;
use Mazedlx\FeaturePolicy\FeatureGroups\ProposedFeatureGroup;
use Mazedlx\FeaturePolicy\Policies\Policy;
use Mazedlx\FeaturePolicy\Value;
use PHPUnit\Framework\Attributes\Test;

final class FeatureGroupTest extends TestCase
{
    #[Test]
    public function it_will_throw_an_exception_for_a_disabled_feature_group(): void
    {
        $this->withoutExceptionHandling();

        $this->expectException(DisabledFeatureGroupException::class);
        $this->expectExceptionMessage('The directive (gamepad) is disabled.');

        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(ProposedFeatureGroup::GAMEPAD, [Value::ALL], ProposedFeatureGroup::class);
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $this->get('test-route')
            ->assertHeaderMissing('Permissions-Policy');
    }

    #[Test]
    public function it_will_render_an_enabled_feature_group(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(ProposedFeatureGroup::CLIPBOARD_READ, [Value::ALL], ProposedFeatureGroup::class);
            }
        };

        config()->set('feature-policy.policy', $policy::class);
        config()->set('feature-policy.directives.proposal', true);

        $this->get('test-route')
            ->assertHeader('Permissions-Policy');
    }
}
