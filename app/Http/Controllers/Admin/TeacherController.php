<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Resources\TeacherResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class TeacherController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:4',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|min:10|numeric'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $teacher = new Teacher();
        $teacher->name = $request->name;
        $teacher->email = $request->email;
        $teacher->phone = $request->phone;
        $teacher->save();
        return $this->success(new TeacherResource($teacher),"❤️ ❤️ Successfully Created ❤️ ❤️");
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:10',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $teacher = Teacher::where('id',$id)->first();
        if($teacher){
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->phone = $request->phone;
            $teacher->update();
            return $this->success(new TeacherResource($teacher));
        }else{
            return $this->fail(['message' => 'Teacher not found',404]);
        }
    }
    public function index()
    {
        return $this->success(TeacherResource::collection(Teacher::all()),"❤️ ❤️ All Teacher ❤️ ❤️");
    }
    public function show($id)
    {
        try {
            Teacher::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Teacher not found!"],404);
        }
        $teacher = new TeacherResource(Teacher::where('id',$id)->first());
        return $this->success($teacher,"❤️ ❤️ ".$teacher->name." has found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $teacher = Teacher::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "Teacher not found!"],404);
        }
        $teacher->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
