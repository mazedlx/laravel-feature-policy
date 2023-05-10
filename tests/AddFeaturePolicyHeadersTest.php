<?php

namespace Mazedlx\FeaturePolicy\Tests;

use PHPUnit\Framework\Attributes\Test;
use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;
use Illuminate\Support\Facades\Route;
use Mazedlx\FeaturePolicy\Policies\Policy;
use Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders;

final class AddFeaturePolicyHeadersTest extends TestCase
{
    #[Test]
    public function it_sets_the_default_feature_policy_headers(): void
    {
        $response = $this->get('test-route')
            ->assertSuccessful();

        $response->assertHeader('Permissions-Policy', 'geolocation=self,fullscreen=self');
    }

    #[Test]
    public function it_wont_set_headers_if_it_is_not_enabled_in_the_config(): void
    {
        config([
            'feature-policy.enabled' => false,
        ]);

        $this->get('test-route')->assertHeaderMissing('Permissions-Policy');
    }

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
    public function a_route_middleware_will_overwrite_a_global_middleware_for_a_given_route(): void
    {
        $this->withoutExceptionHandling();

        $customPolicy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::FULLSCREEN, 'custom-policy');
            }
        };

        Route::get('other-route', static fn () => 'ok')
            ->middleware(AddFeaturePolicyHeaders::class . ':' . $customPolicy::class);

        $this->get('other-route')
            ->assertHeader('Permissions-Policy', 'fullscreen="custom-policy"');
    }

    #[Test]
    public function it_can_enable_reporting_of_permission_violations(): void
    {
        config()->set('feature-policy.reporting.enabled', true);

        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, [Value::ALL]);
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $response = $this->get('test-route')->assertSuccessful();

        $response->assertHeader('Reporting-Endpoints', 'violation-reports="' . config('feature-policy.reporting.url') . '"');
        $response->assertHeader('Permissions-Policy', 'camera=*,report-to=violation-reports');

        $response->assertHeaderMissing('Permissions-Policy-Report-Only');
    }

    #[Test]
    public function it_can_enable_report_only_permission_violations(): void
    {
        config()->set('feature-policy.reporting.enabled', true);
        config()->set('feature-policy.reporting.report_only', true);

        $policy = new class extends Policy {
            public function configure(): void
            {
                $this->addDirective(Directive::CAMERA, [Value::ALL]);
            }
        };

        config()->set('feature-policy.policy', $policy::class);

        $response = $this->get('test-route')->assertSuccessful();

        $response->assertHeader('Reporting-Endpoints', 'violation-reports="' . config('feature-policy.reporting.url') . '"');
        $response->assertHeader('Permissions-Policy', 'camera=*,report-to=violation-reports');
        $response->assertHeader('Permissions-Policy-Report-Only', 'camera=*,report-to=violation-reports');

    }
}
