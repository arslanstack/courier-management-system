<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DriverAd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DriverAdController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $company = $user->company;
        $driverAds = DriverAd::where('company_id', $company->id)->get();
        foreach ($driverAds as $driverAd) {
            if ($driverAd->show_company_name != 0) {
                $driverAd->company;
                if ($driverAd->company_logo) {
                    $driverAd->company_logo = url('public/uploads/driver_ads/' . $driverAd->company_logo);
                }
            } else {
                unset($driverAd->company_name);
                unset($driverAd->company_logo);
            }
        }
        return response()->json(['msg' => 'success', 'response' => 'Driver Ads retrieved successfully', 'data' => $driverAds], 200);
    }

    public function show(Request $request){
        $driverAd = DriverAd::find($request->id);
        if ($driverAd) {
            if ($driverAd->show_company_name != 0) {
                $driverAd->company;
                if ($driverAd->company_logo) {
                    $driverAd->company_logo = url('public/uploads/driver_ads/' . $driverAd->company_logo);
                }
            } else {
                unset($driverAd->company_name);
                unset($driverAd->company_logo);
            }
            $driverAd->responses;
            $driverAd->responses->map(function ($response) {
                $response->company;
                $response->user;
            });
            return response()->json(['msg' => 'success', 'response' => 'Driver Ad retrieved successfully', 'data' => $driverAd], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Driver Ad not found'], 404);
        }
    }

    public function showRecent(){
        $driverAds = DriverAd::orderBy('created_at', 'desc')->paginate(10);
        foreach ($driverAds as $driverAd) {
            if ($driverAd->show_company_name != 0) {
                $driverAd->company;
                if ($driverAd->company_logo) {
                    $driverAd->company_logo = url('public/uploads/driver_ads/' . $driverAd->company_logo);
                }
            } else {
                unset($driverAd->company_name);
                unset($driverAd->company_logo);
            }
        }
        return response()->json(['msg' => 'success', 'response' => 'Recent Driver Ads retrieved successfully', 'data' => $driverAds], 200);
    }

    public function search(Request $request){
        $validator = Validator::make($request->all(), [
            'city' => 'required',
            'state' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $driverAds = DriverAd::where('city', $request->city)->where('state', $request->state);
        if($request->has('zip')){
            $driverAds->where('zip', $request->zip);
        }

        $driverAds = $driverAds->get();

        if($driverAds->count() > 0){
            foreach ($driverAds as $driverAd) {
                if ($driverAd->show_company_name != 0) {
                    $driverAd->company;
                    if ($driverAd->company_logo) {
                        $driverAd->company_logo = url('public/uploads/driver_ads/' . $driverAd->company_logo);
                    }
                } else {
                    unset($driverAd->company_name);
                    unset($driverAd->company_logo);
                }
            }
            return response()->json(['msg' => 'success', 'response' => 'Driver Ads retrieved successfully', 'data' => $driverAds], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'No Driver Ads found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'compensation' => 'required',
            'compensation_type' => 'required',
            'vehicle_types' => 'required',
            'reefer' => 'required',
            'hazmat' => 'required',
            'lift_gate' => 'required',
            'tsa_certified' => 'required',
            'city' => 'required',
            'state' => 'required',
            'experience' => 'required',
            'insurance_coverage' => 'required',
            'company_name' => 'required',
            'show_company_name' => 'required',
            'ad_title' => 'required',
            'description' => 'required',
            'contact_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $driverAd = new DriverAd();
        $driverAd->user_id = Auth::user()->id;
        $driverAd->company_id = Auth::user()->company_id;
        $driverAd->type = $request->type;
        $driverAd->compensation = $request->compensation;
        $driverAd->compensation_type = $request->compensation_type;
        $driverAd->vehicle_types = $request->vehicle_types;
        $driverAd->reefer = $request->reefer;
        $driverAd->hazmat = $request->hazmat;
        $driverAd->lift_gate = $request->lift_gate;
        $driverAd->tsa_certified = $request->tsa_certified;
        $driverAd->city = $request->city;
        $driverAd->state = $request->state;
        $driverAd->zip = $request->zip ?? null;
        $driverAd->experience = $request->experience;
        $driverAd->insurance_coverage = $request->insurance_coverage;
        $driverAd->show_company_name = $request->show_company_name;
        $driverAd->ad_title = $request->ad_title;
        $driverAd->description = $request->description;

        if ($request->has('response_info')) {
            $driverAd->response_info = $request->response_info;
        }

        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = str_replace(' ', '-', Auth::user()->company->name) . rand(0000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move('public/uploads/driver_ads', $filename);
            $driverAd->company_logo = $filename;
        }

        $driverAd->contact_email = $request->contact_email;

        if ($request->has('div_id')) {
            $driverAd->div_id = $request->div_id;
        }

        $query = $driverAd->save();

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Driver Ad created successfully', 'data' => $driverAd], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Something went wrong'], 500);
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'driver_ad_id' => 'required',
            'type' => 'required',
            'compensation' => 'required',
            'compensation_type' => 'required',
            'vehicle_types' => 'required',
            'reefer' => 'required',
            'hazmat' => 'required',
            'lift_gate' => 'required',
            'tsa_certified' => 'required',
            'city' => 'required',
            'state' => 'required',
            'experience' => 'required',
            'insurance_coverage' => 'required',
            'company_name' => 'required',
            'show_company_name' => 'required',
            'ad_title' => 'required',
            'description' => 'required',
            'contact_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $driverAd = DriverAd::find($request->driver_ad_id);

        if(!$driverAd){
            return response()->json(['msg' => 'error', 'response' => 'Driver Ad not found'], 404);
        }

        if($driverAd->company_id != Auth::user()->company_id){
            return response()->json(['msg' => 'error', 'response' => 'Unauthorized'], 401);
        }

        $driverAd->type = $request->type;
        $driverAd->compensation = $request->compensation;
        $driverAd->compensation_type = $request->compensation_type;
        $driverAd->vehicle_types = $request->vehicle_types;
        $driverAd->reefer = $request->reefer;
        $driverAd->hazmat = $request->hazmat;
        $driverAd->lift_gate = $request->lift_gate;
        $driverAd->tsa_certified = $request->tsa_certified;
        $driverAd->city = $request->city;
        $driverAd->state = $request->state;
        $driverAd->zip = $request->zip ?? null;
        $driverAd->experience = $request->experience;
        $driverAd->insurance_coverage = $request->insurance_coverage;
        $driverAd->show_company_name = $request->show_company_name;
        $driverAd->ad_title = $request->ad_title;
        $driverAd->description = $request->description;
        if ($request->has('response_info')) {
            $driverAd->response_info = $request->response_info;
        } else {
            $driverAd->response_info = null;
        }

        if ($request->hasFile('company_logo')) {
            // delete existing file 
            if ($driverAd->company_logo) {
                $file_path = 'public/uploads/driver_ads/' . $driverAd->company_logo;
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
            $file = $request->file('company_logo');
            $filename = str_replace(' ', '-', Auth::user()->company->name) . rand(0000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move('public/uploads/driver_ads', $filename);
            $driverAd->company_logo = $filename;
        }

        $driverAd->contact_email = $request->contact_email;

        if ($request->has('div_id')) {
            $driverAd->div_id = $request->div_id;
        } else {
            $driverAd->div_id = null;
        }

        $query = $driverAd->save();

        if($query){
            return response()->json(['msg' => 'success', 'response' => 'Driver Ad updated successfully', 'data' => $driverAd], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Something went wrong'], 500);
        }

    }
}
