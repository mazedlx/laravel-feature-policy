<?php

declare(strict_types=1);

/**
 * Compares this package's Directive/ProposedFeatureGroup constants against the
 * canonical W3C webappsec-permissions-policy registry and reports two kinds of drift:
 *
 *  - missing:  a Standardized or Retired registry entry has no matching package constant.
 *              (Proposed/Experimental tiers are intentionally excluded - this package does
 *              not aim for exhaustive proposal coverage, so flagging those would just be noise.)
 *  - stale:    a package directive is not flagged isDeprecated(), but no longer appears in
 *              the registry's Standardized, Proposed, or Experimental tables (i.e. it has
 *              been silently retired or dropped upstream without the package catching up).
 */

require __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Mazedlx\FeaturePolicy\Directive;
use Mazedlx\FeaturePolicy\FeatureGroups\DefaultFeatureGroup;
use Mazedlx\FeaturePolicy\FeatureGroups\ProposedFeatureGroup;

const REGISTRY_URL = 'https://raw.githubusercontent.com/w3c/webappsec-permissions-policy/main/features.md';

// ProposedFeatureGroup::directive() reads config('feature-policy.directives.proposal'), which
// needs a booted container. This script only introspects metadata, so force it enabled via the
// same env var the published config already supports, rather than duplicating its shape here.
putenv('FPH_PROPOSAL_ENABLED=true');

$container = new Container();
$container->instance('config', new Repository(['feature-policy' => require __DIR__ . '/../../config/feature-policy.php']));
Container::setInstance($container);

function fetch_registry(): string
{
    $content = file_get_contents(REGISTRY_URL);

    if ($content === false) {
        fwrite(STDERR, "Failed to fetch registry from " . REGISTRY_URL . "\n");
        exit(1);
    }

    return $content;
}

/**
 * @return array<string, list<string>> section heading => list of feature tokens
 */
function parse_registry(string $markdown): array
{
    $sections = [];
    $current = null;

    foreach (explode("\n", $markdown) as $line) {
        if (preg_match('/^## (.+)$/', $line, $headingMatch)) {
            $current = trim($headingMatch[1]);
            $sections[$current] = [];

            continue;
        }

        if ($current !== null && preg_match('/^\|\s*`([a-z0-9-]+)`/', $line, $rowMatch)) {
            $sections[$current][] = $rowMatch[1];
        }
    }

    return $sections;
}

/**
 * @return list<string> every distinct directive token the package currently defines
 */
function package_tokens(): array
{
    $directiveConstants = (new ReflectionClass(Directive::class))->getConstants();
    $proposedConstants = (new ReflectionClass(ProposedFeatureGroup::class))->getConstants();

    return array_values(array_unique([...$directiveConstants, ...$proposedConstants]));
}

function is_deprecated(string $token): bool
{
    foreach ([DefaultFeatureGroup::class, ProposedFeatureGroup::class] as $group) {
        try {
            return $group::directive($token)->isDeprecated();
        } catch (Throwable) {
            continue;
        }
    }

    return false;
}

$registry = parse_registry(fetch_registry());
$standardized = $registry['Standardized Features'] ?? [];
$proposed = $registry['Proposed Features'] ?? [];
$experimental = $registry['Experimental Features'] ?? [];
$retired = $registry['Retired Features'] ?? [];
$live = [...$standardized, ...$proposed, ...$experimental];

$package = package_tokens();

$missing = array_values(array_diff([...$standardized, ...$retired], $package));

$stale = array_values(array_filter(
    $package,
    static fn (string $token): bool => ! in_array($token, $live, true) && ! is_deprecated($token),
));

$hasDrift = $missing !== [] || $stale !== [];

if (! $hasDrift) {
    fwrite(STDOUT, "No directive drift detected.\n");
    exit(0);
}

$report = "## Directive registry drift detected\n\n";
$report .= "Automated check against the [W3C webappsec-permissions-policy registry](" . REGISTRY_URL . ").\n\n";

if ($missing !== []) {
    $report .= "### Missing from the package\n\n";
    $report .= "These Standardized or Retired registry entries have no matching `Directive` constant:\n\n";
    foreach ($missing as $token) {
        $report .= "- `{$token}`\n";
    }
    $report .= "\n";
}

if ($stale !== []) {
    $report .= "### Possibly stale in the package\n\n";
    $report .= "These directives are not flagged `isDeprecated()`, but no longer appear in the registry's Standardized, Proposed, or Experimental tables:\n\n";
    foreach ($stale as $token) {
        $report .= "- `{$token}`\n";
    }
    $report .= "\n";
}

$reportFile = getenv('GITHUB_OUTPUT');

if ($reportFile !== false) {
    $delimiter = 'DRIFT_REPORT_' . bin2hex(random_bytes(8));
    file_put_contents($reportFile, "has_drift=true\nreport<<{$delimiter}\n{$report}\n{$delimiter}\n", FILE_APPEND);
}

fwrite(STDOUT, $report);
exit(1);
