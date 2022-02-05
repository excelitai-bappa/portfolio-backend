<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();

        return response()->json([
            'message' => 'All Project List',
            'data' => $projects
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
            'category_id' => 'required',
            'project_title' => 'required',
            'description' => 'required',
            'project_thumbnail' => 'required|image|mimes:jpeg,png,jpg',
            'project_image' => 'required|image|mimes:jpeg,png,jpg',
            'start_date' => 'required',
            'end_date' => 'required',
            'end_date' => 'required',
            'website_url' => 'required',
        ]);								

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $project = new Project();

        if ($request->hasFile('project_thumbnail')) {
            $image = $request->file('project_thumbnail');
            $extension = $image->extension();
            $name = 'thumbnail'.time().'.'.$extension;
            $image->move(public_path('/upload/projects/'), $name);
            $project_thumbnail_path = 'upload/projects/'.$name;
        }
        if ($request->hasFile('project_image')) {
            $image = $request->file('project_image');
            $extension = $image->extension();
            $name = 'project'.time().'.'.$extension;
            $image->move(public_path('/upload/projects/'), $name);
            $project_image_path = 'upload/projects/'.$name;
        }
        $project->category_id = $request->category_id;
        $project->project_title = $request->project_title;
        $project->description = $request->description;
        $project->project_thumbnail = $project_thumbnail_path;
        $project->project_image = $project_image_path;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->website_url = $request->website_url;
        $project->save();
        
        return response()->json([
            'message' => 'Project Added Successfull',
            'data' =>  $project,
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
            'category_id' => 'required',
            'project_title' => 'required',
            'description' => 'required',
            'project_thumbnail' => 'required|image|mimes:jpeg,png,jpg',
            'project_image' => 'required|image|mimes:jpeg,png,jpg',
            'start_date' => 'required',
            'end_date' => 'required',
            'end_date' => 'required',
            'website_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $project_update = Project::find($id);

        if ($request->hasFile('project_thumbnail')) {

            $destination = public_path($project_update->project_thumbnail);
            if (file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('project_thumbnail');
            $extension = $image->extension();
            $name = 'thumbnail'.time().'.'.$extension;
            $image->move(public_path('/upload/projects/'), $name);
            $project_thumbnail_path = 'upload/projects/'.$name;
        }
        if ($request->hasFile('project_image')) {

            $destination = public_path($project_update->project_image);
            if (file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('project_image');
            $extension = $image->extension();
            $name = 'project'.time().'.'.$extension;
            $image->move(public_path('/upload/projects/'), $name);
            $project_image_path = 'upload/projects/'.$name;
        }

        $project_update->category_id = $request->category_id;
        $project_update->project_title = $request->project_title;
        $project_update->description = $request->description;
        $project_update->project_thumbnail = $project_thumbnail_path;
        $project_update->project_image = $project_image_path;
        $project_update->start_date = $request->start_date;
        $project_update->end_date = $request->end_date;
        $project_update->website_url = $request->website_url;
        $project_update->save();
        
        return response()->json([
            'message' => 'Project Updated Successfull',
            'data' =>  $project_update,
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
        $project = Project::find($id);

        if ($project) {
            
            $project->delete();
            $destination = public_path($project->project_thumbnail);

            if (file_exists($destination)) {
                unlink($destination);
            }
            $destination = public_path($project->project_image);

            if (file_exists($destination)) {
                unlink($destination);
            }

            return response()->json([
                'message' => 'Project Deleted Successfull..!!',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Deleted Failed',
            ], 400);
        }
    }
}
