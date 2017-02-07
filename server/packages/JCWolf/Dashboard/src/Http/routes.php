<?php

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
|
| @description_here
|
 */

use JCWolf\DataModeler\Model;
use JCWolf\DataModeler\Modeler;

Route::get('','DashboardController@index')->name('dashboard');

Route::group( [
    'prefix' => "tools",
], function () {

    Route::resource('models','ModelSchemaController');

//    Route::get('models','ToolsController@getModels')->name('tools.models.browse');
//
//    Route::get('models/new','ToolsController@getNew')->name('tools.models.new');
//    Route::post('models/new','ToolsController@postAdd')->name('tools.models.add');
//
//    Route::get('models/{model}','ToolsController@getModel')->name('tools.models.add');
//    Route::patch('models/{model}','ToolsController@patchUpdate')->name('tools.models.add');
});
/*
|--------------------------------------------------------------------------
| Model BREAD
|--------------------------------------------------------------------------
|
| @description_here
|
 */
Route::group( [
    'prefix' => "model/{model}",
], function () {

    // Show all records for model
    Route::get('',"ModelController@browseModel")->name('model.browse');

    // Create a new record
    Route::get('new',"ModelController@newModel")->name('model.new');
    Route::post('new',"ModelController@addModel")->name('model.add');

    // Show a record
    Route::get('{id}',"ModelController@readModel")->name('model.read');

    // Edit a record
    Route::get('edit/{id}',"ModelController@editModel")->name('model.edit');
    Route::patch('edit/{id}',"ModelController@updateModel")->name('model.update');

    // Delete a record
    Route::get('delete/{id}',"ModelController@deleteModel")->name('model.delete');
    Route::delete('{id}',"ModelController@deleteModel")->name('model.remove');
} );

Route::get("test/{model}/{id}/{all}",function($model,$id , $relations){


    $class = "App\\Models\\" . ucfirst($model);

    $model = new $class;
    if ( !is_null( $id ) )
        $model = $model->findOrFail( $id );

    $relations = explode('/',$relations);

    foreach ($relations as $segment){
        if( is_numeric($segment) )
            continue;

        if( $model instanceof Model){
            $schema = $model->getSchema();

            $column = Modeler::makeColumn($segment,$schema[$segment],$model);
            dd($column->getValue());
        }

        $model = call_user_func([$model,$segment]);
    }

    return $model->get();
})->where("all",'.*');
