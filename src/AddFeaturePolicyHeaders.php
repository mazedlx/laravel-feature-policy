<?php

namespace Mazedlx\FeaturePolicy;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Mazedlx\FeaturePolicy\Policies\Policy;

final class AddFeaturePolicyHeaders
{
    public function handle(Request $request, Closure $next, $customPolicyClass = null)
    {
        $response = $next($request);

        $this->getPolicies($customPolicyClass)
            ->filter(fn (Policy $policy) => $policy->shouldBeApplied($request, $response))
            ->each(fn (Policy $policy) => $policy->applyTo($response));

        return $response;
    }

    protected function getPolicies(?string $customPolicyClass = null): Collection
    {
        $policies = collect();

        if ($customPolicyClass) {
            $policies->push(PolicyFactory::create($customPolicyClass));

            return $policies;
        }

        $policyClass = config('feature-policy.policy');

        if (! empty($policyClass)) {
            $policies->push(PolicyFactory::create($policyClass));
        }

        return $policies;
    }
}
