<?php

namespace CodebarAg\FeaturePolicy\Tests;

use CodebarAg\FeaturePolicy\AddFeaturePolicyHeaders;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\HeaderBag;

class AddFeaturePolicyHeadersTest extends TestCase
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

    protected function getResponseHeaders(string $url = 'test-route'): HeaderBag
    {
        return $this
            ->get($url)
            ->assertSuccessful()
            ->headers;
    }
}
