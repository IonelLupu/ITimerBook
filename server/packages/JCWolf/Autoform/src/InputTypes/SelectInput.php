<?php

namespace JCWolf\Autoform\InputTypes;

use Illuminate\Support\Str;

class SelectInput extends Input
{
    public $template = 'inputs.Select';

    public function values() {

        $values = [];

        if ( isset( $this->properties['values'] ) )
            $values = $this->properties['values'];

        // If the values is a string that starts with an '@' sign
        // it means that we need to get the values from a model's method
        if ( $values[0] == '@' ) {
            $method = Str::substr( $values, 1 );

            return $this->model->{$method}();
        }

        // If the values attribute is an array then just return it
        $arrayValues = json_decode($values,true);

        if ( is_array( $arrayValues ) )
            return $arrayValues;


        return [];
    }

}