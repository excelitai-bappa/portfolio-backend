<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = BlogCategory::all();

        return response()->json([
            'message' => 'All category List',
            'data' => $categories
        ]);
    }

    public function activeCategoryData()
    {
        $active_category = BlogCategory::where('status', 'Active')->orderBy('id', 'DESC')->get();

        if ($active_category) {
            return response()->json([
                'message' => 'All Active Category List',
                'data' => $active_category
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
            'name' => 'required|unique:blog_categories',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $blog_category = new BlogCategory();
        $blog_category->name = $request->name;
        $blog_category->save();
        
        return response()->json([
            'message' => 'Category Added Successfull',
            'data' =>  $blog_category,
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
            'name' => 'required|unique:blog_categories,name,'.$id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $categories_update = BlogCategory::find($id);

      
        $categories_update->name = $request->name;
        $categories_update->save();
        
        return response()->json([
            'message' => 'Category Updated Successfull',
            'data' =>  $categories_update,
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
        $category = BlogCategory::find($id);

        if ($category) {
            
            $category->delete();

            return response()->json([
                'message' => 'Category Deleted Successfull..!!',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Deleted Failed',
            ], 400);
        }
    }
     
    public function changeStatus(Request $request, $id)
    {
        $blog_category_status = BlogCategory::find($id);

        if ($blog_category_status->status == 'Active') {
            $blog_category_status->status = 'Inactive';
            $blog_category_status->save();
        }elseif($blog_category_status->status == 'Inactive'){
            $blog_category_status->status = 'Active';
            $blog_category_status->save();
        }

        return response()->json([
            'message' => 'Status Changed Successfully..!!',
            'data' => $blog_category_status,
        ], 200);
    }
}

