<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\EnrollmentResource;

class EnrollmentController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'course_id' => 'required',
            'cycle_id' => 'required',
            'student_id' => 'required',
            'enrollmentDate' => 'required|date'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $enrollment = new Enrollment();
        $enrollment->course_id = $request->course_id;
        $enrollment->cycle_id = $request->cycle_id;
        $enrollment->student_id = $request->student_id;
        $enrollment->enrollmentDate = $request->enrollmentDate;
        if($request->cancelled) {
            $enrollment->cancelled = $request->cancelled;
            $enrollment->cancellationReason = $request->cancellationReason;
        }
        $enrollment->save();
        return $this->success(new EnrollmentResource($enrollment), "❤️ ❤️ Successfully Created ❤️ ❤️");
    }
    public function index()
    {
        return $this->success(EnrollmentResource::collection(Enrollment::all())," ❤️ ❤️ All Enrollments ❤️ ❤️");
    }
    public function show($id)
    {
        try {
            Enrollment::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Enrollment not found"]);
        }
        $enrollment = new EnrollmentResource(Enrollment::where('id',$id)->first());
        return $this->success($enrollment,"❤️ ❤️ has found ❤️ ❤️");
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'cycle_id' => 'required',
            'student_id' => 'required',
            'enrollmentDate' => 'required|date'
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $enrollment = Enrollment::where('id',$id)->first();
        if($enrollment){
            $enrollment->course_id = $request->course_id;
            $enrollment->cycle_id = $request->cycle_id;
            $enrollment->student_id = $request->student_id;
            $enrollment->enrollmentDate = $request->enrollmentDate;
            switch ($request->cancelled) {
                case false :
                $enrollment->cancelled = $request->cancelled;
                $enrollment->cancellationReason = null;
                break;
                default:
                $enrollment->cancelled = $request->cancelled;
                $enrollment->cancellationReason = $request->cancellationReason;
                break;
            }
            $enrollment->update();
            return $this->success(new EnrollmentResource($enrollment));
        }else{
            return $this->fail(['message' => 'category not found',404]);
        }
    }
    public function destroy($id)
    {
        try {
            $enrollment = Enrollment::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "Enrollment not found"]);
        }
        $enrollment->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
