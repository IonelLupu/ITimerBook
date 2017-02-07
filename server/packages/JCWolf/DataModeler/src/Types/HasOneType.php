<?php

namespace JCWolf\DataModeler\Types;


use Illuminate\Database\Schema\Blueprint;
use JCWolf\DataModeler\Modeler;
use JCWolf\DataModeler\ModelSchema;

class HasOneType extends DataType
{
    protected $type = 'integer';

    protected $relationType = 'hasOne';

    protected $fillable = false;

    public function add( Blueprint $table ) {

        // After creating the model that has the `HasOne` field
        // we need to update the child model by adding the
        // the inverse relationship.

        $childModel = $this->properties['model'];
        $child      = ModelSchema::get( $childModel );

        $childSchema = $child->schema;

        $childSchema[ strtolower( $this->model->getName() ) ] = [
            "type"  => "BelongsTo",
            "model" => $this->model->getName(),
        ];

        Modeler::after( function () use ( $childModel, $childSchema ) {

            Modeler::updateModel( $childModel, $childSchema );

        } );

        return;
    }

    public function getRelation( $model ) {
        $modelName = "App\\" . config( 'modeler.path' ) . "\\" . $this->properties['model'];

        return $model->{$this->relationType}( $modelName );
    }

    public function getValue() {

        return $this->getModel()->{$this->name}()->first();
    }

}
