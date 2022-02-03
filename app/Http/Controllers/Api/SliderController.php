<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'sub_title' => 'required',
            'short_description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $slider = new Slider();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $name = time().'.'.$extension;
            $image->move(public_path('/upload/sliders/'), $name);
            $path = '/upload/sliders/'.$name;
        }

        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->short_description = $request->short_description;
        $slider->image = $path;


        $slider->save();
        
        return response()->json([
            'message' => 'Slider Added Successfull',
            'data' =>  $slider,
        ], 200);
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
            'title' => 'required',
            'sub_title' => 'required',
            'short_description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $slider_update = Slider::find($id);

        if ($request->hasFile('image')) {

            $destination = public_path('upload/sliders/' .$slider_update->image);

            if (file_exists($destination)) {
                unlink($destination);
            }


            $image = $request->file('image');
            $extension = $image->extension();
            $name = time().'.'.$extension;
            $image->move(public_path('/upload/sliders/'), $name);
            $path = '/upload/sliders/'.$name;
        }

        $slider_update->title = $request->title;
        $slider_update->sub_title = $request->sub_title;
        $slider_update->short_description = $request->short_description;
        $slider_update->image = $path;


        $slider_update->save();
        
        return response()->json([
            'message' => 'Slider Updated Successfull',
            'data' =>  $slider_update,
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
        $slider = Slider::find($id);

        if ($slider) {
            $slider->delete();
            return response()->json([
                'message' => 'Slider Deleted Successfull..!!',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Deleted Failed',
            ], 400);
        }
    }
}
