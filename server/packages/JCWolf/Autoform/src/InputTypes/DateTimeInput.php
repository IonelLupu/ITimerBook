<?php

namespace JCWolf\Autoform\InputTypes;


class DateTimeInput extends Input
{
    public $template = 'inputs.DateTime';

    public function view() {
        return $this->value;
    }
}