<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\CoursePerCycle;
use App\Http\Resources\ClubResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class ClubController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'coursepercycle_id' => 'required',
            'teacher_id' => 'required',
            'classTitle' => 'required',
            'classDate' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',
            'classNo' => 'required',
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $coursepercycle = CoursePerCycle::where('id',$request->coursepercycle_id)->first();
        if($coursepercycle){
            $club = new Club();
            $club->course_id = $coursepercycle->course_id;
            $club->cycle_id = $coursepercycle->cycle_id;
            $club->teacher_id = $request->teacher_id;
            $club->classNo = $request->classNo;
            $club->classTitle = $request->classTitle;
            $club->classDate = $request->classDate;
            $club->startTime = $request->startTime;
            $club->endTime = $request->endTime;
            $club->save();
            return $this->success(new ClubResource($club),"success");
        }else {
            return $this->fail(["message" => "coursepercycle not found"]);
        }
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'coursepercycle_id' => 'required',
            'teacher_id' => 'required',
            'classTitle' => 'required',
            'classDate' => 'required|date',
            'startTime' => 'required|date_format:H:i',
            'endTime' => 'required|date_format:H:i|after:startTime',
            'classNo' => 'required',
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $club = Club::where('id',$id)->first();
        if($club){
            $coursepercycle = CoursePerCycle::where('id',$request->coursepercycle_id)->first();
            if($coursepercycle){
                $club->course_id = $coursepercycle->course_id;
                $club->cycle_id = $coursepercycle->cycle_id;
                $club->teacher_id = $request->teacher_id;
                $club->classNo = $request->classNo;
                $club->classTitle = $request->classTitle;
                $club->classDate = $request->classDate;
                $club->startTime = $request->startTime;
                $club->endTime = $request->endTime;
                $club->save();
                return $this->success(new ClubResource($club),"success");
            }else {
                return $this->fail(["message" => "coursepercycle not found"]);
            }
        }
    }
    public function index()
    {
        return $this->success(ClubResource::collection(Club::all()),"All Clubs");
    }
    public function show($id)
    {
        try {
            Club::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "club not found"], 404);
        }
        $club = new ClubResource(Club::where('id', $id)->first());
        return $this->success($club,"❤️ ❤️ has Found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $club = Club::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "club not found!"],404);
        }
        $club->delete();
        return $this->response(["message" => "❤️ ❤️ successfully deleted ❤️ ❤️"],[],200,true);
    }
}
