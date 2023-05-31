<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Club;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AttendanceResource;

class AttendanceController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'club_id' => 'required',
            'student_id' => 'required',
            'timeArrive' => 'required|date_format:H:i',
            'timeLeave' => 'required|date_format:H:i|after:timeArrive'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $club = Club::where('id', $request->club_id)->first();
        if($club){
            $attendance = new Attendance();
            $attendance->course_id = $club->course_id;
            $attendance->cycle_id = $club->cycle_id;
            $attendance->classNo = $club->classNo;
            $attendance->student_id = $request->student_id;
            $attendance->timeArrive = $request->timeArrive;
            $attendance->timeLeave = $request->timeLeave;
            $attendance->save();
            return $this->success(new AttendanceResource($attendance),"successfully Created");
        }
    }public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'club_id' => 'required',
            'student_id' => 'required',
            'timeArrive' => 'required|date_format:H:i',
            'timeLeave' => 'required|date_format:H:i|after:timeArrive'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $attendance = Attendance::where('id',$id)->first();
        if($attendance) {
            $club = Club::where('id', $request->club_id)->first();
            if($club){
                $attendance->course_id = $club->course_id;
                $attendance->cycle_id = $club->cycle_id;
                $attendance->classNo = $club->classNo;
                $attendance->student_id = $request->student_id;
                $attendance->timeArrive = $request->timeArrive;
                $attendance->timeLeave = $request->timeLeave;
                $attendance->save();
                return $this->success(new AttendanceResource($attendance),"successfully Created");
            }
        }
    }
    public function index()
    {
        return $this->success(AttendanceResource::collection(Attendance::all()),"All attendances");
    }
    public function show($id)
    {
        try {
             Attendance::where("id",$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Attendance Not Found"]);
        }
        $attendance =new AttendanceResource(Attendance::where("id",$id)->first());
        return $this->success($attendance,"has Found");
    }
    public function destroy($id)
    {
        try {
            $attendance = Attendance::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "Attendance Not Found"]);
        }
        $attendance->delete();
        return $this->response(["message" => "Success"],[],200,true);
    }
}
