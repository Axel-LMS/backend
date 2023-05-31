<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\CoursePerCycle;
use App\Models\TeacherPerCourse;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TeacherPerCourseResource;

class TeacherPerCourseController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coursepercycle_id' => 'required',
            'teacher_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $coursepercycle =  CoursePerCycle::where('id',$request->coursepercycle_id)->first();
        if($coursepercycle){
            $teacherpercourse = new TeacherPerCourse();
            $teacherpercourse->course_id = $coursepercycle->course_id;
            $teacherpercourse->cycle_id = $coursepercycle->cycle_id;
            $teacherpercourse->teacher_id = $request->teacher_id;
            $teacherpercourse->save();
            return $this->success(new TeacherPerCourseResource($teacherpercourse),"❤️ ❤️ Successfully Created ❤️ ❤️");
        }else {
            return $this->fail(["message" => "Not found Coursepercycle"]);
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'coursepercycle_id' => 'required',
            'teacher_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $teacherpercourse = TeacherPerCourse::where('id',$id)->first();
        if($teacherpercourse){
            $coursepercycle = CoursePerCycle::where('id',$request->coursepercycle_id)->first();
            if($coursepercycle){
                $teacherpercourse->course_id = $coursepercycle->course_id;
                $teacherpercourse->cycle_id = $coursepercycle->cycle_id;
                $teacherpercourse->teacher_id = $request->teacher_id;
                $teacherpercourse->update();
                return $this->success(new TeacherPerCourseResource($teacherpercourse));
            }else{
                return $this->fail(["message" => "coursepercycle not found"],404);
            }
        }else{
            return $this->fail(['message' => 'Teacherpercourse not found',404]);
        }
    }
    public function index()
    {
        return $this->success(TeacherPerCourseResource::collection(TeacherPerCourse::all()),"All TeacherPerCourse");
    }
    public function show($id)
    {
        try {
            TeacherPerCourse::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Teacher not found!"],404);
        }
        $teacherpercourse = new TeacherPerCourseResource(TeacherPerCourse::where('id',$id)->first());
        return $this->success($teacherpercourse,"❤️ ❤️ has found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $teacherpercourse = TeacherPerCourse::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "Teacher not found!"],404);
        }
        $teacherpercourse->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
