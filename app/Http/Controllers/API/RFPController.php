<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RFP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RFPController extends Controller
{
    public function show($id)
    {
        $rfp = RFP::where('id', $id)->first();
        if ($rfp) {
            $rfp->doc_1 = $rfp->doc_1 ? url('public/uploads/rfp_docs/' . $rfp->doc_1) : null;
            $rfp->doc_2 = $rfp->doc_2 ? url('public/uploads/rfp_docs/' . $rfp->doc_2) : null;
            $rfp->user = $rfp->user;
            $rfp->company = $rfp->user->company;
            return response()->json(['msg' => 'success', 'response' => 'RFP retrieved successfully', 'RFP' => $rfp], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'RFP not found'], 200);
        }
    }

    public function store(Request $request)
    {
        // Company did not allow this user to edit RFP
        if (Auth::user()->is_major_user == 0 && Auth::user()->has_post_func == 0) {
            return response()->json(['msg' => 'error', 'response' => 'You dont have previllige to post RFP.'], 401);
        }

        $validator = Validator::make($request->all(), [
            'route_type' => 'required',
            'multiple_routes' => 'required',
            'vehicle_type' => 'required',
            'start_point' => 'required',
            'delivery_point' => 'required',
            'frequency' => 'required',
            'payment_terms' => 'required',
            'insurance_coverage' => 'required',
            'bid_due' => 'required',
            'contact_company' => 'required',
            'contact_name' => 'required',
            'contact_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $frequency = '';
        if ($request->monday && $request->monday == 1) {
            $frequency .= 'monday, ';
        }
        if ($request->tuesday && $request->tuesday == 1) {
            $frequency .= 'tuesday, ';
        }
        if ($request->wednesday && $request->wednesday == 1) {
            $frequency .= 'wednesday, ';
        }
        if ($request->thursday && $request->thursday == 1) {
            $frequency .= 'thursday, ';
        }
        if ($request->friday && $request->friday == 1) {
            $frequency .= 'friday, ';
        }
        if ($request->saturday && $request->saturday == 1) {
            $frequency .= 'saturday, ';
        }
        if ($request->sunday && $request->sunday == 1) {
            $frequency .= 'sunday, ';
        }

        $frequency .= $request->frequency;
        $start_zip = substr($request->start_point, 0, 5);
        $start_addr = calculate_address($start_zip);
        $start_city = $start_addr['city'] ?? null;
        $start_state = $start_addr['state'] ?? null;
        $cordinates = return_cordinates($start_zip);
        $mileage = mileageCalculator($request->start_point, $request->delivery_point);

        $rfp = new RFP();
        $rfp->route_type = $request->route_type;
        $rfp->multiple_routes = $request->multiple_routes;
        $rfp->vehicle_type = $request->vehicle_type;
        $rfp->reefer = $request->reefer &&  $request->reefer == 1 ? 1 : 0;
        $rfp->hazmat = $request->hazmat &&  $request->hazmat == 1 ? 1 : 0;
        $rfp->lift_gate = $request->lift_gate &&  $request->lift_gate == 1 ? 1 : 0;
        $rfp->start_point = $request->start_point;
        $rfp->delivery_point = $request->delivery_point;
        $rfp->description = $request->description ?? null;
        $rfp->frequency = $frequency;
        $rfp->estimated_mileage = $mileage;
        $rfp->payment_terms = $request->payment_terms;
        $rfp->insurance_coverage = $request->insurance_coverage;
        $rfp->bid_per_stop = $request->bid_per_stop &&  $request->bid_per_stop == 1 ? 1 : 0;
        $rfp->bid_per_route = $request->bid_per_route &&  $request->bid_per_route == 1 ? 1 : 0;
        $rfp->other_requirements = $request->other_requirements ?? null;
        $rfp->bid_due = $request->bid_due;
        $rfp->contact_company = $request->contact_company;
        $rfp->contact_name = $request->contact_name;
        $rfp->contact_phone = $request->contact_phone;
        $rfp->contact_email = $request->contact_email ?? Auth::user()->email;
        $rfp->user_id = Auth::user()->id;
        $rfp->start_city = $start_city;
        $rfp->start_state = $start_state;
        $rfp->start_zip = $start_zip;
        $rfp->lat = $cordinates['lat'] ?? null;
        $rfp->long = $cordinates['lng'] ?? null;
        $rfp->recipients = $request->recipients ?? null;

        if ($request->hasFile('doc_1')) {
            $doc_1 = $request->file('doc_1');
            $extension = $doc_1->getClientOriginalExtension();
            $filename = rand(1, 9999) . time() . '.' . $extension;
            $doc_1->move(public_path('uploads/rfp_docs'), $filename);
            $rfp->doc_1 = $filename;
        }

        if ($request->hasFile('doc_2')) {
            $doc_2 = $request->file('doc_2');
            $extension = $doc_2->getClientOriginalExtension();
            $filename = rand(1, 9999) . time() . '.' . $extension;
            $doc_2->move(public_path('uploads/rfp_docs'), $filename);
            $rfp->doc_2 = $filename;
        }

        $query = $rfp->save();
        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Recurring Freight Post submitted successfully', 'RFP' => $rfp], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Recurring Freight Post submission failed'], 200);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rfp_id' => 'required',
            'route_type' => 'required',
            'multiple_routes' => 'required',
            'vehicle_type' => 'required',
            'start_point' => 'required',
            'delivery_point' => 'required',
            'frequency' => 'required',
            'payment_terms' => 'required',
            'insurance_coverage' => 'required',
            'bid_due' => 'required',
            'contact_company' => 'required',
            'contact_name' => 'required',
            'contact_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $rfp = RFP::where('id', $request->rfp_id)->first();

        // RFP does not exist
        if (!$rfp) {
            return response()->json(['msg' => 'error', 'response' => 'RFP not found.'], 404);
        }
        // Not same company as the one posting the RFP
        $company = $rfp->user->company;
        if (Auth::user()->company->id != $company->id) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to update RFP by this company.'], 401);
        }
        // Company did not allow this user to edit RFP
        if (Auth::user()->is_major_user == 0 && Auth::user()->has_post_func == 0) {
            return response()->json(['msg' => 'error', 'response' => 'You dont have previllige to update this RFP.'], 401);
        }

        $frequency = '';
        if ($request->monday && $request->monday == 1) {
            $frequency .= 'monday, ';
        }
        if ($request->tuesday && $request->tuesday == 1) {
            $frequency .= 'tuesday, ';
        }
        if ($request->wednesday && $request->wednesday == 1) {
            $frequency .= 'wednesday, ';
        }
        if ($request->thursday && $request->thursday == 1) {
            $frequency .= 'thursday, ';
        }
        if ($request->friday && $request->friday == 1) {
            $frequency .= 'friday, ';
        }
        if ($request->saturday && $request->saturday == 1) {
            $frequency .= 'saturday, ';
        }
        if ($request->sunday && $request->sunday == 1) {
            $frequency .= 'sunday, ';
        }

        $frequency .= $request->frequency;
        $start_zip = substr($request->start_point, 0, 5);
        $start_addr = calculate_address($start_zip);
        $start_city = $start_addr['city'] ?? null;
        $start_state = $start_addr['state'] ?? null;
        $cordinates = return_cordinates($start_zip);
        $mileage = mileageCalculator($request->start_point, $request->delivery_point);

        $rfp->route_type = $request->route_type;
        $rfp->multiple_routes = $request->multiple_routes;
        $rfp->vehicle_type = $request->vehicle_type;
        $rfp->reefer = $request->reefer &&  $request->reefer == 1 ? 1 : 0;
        $rfp->hazmat = $request->hazmat &&  $request->hazmat == 1 ? 1 : 0;
        $rfp->lift_gate = $request->lift_gate &&  $request->lift_gate == 1 ? 1 : 0;
        $rfp->start_point = $request->start_point;
        $rfp->delivery_point = $request->delivery_point;
        $rfp->description = $request->description ?? null;
        $rfp->frequency = $frequency;
        $rfp->estimated_mileage = $mileage;
        $rfp->payment_terms = $request->payment_terms;
        $rfp->insurance_coverage = $request->insurance_coverage;
        $rfp->bid_per_stop = $request->bid_per_stop &&  $request->bid_per_stop == 1 ? 1 : 0;
        $rfp->bid_per_route = $request->bid_per_route &&  $request->bid_per_route == 1 ? 1 : 0;
        $rfp->other_requirements = $request->other_requirements ?? null;
        $rfp->bid_due = $request->bid_due;
        $rfp->contact_company = $request->contact_company;
        $rfp->contact_name = $request->contact_name;
        $rfp->contact_phone = $request->contact_phone;
        $rfp->contact_email = $request->contact_email ?? $rfp->contact_email;
        $rfp->start_city = $start_city;
        $rfp->start_state = $start_state;
        $rfp->start_zip = $start_zip;
        $rfp->lat = $cordinates['lat'] ?? null;
        $rfp->long = $cordinates['lng'] ?? null;
        $rfp->recipients = $request->recipients ?? null;

        if ($request->hasFile('doc_1')) {
            $file_path = public_path('uploads/neighborhoods/' . $rfp->doc_1);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $doc_1 = $request->file('doc_1');
            $extension = $doc_1->getClientOriginalExtension();
            $filename = rand(1, 9999) . time() . '.' . $extension;
            $doc_1->move(public_path('uploads/rfp_docs'), $filename);
            $rfp->doc_1 = $filename;
        }

        if ($request->hasFile('doc_2')) {
            $file_path = public_path('uploads/neighborhoods/' . $rfp->doc_2);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            $doc_2 = $request->file('doc_2');
            $extension = $doc_2->getClientOriginalExtension();
            $filename = rand(1, 9999) . time() . '.' . $extension;
            $doc_2->move(public_path('uploads/rfp_docs'), $filename);
            $rfp->doc_2 = $filename;
        }

        $query = $rfp->save();

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Recurring Freight Post updated successfully', 'RFP' => $rfp], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Recurring Freight Post updation failed'], 200);
        }
    }

    public function allByUser()
    {
        $user = Auth::user();

        $rfps = RFP::where('user_id', $user->id)->get();

        // if no RFPs found
        if (count($rfps) == 0) {
            return response()->json(['msg' => 'error', 'response' => 'No RFPs found'], 200);
        }

        foreach ($rfps as $rfp) {
            $rfp->doc_1 = $rfp->doc_1 ? url('public/uploads/rfp_docs/' . $rfp->doc_1) : null;
            $rfp->doc_2 = $rfp->doc_2 ? url('public/uploads/rfp_docs/' . $rfp->doc_2) : null;
            $rfp->user = $rfp->user;
            $rfp->company = $rfp->user->company;
        }

        return response()->json(['msg' => 'success', 'response' => 'RFPs retrieved successfully', 'RFPs' => $rfps], 200);
    }

    public function allByCompany($company_id)
    {
        // get all users from company with company_id
        $users = User::where('company_id', $company_id)->get();

        if (count($users) == 0) {
            return response()->json(['msg' => 'error', 'response' => 'No users found in this company'], 200);
        }

        // get all rfps where user_id is any  from $users

        $rfps = RFP::whereIn('user_id', $users->pluck('id'))->get();

        if (count($rfps) == 0) {
            return response()->json(['msg' => 'error', 'response' => 'No RFPs found for this company'], 200);
        }

        foreach ($rfps as $rfp) {
            $rfp->doc_1 = $rfp->doc_1 ? url('public/uploads/rfp_docs/' . $rfp->doc_1) : null;
            $rfp->doc_2 = $rfp->doc_2 ? url('public/uploads/rfp_docs/' . $rfp->doc_2) : null;
            $rfp->user = $rfp->user;
            $rfp->company = $rfp->user->company;
        }

        return response()->json(['msg' => 'success', 'response' => 'RFPs retrieved successfully', 'RFPs' => $rfps], 200);
    }

    public function searchRFP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_city' => 'required',
            'vehicle_type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->has('start_zip') && $request->has('radius')) {
            $cordinates = return_cordinates($request->start_zip);
            if(!$cordinates) {
                return response()->json(['msg' => 'error', 'response' => 'Invalid Zip Code or no response from API'], 200);
            }
            $radius = $request->radius;
            $latLngRange = $this->calculateLatLngRange($cordinates, $radius);

            $rfps = RFP::where('start_city', $request->start_city)
                ->where('vehicle_type', $request->vehicle_type)
                ->whereBetween('lat', [$latLngRange['lat_min'], $latLngRange['lat_max']])
                ->whereBetween('long', [$latLngRange['lng_min'], $latLngRange['lng_max']])
                ->get();
        } else if ($request->has('start_city') && $request->has('start_state')) {
            $rfps = RFP::where('start_city', $request->start_city)
                ->where('start_state', $request->start_state)
                ->where('vehicle_type', $request->vehicle_type)
                ->get();
        } else {
            $rfps = RFP::where('start_city', $request->start_city)
                ->where('vehicle_type', $request->vehicle_type)
                ->get();
        }

        if (count($rfps) == 0) {
            return response()->json(['msg' => 'error', 'response' => 'No RFPs found for the entered parameters.'], 200);
        }

        foreach ($rfps as $rfp) {
            $rfp->doc_1 = $rfp->doc_1 ? url('public/uploads/rfp_docs/' . $rfp->doc_1) : null;
            $rfp->doc_2 = $rfp->doc_2 ? url('public/uploads/rfp_docs/' . $rfp->doc_2) : null;
            $rfp->user = $rfp->user;
            $rfp->company = $rfp->user->company;
        }

        return response()->json(['msg' => 'success', 'response' => 'RFPs retrieved successfully', 'RFPs' => $rfps], 200);
    }

    private function calculateLatLngRange($coordinates, $radius)
    {
        $lat = $coordinates['lat'];
        $lng = $coordinates['lng'];

        // Radius of the Earth in miles
        $earthRadius = 3959;

        // Latitude range
        $latRange = $radius / $earthRadius;
        $latMin = $lat - rad2deg($latRange);
        $latMax = $lat + rad2deg($latRange);

        // Longitude range (adjusted for the latitude)
        $lngRange = $radius / ($earthRadius * cos(deg2rad($lat)));
        $lngMin = $lng - rad2deg($lngRange);
        $lngMax = $lng + rad2deg($lngRange);

        return [
            'lat_min' => $latMin,
            'lat_max' => $latMax,
            'lng_min' => $lngMin,
            'lng_max' => $lngMax,
        ];
    }
}
