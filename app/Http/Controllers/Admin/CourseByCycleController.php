<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseByCycle;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CourseByCycleResource;

class CourseByCycleController extends BaseController
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
            $courseByCycle = new CourseByCycle();
            $courseByCycle->course_id = $request->course_id;
            $courseByCycle->cycle_id = $request->cycle_id;
            $courseByCycle->courseStartDate = $course->startDate;
            $courseByCycle->courseEndDate = $course->endDate;
            $courseByCycle->save();
            return $this->success( new CourseByCycleResource($courseByCycle),"❤️ ❤️ Successfully Created ❤️ ❤️");
        }else {
            return "Course Not Found!";
        }

    }
    public function index()
    {
        return $this->success(CourseByCycleResource::collection(CourseByCycle::all()),"❤️ ❤️ All CourseByCycles ❤️ ❤️");
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
        $courseByCycle = CourseByCycle::where('id',$id)->first();
        if($courseByCycle){
            $course = Course::where('id' , $request->course_id)->first();
            if($course) {
                $courseByCycle->course_id = $request->course_id;
                $courseByCycle->cycle_id = $request->cycle_id;
                $courseByCycle->courseStartDate = $course->startDate;
                $courseByCycle->courseEndDate = $course->endDate;
                // return $request->all();
                $courseByCycle->update();
                return $this->success( new CourseByCycleResource($courseByCycle),"❤️ ❤️ Successfully Updated ❤️ ❤️");
            }else {
                return "Course Not Found!";
            }
        }else{
            return $this->fail(['message' => 'CourseByCycle not found',404]);
        }
    }
    public function show($id)
    {
        try {
             CourseByCycle::where('id', $id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "CourseByCycle not found!"],404);
        }
        $courseByCycle = new CourseByCycleResource(CourseByCycle::where('id',$id)->first());
        return $this->success($courseByCycle,"❤️ ❤️ has found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $courseByCycle = CourseByCycle::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "Coursebycycle not found!"], 404);
        }
        $courseByCycle->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
