<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
 
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $validator = Validator::make($credentials, [
            'email' => "required|email",
            'password' => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        if (Auth::attempt($credentials)) {

            $user = Auth::user();
            if ($user->status == 'Active') {
                $token = $user->createToken('Api Token')->plainTextToken;

                return response()->json([
                    'message' => 'Login Successfull',
                    'token' => $token,
                    'data' => $user,
                ], 200);
            }else{
                return response()->json([
                    'status_error' => 'Account Not Active',
                ], 401);
            }
        }else{
            return response()->json([
                'incorrect_error' => 'Email Or Password Incorrect..!!',
            ], 500);
        }
        
    }

    public function registration(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|unique:users',
            'profile_picture' => 'image|mimes:jpeg,png,jpg',
            'phone' => 'required|numeric|unique:users',
            'password' => 'required|min:5|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Registration Failed..!!',
                'errors' => $validator->errors(),
            ], 422);
        }

        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);

            if ($request->hasFile('profile_picture')) {

                $image = $request->file('profile_picture');
                $extension = $image->extension();
                $name = time().'.'.$extension;
                $image->move(public_path('/upload/users_images/'), $name);
            }
            $user->profile_picture = $name;

            $user->save();


            return response()->json([
                'message' => 'Registration Successfull',
                'data' =>  $user,
            ], 200);

        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }
    }

    public function show()
    {
       $user = Auth::user();

       if ($user) {
        return response()->json([
            'message' => 'User Information..!!',
            'data' => $user
        ], 200);
       }
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully Logged Out..!!'
        ], 200);
    }
}
