<?php

namespace JCWolf\Autoform\InputTypes;


use Illuminate\Http\Request;
use JCWolf\Autoform\RelationshipsContract;

class BelongsToInput extends SelectInput implements RelationshipsContract
{
    public $template = 'inputs.BelongsTo';

    public function values() {

        // Values for the select field are the rows selected
        // from the specified relation model
        $model = "App\\Models\\" . $this->properties['model'];

        $instance = new $model;
        $values   = $instance->all();

        return $values;
    }

    public function view(  ) {
        if(isset($this->value[$this->properties['label']]))
            return $this->value[$this->properties['label']];

        if( isset($this->value['name']) )
            return $this->value->name;

        return 'no_label_defined';
    }

    public function save( $value, Request $request ) {
        $this->model[ $this->column ] = $value;
    }

    public function getRelatedModel(  ) {

        return $this->getColumn()->getRelatedModel();
    }

}