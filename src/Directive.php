<?php

namespace Mazedlx\FeaturePolicy;

use Mazedlx\FeaturePolicy\Directives\DefaultDirective;
use Mazedlx\FeaturePolicy\Exceptions\UnknownPermissionGroupException;

abstract class Directive
{
    protected array $rules = [];

    final public const ACCELEROMETER = 'accelerometer';
    final public const AMBIENT_LIGHT_SENSOR = 'ambient-light-sensor';
    final public const AUTOPLAY = 'autoplay';
    final public const BATTERY = 'battery';
    final public const BLUETOOTH = 'bluetooth';
    final public const CAMERA = 'camera';
    final public const CH_UA = 'ch-ua';
    final public const CH_UA_ARCH = 'ch-ua-arch';
    final public const CH_UA_BITNESS = 'ch-ua-bitness';
    final public const CH_UA_FULL_VERSION = 'ch-ua-full-version';
    final public const CH_UA_FULL_VERSION_LIST = 'ch-ua-full-version-list';
    final public const CH_UA_MOBILE = 'ch-ua-mobile';
    final public const CH_UA_MODEL = 'ch-ua-model';
    final public const CH_UA_PLATFORM = 'ch-ua-platform';
    final public const CH_UA_PLATFORM_VERSION = 'ch-ua-platform-version';
    final public const CH_UA_WOW64 = 'ch-ua-wow64';
    final public const CROSS_ORIGIN_ISOLATED = 'cross-origin-isolated';
    final public const DISPLAY_CAPTURE = 'display-capture';

    /** @deprecated formerly in Chrome, behind a flag */
    final public const DOCUMENT_DOMAIN = 'document-domain';
    final public const ENCRYPTED_MEDIA = 'encrypted-media';
    final public const EXECUTION_WHILE_NOT_RENDERED = 'execution-while-not-rendered';
    final public const EXECUTION_WHILE_OUT_OF_VIEWPORT = 'execution-while-out-of-viewport';
    final public const FULLSCREEN = 'fullscreen';
    final public const GEOLOCATION = 'geolocation';
    final public const GYROSCOPE = 'gyroscope';
    final public const HID = 'hid';
    final public const IDLE_DETECTION = 'idle-detection';
    final public const KEYBOARD_MAP = 'keyboard-map';
    final public const MAGNETOMETER = 'magnetometer';
    final public const MICROPHONE = 'microphone';
    final public const MIDI = 'midi';
    final public const NAVIGATION_OVERRIDE = 'navigation-override';
    final public const PAYMENT = 'payment';
    final public const PICTURE_IN_PICTURE = 'picture-in-picture';
    final public const PUBLICKEY_CREDENTIALS_GET = 'publickey-credentials-get';
    final public const SCREEN_WAKE_LOCK = 'screen-wake-lock';
    final public const SERIAL = 'serial';
    /** @deprecated unknown directive */
    final public const SPEAKER = 'speaker';
    final public const SYNC_XHR = 'sync-xhr';
    final public const USB = 'usb';
    final public const VR = 'vr'; // after Chrome 79 replaced by xr-spatial-tracking
    /** @deprecated known as 'screen-wake-rock' */
    final public const WAKE_LOCK = 'wake-lock';
    final public const WEB_SHARE = 'web-share';
    /** @deprecated unknown directive */
    final public const XR = 'vr';
    /** @see Implemented in Chrome as vr prior to Chrome 79 */
    final public const XR_SPATIAL_TRACKING = 'xr-spatial-tracking';

    public static function make(string $directive, string $type = 'default'): DirectiveContract
    {
        return match ($type) {
            'default' => DefaultDirective::directive($directive),
            default => throw new UnknownPermissionGroupException($type),
        };
    }

    public function addRule(string $rule): static
    {
        if (in_array($rule, $this->rules, true)) {
            return $this;
        }

        $this->rules[] = $rule;

        return $this;
    }

    public function rules(): array
    {
        return $this->rules;
    }

    public function note(): string
    {
        return '';
    }

    public function isDeprecated(): bool
    {
        return false;
    }
}
