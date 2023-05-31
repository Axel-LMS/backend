<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $user = new User();
        $user->name= $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole('admin');
        $token = $user->createToken('adminauth-lms')->plainTextToken;
        return response()->json
        ([
            'data' => ['user' => $user,'token' => $token],
            'errors' => [],
            'condition' => true,
        ],201);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if($validator->fails()){
            return $this->fail($validator->errors());
        }
        $user = User::where('email',$request->email)->first();
        if($user) {
            if(Hash::check($request->password,$user->password)) {
                $token = $user->createToken('adminauth-lms')->plainTextToken;
                return response()->json([
                    'data' => ['user'=>$user,'token' => $token],
                    'errors'=> [],
                    'condition' => true
                ]);
            }else {
                return "Wrong Password";
            }
        }else {
            return $this->fail(["message" => "There is no user with this email"],404);
        }
    }
}
