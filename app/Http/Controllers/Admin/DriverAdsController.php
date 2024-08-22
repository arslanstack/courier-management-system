<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DriverAd;
use App\Models\DriverResponse;
use Illuminate\Http\Request;

class DriverAdsController extends Controller
{
    public function index(Request $request)
    {
        $query = DriverAd::query();
        $search_query = $request->input('search_query');
        if (($request->has('search_query') && !empty($search_query))) {
            $query->where(function ($query) use ($search_query) {
                $query->where('city', 'like', '%' . $search_query . '%')
                    ->orWhere('state', 'like', '%' . $search_query . '%')
                    ->orWhere('zip', 'like', '%' . $search_query . '%')
                    ->orWhereHas('company', function ($query) use ($search_query) {
                        $query->where('name', 'like', '%' . $search_query . '%');
                    });
            });
        }
        $data['driverAds'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/driver_ads/manage_driver_ads', $data);
    }

    public function show($id)
    {
        $driverAd = DriverAd::where('id', $id)->first();
        if (!$driverAd) {
            return redirect()->back()->with('error', 'Driver Ad not found');
        }
        $data['driverAd'] = $driverAd;
        $data['responses'] = DriverResponse::where('driver_ad_id', $driverAd->id)->get();
        return view('admin/driver_ads/driver_ads_details', $data);
    }

    public function responseDetails(Request $request)
    {
        $response = DriverResponse::where('id', $request->id)->first();
        if (!empty($response)) {
            $htmlresult = view('admin/driver_ads/response_ajax', compact('response'))->render();
            $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
            return $finalResult;
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Response not found.']);
        }
    }
}
