<?php

namespace CodebarAg\FeaturePolicy\Tests;

use CodebarAg\FeaturePolicy\AddFeaturePolicyHeaders;
use CodebarAg\FeaturePolicy\Directive;
use CodebarAg\FeaturePolicy\Exceptions\InvalidFeaturePolicy;
use CodebarAg\FeaturePolicy\Policies\Policy;
use CodebarAg\FeaturePolicy\Value;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\HeaderBag;

class AddFeaturePolicyHeaderTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        app(Kernel::class)->pushMiddleware(AddFeaturePolicyHeaders::class);

        Route::get('test-route', function () {
            return 'ok';
        });
    }

    /** @test */
    public function it_sets_the_default_feature_policy_headers()
    {
        $headers = $this->getResponseHeaders();

        $this->assertStringContainsString('geolocation=self', $headers->get('Permissions-Policy'));
    }

    /** @test */
    public function it_wont_set_headers_if_it_is_not_enabled_in_the_config()
    {
        config([
            'feature-policy.enabled' => false,
        ]);

        $headers = $this->getResponseHeaders();

        $this->assertNull($headers->get('Permissions-Policy'));
    }

    /** @test */
    public function it_throws_an_invalid_policy_class_exception_when_using_an_invalid_policy()
    {
        $this->withoutExceptionHandling();

        $invalidPolicyClassName = get_class(new class
        {
        });

        config(['feature-policy.policy' => $invalidPolicyClassName]);

        $this->expectException(InvalidFeaturePolicy::class);

        $this->getResponseHeaders();
    }

    /** @test */
    public function it_accepts_multiple_values_for_the_same_directive()
    {
        $policy = new class extends Policy
        {
            public function configure()
            {
                $this->addDirective(Directive::CAMERA, 'src-1')
                    ->addDirective(Directive::CAMERA, 'src-2')
                    ->addDirective(Directive::FULLSCREEN, 'src-3')
                    ->addDirective(Directive::FULLSCREEN, 'src-4');
            }
        };

        config(['feature-policy.policy' => get_class($policy)]);

        $headers = $this->getResponseHeaders();

        $this->assertEquals(
            'camera=("src-1" "src-2"),fullscreen=("src-3" "src-4")',
            $headers->get('Permissions-Policy')
        );
    }

    /** @test */
    public function it_can_add_multiple_values_for_the_same_directive_in_one_go()
    {
        $policy = new class extends Policy
        {
            public function configure()
            {
                $this->addDirective(Directive::CAMERA, ['src-1', 'src-2']);
            }
        };

        config(['feature-policy.policy' => get_class($policy)]);

        $headers = $this->getResponseHeaders();

        $this->assertEquals(
            'camera=("src-1" "src-2")',
            $headers->get('Permissions-Policy')
        );
    }

    /** @test */
    public function it_doesnt_quotes_special_directive_values()
    {
        $policy = new class extends Policy
        {
            public function configure()
            {
                $this->addDirective(Directive::CAMERA, [Value::SELF]);
            }
        };

        config(['feature-policy.policy' => get_class($policy)]);

        $headers = $this->getResponseHeaders();

        $this->assertEquals(
            'camera=self',
            $headers->get('Permissions-Policy')
        );
    }

    /** @test */
    public function it_can_add_values_from_a_space_separated_string()
    {
        $policy = new class extends Policy
        {
            public function configure()
            {
                $this->addDirective(Directive::CAMERA, 'src-1 '.Value::SELF.' src-2');
            }
        };

        config(['feature-policy.policy' => get_class($policy)]);

        $headers = $this->getResponseHeaders();

        $this->assertEquals(
            'camera=("src-1" self "src-2")',
            $headers->get('Permissions-Policy')
        );
    }

    /** @test */
    public function it_will_not_add_duplicate_values()
    {
        $policy = new class extends Policy
        {
            public function configure()
            {
                $this->addDirective(Directive::CAMERA, [Value::SELF, Value::SELF]);
            }
        };

        config(['feature-policy.policy' => get_class($policy)]);

        $headers = $this->getResponseHeaders();

        $this->assertEquals(
            'camera=self',
            $headers->get('Permissions-Policy')
        );
    }

    /** @test */
    public function it_will_render_none_value()
    {
        $policy = new class extends Policy
        {
            public function configure()
            {
                $this->addDirective(Directive::CAMERA, [Value::NONE]);
            }
        };

        config(['feature-policy.policy' => get_class($policy)]);

        $headers = $this->getResponseHeaders();

        $this->assertEquals(
            'camera=()',
            $headers->get('Permissions-Policy')
        );
    }

    /** @test */
    public function it_will_render_all_value()
    {
        $policy = new class extends Policy
        {
            public function configure()
            {
                $this->addDirective(Directive::CAMERA, [Value::ALL]);
            }
        };

        config(['feature-policy.policy' => get_class($policy)]);

        $headers = $this->getResponseHeaders();

        $this->assertEquals(
            'camera=*',
            $headers->get('Permissions-Policy')
        );
    }

    /** @test */
    public function a_route_middleware_will_overwrite_a_global_middleware_for_a_given_route()
    {
        $this->withoutExceptionHandling();

        $customPolicy = new class extends Policy
        {
            public function configure()
            {
                $this->addDirective(Directive::FULLSCREEN, 'custom-policy');
            }
        };

        Route::get('other-route', function () {
            return 'ok';
        })->middleware(AddFeaturePolicyHeaders::class.':'.get_class($customPolicy));

        $headers = $this->getResponseHeaders('other-route');

        $this->assertEquals(
            'fullscreen="custom-policy"',
            $headers->get('Permissions-Policy')
        );
    }

    protected function getResponseHeaders(string $url = 'test-route'): HeaderBag
    {
        return $this->get($url)
            ->assertSuccessful()
            ->headers;
    }
}
