<?php

namespace JCWolf\Autoform\InputTypes;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JCWolf\Autoform\InputContract;
use JCWolf\DataModeler\Model;
use JCWolf\DataModeler\Types\DataType;

class Input implements InputContract
{
    protected $template = 'inputs.Input';

    public $value;

    public $properties = [
        "nullable" => false,
        "default"  => NULL,
        'form'     => [
            "visible" => true
        ],
        'table'    => [
            "visible" => true,
            "label"   => ""
        ]
    ];

    public $name;
    public $label;

    /**
     * @var Model
     */
    protected $model;

    public function __construct( $name, $properties = [ ], $value = NULL, Model $model = NULL ) {

        $this->name = $name;
//        $this->properties = array_replace( $this->properties, $properties );
        $this->properties = array_replace_recursive( $this->properties, $properties );
        $this->value      = $value;
        $this->model      = $model;

        $this->label = isset( $properties['label'] ) ? $properties['label'] : ucfirst( $name );

    }

    public function isVisible() {

        return $this->properties['form']['visible'];
    }

    public function render() {

//        if( isset($this->properties['visible']) && in_array($this->properties['visible'],[false,"false"]))
//            return '';

        return view( 'Autoform::' . $this->template, [
            'input' => $this
        ] );
    }

    public function view() {
        return $this->value;
    }

    /**
     * @return DataType
     */
    public function getColumn() {

        $class = config( 'modeler.types' )[ $this->properties['type'] ];

        $column = new $class( $this->name, $this->properties, $this->model );

        return $column;
    }

    public function save( $value, Request $request ) {
        $this->model[ $this->column ] = $value;
    }

    public function afterSave( $value ) {
        $this->model[ $this->column ] = $value;
    }

    public function delete() {

    }

    public function getDefaultValue() {

        $default = $this->properties['default'];

        if ( $default[0] == '@' ) {
            $function = Str::substr( $default, 1 );

            return $function();
        }

        return [ ];

    }

    public function __get( $property ) {
        if ( $property == 'column' )
            return $this->getColumn()->getName();

        return $this->{$property};
    }

    public function __toString() {
        return (string)$this->render();
    }
}