<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
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
        $about = About::find($id);

        if ($about) {
            return response()->json([
                'message' => 'About Information',
                'data' => $about,
            ], 200);
        }else{
            return response()->json([
                'message' => 'About Failed',
            ], 400);
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
            'title' => 'required',
            'short_description' => 'required',
            'year_of_experienced' => 'required|numeric',
            'project_complete' => 'required|numeric',
            'our_member' => 'required|numeric',
            'service_provide' => 'required|numeric',
            'happy_customers' => 'required|numeric',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $about_us_update = About::find($id);

        $about_us_update->title = $request->title;
        $about_us_update->short_description = $request->short_description;
        $about_us_update->year_of_experienced = $request->year_of_experienced;
        $about_us_update->project_complete = $request->project_complete;
        $about_us_update->our_member = $request->our_member;
        $about_us_update->service_provide = $request->service_provide;
        $about_us_update->happy_customers = $request->happy_customers;
        $about_us_update->save();
        
        return response()->json([
            'message' => 'About Us Updated Successfull',
            'data' =>  $about_us_update,
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
