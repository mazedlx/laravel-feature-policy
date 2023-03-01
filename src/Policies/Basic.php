<?php

namespace CodebarAg\FeaturePolicy\Policies;

use CodebarAg\FeaturePolicy\Directive;
use CodebarAg\FeaturePolicy\Value;

class Basic extends Policy
{
    public function configure()
    {
        $this->addDirective(Directive::GEOLOCATION, Value::SELF)
            ->addDirective(Directive::FULLSCREEN, Value::SELF);
    }
}
