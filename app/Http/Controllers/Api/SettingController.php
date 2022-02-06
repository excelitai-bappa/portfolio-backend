<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
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
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg',
            'favicon' => 'required|image|mimes:jpeg,png,jpg',
            'email' => 'required|email',
            'mobile' => 'required|min:11|max:11',
            'address' => 'required',
            'fb_link' => 'required',
            'twitter_link' => 'required',
            'linekdin_link' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $setting = Setting::find($id);

        if ($request->hasFile('logo')) {

            $destination = public_path($setting->logo);
            if (file_exists($destination)) {
                unlink($destination);
            }
            
            $image = $request->file('logo');
            $extension = $image->extension();
            $name = time().'.'.$extension;
            $image->move(public_path('/upload/logo/'), $name);
            $logo_path = 'upload/logo/'.$name;
        }
        if ($request->hasFile('favicon')) {

            $destination = public_path($setting->favicon);
            if (file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('favicon');
            $extension = $image->extension();
            $name = time().'.'.$extension;
            $image->move(public_path('/upload/favicon/'), $name);
            $favicon_path = 'upload/favicon/'.$name;
        }

        $setting->name = $request->name;
        $setting->email = $request->email;
        $setting->mobile = $request->mobile;
        $setting->address = $request->address;
        $setting->fb_link = $request->fb_link;
        $setting->twitter_link = $request->twitter_link;
        $setting->linekdin_link = $request->linekdin_link;
        $setting->logo = $logo_path;
        $setting->favicon = $favicon_path;


        $setting->save();
        
        return response()->json([
            'message' => 'Setting Updated Successfully',
            'data' =>  $setting,
        ], 200);
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
