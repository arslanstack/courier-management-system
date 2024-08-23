<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DriverAd;
use App\Models\DriverResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DriverResponseController extends Controller
{
    public function allReceived()
    {
        $driverResponses = DriverResponse::whereHas('driverAd', function ($query) {
            $query->where('company_id', Auth::user()->company_id);
        })->with('driverAd')->with('user')->get();
        return response()->json(['msg' => 'success', 'response' => 'Data retreived successfully', 'data' => $driverResponses], 200);
    }

    public function allSent(Request $request)
    {
        $driverResponses = DriverResponse::where('company_id', Auth::user()->company_id)->with('driverAd')->get();
        return response()->json(['msg' => 'success', 'response' => 'Data retreived successfully', 'data' => $driverResponses], 200);
    }

    public function show($id)
    {
        $driverResponse = DriverResponse::where('id', $id)->with('driverAd')->with('user')->first();
        if (!$driverResponse) {
            return response()->json(['msg' => 'error', 'response' => 'Response not found'], 404);
        }
        return response()->json(['msg' => 'success', 'response' => 'Data retreived successfully.', 'data' => $driverResponse], 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'driver_ad_id' => 'required',
            'name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'vehicle_types' => 'required',
            'message' => 'required',
            'contact_email' => 'required',
            'contact_phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $driverAd = DriverAd::find($request->driver_ad_id);

        if (!$driverAd) {
            return response()->json(['msg' => 'error', 'response' => 'Driver Ad not found'], 404);
        }

        if (Auth::user()->company_id == $driverAd->company_id) {
            return response()->json(['msg' => 'error', 'response' => 'You cannot respond to your own ad.'], 401);
        }

        $driverResponse = new DriverResponse();
        $driverResponse->driver_ad_id = $request->driver_ad_id;
        $driverResponse->company_id = Auth::user()->company_id;
        $driverResponse->user_id = Auth::id();
        $driverResponse->name = $request->name;
        $driverResponse->city = $request->city;
        $driverResponse->state = $request->state;
        $driverResponse->vehicle_types = $request->vehicle_types;
        $driverResponse->contact_email = $request->contact_email;
        $driverResponse->contact_phone = $request->contact_phone;
        $driverResponse->message = $request->message;
        $driverResponse->status = 1;
        $query = $driverResponse->save();
        // Send Mails if asked in future
        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Response submitted successfully'], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Error submitting response'], 500);
        }
    }
}
