<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function success($data, $message = '')
    {
        return $data->additional(['condition'=> true, 'message' => $message] );
    }
    public function response($data,$errors,$code = 200, $condition = true)
    {
        return response()->json([
            "data" => $data,
            "errors" => $errors,
            "condition" => $condition
        ],$code);
    }
    public function fail($errors = [], $code = 404)
    {
        return $this->response([],$errors,$code,false);
    }
}
