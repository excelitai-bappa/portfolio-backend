<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = BlogResource::collection(Blog::with('blog_category')->get());

        return response()->json([
            'message' => 'All Blog List',
            'data' => $blogs,
        ]);
    }

    public function activeBlogData()
    {
        $active_blog = BlogResource::collection(
            Blog::with('blog_category')
                ->where('status', 'Active')
                ->orderBy('id', 'DESC')
                ->get()
        );

        if ($active_blog) {
            return response()->json([
                'message' => 'All Active Blog List',
                'data' => $active_blog,
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
            'blog_category_id' => 'required',
            'title' => 'required|unique:blogs',
            'description' => 'required',
            'blog_thumbnail' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $blog = new Blog();

        if ($request->hasFile('blog_thumbnail')) {
            $image = $request->file('blog_thumbnail');
            $extension = $image->extension();
            $name = 'blogthumbnail' . time() . '.' . $extension;
            $image->move(public_path('/upload/blog/'), $name);
            $blog_thumbnail_path = 'upload/blog/' . $name;
        }
        $blog->blog_category_id = $request->blog_category_id;
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->blog_thumbnail = $blog_thumbnail_path;
        $blog->created_by = Auth()->user()->name;
        $blog->slug = Str::slug($blog->title);
        $blog->save();

        return response()->json(
            [
                'message' => 'Blog Added Successfull',
                'data' => $blog,
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
        $blog = new BlogResource(Blog::find($id));

        if ($blog) {
            return response()->json(
                [
                    'message' => 'Blog Information',
                    'data' => $blog,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'Blog Failed',
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
            'blog_category_id' => 'required',
            'title' => 'required|unique:blogs,title,' . $id,
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $blog_update = Blog::find($id);

        $data = [
            'blog_category_id' => $request->blog_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth()->user()->name,
            'slug' => Str::slug($blog_update->title),
        ];

        if ($request->hasFile('blog_thumbnail')) {
            $destination = public_path($blog_update->blog_thumbnail);

            if ($blog_update->blog_thumbnail && file_exists($destination)) {
                unlink($destination);
            }

            $image = $request->file('blog_thumbnail');
            $extension = $image->extension();
            $name = time() . '.' . $extension;
            $image->move(public_path('/upload/blogs/'), $name);
            $path = 'upload/blogs/' . $name;
            $data['blog_thumbnail'] = $path;
        }

        $blog_update->update($data);

        return response()->json(
            [
                'message' => 'Blog Updated Successfull',
                'data' => $blog_update,
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
        $blog = new BlogResource(Blog::find($id));

        if ($blog) {
            $blog->delete();
            $blog_thumbnail_path = public_path($blog->blog_thumbnail_path);

            if (file_exists($blog_thumbnail_path)) {
                unlink($blog_thumbnail_path);
            }
            $destination = public_path($blog->project_image);

            if (file_exists($destination)) {
                unlink($destination);
            }

            return response()->json(
                [
                    'message' => 'Blog Deleted Successfull..!!',
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
        $blog_status = Blog::find($id);

        if ($blog_status->status == 'Active') {
            $blog_status->status = 'Inactive';
            $blog_status->save();
        } elseif ($blog_status->status == 'Inactive') {
            $blog_status->status = 'Active';
            $blog_status->save();
        }

        return response()->json(
            [
                'message' => 'Status Changed Successfully..!!',
                'data' => $blog_status,
            ],
            200
        );
    }
}
