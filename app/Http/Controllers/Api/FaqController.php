<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faq = Faq::all();

        return response()->json([
            'message' => 'All FAQ List',
            'data' => $faq,
        ]);
    }

    public function activeFaqData()
    {
        $active_faq_data = Faq::where('status', 'Active')
            ->orderBy('id', 'DESC')
            ->get();

        if ($active_faq_data) {
            return response()->json([
                'message' => 'All FAQ List',
                'data' => $active_faq_data,
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
            'question' => 'required|unique:faqs', 
            'answer' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $faq = new Faq();

        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return response()->json(
            [
                'message' => 'Faq Added Successfull',
                'data' => $faq,
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
        $faq = Faq::find($id);

        if ($faq) {
            return response()->json(
                [
                    'message' => 'FAQ Information',
                    'data' => $faq,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'message' => 'FAQ Failed',
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
            'question' => 'required|unique:faqs,question,' . $id ,
            'answer' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422
            );
        }

        $faq_update = Faq::find($id);

        $faq_update->question = $request->question;
        $faq_update->answer = $request->answer;
        $faq_update->save();

        return response()->json(
            [
                'message' => 'Faq Updated Successfull',
                'data' => $faq_update,
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
        $faq = Faq::find($id);

        if ($faq) {
            $faq->delete();
            return response()->json(
                [
                    'message' => 'Faq Deleted Successfull..!!',
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
        $faq = Faq::find($id);

        if ($faq->status == 'Active') {
            $faq->status = 'Inactive';
            $faq->save();
        } elseif ($faq->status == 'Inactive') {
            $faq->status = 'Active';
            $faq->save();
        }

        return response()->json(
            [
                'message' => 'Status Changed Successfully..!!',
                'data' => $faq,
            ],
            200
        );
    }
}
