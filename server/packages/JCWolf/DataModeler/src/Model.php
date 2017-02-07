<?php

namespace JCWolf\DataModeler;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    protected $schema;

    public function __construct( $attributes = [ ] ) {

        $this->fillable( $this->getFillableColumns() );

        parent::__construct( $attributes );
    }

    /**
     * Save the model to the database.
     *
     * @param  array $options
     *
     * @return bool
     */
    public function save( array $options = [ ] ) {

        // Process every column's save method
        $columns = $this->getColumns();

        foreach ( $columns as $column )
            $column->save();

        parent::save( $options );
    }

    /**
     * Get a relationship.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function getRelationValue( $key ) {

        // If the attribute exists in the $schema of the model we will assume
        // it is also an relationship and call the method associated to it.
        if ( $this->hasField( $key ) ) {

            $properties = $this->getSchema()[ $key ];
            $column     = Modeler::makeColumn( $key, $properties, $this );

            return $column->getValue();
        }

        return parent::getRelationValue( $key );
    }

    /**
     * Overwriting this method so you can call a relationship
     * method from the schema
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call( $method, $args ) {

        $schema = static::getSchema();

        if ( $this->hasField( $method ) ) {
            $properties = $schema[ $method ];
            $column     = Modeler::makeColumn( $method, $properties, $this );

            return $column->getRelation( $this );
        }

        return parent::__call( $method, $args );
    }

    /**
     * Get the model's schema from database
     *
     * @return []
     */
    public function getSchema() {
        if ( is_null( $this->schema ) )
            $this->schema = ModelSchema::getSchemaForModel( $this );

        return $this->schema;
    }

    /**
     * Get the model's name (without the full namespace)
     *
     * @param bool $lowercase
     *
     * @return string
     */
    public function getModelName( $lowercase = false ) {

        $modelName = explode( '\\', class_basename( $this ) );
        $modelName = end( $modelName );

        if ( $lowercase )
            return strtolower( $modelName );

        return $modelName;
    }

    /**
     * Check if a column exists in the model's schema
     *
     * @param $key
     *
     * @return bool
     */
    private function hasField( $key ) {
        return isset( $this->getSchema()[ $key ] );
    }

    /**
     * Get model's columns objects
     *
     * @return array
     */
    public function getColumns() {

        $schema = $this->getSchema();

        $columns = [ ];
        foreach ( $schema as $field => $properties )
            $columns[] = Modeler::makeColumn( $field, $properties, $this );

        return $columns;
    }

    /**
     * Get model's fillable columns from schema
     *
     * @return array
     */
    private function getFillableColumns() {

        $columns = $this->getColumns();

        $fillableFields = [ ];
        foreach ( $columns as $column )
            if ( $column->isFillable() )
                $fillableFields[] = $column->getName();

        return $fillableFields;
    }
}
