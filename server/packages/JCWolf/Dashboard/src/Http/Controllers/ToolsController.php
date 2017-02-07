<?php

namespace JCWolf\Dashboard\Http\Controllers;

use JCWolf\DataModeler\ModelSchema;

class ToolsController extends Controller
{

    public function getModels(  ) {

        $models = ModelSchema::all();
        return view('Dashboard::tools.models',[
            'models' => $models
        ]);
    }
}
