<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\Directives;

use Mazedlx\FeaturePolicy\Directive;
use Mazedlx\FeaturePolicy\DirectiveContract;
use Mazedlx\FeaturePolicy\Exceptions\InvalidDirective;

final class DefaultDirective
{
    public static function directive(string $directive): DirectiveContract
    {
        return match ($directive) {
            Directive::ACCELEROMETER => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::ACCELEROMETER;
                }
            },
            Directive::AMBIENT_LIGHT_SENSOR => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::AMBIENT_LIGHT_SENSOR;
                }
            },
            Directive::AUTOPLAY => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::AUTOPLAY;
                }
            },
            Directive::CAMERA => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::CAMERA;
                }
            },
            Directive::DOCUMENT_DOMAIN => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::DOCUMENT_DOMAIN;
                }
            },
            Directive::ENCRYPTED_MEDIA => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::ENCRYPTED_MEDIA;
                }
            },
            Directive::EXECUTION_WHILE_NOT_RENDERED => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::EXECUTION_WHILE_NOT_RENDERED;
                }
            },
            Directive::EXECUTION_WHILE_OUT_OF_VIEWPORT => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::EXECUTION_WHILE_OUT_OF_VIEWPORT;
                }
            },
            Directive::FULLSCREEN => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::FULLSCREEN;
                }
            },
            Directive::GEOLOCATION => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::GEOLOCATION;
                }
            },
            Directive::GYROSCOPE => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::GYROSCOPE;
                }
            },
            Directive::MAGNETOMETER => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::MAGNETOMETER;
                }
            },
            Directive::MICROPHONE => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::MICROPHONE;
                }
            },
            Directive::MIDI => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::MIDI;
                }
            },
            Directive::PAYMENT => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::PAYMENT;
                }
            },
            Directive::PICTURE_IN_PICTURE => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::PICTURE_IN_PICTURE;
                }
            },
            Directive::SPEAKER => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::SPEAKER;
                }
            },
            Directive::SYNC_XHR => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::SYNC_XHR;
                }
            },
            Directive::USB => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::USB;
                }
            },
            Directive::WAKE_LOCK => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return Directive::WAKE_LOCK;
                }
            },
            Directive::XR, Directive::VR => new class extends Directive implements DirectiveContract {
                public function name(): string
                {
                    return 'vr';
                }
            },
            default => throw InvalidDirective::notSupported($directive),
        };
    }
}
