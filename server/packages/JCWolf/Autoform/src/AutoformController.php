<?php

namespace JCWolf\Autoform;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class AutoformController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $model;

    /**
     * @var Autoform
     */
    protected $autoform;

    public function __construct( Request $request ) {

        $this->autoform = app()->make( 'autoform' );

        $modeName = ucfirst( Route::current()->getParameter( 'model' ) );
        $modelId  = Route::current()->getParameter( 'id' );

        $class = "App\\Models\\" . $modeName;

        $this->model = new $class;
        if ( !is_null( $modelId ) )
            $this->model = $this->model->findOrFail( $modelId );
    }

    public function browseModel() {
        return $this->model->all();
    }

    public function readModel() {
        return $this->model;
    }

    public function newModel() {

//        return view( 'post.new', [ "model" => $this->model ] );
        return $this->autoform->addForm($this->model);
    }

    public function addModel() {
        return $this->model;
    }

    public function editModel() {

//        return view( 'post.new', [ "model" => $this->model ] );
        return $this->autoform->editForm($this->model);
    }

    public function updateModel() {
        return $this->model;
    }
}
