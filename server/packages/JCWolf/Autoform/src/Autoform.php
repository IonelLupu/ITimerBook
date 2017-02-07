<?php

namespace JCWolf\Autoform;

use Illuminate\Http\Request;
use JCWolf\Autoform\InputTypes\HasManyInput;
use JCWolf\DataModeler\Model;

class Autoform
{

    public function listModel( Model $model, $values = null ) {

        if( is_null($values) )
            $values = $model->all();

        return view( 'Autoform::model.list', [
            "model"  => $model,
            "values" => $values
        ] );
    }

    public function createForm( Model $model, $route = NULL ) {

        $inputs = $this->getInputs( $model );

        return view( 'Autoform::model.forms.createForm', [
            "route"  => $route,
            "model"  => $model,
            "inputs" => $inputs
        ] );
    }

    public function updateForm( Model $model, $route = NULL ) {

        $inputs = $this->getInputs( $model );

        return view( 'Autoform::model.forms.updateForm', [
            "route"  => $route,
            "model"  => $model,
            "inputs" => $inputs
        ] );
    }

    public function editForm( Model $model, $route = NULL ) {

        $inputs = $this->getInputs( $model );

        return view( 'Autoform::model.edit', [
            "route"  => $route,
            "model"  => $model,
            "inputs" => $inputs
        ] );
    }

    public function addForm( $modelName, $route = NULL ) {

        $model = new $modelName;

        $inputs = $this->getInputs( $model );

        return view( 'Autoform::model.add', [
            "route"  => $route,
            "model"  => $model,
            "inputs" => $inputs
        ] );
    }

    public function getInput( $fieldName, $properties, Model $model ) {

        $class = config( 'autoform.inputs.' . $properties['type'] );

        if ( is_null( $class ) )
            throw new \Exception( "Input '{$properties['type']}' not defined" );

        $instance = new $class( $fieldName, $properties, $model[ $fieldName ], $model );

        return $instance;
    }

    public function getInputs( Model $model ) {

        $inputs = [ ];

        $schema = $model->getSchema();
        foreach ( $schema as $field => $properties )
            $inputs[] = $this->getInput( $field, $properties, $model );

        return $inputs;
    }

    public function save( Model $model, Request $request ) {

        $schema = $model->getSchema();

        foreach ( $schema as $field => $properties ) {
            if ( $request->has( $field ) || $request->hasFile( $field ) ) {

                $input = $this->getInput( $field, $properties, $model );

                $input->save( $request->get( $field ), $request );
            }
        }

        $model->save();

        // Actions to do after the models was saved
        foreach ( $schema as $field => $properties ) {
            $input = $this->getInput( $field, $properties, $model );

            $input->afterSave( $request->get( $field ), $request );
        }

        return $model;
    }

    public function insert( Request $request ) {
        $model = $request->get( '_model' );

        $instance = new $model;

        return $this->save( $instance, $request );
    }

    public function delete( Model $model ) {

        $inputs = $this->getInputs( $model );
        foreach ( $inputs as $input ) {
            $input->delete();
        }

        $model->delete();
    }

    public function getRelationships( $model ) {

        $allRelationships = [
            HasManyInput::class
        ];

        $inputs = static::getInputs( $model );

        $relationships = [ ];

        foreach ( $inputs as $input ) {

            foreach ( $allRelationships as $relationship ) {
                if ( $input instanceof $relationship )
                    $relationships[] = $input;
            }
        }

        return $relationships;
    }

}