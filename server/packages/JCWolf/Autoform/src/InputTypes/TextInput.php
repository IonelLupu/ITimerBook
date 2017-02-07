<?php

namespace JCWolf\Autoform\InputTypes;


class TextInput extends Input
{
    public $template = 'inputs.Text';

    public function view() {
        return str_limit($this->value,10);
    }
}