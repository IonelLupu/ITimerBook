<?php

namespace JCWolf\DataModeler\Types;

use Illuminate\Database\Schema\Blueprint;
use JCWolf\DataModeler\Helpers;
use JCWolf\DataModeler\Modeler;

abstract class DataType
{
    protected $type = 'string';

    public $name;

    public $properties = [
        'type'     => NULL,
        'optional' => false,
        'visible'  => true,
    ];

    public $columnProperties = [];

    protected $fillable = true;

    /**
     * @var Modeler
     */
    public $model;

    public function __construct( $name, $properties = [ ], $model = NULL ) {

        $this->name  = $name;
        $this->model = $model;

        $this->setProperties( $properties );
    }

    /**
     * @return mixed
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel( $model ) {
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function getProperties() {
        return $this->properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties( $properties = [ ] ) {

        $this->properties = array_replace_recursive( $this->properties, $properties );
//        $this->properties = array_merge( $this->properties, $properties );
    }

    /**
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param $type
     */
    public function setType( $type ) {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name ) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function isFillable() {
        return $this->fillable;
    }

    /**
     * Add the column with some properties to the table
     *
     * @param Blueprint $table
     *
     * @return \Illuminate\Support\Fluent
     */
    public function add( Blueprint $table ) {

        $columnSchema = $table->addColumn( $this->getType(), $this->getName(), $this->columnProperties );

        $columnSchema->nullable($this->properties['optional']);

        if ( isset( $this->properties['default'] ) )
            $columnSchema->default( $this->properties['default'] );

        return $columnSchema;
    }

    /**
     * What to do when removing the column. For example this
     * can be used to delete the images saved for a model.
     */
    public function remove() {

    }

    /**
     * This is used by the relationship types to get the column value.
     * For example for the `author`(saved as author_id in the DB) we
     * need to call the `author()` method on the model.
     */
    public function getValue() {

    }

    /**
     * The save method can be overwritten so a field can have
     * a custom save function
     */
    public function save() {

    }

    /**
     * Parses the autoValue property of the field
     *
     * @return string
     */
    public function getAutoValue() {

        $value = $this->properties['autoValue'];

        // If the first character is `>` it means that the value
        // is the returned value of a function
        if ( $value[0] == '>' ) {
            $function = substr( $value, 1 );

            return call_user_func( Helpers::class . '::' . $function );
        }

        return $value;
    }
}
