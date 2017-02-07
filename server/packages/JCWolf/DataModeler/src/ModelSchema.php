<?php

namespace JCWolf\DataModeler;

use Illuminate\Database\Eloquent\Model as Eloquent;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * The ModelSchema model
 *
 * @property integer        $id
 * @property string         $name
 * @property string         $schema
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class ModelSchema extends Eloquent
{
    protected $fillable = [ 'name', 'schema' ];

    public static function createTable() {

        Schema::create( 'model_schemas', function ( Blueprint $table ) {

            $table->increments( 'id' );
            $table->string( 'name' );
            $table->text( 'schema' );
            $table->timestamps();

        } );
    }

    public function getSchemaAttribute() {
        return json_decode( $this->attributes['schema'], true );
    }

    public function setSchemaAttribute( $schema ) {
        $this->attributes['schema'] = json_encode( $schema );
    }

    public static function getSchemaForModel( $class ) {
        $modelName   = explode( '\\', class_basename( $class ) );
        $modelSchema = static::whereName( end( $modelName ) )->first();

        return $modelSchema->schema;
    }

    /**
     * Get a model schema from database
     *
     * @param $model
     *
     * @return Eloquent
     */
    public static function get( $model ) {
        return static::where( 'name', $model )->first();
    }

    public static function instance( $model ) {

        $modelsPath = config( 'modeler.path' );

        $class = 'App\\' . $modelsPath . '\\' . $model;

        return new $class;
    }
}
