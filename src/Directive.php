<?php

namespace Mazedlx\FeaturePolicy;

use ReflectionClass;

abstract class Directive
{
    const ACCELEROMETER = 'accelerometer';
    const AMBIENT_LIGHT_SENSOR = 'ambient-light-sensor';
    const AUTOPLAY = 'autoplay';
    const CAMERA = 'camera';
    const ENCRYPTED_MEDIA = 'encrypted-media';
    const FULLSCREEN = 'fullscreen';
    const GEOLOCATION = 'geolocation';
    const GYROSCOPE = 'gyroscope';
    const MAGNETOMETER = 'magnetometer';
    const MICROPHONE = 'microphone';
    const MIDI = 'midi';
    const PAYMENT = 'payment';
    const PICTURE_IN_PICTURE = 'picture-in-picture';
    const SPEAKER = 'speaker';
    const USB = 'usb';
    const VR = 'vr';

    public static function isValid(string $directive): bool
    {
        $constants = (new ReflectionClass(static::class))->getConstants();

        return in_array($directive, $constants);
    }
}
