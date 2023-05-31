<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Client\ClientAuthController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Resources\UserResource;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        $user = $request->user();
        return new UserResource($user);
});
Route::get('/get-sliders', [HomeController::class, 'getSliders']);
Route::get('/get-categories', [HomeController::class, 'getCategories']);
Route::post('/admin/register', [AuthController::class,'register']);
Route::post('/admin/login', [AuthController::class,'login']);
Route::post('/register', [ClientAuthController::class,'register']);
Route::post('/login', [ClientAuthController::class,'login']);
