<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Carbon\Month;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WarehouseController extends Controller
{
    public function index() {
        $user = Auth::user();
        $company = $user->company;

        $warehouses = Warehouse::where('company_id', $company->id)->get();
        if($warehouses->count() == 0) {
            return response()->json(['msg' => 'error', 'response' => 'No Warehouses Found'], 200);
        }

        return response()->json(['msg' => 'success', 'response' => 'Warehouses retreived successfully.', 'data' => $warehouses], 200);
    }

    public function show($id) {
        $warehouse = Warehouse::where('id', $id)->first();
        if(!$warehouse) {
            return response()->json(['msg' => 'error', 'response' => 'Warehouse not found'], 200);
        }
        return response()->json(['msg' => 'success', 'response' => 'Warehouse retreived successfully.', 'data' => $warehouse], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $addr = warehouse_address_finder($request->zip);
        $warehouse = new Warehouse();
        $warehouse->name = $request->name;
        $warehouse->company_id = Auth::user()->company->id;
        $warehouse->city = $addr['city'] ?? $request->city;
        $warehouse->state = $addr['state'] ?? $request->state;
        $warehouse->country = $addr['country'] ?? $request->country;
        $warehouse->zip = $request->zip;
        $warehouse->lat = $addr['lat'] ?? null;
        $warehouse->long = $addr['lng'] ?? null;
        $query = $warehouse->save();

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Company Warehouse added successfully.', 'data' => $warehouse], 200);
        }

        return response()->json(['msg' => 'error', 'response' => 'Something went wrong.'], 200);  
    }

    public function update(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip' => 'required',
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $warehouse = Warehouse::where('id', $request->id)->first();
        if(!$warehouse) {
            return response()->json(['msg' => 'error', 'response' => 'Warehouse not found'], 200);
        }

        $addr = warehouse_address_finder($request->zip);
        $warehouse->name = $request->name;
        $warehouse->city = $addr['city'] ?? $request->city;
        $warehouse->state = $addr['state'] ?? $request->state;
        $warehouse->country = $addr['country'] ?? $request->country;
        $warehouse->zip = $request->zip;
        $warehouse->lat = $addr['lat'] ?? null;
        $warehouse->long = $addr['lng'] ?? null;
        $query = $warehouse->save();

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Company Warehouse updated successfully.', 'data' => $warehouse], 200);
        }

        return response()->json(['msg' => 'error', 'response' => 'Something went wrong.'], 200);
    }
}

