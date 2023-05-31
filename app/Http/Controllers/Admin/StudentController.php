<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class StudentController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|min:4',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|numeric|min:10',
            'birthday' => 'required|date'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->birthday = $request->birthday;
        $student->phone = $request->phone;
        $student->save();
        return $this->success(new StudentResource($student),"❤️ ❤️ Successfully Created ❤️ ❤️");
    }
    public function index()
    {
        return $this->success(StudentResource::collection(Student::all()),"❤️ ❤️ All Students ❤️ ❤️");
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'phone' => 'required|numeric|min:6',
            'birthday' => 'required|date'
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $student = Student::where('id',$id)->first();
        if($student){
            $student->name = $request->name;
            $student->email = $request->email;
            $student->birthday = $request->birthday;
            $student->phone = $request->phone;
            $student->update();
            return $this->success(new StudentResource($student));
        }else{
            return $this->fail(['message' => 'Student not found',404]);
        }
    }
    public function show($id)
    {
        try {
            Student::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Student not found!"],404);
        }
        $student = new StudentResource(Student::where('id',$id)->first());
        return $this->success($student,"❤️ ❤️ ".$student->name." has found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $student = Student::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "Student not found!"],404);
        }
        $student->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
