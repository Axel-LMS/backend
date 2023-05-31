<?php

use App\Models\Cycle;
use App\Models\Course;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cycle', function () {
    return Cycle::where('id', 1)->first()->coursebycycles;
});

Route::get('/make-roles', function(){
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'client']);
    Role::create(['name' => 'customer']);
});
