<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::all();

        return response()->json([
            'message' => 'All service List',
            'data' => $services
        ]);
    }

    public function activeServiceData()
    {
        $active_service = Service::where('status', 'Active')->orderBy('id', 'DESC')->get();

        if ($active_service) {
            return response()->json([
                'message' => 'All Active Service List',
                'data' => $active_service
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
            'name' => 'required|unique:services',
            'icon_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $service = new Service();

        $service->name = $request->name;
        $service->icon_url = $request->icon_url;
        $service->save();
        
        return response()->json([
            'message' => 'Service Added Successfull',
            'data' =>  $service,
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
        $service = Service::find($id);

        if ($service) {
            return response()->json([
                'message' => 'Service Information',
                'data' => $service,
            ], 200);
        }else{
            return response()->json([
                'message' => 'Service Failed',
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
            'name' => 'required|unique:services,name,'.$id,
            'icon_url' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $services_update = Service::find($id);

      
        $services_update->name = $request->name;
        $services_update->icon_url = $request->icon_url;
        $services_update->save();
        
        return response()->json([
            'message' => 'service Updated Successfull',
            'data' =>  $services_update,
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
        $service = Service::find($id);

        if ($service) {
            
            $service->delete();

            return response()->json([
                'message' => 'Service Deleted Successfull..!!',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Deleted Failed',
            ], 400);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $service = Service::find($id);

        if ($service->status == 'Active') {
            $service->status = 'Inactive';
            $service->save();
        }elseif($service->status == 'Inactive'){
            $service->status = 'Active';
            $service->save();
        }

        return response()->json([
            'message' => 'Status Changed Successfully..!!',
            'data' => $service,
        ], 200);
    }
}
