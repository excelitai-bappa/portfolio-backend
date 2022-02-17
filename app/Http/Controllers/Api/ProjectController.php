<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
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
        $projects = ProjectResource::collection(
            Project::with('project_category')->get()
        );
        return response()->json([
            'message' => 'All Project List',
            'data' => $projects,
        ]);
    }

    public function activeProjectData()
    {
        $active_project = ProjectResource::collection(Project::with('project_category')
            ->where('status', 'Active')
            ->orderBy('id', 'DESC')
            ->get()
        );

        if ($active_project) {
            return response()->json([
                'message' => 'All Active Project List',
                'data' => $active_project,
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
            'category_id' => 'required',
            'project_title' => 'required',
            'description' => 'required',
            'project_thumbnail' => 'required|image|mimes:jpeg,png,jpg',
            // 'project_image' => 'required|image|mimes:jpeg,png,jpg',
            'start_date' => 'required',
            'end_date' => 'required',
            'website_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $project = new Project();

        if ($request->hasFile('project_thumbnail')) {
            $image = $request->file('project_thumbnail');
            $extension = $image->extension();
            $name = 'thumbnail' . time() . '.' . $extension;
            $image->move(public_path('/upload/projects/'), $name);
            $project_thumbnail_path = 'upload/projects/' . $name;
        }
        // if ($request->hasFile('project_image')) {
        //     $image = $request->file('project_image');
        //     $extension = $image->extension();
        //     $name = 'project' . time() . '.' . $extension;
        //     $image->move(public_path('/upload/projects/'), $name);
        //     $project_image_path = 'upload/projects/' . $name;
        // }
        $project->category_id = $request->category_id;
        $project->project_title = $request->project_title;
        $project->description = $request->description;
        $project->project_thumbnail = $project_thumbnail_path;
        // $project->project_image = $project_image_path;
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->website_url = $request->website_url;
        $project->save();

        return response()->json(
            [
                'message' => 'Project Added Successfull',
                'data' => $project,
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
        $project = new ProjectResource(Project::find($id));

        if ($project) {
            return response()->json(
                [
                    'message' => 'Project Information',
                    'data' => $project,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'Project Failed',
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
            'category_id' => 'required',
            'project_title' => 'required',
            'description' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'website_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $project_update = Project::find($id);

        $data = [
            'category_id' => $request->category_id,
            'project_title' => $request->project_title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'website_url' => $request->website_url,
        ];

        if ($request->hasFile('project_thumbnail')) {
            $destination = public_path($project_update->project_thumbnail);

            if ($project_update->project_thumbnail && file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('project_thumbnail');
            $extension = $image->extension();
            $name = time() . '.' . $extension;
            $image->move(public_path('/upload/projects/'), $name);
            $path = 'upload/projects/' . $name;
            $data['project_thumbnail'] = $path;
        }

        $project_update->update($data);

        return response()->json(
            [
                'message' => 'Project Updated Successfull',
                'data' => $project_update,
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
        $project = new ProjectResource(Project::find($id));

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

            return response()->json(
                [
                    'message' => 'Project Deleted Successfull..!!',
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
        $project = Project::find($id);

        if ($project->status == 'Active') {
            $project->status = 'Inactive';
            $project->save();
        } elseif ($project->status == 'Inactive') {
            $project->status = 'Active';
            $project->save();
        }

        return response()->json(
            [
                'message' => 'Status Changed Successfully..!!',
                'data' => $project,
            ],
            200
        );
    }
}
