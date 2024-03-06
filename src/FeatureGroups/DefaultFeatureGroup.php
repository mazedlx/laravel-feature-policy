<?php

declare(strict_types=1);

namespace Mazedlx\FeaturePolicy\FeatureGroups;

use Mazedlx\FeaturePolicy\Directive;
use Mazedlx\FeaturePolicy\Exceptions\UnsupportedPermissionException;

final class DefaultFeatureGroup implements FeatureGroupContract
{
    public static function directive(string $directive): DirectiveContract
    {
        return match ($directive) {
            Directive::ACCELEROMETER => new class extends Directive {
                public function name(): string
                {
                    return Directive::ACCELEROMETER;
                }

                public function specificationName(): string
                {
                    return 'Generic Sensor API';
                }

                public function specificationUrl(): string
                {
                    return 'https://www.w3.org/TR/generic-sensor/#feature-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 66';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5758486868656128';
                }
            },
            Directive::AMBIENT_LIGHT_SENSOR => new class extends Directive {
                public function name(): string
                {
                    return Directive::AMBIENT_LIGHT_SENSOR;
                }

                public function specificationName(): string
                {
                    return 'Generic Sensor API';
                }

                public function specificationUrl(): string
                {
                    return 'https://www.w3.org/TR/generic-sensor/#feature-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 66';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5758486868656128';
                }
            },
            Directive::AUTOPLAY => new class extends Directive {
                public function name(): string
                {
                    return Directive::AUTOPLAY;
                }

                public function specificationName(): string
                {
                    return 'HTML';
                }

                public function specificationUrl(): string
                {
                    return 'https://html.spec.whatwg.org/multipage/infrastructure.html#policy-controlled-features';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 64';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5100524789563392';
                }
            },
            Directive::BATTERY => new class extends Directive {
                public function name(): string
                {
                    return Directive::BATTERY;
                }

                public function specificationName(): string
                {
                    return 'Battery Status API';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/battery/#permissions-policy-integration';
                }

                public function browserSupport(): string
                {
                    return 'Chrome - Open';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://bugs.chromium.org/p/chromium/issues/detail?id=1007264';
                }
            },
            Directive::BLUETOOTH => new class extends Directive {
                public function name(): string
                {
                    return Directive::BLUETOOTH;
                }

                public function specificationName(): string
                {
                    return 'Web Bluetooth';
                }

                public function specificationUrl(): string
                {
                    return 'https://webbluetoothcg.github.io/web-bluetooth/#permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 104';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/6439287120723968';
                }
            },
            Directive::CAMERA => new class extends Directive {
                public function name(): string
                {
                    return Directive::CAMERA;
                }

                public function specificationName(): string
                {
                    return 'Media Capture';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/mediacapture-main/#permissions-policy-integration';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 64';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5023919287304192';
                }
            },
            Directive::CH_UA => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_ARCH => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_ARCH;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_BITNESS => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_BITNESS;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_FULL_VERSION => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_FULL_VERSION;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_FULL_VERSION_LIST => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_FULL_VERSION_LIST;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_MOBILE => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_MOBILE;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_MODEL => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_MODEL;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_PLATFORM => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_PLATFORM;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_PLATFORM_VERSION => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_PLATFORM_VERSION;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CH_UA_WOW64 => new class extends Directive {
                public function name(): string
                {
                    return Directive::CH_UA_WOW64;
                }

                public function specificationName(): string
                {
                    return 'User-Agent Client Hints';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/ua-client-hints/';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5995832180473856';
                }
            },
            Directive::CROSS_ORIGIN_ISOLATED => new class extends Directive {
                public function name(): string
                {
                    return Directive::CROSS_ORIGIN_ISOLATED;
                }

                public function specificationName(): string
                {
                    return 'HTML';
                }

                public function specificationUrl(): string
                {
                    return 'https://html.spec.whatwg.org/multipage/infrastructure.html#policy-controlled-features';
                }

                public function browserSupport(): string
                {
                    return 'Experimental in Chrome 85';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            Directive::DISPLAY_CAPTURE => new class extends Directive {
                public function name(): string
                {
                    return Directive::DISPLAY_CAPTURE;
                }

                public function specificationName(): string
                {
                    return 'Media Capture: Screen Share';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/mediacapture-screen-share/#permissions-policy-integration';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 94';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/5144822362931200';
                }
            },
            Directive::DOCUMENT_DOMAIN => new class extends Directive {
                public function name(): string
                {
                    return Directive::DOCUMENT_DOMAIN;
                }

                public function specificationName(): string
                {
                    return 'HTML';
                }

                public function specificationUrl(): string
                {
                    return 'https://html.spec.whatwg.org/multipage/infrastructure.html#policy-controlled-features';
                }

                public function browserSupport(): string
                {
                    return 'Formerly in Chrome, behind a flag';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }

                public function note(): string
                {
                    return 'Directive is retired';
                }

                public function isDeprecated(): bool
                {
                    return true;
                }
            },
            Directive::ENCRYPTED_MEDIA => new class extends Directive {
                public function name(): string
                {
                    return Directive::ENCRYPTED_MEDIA;
                }

                public function specificationName(): string
                {
                    return 'Encrypted Media Extensions';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/encrypted-media/#permissions-policy-integration';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 64';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5023919287304192';
                }
            },
            Directive::EXECUTION_WHILE_NOT_RENDERED => new class extends Directive {
                public function name(): string
                {
                    return Directive::EXECUTION_WHILE_NOT_RENDERED;
                }

                public function specificationName(): string
                {
                    return 'Page Lifecycle';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/page-lifecycle/#feature-policies';
                }

                public function browserSupport(): string
                {
                    return 'Behind a flag in Chrome';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }

                public function note(): string
                {
                    return 'To enable these, use the Chrome command line flag --enable-blink-features=ExperimentalProductivityFeatures.';
                }
            },
            Directive::EXECUTION_WHILE_OUT_OF_VIEWPORT => new class extends Directive {
                public function name(): string
                {
                    return Directive::EXECUTION_WHILE_OUT_OF_VIEWPORT;
                }

                public function specificationName(): string
                {
                    return 'Page Lifecycle';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/page-lifecycle/#feature-policies';
                }

                public function browserSupport(): string
                {
                    return 'Behind a flag in Chrome';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }

                public function note(): string
                {
                    return 'To enable these, use the Chrome command line flag --enable-blink-features=ExperimentalProductivityFeatures.';
                }
            },
            Directive::FULLSCREEN => new class extends Directive {
                public function name(): string
                {
                    return Directive::FULLSCREEN;
                }

                public function specificationName(): string
                {
                    return 'Fullscreen API';
                }

                public function specificationUrl(): string
                {
                    return 'https://fullscreen.spec.whatwg.org/#permissions-policy-integration';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 62';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5094837900541952';
                }
            },
            Directive::GEOLOCATION => new class extends Directive {
                public function name(): string
                {
                    return Directive::GEOLOCATION;
                }

                public function specificationName(): string
                {
                    return 'Geolocation API';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/geolocation-api/#permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 64';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5023919287304192';
                }
            },
            Directive::GYROSCOPE => new class extends Directive {
                public function name(): string
                {
                    return Directive::GYROSCOPE;
                }

                public function specificationName(): string
                {
                    return 'Generic Sensor API';
                }

                public function specificationUrl(): string
                {
                    return 'https://www.w3.org/TR/generic-sensor/#feature-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 66';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5758486868656128';
                }
            },
            Directive::HID => new class extends Directive {
                public function name(): string
                {
                    return Directive::HID;
                }

                public function specificationName(): string
                {
                    return '';
                }

                public function specificationUrl(): string
                {
                    return '';
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
            Directive::IDLE_DETECTION => new class extends Directive {
                public function name(): string
                {
                    return Directive::IDLE_DETECTION;
                }

                public function specificationName(): string
                {
                    return 'Idle Detection API';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/idle-detection/#api-permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 94';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://chromestatus.com/feature/4590256452009984';
                }
            },
            Directive::KEYBOARD_MAP => new class extends Directive {
                public function name(): string
                {
                    return Directive::KEYBOARD_MAP;
                }

                public function specificationName(): string
                {
                    return 'Keyboard API';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/keyboard-map/#permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 97';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5657965899022336';
                }
            },
            Directive::MAGNETOMETER => new class extends Directive {
                public function name(): string
                {
                    return Directive::MAGNETOMETER;
                }

                public function specificationName(): string
                {
                    return 'Generic Sensor API';
                }

                public function specificationUrl(): string
                {
                    return 'https://www.w3.org/TR/generic-sensor/#feature-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 66';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5758486868656128';
                }
            },
            Directive::MICROPHONE => new class extends Directive {
                public function name(): string
                {
                    return Directive::MICROPHONE;
                }

                public function specificationName(): string
                {
                    return 'Media Capture';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/mediacapture-main/#permissions-policy-integration';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 64';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5023919287304192';
                }
            },
            Directive::MIDI => new class extends Directive {
                public function name(): string
                {
                    return Directive::MIDI;
                }

                public function specificationName(): string
                {
                    return 'Web MIDI';
                }

                public function specificationUrl(): string
                {
                    return 'https://webaudio.github.io/web-midi-api/#permissions-policy-integration';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 64';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5023919287304192';
                }
            },
            Directive::NAVIGATION_OVERRIDE => new class extends Directive {
                public function name(): string
                {
                    return Directive::NAVIGATION_OVERRIDE;
                }

                public function specificationName(): string
                {
                    return 'CSS Spatial Navigation';
                }

                public function specificationUrl(): string
                {
                    return 'https://drafts.csswg.org/css-nav-1/#policy-feature';
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
            Directive::PAYMENT => new class extends Directive {
                public function name(): string
                {
                    return Directive::PAYMENT;
                }

                public function specificationName(): string
                {
                    return 'Payment Request API';
                }

                public function specificationUrl(): string
                {
                    return 'https://www.w3.org/TR/payment-request/#permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 60';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            Directive::PICTURE_IN_PICTURE => new class extends Directive {
                public function name(): string
                {
                    return Directive::PICTURE_IN_PICTURE;
                }

                public function specificationName(): string
                {
                    return 'Picture-in-Picture';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/picture-in-picture/#feature-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }

                public function note(): string
                {
                    return 'Shipped in Chrome';
                }
            },
            Directive::PUBLICKEY_CREDENTIALS_GET => new class extends Directive {
                public function name(): string
                {
                    return Directive::PUBLICKEY_CREDENTIALS_GET;
                }

                public function specificationName(): string
                {
                    return 'Web Authentication API';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/webauthn/#sctn-permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 84';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://bugs.chromium.org/p/chromium/issues/detail?id=993007';
                }
            },
            Directive::SCREEN_WAKE_LOCK => new class extends Directive {
                public function name(): string
                {
                    return Directive::SCREEN_WAKE_LOCK;
                }

                public function specificationName(): string
                {
                    return 'Wake Lock API';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/screen-wake-lock/#policy-control';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 84';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/4636879949398016';
                }
            },
            Directive::SERIAL => new class extends Directive {
                public function name(): string
                {
                    return Directive::SERIAL;
                }

                public function specificationName(): string
                {
                    return 'Web Serial API';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/serial/#permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 89';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            Directive::SPEAKER => new class extends Directive {
                public function name(): string
                {
                    return Directive::SPEAKER;
                }

                public function specificationName(): string
                {
                    return '';
                }

                public function specificationUrl(): string
                {
                    return '';
                }

                public function browserSupport(): string
                {
                    return '';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }

                public function note(): string
                {
                    return 'Unknown directive';
                }

                public function isDeprecated(): bool
                {
                    return true;
                }
            },
            Directive::SYNC_XHR => new class extends Directive {
                public function name(): string
                {
                    return Directive::SYNC_XHR;
                }

                public function specificationName(): string
                {
                    return 'XMLHttpRequest';
                }

                public function specificationUrl(): string
                {
                    return 'https://xhr.spec.whatwg.org/#feature-policy-integration';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 65';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://www.chromestatus.com/feature/5154875084111872';
                }
            },
            Directive::USB => new class extends Directive {
                public function name(): string
                {
                    return Directive::USB;
                }

                public function specificationName(): string
                {
                    return 'WebUSB';
                }

                public function specificationUrl(): string
                {
                    return 'https://wicg.github.io/webusb/#permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Chrome 60';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }
            },
            Directive::WAKE_LOCK => new class extends Directive {
                public function name(): string
                {
                    return Directive::WAKE_LOCK;
                }

                public function specificationName(): string
                {
                    return '';
                }

                public function specificationUrl(): string
                {
                    return '';
                }

                public function browserSupport(): string
                {
                    return '';
                }

                public function browserSupportUrl(): string
                {
                    return '';
                }

                public function note(): string
                {
                    return "Probably known as 'screen-wake-rock'";
                }

                public function isDeprecated(): bool
                {
                    return true;
                }
            },
            Directive::WEB_SHARE => new class extends Directive {
                public function name(): string
                {
                    return Directive::WEB_SHARE;
                }

                public function specificationName(): string
                {
                    return 'Web Share API';
                }

                public function specificationUrl(): string
                {
                    return 'https://w3c.github.io/web-share/#permissions-policy';
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
            Directive::XR_SPATIAL_TRACKING, Directive::XR, Directive::VR => new class extends Directive {
                public function name(): string
                {
                    return Directive::XR_SPATIAL_TRACKING;
                }

                public function specificationName(): string
                {
                    return 'WebXR Device API';
                }

                public function specificationUrl(): string
                {
                    return 'https://immersive-web.github.io/webxr/#permissions-policy';
                }

                public function browserSupport(): string
                {
                    return 'Available as a Chrome Origin Trial';
                }

                public function browserSupportUrl(): string
                {
                    return 'https://developers.chrome.com/origintrials/#/trials/active';
                }

                public function note(): string
                {
                    return 'Implemented in Chrome as vr prior to Chrome 79.';
                }
            },
            default => throw new UnsupportedPermissionException($directive),
        };
    }
}
