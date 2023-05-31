<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Resources\CourseResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class CourseController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required|min:4',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);
        if($validator->fails()){
           return $this->fail($validator->errors());
        }
        $course = new Course();
        if($request->image_id) {
            $course->image_id = $request->image_id;
        }
        $course->name = $request->name;
        $course->category_id = $request->category_id;
        $course->description = $request->description;
        $course->startDate = $request->startDate;
        $course->endDate = $request->endDate;
        $course->save();
        return $this->success( new CourseResource($course),"❤️ ❤️ Successfully Created ❤️ ❤️");
    }
    public function index()
    {
        return $this->success(CourseResource::collection(Course::with('image')->get()),"❤️ ❤️ All Courses ❤️ ❤️");
    }
    public function update(Request $request , $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'category_id' => 'required',
            'description' => 'required|min:4',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $course = Course::where('id',$id)->first();
        if($course){
            if($request->image_id) {
                $course->image_id = $request->image_id;
            }
            $course->name = $request->name;
            $course->category_id = $request->category_id;
            $course->description = $request->description;
            $course->startDate = $request->startDate;
            $course->endDate = $request->endDate;
            $course->update();
            return $this->success(new CourseResource($course));
        }else{
            return $this->fail(['message' => 'course not found',404]);
        }
    }
    public function show($id)
    {
        try {
            Course::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Course not found!"],404);
        }
        $course = new CourseResource(Course::where('id',$id)->with('image')->first());
        return $this->success($course, "❤️ ❤️ has found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $course = Course::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "course not found"],404);
        }
        $course->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
