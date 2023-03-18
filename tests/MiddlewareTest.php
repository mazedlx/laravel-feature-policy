<?php

namespace Mazedlx\FeaturePolicy\Tests;

use Symfony\Component\HttpFoundation\HeaderBag;

class MiddlewareTest extends TestCase
{
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
