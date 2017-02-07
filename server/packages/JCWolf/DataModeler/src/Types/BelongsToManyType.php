<?php

namespace JCWolf\DataModeler\Types;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use JCWolf\DataModeler\Modeler;

class BelongsToManyType extends DataType
{
    protected $type = 'integer';

    protected $fillable = false;

    protected $relationType = 'belongsToMany';

    /**
     * @return string
     */
    public function getName() {
        return $this->name . '_id';
    }

    public function add( Blueprint $table ) {

        $mainModel = new Modeler( $this->getModel()->getName() );
        $subModel  = new Modeler( $this->properties['model'] );

        $modelsTable = [ Str::snake( $mainModel->getName() ), Str::snake( $subModel->getName() ) ];
        sort( $modelsTable );

        $pivotTableName = strtolower( implode( '_', $modelsTable ) );

        if ( Schema::hasTable( $pivotTableName ) )
            Schema::drop( $pivotTableName );

        // If the Model doesn't exists create a default one
        $relatedModel = $subModel->getName();
        if ( !Modeler::modelExists( $relatedModel ) ) {
            Modeler::createBasicModel( $relatedModel );
        }

        $mainModelColumn = strtolower( Str::snake( $mainModel->getName() ) );
        $subModelColumn  = strtolower( Str::snake( $subModel->getName() ) );

        Schema::create( $pivotTableName, function ( Blueprint $pivotTable ) use ( $mainModelColumn, $subModelColumn ) {

            $pivotTable->integer( $mainModelColumn . '_id' )->unsigned();
            $pivotTable->integer( $subModelColumn . '_id' )->unsigned();

        } );

        // Add the foreign keys constraints after the main model was created.
        // We need that table to be created first
        Modeler::after( function () use ( $pivotTableName, $mainModel, $subModel, $mainModelColumn, $subModelColumn ) {

            Schema::table( $pivotTableName, function ( Blueprint $pivotTable ) use ( $mainModel, $subModel, $mainModelColumn, $subModelColumn ) {

                $pivotTable->foreign( $mainModelColumn . '_id' )
                    ->references( 'id' )->on( $mainModel->getTable() )
                    ->onDelete( 'cascade' );

                $pivotTable->foreign( $subModelColumn . '_id' )
                    ->references( 'id' )->on( $subModel->getTable() )
                    ->onDelete( 'cascade' );
            } );

        } );

    }


    public function getRelation( $model ) {
        $modelName = "App\\" . config( 'modeler.path' ) . "\\" . $this->properties['model'];

        return $model->{$this->relationType}( $modelName );
    }

    public function getValue() {

        return $this->getModel()->{$this->name}()->get();
    }


    public function remove() {

        $mainModel   = new Modeler( $this->getModel()->getModelName() );
        $subModel    = new Modeler( $this->properties['model'] );
        $modelsTable = [ Str::snake( $mainModel->getName() ), Str::snake( $subModel->getName() ) ];
        sort( $modelsTable );

        $pivotTableName = strtolower( implode( '_', $modelsTable ) );

        // remove the pivot table if one of the tables is dropped
        if ( Schema::hasTable( $pivotTableName ) ) {
            Schema::drop( $pivotTableName );
        }
    }
}
