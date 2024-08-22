<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehiclePost;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = VehiclePost::query();
        $search_query = $request->input('search_query');
        if (($request->has('search_query') && !empty($search_query))) {
            $query->where(function ($query) use ($search_query) {
                $query->where('start_city', 'like', '%' . $search_query . '%')
                    ->orWhere('start_state', 'like', '%' . $search_query . '%')
                    ->orWhere('start_zip', 'like', '%' . $search_query . '%')
                    ->orWhere('destination_city', 'like', '%' . $search_query . '%')
                    ->orWhere('destination_state', 'like', '%' . $search_query . '%')
                    ->orWhere('destination_zip', 'like', '%' . $search_query . '%')
                    ->orWhereHas('company', function ($query) use ($search_query) {
                        $query->where('name', 'like', '%' . $search_query . '%');
                    });
            });
        }
        $data['vehiclePosts'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/vehicleposts/manage_vehicleposts', $data);
    }

    public function show(Request $request)
    {
        $vehiclePost = VehiclePost::where('id', $request->id)->first();
        if (!empty($vehiclePost)) {
            $vehiclePost->stops = $vehiclePost->VehicleStop;
            $htmlresult = view('admin/vehicleposts/vehiclepost_ajax', compact('vehiclePost'))->render();
            $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
            return $finalResult;
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Vehicle Post not found.']);
        }
    }
}
