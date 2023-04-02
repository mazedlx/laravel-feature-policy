<?php

namespace Mazedlx\FeaturePolicy\Tests;

use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;
use Illuminate\Support\Facades\Route;
use Mazedlx\FeaturePolicy\Policies\Policy;
use Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders;
use Mazedlx\FeaturePolicy\Exceptions\InvalidFeaturePolicy;

class AddFeaturePolicyHeadersTest extends TestCase
{
    /** @test */
    public function it_sets_the_default_feature_policy_headers(): void
    {
        $permissionPolicyHeader = $this->get('test-route')
            ->assertSuccessful()
            ->headers
            ->get('Permissions-Policy');

        $this->assertStringContainsString('geolocation=self', $permissionPolicyHeader);
    }

    /** @test */
    public function it_wont_set_headers_if_it_is_not_enabled_in_the_config(): void
    {
        config([
            'feature-policy.enabled' => false,
        ]);

        $this->get('test-route')->assertHeaderMissing('Permissions-Policy');
    }

    /** @test */
    public function it_throws_an_invalid_policy_class_exception_when_using_an_invalid_policy(): void
    {
        $this->withoutExceptionHandling();

        config(['feature-policy.policy' => self::class]);

        $this->expectException(InvalidFeaturePolicy::class);

        $this->get('test-route')->assertOk();
    }

    /** @test */
    public function it_accepts_multiple_values_for_the_same_directive(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, 'src-1')
                    ->addDirective(Directive::CAMERA, 'src-2')
                    ->addDirective(Directive::FULLSCREEN, 'src-3')
                    ->addDirective(Directive::FULLSCREEN, 'src-4');
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $this->get('test-route')
            ->assertHeader('Permissions-Policy', 'camera=("src-1" "src-2"),fullscreen=("src-3" "src-4")');
    }

    /** @test */
    public function it_can_add_multiple_values_for_the_same_directive_in_one_go(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, ['src-1', 'src-2']);
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $this->get('test-route')
            ->assertHeader('Permissions-Policy', 'camera=("src-1" "src-2")');
    }

    /** @test */
    public function it_doesnt_quotes_special_directive_values(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, [Value::SELF]);
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $this->get('test-route')
            ->assertHeader('Permissions-Policy', 'camera=self');
    }

    /** @test */
    public function it_can_add_values_from_a_space_separated_string(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, 'src-1 ' . Value::SELF . ' src-2');
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $this->get('test-route')
            ->assertHeader('Permissions-Policy', 'camera=("src-1" self "src-2")');
    }

    /** @test */
    public function it_will_not_add_duplicate_values(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, [Value::SELF, Value::SELF]);
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $this->get('test-route')
            ->assertHeader('Permissions-Policy', 'camera=self');
    }

    /** @test */
    public function it_will_render_none_value(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, [Value::NONE]);
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $this->get('test-route')
            ->assertHeader('Permissions-Policy', 'camera=()');
    }

    /** @test */
    public function it_will_render_all_value(): void
    {
        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, [Value::ALL]);
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $this->get('test-route')
            ->assertHeader('Permissions-Policy', 'camera=*');
    }

    /** @test */
    public function a_route_middleware_will_overwrite_a_global_middleware_for_a_given_route(): void
    {
        $this->withoutExceptionHandling();

        $customPolicy = new class extends Policy {
            public function configure()
            {
                $this->addDirective(Directive::FULLSCREEN, 'custom-policy');
            }
        };

        Route::get('other-route', static fn () => 'ok')
            ->middleware(AddFeaturePolicyHeaders::class . ':' . get_class($customPolicy));

        $this->get('other-route')
            ->assertHeader('Permissions-Policy', 'fullscreen="custom-policy"');
    }
}
