<?php

namespace App\Http\Controllers\Client;

use App\Models\Slider;
use App\Http\Resources\SliderResource;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class HomeController extends BaseController
{
    public function getSliders()
    {
        $sliders = SliderResource::collection(Slider::where('status' , true)->orderBy('order_by', 'asc')->active()->with('image')->get());
        return $this->success($sliders, "Sliders");
    }
    public function getCategories()
    {
        $categories = CategoryResource::collection(Category::with('image')->get());
        return $this->success($categories, "categories");
    }
}
