<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Filing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilingsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'post_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $table = '';
        switch ($request->type) {
            case 0:
                $table = 'companies';
                break;
            case 1:
                $table = 'quote_requests';
                break;
            case 2:
                $table = 'vehicles';
                break;
            case 3:
                $table = 'rfps';
                break;
            default:
                return response()->json(['msg' => 'error', 'response' => 'Invalid type!'], 400);
        }

        $query = DB::table($table);
        $query->where('id', $request->post_id);
        $post = $query->first();

        if (empty($post)) {
            return response()->json(['msg' => 'error', 'response' => 'Invalid Post ID no such record in required table.'], 404);
        }


        $user = Auth::user();
        $company = $user->company;
        $filing = new Filing();
        $filing->company_id = $company->id;
        $filing->user_id = $user->id;
        $filing->post_id = $request->post_id;
        $filing->type = $request->type;
        $filing->city = $request->city ?? 'N/A';
        $filing->state = $request->state ?? 'N/A';
        $filing->note = $request->note ?? 'N/A';
        $query = $filing->save();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Somehting went wrong! Please try again later.'], 400);
        } else {
            return response()->json(['msg' => 'success', 'response' => 'Filing has been added to the filing cabinet successfully!', 'data' => $filing], 200);
        }
    }

    public function addNote(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filings' => 'required',
            'note' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = Auth::user();
        $company = $user->company;
        $request->filings = json_decode($request->filings, true);

        $filings = Filing::whereIn('id', $request->filings)
            ->where('company_id', $company->id)
            ->get();

        if (count($filings) !== count($request->filings)) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to add note to some of these filings.'], 401);
        }

        $updated = Filing::whereIn('id', $request->filings)
            ->update(['note' => $request->note]);

        if ($updated) {
            $filings = Filing::where('company_id', $company->id)
                ->where('type', $request->type)
                ->get();
            $table = getFilingTable($request->type);
            if ($table == null) {
                return response()->json(['msg' => 'success', 'response' => 'Note added successfully', 'data' => []], 200);
            }
            foreach ($filings as $filing) {
                $filing->post = DB::table($table)->where('id', $filing->post_id)->first();
            }
            return response()->json(['msg' => 'success', 'response' => 'Note added to the filings successfully!', 'data' => $filings], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Something went wrong! Please try again later.'], 400);
        }
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'filings' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();
        $company = $user->company;
        $request->filings = json_decode($request->filings, true);

        $filings = Filing::whereIn('id', $request->filings)
            ->where('company_id', $company->id)
            ->get();

        if (count($filings) !== count($request->filings)) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to delete some of these filings.'], 401);
        }

        $deleted = Filing::whereIn('id', $request->filings)
            ->delete();

        if ($deleted) {
            $filings = Filing::where('company_id', $company->id)
                ->where('type', $request->type)
                ->get();
            $table = getFilingTable($request->type);
            if ($table == null) {
                return response()->json(['msg' => 'success', 'response' => 'Note added successfully', 'data' => []], 200);
            }
            foreach ($filings as $filing) {
                $filing->post = DB::table($table)->where('id', $filing->post_id)->first();
            }
            return response()->json(['msg' => 'success', 'response' => 'Filings deleted successfully!', 'data' => $filings], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Something went wrong! Please try again later.'], 400);
        }
    }
    public function getCompanyFilings()
    {
        $user = Auth::user();
        $company = $user->company;
        $type = 0;

        $filings = Filing::where('company_id', $company->id)
            ->where('type', $type)
            ->get();

        if (empty($filings)) {
            return response()->json(['msg' => 'error', 'response' => 'No Records Found'], 404);
        }

        foreach ($filings as $filing) {
            $filing->post = DB::table('companies')->where('id', $filing->post_id)->first();
        }

        return response()->json(['msg' => 'success', 'response' => 'Company Filings Retreived Successfully', 'data' => $filings], 200);
    }

    public function getQuoteFilings()
    {
        $user = Auth::user();
        $company = $user->company;
        $type = 1;

        $filings = Filing::where('company_id', $company->id)
            ->where('type', $type)
            ->get();

        if (empty($filings)) {
            return response()->json(['msg' => 'error', 'response' => 'No Records Found'], 404);
        }

        foreach ($filings as $filing) {
            $filing->post = DB::table('quote_requests')->where('id', $filing->post_id)->first();
        }

        return response()->json(['msg' => 'success', 'response' => 'Quote Requests Filings Retreived Successfully', 'data' => $filings], 200);
    }

    public function getRFPFilings()
    {
        $user = Auth::user();
        $company = $user->company;
        $type = 3;

        $filings = Filing::where('company_id', $company->id)
            ->where('type', $type)
            ->get();

        if (empty($filings)) {
            return response()->json(['msg' => 'error', 'response' => 'No Records Found'], 404);
        }

        foreach ($filings as $filing) {
            $filing->post = DB::table('rfps')->where('id', $filing->post_id)->first();
        }

        return response()->json(['msg' => 'success', 'response' => 'RFPS Filings Retreived Successfully', 'data' => $filings], 200);
    }
}
