<?php

namespace Mazedlx\FeaturePolicy\Tests;

use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Mazedlx\FeaturePolicy\Policies\Basic;
use Mazedlx\FeaturePolicy\Policies\Policy;
use Symfony\Component\HttpFoundation\HeaderBag;
use Mazedlx\FeaturePolicy\AddFeaturePolicyHeaders;

class AddFeaturePolicyHeadersTest extends TestCase
{
    public function setUp()
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

        $this->assertContains("geolocation 'self'", $headers->get('Feature-Policy'));
    }

    protected function getResponseHeaders(string $url = 'test-route'): HeaderBag
    {
        return $this
            ->get($url)
            ->assertSuccessful()
            ->headers;
    }
}
