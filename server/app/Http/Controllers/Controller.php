<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __get($property)
    {
        if ($property == 'user')
            return Auth::user();
    }

    public function response($data)
    {
        return response()->json($data, 200);
    }

    public function error($data)
    {
        return response()->json($data, 401);
    }

    public function internalError($data)
    {
        return response()->json([
            "server" => [$data]
        ], 500);
    }

    public function getCategories()
    {
        return Category::all();
    }

}
