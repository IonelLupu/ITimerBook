<?php

namespace JCWolf\Autoform\InputTypes;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use JCWolf\DataModeler\Model;

/**
 * @property mixed column
 */
class ManyToManyInput extends Input
{
    protected $template = 'inputs.ManyToMany';

    /**
     * @return BelongsToMany
     */
    public function relation() {

        $relation = $this->getColumn()->name;

        return $this->model->{$relation}();
    }

    public function save( $value, Request $request ) {

    }

    public function afterSave( $value ) {

        if( !is_array($value) )
            $value = [];

        $this->relation()->sync( $value );
    }

    public function values() {

        // Values for the select field are the rows selected
        // from the specified relation model
        $model = "App\\". config('modeler.path') ."\\" . $this->properties['model'];

        /** @var Model $instance */
        $instance = new $model;
        $values   = $instance->all();

        return $values;
    }

    public function isSelected( $item ) {

        foreach ( $this->value as $value ) {
            if( $item->id == $value->id )
                return 1;
        }

        return 0;
    }

    public function getOptionLabel( $option ) {

        $properties = $this->properties;

        $label = isset( $properties['label'] ) ? $properties['label'] : "name";

        if ( !isset( $option[ $label ] ) )
            throw new \Exception( "No label defined for " . $properties['model'] . "model." . $option );

        return $option[ $label ];
    }

    public function view(  ) {
        return implode(', ', $this->value->pluck('name')->toArray());
    }
}