<?php

namespace JCWolf\Autoform\InputTypes;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use JCWolf\Autoform\RelationshipsContract;
use JCWolf\DataModeler\Model;

/**
 * @property mixed column
 */
class HasManyInput extends Input implements RelationshipsContract
{
    protected $template = 'inputs.HasMany';

    public function __construct( $name, $properties = [ ], $value = NULL, Model $model = NULL ) {

        $properties['form']['visible'] = false;

        parent::__construct( $name, $properties,$value,$model);

    }

    /**
     * @return HasMany
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

//        $this->relation()->delete();
//        $this->relation()->save($value);
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
            throw new \Exception( "No label defined for " . $properties['model'] . " model." . $option );

        return $option[ $label ];
    }

    public function getRelatedModel(  ) {

        return $this->getColumn()->getRelatedModel();
    }

    public function view(  ) {
        return implode(', ', $this->value->pluck('name')->toArray());
    }
}