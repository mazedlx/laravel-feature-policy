# AGENTS.md

Shared project context for working in this repository.

## What this is

`mazedlx/laravel-feature-policy` is a standalone Laravel package (not an app) that adds a
`Permissions-Policy` HTTP response header (formerly "Feature-Policy") to Laravel responses via
middleware. Inspired by `spatie/laravel-csp`.

Note the naming mismatch: the package, config key, and middleware say "Feature-Policy", but the
header actually emitted is `Permissions-Policy` (the spec was renamed after coming out of draft).

## Commands

Commands below assume a `php` binary on your PATH — substitute your own local PHP setup
(Docker, Valet, DDEV, Herd, etc.) as needed; none of it is specific to one tool.

- Install dependencies: `composer install`
- Run tests: `vendor/bin/phpunit --no-progress --no-coverage`
- Single test: `vendor/bin/phpunit --no-progress --no-coverage --filter testMethodName`
- Coverage (HTML in `build/coverage`): `composer test-coverage`
- Static analysis (level 5): `vendor/bin/phpstan analyse --no-progress --error-format=raw`
- Rector (config in `rector.php`): `vendor/bin/rector process --no-progress-bar --output-format=github`
- Formatting: `php-cs-fixer fix --show-progress=none -q -n` — **php-cs-fixer is not a composer
  dependency**; it is run as a globally installed tool (as CI does). Config is `.php-cs-fixer.dist.php`
  (PSR-2 base + custom rules).

CI (`.github/workflows/`) runs tests and PHPStan across PHP 8.1–8.5, and auto-commits php-cs-fixer
and Rector changes back to the branch on push.

Always pass `--no-coverage` when running tests as an agent, regardless of whether a coverage
driver happens to be installed — coverage output isn't needed to verify a change and only adds
overhead. The flag is a hard requirement, not just a preference, for anyone *without* a coverage
driver (Xdebug/PCOV): `phpunit.xml.dist` configures `<coverage><report>` outputs, and PHPUnit 10+
treats a missing driver as fatal rather than a warning when any coverage report is configured,
aborting before any test runs ("No tests executed!", exit 1, no visible error) — some human
contributors do have a driver installed and won't hit this, but the flag is harmless either way.
CI already runs with `--no-coverage`, which is why this doesn't show up there.

## Code style

- PSR-12 as baseline
- `declare(strict_types=1)` in every file
- Classes default `final`, methods default `private`
- Always return types, including `void` and on closures
- Happy path last, avoid `else`, use early returns
- Space after `!` operator: `if (! $foo)`
- String interpolation over concatenation
- No docblocks when type hints are sufficient
- After a change: actively clean up code that's now redundant (old imports, dead
  functions/vars, replaced implementations) — no backwards-compatibility shims unless
  explicitly required by the package's own consumer-facing BC policy below

## Architecture

The request flow on every response:

1. **`AddFeaturePolicyHeaders`** (middleware, `src/`) runs *after* `$next($request)`. It resolves a
   policy (from the `:CustomPolicy` middleware parameter, else `config('feature-policy.policy')`)
   through **`PolicyFactory::create()`**, which container-resolves the class and validates it is a
   `Policy` (else throws `InvalidFeaturePolicy`). It then calls `shouldBeApplied()` and `applyTo()`.
2. **`Policies\Policy`** (abstract) holds the directives. Subclasses implement `configure()` and chain
   `addDirective(Directive::X, $values)`. `shouldBeApplied()` is gated by `config('feature-policy.enabled')`.
   `applyTo()` sets the `Permissions-Policy` header (skipping if one already exists) and, when
   `feature-policy.reporting.*` is enabled, also emits `Reporting-Endpoints` and
   `Permissions-Policy-Report-Only`.
3. **`Formatter\PolicyFormatter`** turns the directive collection into the header string via
   `Policy::__toString()`. One rule → `name=value`; multiple rules → `name=(v1 v2)`; joined by `,`.

### How directives are defined (the key structural detail)

`Directive` (abstract) is **only a registry of name constants** (`ACCELEROMETER`, `CAMERA`, …) plus
shared rule-list behavior. The actual directive *instances* live as **anonymous subclasses** returned
from a big `match` inside a **FeatureGroup**:

- `Directive::make($name, $type)` dispatches to `DefaultFeatureGroup::directive()` or
  `ProposedFeatureGroup::directive()`.
- **`DefaultFeatureGroup`** — the standard/shipped directives. Each `match` arm returns an anonymous
  `Directive` subclass carrying metadata (`name()`, `specificationName/Url()`, `browserSupport()`,
  and optionally `note()`). A deprecated directive additionally implements `DeprecatedDirective`
  (`deprecatedSince(): DateTimeImmutable`) instead of an `isDeprecated()` method.
- **`ProposedFeatureGroup`** — proposed/experimental directives, gated by
  `config('feature-policy.directives.proposal')`; throws `DisabledFeatureGroupException` when disabled.
- Unknown names throw `UnsupportedPermissionException`; unknown group types throw
  `UnknownPermissionGroupException`.

**To add a new directive:** add the constant to `src/Directive.php` *and* a matching arm in the
appropriate FeatureGroup's `match`. Adding the constant alone will throw at runtime.

**Never bake per-request policy state (`addRule()`) into a `FeatureGroup`'s factory entry.**
`Directive::make()` returns metadata that `Policy::addDirective()` then appends rules onto — a
pre-seeded rule combines with whatever a consumer configures instead of being replaced by it,
producing a malformed directive value. If a directive needs a safe default, it belongs in a
`Policy` subclass's own `configure()`, not the FeatureGroup factory.

### Value quoting

`Policy::addDirective()` space-splits values and wraps each in quotes **except** the special
`Value` tokens (`SELF`, `NONE`, `ALL` → `self`/`*`/`none`), which are emitted unquoted.

## Commit conventions

`CONTRIBUTING.md` already sets the baseline: coherent, squashed history per pull request, one PR
per feature, tests required, behavior changes documented. On top of that, observed convention in
this repo's actual history (`git log`): short, imperative-mood, one-line subjects (e.g. "Add 10
missing standardized directives", "Correct the wake-lock directive's deprecation note") — no
Conventional Commits type prefixes (`feat:`, `fix:`), a body only when the subject alone doesn't
explain the "why." Match this style rather than introducing a new one.

## Issues and pull requests

Do not create issues or pull requests unless explicitly directed, and even then only after a
separate, explicit approval for that specific issue/PR.

## Scope discipline

Make only the change that was actually asked for — nothing inferred as a "natural extension" of
it. A request to do X is not implicit approval for a related Y that seems like it would round X
out. If a related action seems worth doing, name it and ask, rather than doing it silently
alongside the requested change. The actions most likely to slip through unchecked are the ones
that feel like obvious housekeeping, not the ones that look risky — treat that feeling as a reason
to pause, not a reason to proceed.

(E.g.: "don't commit this file yet" is a statement about timing, not a request to also
git-ignore it.)

## Compatibility

Two distinct concerns, easy to conflate — read both.

### Supported versions

The package targets a very wide range — Laravel 7→13 and PHP 8.1/8.2 (`composer.json`), with CI
testing PHP 8.1–8.5. There is **no committed `composer.lock`**, so CI resolves to latest matching
versions. Keep new code working across this whole span; avoid APIs newer than the lowest supported
Laravel/PHP.

### Backward compatibility policy

This package has 200k+ installs. No change ships without checking its impact on existing
consumers first — a fix being "correct" doesn't make it safe to ship silently.

**Before proposing or implementing any change to public behavior** (constants, method
signatures, config keys, or anything emitted in an HTTP response — headers, exceptions,
config defaults):

1. **Classify it:**
   - *Safe now* — no consumer-visible change, or only fixes output that was already broken/unusable.
   - *Needs a version bump + changelog* — changes what gets emitted or how existing code
     must be written, but doesn't crash existing code outright.
   - *Breaking* — existing consumer code fails outright (fatal errors, removed
     constants/methods). Only ever ship behind a major version, with a migration note.

2. **Check both populations affected by the change** — those who use the feature in
   question, and those who don't — not just the population where the bug/change is obvious.
   A fix can be side-effect-free for 99% of consumers and still change real output for the
   remaining 1%; both need to be stated explicitly, not just the common case.

3. **Verify with the real test suite, not just reasoning.** Run
   `vendor/bin/phpunit --no-progress --no-coverage` after any change to public behavior —
   existing test failures are concrete evidence of consumer-visible impact, not just an
   inconvenience to fix. If a "bugfix" breaks existing tests that never touched the buggy
   code path, that's a sign the change has a bigger blast radius than intended, and the
   classification in step 1 needs to be revisited.

## Tests

PHPUnit via `orchestra/testbench`. `tests/TestCase.php` boots `FeaturePolicyServiceProvider` and
registers a `test-route` wrapped in the middleware, so feature tests assert directly on the response
headers.
