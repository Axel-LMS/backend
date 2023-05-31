<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Test;
use Illuminate\Http\Request;
use App\Models\CoursePerCycle;
use App\Http\Resources\TestResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class TestController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'coursepercycle_id' => 'required',
            'testDate' => 'required|date',
            'testTime' => 'required|date_format:H:i',
            'agenda' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $coursepercycle = CoursePerCycle::where('id',$request->coursepercycle_id)->first();
        if($coursepercycle){
            $test = new Test();
            $test->course_id = $coursepercycle->course_id;
            $test->cycle_id = $coursepercycle->cycle_id;
            $test->testNo = 1;
            $test->testDate = $request->testDate;
            $test->testTime = $request->testTime;
            $test->agenda = $request->agenda;
            $test->save();
            return $this->success(new TestResource($test),"Success");
        }
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'coursepercycle_id' => 'required',
            'testDate' => 'required|date',
            'testTime' => 'required|date_format:H:i',
            'agenda' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $test = Test::where('id',$id)->first();
        if($test) {
            $coursepercycle = CoursePerCycle::where('id',$request->coursepercycle_id)->first();
            if($coursepercycle){
                $test->course_id = $coursepercycle->course_id;
                $test->cycle_id = $coursepercycle->cycle_id;
                $test->testNo = 1;
                $test->testDate = $request->testDate;
                $test->testTime = $request->testTime;
                $test->agenda = $request->agenda;
                $test->save();
                return $this->success(new TestResource($test),"Success");
            }
        }
    }
    public function show($id)
    {
        try {
            Test::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Test not found!"],404);
        }
        $test = new TestResource(Test::where('id',$id)->first());
        return $this->success($test,"❤️ ❤️ has found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $test = Test::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "Test not found!"],404);
        }
        $test->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }

    public function index()
    {
        return $this->success(TestResource::collection(Test::all()),"All Tests");
    }
}
