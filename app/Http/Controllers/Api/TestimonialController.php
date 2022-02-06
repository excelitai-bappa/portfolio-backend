<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = TestimonialResource::collection(Testimonial::all());

        return response()->json([
            'message' => 'All Testimonial List',
            'data' => $testimonials
        ]);
    }

    public function activeTestimonialData()
    {
        $active_testimonial = TestimonialResource::collection(Testimonial::where('status', 'Active')->orderBy('id', 'DESC')->get());

        if ($active_testimonial) {
            return response()->json([
                'message' => 'All Active Testimonial List',
                'data' => $active_testimonial
            ]);
        }else{
            return response()->json([
                'message' => 'No Data Availble'
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
            'statement' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',			
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $testimonial = new Testimonial();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $name = 'testimonial'.time().'.'.$extension;
            $image->move(public_path('/upload/testimonials/'), $name);
            $path = 'upload/testimonials/'.$name;
        }

        $testimonial->statement = $request->statement;
        $testimonial->name = $request->name;
        $testimonial->designation = $request->designation;
        $testimonial->image = $path;

        $testimonial->save();
        
        return response()->json([
            'message' => 'Testimonial Added Successfull',
            'data' =>  $testimonial,
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
            'statement' => 'required',
            'name' => 'required',
            'designation' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',	
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $testimonial_update = Testimonial::find($id);

        if ($request->hasFile('image')) {

            $destination = public_path($testimonial_update->image);
            
            if (file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('image');
            $extension = $image->extension();
            $name = 'testimonial'.time().'.'.$extension;
            $image->move(public_path('/upload/testimonials/'), $name);
            $path = 'upload/testimonials/'.$name;
        }

        $testimonial_update->statement = $request->statement;
        $testimonial_update->name = $request->name;
        $testimonial_update->designation = $request->designation;
        $testimonial_update->image = $path;

        $testimonial_update->save();
        
        return response()->json([
            'message' => 'Testimonial Updated Successfull',
            'data' =>  $testimonial_update,
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
        $testimonial = Testimonial::find($id);

        if ($testimonial) {
            
            $testimonial->delete();
            $destination = public_path($testimonial->image);

            if (file_exists($destination)) {
                unlink($destination);
            }

            return response()->json([
                'message' => 'Testimonial Deleted Successfull..!!',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Deleted Failed',
            ], 400);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $testimonial = Testimonial::find($id);

        if ($testimonial->status == 'Active') {
            $testimonial->status = 'Inactive';
            $testimonial->save();
        }elseif($testimonial->status == 'Inactive'){
            $testimonial->status = 'Active';
            $testimonial->save();
        }

        return response()->json([
            'message' => 'Status Changed Successfully..!!',
            'data' => $testimonial,
        ], 200);
    }
}

