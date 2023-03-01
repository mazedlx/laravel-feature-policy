<?php

namespace CodebarAg\FeaturePolicy;

use ReflectionClass;

abstract class Directive
{
    const ACCELEROMETER = 'accelerometer';

    const AMBIENT_LIGHT_SENSOR = 'ambient-light-sensor';

    const AUTOPLAY = 'autoplay';

    const CAMERA = 'camera';

    const DOCUMENT_DOMAIN = 'document-domain';

    const ENCRYPTED_MEDIA = 'encrypted-media';

    const EXECUTION_WHILE_NOT_RENDERED = 'execution-while-not-rendered';

    const EXECUTION_WHILE_OUT_OF_VIEWPORT = 'execution-while-out-of-viewport';

    const FULLSCREEN = 'fullscreen';

    const GEOLOCATION = 'geolocation';

    const GYROSCOPE = 'gyroscope';

    const MAGNETOMETER = 'magnetometer';

    const MICROPHONE = 'microphone';

    const MIDI = 'midi';

    const PAYMENT = 'payment';

    const PICTURE_IN_PICTURE = 'picture-in-picture';

    const SPEAKER = 'speaker';

    const SYNC_XHR = 'sync-xhr';

    const USB = 'usb';

    const VR = 'vr';

    const WAKE_LOCK = 'wake-lock';

    const XR = 'vr';

    public static function isValid(string $directive): bool
    {
        $constants = (new ReflectionClass(static::class))->getConstants();

        return in_array($directive, $constants);
    }
}
