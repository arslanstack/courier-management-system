<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\CompanyAirports;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    public function index()
    {
        $airports = Airport::all();
        if ($airports->count() == 0) {
            return response()->json(['msg' => 'error', 'response' => 'No Airports Found'], 200);
        }
        return response()->json(['msg' => 'success', 'response' => 'Airports retreived successfully.', 'data' => $airports], 200);
    }

    public function getCompanyAirports(){
        $companyAirports = CompanyAirports::where('company_id', Auth::user()->company->id)->get();
        if ($companyAirports->count() == 0) {
            return response()->json(['msg' => 'error', 'response' => 'No Airports Found'], 200);
        }
        foreach($companyAirports as $companyAirport){
            $airport = Airport::where('id', $companyAirport->airport_id)->first();
            $companyAirport->airport = $airport;
        }
        return response()->json(['msg' => 'success', 'response' => 'Company Airports retreived successfully.', 'data' => $companyAirports], 200);
    }

    public function show($id)
    {
        $airport = Airport::where('id', $id)->first();
        if (!$airport) {
            return response()->json(['msg' => 'error', 'response' => 'Airport not found'], 200);
        }
        return response()->json(['msg' => 'success', 'response' => 'Airport retreived successfully.', 'data' => $airport], 200);
    }

    public function getCompanyAirportDetails($id){
        $companyAirport = CompanyAirports::where('id', $id)->first();
        if (!$companyAirport) {
            return response()->json(['msg' => 'error', 'response' => 'Company Airport not found'], 200);
        }
        $airport = Airport::where('id', $companyAirport->airport_id)->first();
        $companyAirport->airport = $airport;
        $companyAirport->company = Auth::user()->company;
        return response()->json(['msg' => 'success', 'response' => 'Company Airport retreived successfully.', 'data' => $companyAirport], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'airport_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'error', 'response' => $validator->errors()], 200);
        }

        $airport = Airport::where('id', $request->airport_id)->first();

        if (!$airport) {
            return response()->json(['msg' => 'error', 'response' => 'Airport already exists'], 200);
        }

        $authUser = Auth::user();
        $companyAirport = new CompanyAirports();
        $companyAirport->company_id = Auth::user()->company->id;
        $companyAirport->airport_id = $request->airport_id;
        $query = $companyAirport->save();
        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Error saving airport'], 200);
        }
        return response()->json(['msg' => 'success', 'response' => 'Company Airport added successfully.'], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'airport_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'error', 'response' => $validator->errors()], 200);
        }

        $airport = Airport::where('id', $request->airport_id)->first();

        if (!$airport) {
            return response()->json(['msg' => 'error', 'response' => 'Airport already exists'], 200);
        }

        $authUser = Auth::user();
        $company = Auth::user()->company;
        $companyAirport = CompanyAirports::where('company_id', $company->id)->where('airport_id', $request->airport_id)->first();
        if (!$companyAirport) {
            return response()->json(['msg' => 'error', 'response' => 'Airport not found'], 200);
        }
        if($companyAirport->operation_active == 1){
            $companyAirport->operation_active = 0;
            $query = $companyAirport->save();
            if($query){
                return response()->json(['msg' => 'success', 'response' => 'Operation Status Deactivated Successfully'], 200);
            } else {
                return response()->json(['msg' => 'error', 'response' => 'Error Deactivating Operation Status'], 200);
            }
        } else if($companyAirport->operation_active == 0){
            $companyAirport->operation_active = 1;
            $query = $companyAirport->save();
            if($query){
                return response()->json(['msg' => 'success', 'response' => 'Operation Status Activated Successfully'], 200);
            } else {
                return response()->json(['msg' => 'error', 'response' => 'Error Activating Operation Status'], 200);
            }
        }
    }
}
