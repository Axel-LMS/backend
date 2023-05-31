<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Resources\SliderResource;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class SliderController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->success(SliderResource::collection(Slider::with('image')->paginate(10)));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'image_id' => 'required',
            'order_by' => 'required',
            'status' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $slider = new Slider();
        $slider->image_id = $request->image_id;
        $slider->order_by = $request->order_by;
        if ($request->status == 'true') {
            $slider->status = true;
        } else {
            $slider->status = false;
        }
        $slider->save();
        return $this->success(new SliderResource($slider));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
             Slider::where('id', $id)->firstOrFail();
        } catch (Exception $e) {
            return $this->error(["message" => $e->getMessage()], 404);
        }
        $result = new SliderResource(Slider::where('id', $id)->first());
        return $this->success($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'image_id' => 'required',
            'order_by' => 'required',
            'status' => 'required'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $slider = Slider::where('id', $id)->first();
        $slider->image_id = $request->image_id;
        $slider->order_by = $request->order_by;
        if ($request->status == 'true') {
            $slider->status = true;
        } else {
            $slider->status = false;
        }
        $slider->update();
        return $this->success(new SliderResource($slider),"updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $slider = Slider::where('id', $id)->firstOrFail();
        } catch (Exception $e) {
            return $this->error(['message' => $e->getMessage()], 404);
        }
        $slider->delete();
        return $this->response(["message" => "❤️ ❤️ Successfully Deleted ❤️ ❤️"],[],200,true);
    }
}
