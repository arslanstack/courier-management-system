<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    public function index(Request $request)
    {
        $query = Airport::query();
        $search_query = $request->input('search_query');
        if (($request->has('search_query') && !empty($search_query))) {
            $query->where(function ($query) use ($search_query) {
                $query->where('name', 'like', '%' . $search_query . '%')
                    ->orWhere('city', 'like', '%' . $search_query . '%')
                    ->orWhere('country', 'like', '%' . $search_query . '%')
                    ->orWhere('code', 'like', '%' . $search_query . '%');
            });
        }
        $data['airports'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/airports/manage_airports', $data);
    }

    public function show(Request $request)
    {
        $airport = Airport::where('id', $request->id)->first();
        if (!empty($airport)) {
            $htmlresult = view('admin/airports/airport_ajax', compact('airport'))->render();
            $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
            return $finalResult;
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Airport not found.']);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $airport = new Airport();
        $airport->name = $request->name ?? null;
        $airport->code = $request->code;
        $airport->city = $request->city ?? null;
        $airport->country = $request->country ?? null;
        $query = $airport->save();
        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Airport added successfully!', 'airport' => $airport], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Failed to add airport!'], 400);
        }
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'error', 'response' => 'The following fields are required: ' . implode(', ', array_keys($validator->errors()->messages()))]);
        }
        $airport = Airport::where('id', $request->id)->first();
        if (!empty($airport)) {
            $airport->name = $request->name ?? null;
            $airport->code = $request->code;
            $airport->city = $request->city ?? null;
            $airport->country = $request->country ?? null;
            $query = $airport->save();
            if($query){
                return response()->json(['msg' => 'success', 'response' => 'Airport updated successfully!', 'airport' => $airport], 200);
            } else {
                return response()->json(['msg' => 'error', 'response' => 'Failed to update airport!'], 400);
            }
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Airport not found.']);
        }
    }
    public function delete(Request $request)
    {
        $airport = Airport::find($request->id);
        if (!empty($airport)) {
            $airport->delete();
            return response()->json(['msg' => 'success', 'response' => 'Airport deleted successfully.']);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Airport not found.']);
        }
    }
}
