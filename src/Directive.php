<?php

namespace Mazedlx\FeaturePolicy;

use Mazedlx\FeaturePolicy\Directives\DefaultDirective;
use Mazedlx\FeaturePolicy\Exceptions\InvalidDirective;

abstract class Directive
{
    protected array $rules = [];

    public const ACCELEROMETER = 'accelerometer';
    public const AMBIENT_LIGHT_SENSOR = 'ambient-light-sensor';
    public const AUTOPLAY = 'autoplay';
    public const CAMERA = 'camera';
    public const DOCUMENT_DOMAIN = 'document-domain';
    public const ENCRYPTED_MEDIA = 'encrypted-media';
    public const EXECUTION_WHILE_NOT_RENDERED = 'execution-while-not-rendered';
    public const EXECUTION_WHILE_OUT_OF_VIEWPORT = 'execution-while-out-of-viewport';
    public const FULLSCREEN = 'fullscreen';
    public const GEOLOCATION = 'geolocation';
    public const GYROSCOPE = 'gyroscope';
    public const MAGNETOMETER = 'magnetometer';
    public const MICROPHONE = 'microphone';
    public const MIDI = 'midi';
    public const PAYMENT = 'payment';
    public const PICTURE_IN_PICTURE = 'picture-in-picture';
    public const SPEAKER = 'speaker';
    public const SYNC_XHR = 'sync-xhr';
    public const USB = 'usb';
    public const VR = 'vr';
    public const WAKE_LOCK = 'wake-lock';
    public const XR = 'vr';

    public static function make(string $directive, string $type = 'default'): DirectiveContract
    {
        return match ($type) {
            'default' => DefaultDirective::directive($directive),
            default => throw InvalidDirective::unknownDirectiveType($type),
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
}
