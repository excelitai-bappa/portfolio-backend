<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
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
    public function show()
    {
        $setting = new SettingResource(Setting::first());

        if ($setting) {
            return response()->json(
                [
                    'message' => 'Setting Information',
                    'data' => $setting,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'Setting Failed',
                ],
                400
            );
        }
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
            'short_description' => 'required',
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

        $data = [
            'name' => $request->name,
            'short_description' => $request->short_description,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'fb_link' => $request->fb_link,
            'twitter_link' => $request->twitter_link,
            'linekdin_link' => $request->linekdin_link,
        ];

        if ($request->hasFile('logo')) {
            $destination = public_path($setting->image);

            if ($setting->image && file_exists($destination)) {
                unlink($destination);
            }

            $logo = $request->file('logo');
            $extension = $logo->extension();
            $name =  'logo-' . time() . '.' . $extension;
            $logo->move(public_path('/upload/logo/'), $name);
            $logo_path = 'upload/logo/' . $name;
            $data['logo'] = $logo_path;
        }
        if ($request->hasFile('favicon')) {
            $destination = public_path($setting->favicon);

            if ($setting->favicon && file_exists($destination)) {
                unlink($destination);
            }

            $favicon = $request->file('favicon');
            $extension = $favicon->extension();
            $name = 'favicon-' . time() . '.' . $extension;
            $favicon->move(public_path('/upload/logo/'), $name);
            $favicon_path = 'upload/logo/' . $name;
            $data['favicon'] = $favicon_path;
        }

        $setting->update($data);

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
