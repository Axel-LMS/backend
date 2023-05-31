<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CoursePerCycle;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CoursePerCycleResource;

class CoursePerCycleController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'cycle_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }

        $course = Course::where('id' , $request->course_id)->first();
        if($course) {
            $coursePerCycle = new CoursePerCycle();
            $coursePerCycle->course_id = $request->course_id;
            $coursePerCycle->cycle_id = $request->cycle_id;
            $coursePerCycle->courseStartDate = $course->startDate;
            $coursePerCycle->courseEndDate = $course->endDate;
            $coursePerCycle->save();
            return $this->success( new CoursePerCycleResource($coursePerCycle),"❤️ ❤️ Successfully Created ❤️ ❤️");
        }else {
            return "Course Not Found!";
        }
    }
    public function index()
    {
        return $this->success(CoursePerCycleResource::collection(CoursePerCycle::all()),"❤️ ❤️ All CoursePerCycles ❤️ ❤️");
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'cycle_id' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $coursePerCycle = CoursePerCycle::where('id',$id)->first();
        if($coursePerCycle){
            $course = Course::where('id' , $request->course_id)->first();
            if($course) {
                $coursePerCycle->course_id = $request->course_id;
                $coursePerCycle->cycle_id = $request->cycle_id;
                $coursePerCycle->courseStartDate = $course->startDate;
                $coursePerCycle->courseEndDate = $course->endDate;
                $coursePerCycle->update();
                return $this->success( new CoursePerCycleResource($coursePerCycle),"❤️ ❤️ Successfully Updated ❤️ ❤️");
            }else {
                return "Course Not Found!";
            }
        }else{
            return $this->fail(['message' => 'CoursePerCycle not found',404]);
        }
    }
    public function show($id)
    {
        try {
             CoursePerCycle::where('id', $id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Course not found!"],404);
        }
        $CoursePerCycle = new CoursePerCycleResource(CoursePerCycle::where('id',$id)->first());
        return $this->success($CoursePerCycle,"❤️ ❤️ has found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $CoursePerCycle = CoursePerCycle::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "CoursePerCycle not found!"], 404);
        }
        $CoursePerCycle->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
