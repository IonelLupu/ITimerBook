<?php

namespace JCWolf\Autoform\InputTypes;


use Illuminate\Http\Request;

class BooleanInput extends Input
{
    public $template = 'inputs.Boolean';

    public function save( $value, Request $request ) {
        $this->model[ $this->column ] = $value != NULL ? 1 : 0;
    }

    public function view() {

        $value = $this->value ? "True" : "False";
        $class = $this->value ? "green" : "red";

        return "<span><small class='label bg-{$class}'>" . $value . "</small></span>";
    }
}