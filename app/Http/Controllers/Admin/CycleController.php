<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Cycle;
use Illuminate\Http\Request;
use App\Http\Resources\CycleResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class CycleController extends BaseController
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'description' => 'required|min:4',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'vacationStartDate' => 'required|date',
            'vacationEndDate' => 'required|date',
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $cycle = new Cycle();
        $cycle->description = $request->description;
        $cycle->startDate = $request->startDate;
        $cycle->endDate = $request->endDate;
        $cycle->vacationStartDate = $request->vacationStartDate;
        $cycle->vacationEndDate = $request->vacationEndDate;
        $cycle->save();
        return $this->success(new CycleResource($cycle), "❤️ ❤️ Successfully Created ❤️ ❤️");
    }
    public function index()
    {
        return $this->success(CycleResource::collection(Cycle::all()),"❤️ ❤️ All Cycles ❤️ ❤️");
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'description' => 'required|min:4',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'vacationStartDate' => 'required|date',
            'vacationEndDate' => 'required|date',
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $cycle = Cycle::where('id',$id)->first();
        if($cycle){
            $cycle->description = $request->description;
            $cycle->startDate = $request->startDate;
            $cycle->endDate = $request->endDate;
            $cycle->vacationStartDate = $request->vacationStartDate;
            $cycle->vacationEndDate = $request->vacationEndDate;
            $cycle->update();
            return $this->success(new CycleResource($cycle));
        }else{
            return $this->fail(['message' => 'cycle not found',404]);
        }
    }
    public function show($id)
    {
        try {
             Cycle::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "cycle not found!"], 404);
        }
        $cycle = new CycleResource(Cycle::where('id', $id)->first());
        return $this->success($cycle, "❤️ ❤️ has Found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $cycle = Cycle::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "Cycle not Found!"],404);
        }
        $cycle->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
