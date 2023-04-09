<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\FeatureGroups;

use Mazedlx\FeaturePolicy\Directive;
use Mazedlx\FeaturePolicy\Exceptions\DisabledFeatureGroupException;
use Mazedlx\FeaturePolicy\Exceptions\UnsupportedPermissionException;

final class ProposedFeatureGroup implements FeatureGroupContract
{
    public const CLIPBOARD_READ = 'clipboard-read';
    public const CLIPBOARD_WRITE = 'clipboard-write';
    public const GAMEPAD = 'gamepad';
    public const SHARED_AUTOFILL = 'shared-autofill';
    public const SPEAKER_SELECTION = 'speaker-selection';

    public static function directive(string $directive): DirectiveContract
    {
        throw_unless(config('feature-policy.directives.proposal'), new DisabledFeatureGroupException($directive));

        return match ($directive) {
            self::CLIPBOARD_READ => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return ProposedFeatureGroup::CLIPBOARD_READ;
                }

                public function specificationName(): string
                {
                    return 'w3c/clipboard-apis#120';
                }

                public function specificationUrl(): string
                {
                    return 'https://github.com/w3c/clipboard-apis/pull/120';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 86';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            self::CLIPBOARD_WRITE => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return ProposedFeatureGroup::CLIPBOARD_WRITE;
                }

                public function specificationName(): string
                {
                    return 'w3c/clipboard-apis#120';
                }

                public function specificationUrl(): string
                {
                    return 'https://github.com/w3c/clipboard-apis/pull/120';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 86';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            self::GAMEPAD => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return ProposedFeatureGroup::GAMEPAD;
                }

                public function specificationName(): string
                {
                    return 'w3c/gamepad#112';
                }

                public function specificationUrl(): string
                {
                    return 'https://github.com/w3c/gamepad/pull/112';
                }

                public function browserSupport(): string
                {
                    return '';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            self::SHARED_AUTOFILL => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return ProposedFeatureGroup::SHARED_AUTOFILL;
                }

                public function specificationName(): string
                {
                    return 'https://github.com/schwering/shared-autofill';
                }

                public function specificationUrl(): string
                {
                    return 'https://github.com/schwering/shared-autofill';
                }

                public function browserSupport(): string
                {
                    return '';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            self::SPEAKER_SELECTION => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return ProposedFeatureGroup::SPEAKER_SELECTION;
                }

                public function specificationName(): string
                {
                    return 'w3c/mediacapture-output#96';
                }

                public function specificationUrl(): string
                {
                    return 'https://github.com/w3c/mediacapture-output/pull/96';
                }

                public function browserSupport(): string
                {
                    return '';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            default => throw new UnsupportedPermissionException($directive),
        };
    }
}
