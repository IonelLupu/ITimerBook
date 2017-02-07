<?php

namespace JCWolf\Dashboard\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use JCWolf\Autoform\AutoformFacade as Autoform;

class ModelController extends Controller
{

    protected $model;

    /**
     * @var Autoform
     */
    protected $autoform;

    public function __construct( Request $request ) {

        $this->autoform = app()->make( 'autoform' );

        if ( !is_null( Route::current() ) ) {

            $modeName = ucfirst( Route::current()->getParameter( 'model' ) );
            $modelId  = Route::current()->getParameter( 'id' );

            $class = "App\\Models\\" . $modeName;

            $this->model = new $class;
            if ( !is_null( $modelId ) )
                $this->model = $this->model->findOrFail( $modelId );
        }
    }

    public function browseModel() {

        return view( 'Dashboard::model.browse', [ "model" => $this->model ] );
    }

    public function readModel() {
        return $this->model;
    }

    public function newModel() {

        return view( 'Dashboard::model.new', [ "model" => $this->model ] );
    }

    public function addModel( Request $request ) {

        $model = Autoform::insert( $request );
        return redirect()->route( 'model.edit', [
            'model' => $model->getModelName(true),
            'id'    => $model->id,
        ] );
    }

    public function editModel() {

//        dd(Autoform::getRelationships($this->model));
//        dd(Autoform::getRelationships($this->model)[0]->getRelatedModel());
        return view( 'Dashboard::model.edit', [ "model" => $this->model ] );
    }

    public function updateModel( Request $request ) {

        Autoform::save( $this->model, $request );

        return redirect()->back();
    }

    public function deleteModel() {
        Autoform::delete( $this->model );

        return redirect()->back();
    }
}
