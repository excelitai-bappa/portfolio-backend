<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SlidersResource;
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
        $sliders = SlidersResource::collection(Slider::all());

        return response()->json([
            'message' => 'All Slider List',
            'data' => $sliders,
        ]);
    }

    public function activeSliderData()
    {
        $active_slider = SlidersResource::collection(
            Slider::where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get()
        );

        if ($active_slider) {
            return response()->json([
                'message' => 'All Active Slider List',
                'data' => $active_slider,
            ]);
        } else {
            return response()->json([
                'message' => 'No Data Availble',
            ]);
        }
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
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $slider = new Slider();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $name = time() . '.' . $extension;
            $image->move(public_path('/upload/sliders/'), $name);
            $path = 'upload/sliders/' . $name;
        }

        $slider->title = $request->title;
        $slider->sub_title = $request->sub_title;
        $slider->short_description = $request->short_description;
        $slider->image = $path;

        $slider->save();

        return response()->json(
            [
                'message' => 'Slider Added Successfull',
                'data' => $slider,
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $slider = new SlidersResource(Slider::find($id));

        if ($slider) {
            return response()->json(
                [
                    'message' => 'Slider Information',
                    'data' => $slider,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'Slider Information Failed',
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
        // return response($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'sub_title' => 'required',
            'short_description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $slider_update = Slider::find($id);

        $data = [
            'title' => $request->title,
            'sub_title' => $request->sub_title,
            'short_description' => $request->short_description,
        ];

        if ($request->hasFile('image')) {
            $destination = public_path($slider_update->image);

            if ($slider_update->image && file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('image');
            $extension = $image->extension();
            $name = time() . '.' . $extension;
            $image->move(public_path('/upload/sliders/'), $name);
            $path = 'upload/sliders/' . $name;
            $data['image'] = $path;
        }

        $slider_update->update($data);

        return response()->json(
            [
                'message' => 'Slider Updated Successfull',
                'data' => $slider_update,
            ],
            200
        );
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
            $destination = public_path($slider->image);

            if (file_exists($destination)) {
                unlink($destination);
            }

            return response()->json(
                [
                    'message' => 'Slider Deleted Successfull..!!',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'Deleted Failed',
                ],
                400
            );
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $slider = Slider::find($id);

        if ($slider->status == 'Active') {
            $slider->status = 'Inactive';
            $slider->save();
        } elseif ($slider->status == 'Inactive') {
            $slider->status = 'Active';
            $slider->save();
        }

        return response()->json(
            [
                'message' => 'Status Changed Successfully..!!',
                'data' => $slider,
            ],
            200
        );
    }
}
