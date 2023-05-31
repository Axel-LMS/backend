<?php

namespace App\Http\Controllers\Admin;
use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
    public function store(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required|min:4'
            ]);
            if($validator->fails()){
                return $this->fail($validator->errors(),403);
            }
            $category = new Category();
            if($request->image_id) {
                $category->image_id = $request->image_id;
            }
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();
      return $this->success(new CategoryResource($category),'success');

    }
    public function index()
    {
        return $this->success(CategoryResource::collection(Category::with('image')->get()),"❤️ ❤️ All Categories ❤️ ❤️");
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|min:4'
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors());
        }
        $category = Category::where('id',$id)->first();
        if($category){
            if($request->image_id) {
                $category->image_id = $request->image_id;
            }
            $category->name = $request->name;
            $category->description = $request->description;
            $category->update();
            return $this->success(new CategoryResource($category));
        }else{
            return $this->fail(['message' => 'category not found',404]);
        }
    }
    public function show($id)
    {
        try {
            Category::where('id',$id)->firstOrFail();
        } catch (Exception) {
            return $this->fail(["message" => "Category not found"], 404);
        }
        $category = new CategoryResource(Category::where('id', $id)->with('image')->first());
        return $this->success($category,"❤️ ❤️ has Found ❤️ ❤️");
    }
    public function destroy($id)
    {
        try {
            $category = Category::where('id',$id)->firstOrFail();
        } catch (Exception ) {
            return $this->fail(["message" => "category not found!"],404);
        }
        $category->delete();
        return $this->response(["message" => "❤️ ❤️ successfully deleted ❤️ ❤️"],[],200,true);
    }
}
