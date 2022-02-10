<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg',	
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $profile_update = User::find(Auth::guard('sanctum')->user()->id);

        if ($request->hasFile('profile_picture')) {

            $destination = public_path($profile_update->profile_picture);
            
            if (file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('profile_picture');
            $extension = $image->extension();
            $name = 'profile'.time().'.'.$extension;
            $image->move(public_path('/upload/users_images/'), $name);
            $path = 'upload/users_images/'.$name;
        }

        $profile_update->name = $request->name;
        $profile_update->phone = $request->phone;
        $profile_update->profile_picture = $path;


        $profile_update->save();
        
        return response()->json([
            'message' => 'Profile Updated Successfull',
            'data' =>  $profile_update,
        ], 200);
    }

    public function ChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'oldpassword' => 'required',
            'password' => 'required|confirmed',	
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $hashedPassword = Auth::guard('sanctum')->user()->password;
        $id = Auth::guard('sanctum')->user()->id;
        if (Hash::check($request->oldpassword, $hashedPassword)) {

            $user = User::find($id);
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

            return redirect()->route('user.login');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
