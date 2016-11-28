<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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

}
