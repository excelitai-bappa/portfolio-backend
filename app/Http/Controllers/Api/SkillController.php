<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skills = Skill::all();

        return response()->json([
            'message' => 'All Skill List',
            'data' => $skills
        ]);
    }

    public function activeSkillData()
    {
        $active_skill = Skill::where('status', 'Active')->orderBy('id', 'DESC')->get();

        if($active_skill){
            return response()->json([
                'message' => 'All Active Skill List',
                'data' => $active_skill
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
            'skill_name' => 'required|unique:skills',
            'skill_percentage' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $skill = new Skill();

        $skill->skill_name = $request->skill_name;
        $skill->skill_percentage = $request->skill_percentage;
        $skill->save();
        
        return response()->json([
            'message' => 'Skill Added Successfull',
            'data' =>  $skill,
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
            'skill_name' => 'required|unique:skills,skill_name,'.$id,
            'skill_percentage' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $skill_update = Skill::find($id);

        $skill_update->skill_name = $request->skill_name;
        $skill_update->skill_percentage = $request->skill_percentage;
        $skill_update->save();
        
        return response()->json([
            'message' => 'Skill Updated Successfull',
            'data' =>  $skill_update,
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
        $skill = Skill::find($id);

        if ($skill) {
            $skill->delete();
            return response()->json([
                'message' => 'Skill Deleted Successfull..!!',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Deleted Failed',
            ], 400);
        }
    }
    
    public function changeStatus(Request $request, $id)
    {
        $skill = Skill::find($id);

        if ($skill->status == 'Active') {
            $skill->status = 'Inactive';
            $skill->save();
        }elseif($skill->status == 'Inactive'){
            $skill->status = 'Active';
            $skill->save();
        }

        return response()->json([
            'message' => 'Status Changed Successfully..!!',
            'data' => $skill,
        ], 200);
    }
}

