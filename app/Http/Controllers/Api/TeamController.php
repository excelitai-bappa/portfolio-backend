<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::all();

        return response()->json([
            'message' => 'All Team List',
            'data' => $teams
        ]);
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
            'name' => 'required',
            'designation' => 'required',
            'fb_url' => 'required',
            'twitter_url' => 'required',
            'linkedin_url' => 'required',
            'insta_url' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $team = new Team();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->extension();
            $name = time().'.'.$extension;
            $image->move(public_path('/upload/teams/'), $name);
            $path = 'upload/teams/'.$name;
        }

        $team->name = $request->name;
        $team->designation = $request->designation;
        $team->fb_url = $request->fb_url;
        $team->twitter_url = $request->twitter_url;
        $team->linkedin_url = $request->linkedin_url;
        $team->insta_url = $request->insta_url;
        $team->image = $path;


        $team->save();
        
        return response()->json([
            'message' => 'Team Added Successfull',
            'data' =>  $team,
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
            'name' => 'required',
            'designation' => 'required',
            'fb_url' => 'required',
            'twitter_url' => 'required',
            'linkedin_url' => 'required',
            'insta_url' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $team_update = Team::find($id);

        if ($request->hasFile('image')) {

            $destination = public_path($team_update->image);
            if (file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('image');
            $extension = $image->extension();
            $name = time().'.'.$extension;
            $image->move(public_path('/upload/teams/'), $name);
            $path = 'upload/teams/'.$name;
        }

        $team_update->name = $request->name;
        $team_update->designation = $request->designation;
        $team_update->fb_url = $request->fb_url;
        $team_update->twitter_url = $request->twitter_url;
        $team_update->linkedin_url = $request->linkedin_url;
        $team_update->insta_url = $request->insta_url;
        $team_update->image = $path;


        $team_update->save();
        
        return response()->json([
            'message' => 'Team Updated Successfull',
            'data' =>  $team_update,
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
        $team = Team::find($id);

        if ($team) {
            
            $team->delete();
            $destination = public_path($team->image);

            if (file_exists($destination)) {
                unlink($destination);
            }

            return response()->json([
                'message' => 'Team Deleted Successfull..!!',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Deleted Failed',
            ], 400);
        }
    }
}
