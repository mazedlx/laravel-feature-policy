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
    final public const CAMERA = 'camera';
    final public const DOCUMENT_DOMAIN = 'document-domain';
    final public const ENCRYPTED_MEDIA = 'encrypted-media';
    final public const EXECUTION_WHILE_NOT_RENDERED = 'execution-while-not-rendered';
    final public const EXECUTION_WHILE_OUT_OF_VIEWPORT = 'execution-while-out-of-viewport';
    final public const FULLSCREEN = 'fullscreen';
    final public const GEOLOCATION = 'geolocation';
    final public const GYROSCOPE = 'gyroscope';
    final public const MAGNETOMETER = 'magnetometer';
    final public const MICROPHONE = 'microphone';
    final public const MIDI = 'midi';
    final public const PAYMENT = 'payment';
    final public const PICTURE_IN_PICTURE = 'picture-in-picture';
    final public const SPEAKER = 'speaker';
    final public const SYNC_XHR = 'sync-xhr';
    final public const USB = 'usb';
    final public const VR = 'vr';
    final public const WAKE_LOCK = 'wake-lock';
    final public const XR = 'vr';

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
