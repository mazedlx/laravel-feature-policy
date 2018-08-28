<?php

namespace Mazedlx\FeaturePolicy\Policies;

use Mazedlx\FeaturePolicy\Value;
use Mazedlx\FeaturePolicy\Directive;

class Basic extends Policy
{
    public function configure()
    {
        $this->addDirective(Directive::GEOLOCATION, Value::SELF)
            ->addDirective(Directive::MIDI, Value::SELF)
            ->addDirective(Directive::MICROPHONE, Value::SELF)
            ->addDirective(Directive::CAMERA, Value::SELF)
            ->addDirective(Directive::MAGNETOMETER, Value::SELF)
            ->addDirective(Directive::GYROSCOPE, Value::SELF)
            ->addDirective(Directive::SPEAKER, Value::SELF)
            ->addDirective(Directive::FULLSCREEN, Value::SELF)
            ->addDirective(Directive::PAYMENT, Value::SELF);
    }
}
