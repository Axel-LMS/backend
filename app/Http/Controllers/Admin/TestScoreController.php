<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Test;
use App\Models\TestScore;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\TestScoreResource;
use Illuminate\Support\Facades\Validator;

class TestScoreController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'test_id' => 'required',
            'student_id' => 'required',
            'score' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $test = Test::where('id',$request->test_id)->first();
        if($test){
            $testscore = new TestScore();
            $testscore->course_id = $test->course_id;
            $testscore->cycle_id = $test->cycle_id;
            $testscore->testNo = $test->testNo;
            $testscore->student_id = $request->student_id;
            $testscore->score = $request->score;
            $testscore->save();
            return $this->success(new TestScoreResource($testscore),"success");
        }
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'test_id' => 'required',
            'student_id' => 'required',
            'score' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $testscore = TestScore::where('id',$id)->first();
        if($testscore){
            $test = Test::where('id',$request->test_id)->first();
            if($test){
                $testscore->course_id = $test->course_id;
                $testscore->cycle_id = $test->cycle_id;
                $testscore->testNo = $test->testNo;
                $testscore->student_id = $request->student_id;
                $testscore->score = $request->score;
                $testscore->update();
                return $this->success(new TestScoreResource($testscore),"success");
            }
        }
    }
    public function index()
    {
        return $this->success(TestScoreResource::collection(TestScore::all()),"all Testscores");
    }
    public function show($id)
    {
        try {
            TestScore::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "TestScore not found!"],404);
        }
        $testScore = new TestScoreResource(TestScore::where('id',$id)->first());
        return $this->success($testScore,"❤️ ❤️ has found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $testScore = TestScore::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "TestScore not found!"],404);
        }
        $testScore->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
