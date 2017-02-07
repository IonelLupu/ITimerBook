<?php

namespace JCWolf\DataModeler;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

use Illuminate\Support\Str;
use JCWolf\DataModeler\Types\BelongsToManyType;
use JCWolf\DataModeler\Types\BelongsToType;
use JCWolf\DataModeler\Types\ImageType;
use JCWolf\DataModeler\Types\TextType;
use JCWolf\DataModeler\Types\NumberType;
use JCWolf\DataModeler\Types\BooleanType;
use JCWolf\DataModeler\Types\StringType;
use JCWolf\DataModeler\Types\DateTimeType;
use JCWolf\DataModeler\Types\SelectType;

use JCWolf\DataModeler\Types\HasOneType;

class Modeler
{
    public $name;

    protected $schema;

    public static $afterCallbacks;

    /**
     * Modeler constructor.
     *
     * @param $name
     * @param $schema
     */
    public function __construct( $name, $schema = [ ] ) {

        if ( is_null( $name ) )
            throw new InvalidArgumentException( 'No model name provided' );

        $this->name   = $name;
        $this->schema = $schema;
    }

    /**
     * Get the model's name (without the full namespace)
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Get the model's name (without the full namespace)
     *
     * @return string
     */
    public function getModelName() {

        return $this->getName();
    }

    /**
     * @param mixed $name
     */
    public function setName( $name ) {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getSchema() {
        return $this->schema;
    }

    /**
     * @param array $schema
     */
    public function setSchema( $schema ) {
        $this->schema = $schema;
    }

    public function getTable() {
        return Str::snake( Str::plural( class_basename( $this->getName() ) ) );
    }

    public static function modelsDirectory() {
        return app_path( config( 'modeler.path' ) );
    }

    public function modelFile() {
        $modelsDir = static::modelsDirectory();

        return $modelsDir . "/{$this->name}.php";
    }

    public static function createModel( $name = NULL, $schema = [ ] ) {

        /**
         * If the schema is empty we will create a simple model and return
         */
        if ( count( $schema ) == 0 ) {
            return static::createBasicModel( $name );
        }

        $modeler = new static( $name, $schema );

        $table = $modeler->getTable();

        if ( Schema::hasTable( $table ) )
            throw new Exception( "Table {$table} for {$modeler->name} model already exists" );

        // **************************************************
        // Create the model's file
        // **************************************************
        $modelTemplate = '<?php' . PHP_EOL . PHP_EOL;
        $modelTemplate .= view( 'DataModeler::Model', [
            'path' => config( 'modeler.path' ),
            "name" => $name,
        ] )->render();

        $modelsDir = static::modelsDirectory();
        if ( !File::isDirectory( $modelsDir ) )
            File::makeDirectory( $modelsDir, 0777, true );

        $modelFile = $modeler->modelFile();

        if ( !File::exists( $modelFile ) )
            File::put( $modelFile, $modelTemplate );

        // **************************************************
        // Create the model's table
        // **************************************************
        static::$afterCallbacks = [ ];
        Schema::create( $table, function ( Blueprint $table ) use ( $schema, $modeler ) {

            $table->increments( 'id' );

            foreach ( $schema as $columnName => $columnProperties ) {
                $column = static::makeColumn( $columnName, $columnProperties, $modeler );
                $column->add( $table );
            }

            $table->timestamps();
        } );
        static::runAfterSchemaCreate();


        // *************************************************
        // Save the model's data to the models table
        // *************************************************
        if ( !Schema::hasTable( ( new ModelSchema )->getTable() ) ) {
            ModelSchema::createTable();
        }

        ModelSchema::create( [
            'name'   => $modeler->name,
            'schema' => $modeler->schema,
        ] );

        return $modeler;
    }

    public static function updateModel( $name = NULL, $schema = [ ] ) {

        if ( !static::modelExists( $name ) )
            throw new InvalidArgumentException( "The `{$name}` model does not exist" );

        $modeler = new static( $name, $schema );

        $modelSchema = ModelSchema::get( $name );
        $oldSchema   = $modelSchema->schema;
        $newSchema   = $modeler->schema;

        // Alter the table using the new schema
        static::$afterCallbacks = [ ];
        Schema::table( $modeler->getTable(), function ( Blueprint $table ) use ( $newSchema, $oldSchema, $modeler ) {

            $lastColumn = NULL;
            foreach ( $newSchema as $columnName => $columnProperties ) {

                $column       = static::makeColumn( $columnName, $columnProperties, $modeler );
                $columnSchema = $column->add( $table );

                /**
                 * A `$columnSchema` is present only when there is a column in the
                 * current table. In the case of columns that need pivot tables
                 * there is no `$columnSchema` returned.
                 */
                if ( !$columnSchema )
                    return;

                /**
                 * Reorder the columns in the table
                 */
                if ( $lastColumn )
                    $columnSchema->after( $lastColumn->getName() );

                $lastColumn = $column;

                // If the column is in the old schema we need to alter that column
                if ( isset( $oldSchema[ $columnName ] ) )
                    $columnSchema->change();

            }
        } );
        static::runAfterSchemaCreate();

        // Save the new schema in database
        $modelSchema->schema = $newSchema;
        $modelSchema->save();
    }

    public static function renameColumns( $model, $columns ) {

        $modeler = new static( $model );

        // Rename the columns if necessary
        Schema::table( $modeler->getTable(), function ( Blueprint $table ) use ( $columns ) {

            foreach ( $columns as $oldColumn => $newColumn ) {
                $table->renameColumn( $oldColumn, $newColumn );
            }
        } );
    }

    public static function makeColumn( $name, $properties, $model = NULL ) {

        $fieldTypes = config( 'modeler.types' );

        $type = $properties['type'];
        if ( !isset( $fieldTypes[ $type ] ) )
            throw new Exception( "`{$type}` type for `{$name}` field of `{$model->getModelName()}` model does not exist." );

        $className = $fieldTypes[ $type ];
        $column    = new $className( $name, $properties, $model );

        return $column;
    }

    public static function removeModel( $name ) {

        $model = ModelSchema::get( $name );
        if ( is_null( $model ) )
            return;

        $modeler = new static( $model->name, $model->schema );
        $modeler->remove();
    }

    public function remove() {

        $table       = static::getTable( $this->name );
        $modelSchema = ModelSchema::get( $this->name );

        $model = new static( $modelSchema->name, $modelSchema->schema );

        if ( Schema::hasTable( $table ) ) {
            foreach ( $this->schema as $columnName => $properties ) {
                $column = static::makeColumn( $columnName, $properties, $model );
                $column->remove();
            }

            Schema::drop( $table );
        }

        $modelFile = static::modelFile( $this->name );
        if ( File::exists( $modelFile ) )
            File::delete( $modelFile );

        ModelSchema::whereName( $this->name )->delete();
    }

    public static function createBasicModel( $relatedModel ) {
        static::createModel( $relatedModel, [
            'name' => [
                "type" => "String"
            ]
        ] );
    }

    public static function modelExists( $relatedModel ) {

        $model = new static( $relatedModel );

        return Schema::hasTable( $model->getTable() );
//        $modelSchema = ModelSchema::whereName( $relatedModel )->first();
//
//        return $modelSchema != NULL;
    }

    public static function after( callable $callable ) {
        static::$afterCallbacks[] = $callable;
    }

    public static function runAfterSchemaCreate() {
        foreach ( static::$afterCallbacks as $callable ) {
            $callable();
        }
    }

}
