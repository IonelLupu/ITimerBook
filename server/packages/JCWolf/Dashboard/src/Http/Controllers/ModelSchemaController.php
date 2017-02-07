<?php

namespace JCWolf\Dashboard\Http\Controllers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use JCWolf\DataModeler\Modeler;
use JCWolf\DataModeler\ModelSchema;

class ModelSchemaController extends Controller
{

    public function __construct() {
        Route::model( 'model', ModelSchema::class );
    }

    public function index() {

        $models = ModelSchema::all();

        return view( 'Dashboard::models.index', [
            'models' => $models
        ] );
    }

    public function edit( ModelSchema $model ) {

        $inputTypes = config( 'autoform.inputs' );
        unset( $inputTypes['Input'] );

        return view( 'Dashboard::models.edit', [
            'model'      => $model,
            'inputTypes' => $inputTypes
        ] );
    }

    public function create() {

        return view( 'Dashboard::models.create' );

    }

    private function getModelSchema( Request $request ) {

        $fields = $request->get( 'name',[] );

        $properties = collect( $request->get( 'properties',[] ) );
        $properties = $properties->map( function ( $value ) {
            return json_decode( $value, JSON_OBJECT_AS_ARRAY );
        } )->toArray();

        return array_combine( $fields, $properties );
    }

    public function update( Request $request, ModelSchema $model ) {


        $newSchema = $this->getModelSchema( $request );

        Modeler::updateModel( $model->name, $newSchema );

        return back();
    }


    public function store( Request $request ) {

        $schema = $this->getModelSchema( $request );

        Modeler::createModel( $request->get( "model" ), $schema );

        return back();
    }

    public function destroy( ModelSchema $model ) {
        Modeler::removeModel($model->name);

        return back();
    }
}
