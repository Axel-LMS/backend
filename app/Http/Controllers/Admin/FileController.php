<?php

namespace App\Http\Controllers\Admin;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class FileController extends BaseController
{
    public function index()
    {
        return $this->response(File::all(),[],200);
    }
    public function  show($file)
    {
        $file =  File::where('id', $file)->first();
        return $this->response("File", $file->file);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "file" => 'required|image'
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $filename = time() . "_" . $request->file('file')->getClientOriginalName();
        $photo = request()->file('file')->storeAs('photos', $filename);
        $file = new File();
        $file->file = $photo;
        $file->save();
        return $this->response($file, []);
    }
}
