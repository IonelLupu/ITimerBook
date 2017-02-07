<?php

namespace JCWolf\DataModeler\Types;

use Illuminate\Database\Schema\Blueprint;
use JCWolf\DataModeler\Model;
use JCWolf\DataModeler\Modeler;

class BelongsToType extends DataType
{
    protected $type = 'integer';

    protected $relationType = 'belongsTo';

    /**
     * @return string
     */
    public function getName() {
        return $this->name . '_id';
    }

    public function add( Blueprint $table ) {

        // If the Model doesn't exists create a default one
        $relatedModel = new Modeler($this->properties['model']);

        if ( !Modeler::modelExists( $relatedModel->getName() ) ) {
            Modeler::createBasicModel( $relatedModel->getName() );
        }

        $column = parent::add( $table );

        $column->unsigned();

        // TODO : By adding foreign constraints to the table you can't update the table model (duplicate constraint key)
        // Add table constraints
//        $table->foreign($this->getName())
//              ->references('id')
//              ->on($relatedModel->getTable());

        return $column;
    }

    public function getRelation( $model ) {

        $modelName = "App\\" . config( 'modeler.path' ) . "\\" . $this->properties['model'];
        return $model->{$this->relationType}( $modelName, $this->getName(),'id', $this->name );
    }


    public function getValue() {
        return $this->getModel()->{$this->name}()->first();
    }

    public function save() {

        $model = $this->getModel();

        // Check if it has the autoValue field set.
        if ( isset( $this->properties['autoValue'] ) ) {

            $model->{$this->getName()} = $this->getAutoValue();
        }

    }


    /**
     * @return Model
     */
    public function getRelatedModel() {

        $modelName = "App\\" . config( 'modeler.path' ) . "\\" . $this->properties['model'];

        return new $modelName;
    }
}
