<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\RFP;
use App\Models\RFPBid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RFPBidsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'rfp_id' => 'required',
            'amount' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'contact_email' => 'required',
            'terms' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $rfp = RFP::where('id', $request->rfp_id)->first();

        if (!$rfp) {
            return response()->json(['msg' => 'error', 'response' => 'RFP not found'], 404);
        }
        $user_id = Auth::id();
        $company = Auth::user()->company;
        $company_id = $company->id;

        if ($company->id == $rfp->user->company->id) {
            return response()->json(['msg' => 'error', 'response' => 'You cannot bid on your own RFP'], 401);
        }

        if ($company->company_type != 3) {
            return response()->json(['msg' => 'error', 'response' => 'Only Courier Companies can bid on RFP'], 401);
        }

        $rfp_bid = new RFPBid();
        $rfp_bid->rfp_id = $request->rfp_id;
        $rfp_bid->user_id = $user_id;
        $rfp_bid->company_id = $company_id;
        $rfp_bid->amount = $request->amount;
        $rfp_bid->contact_name = $request->contact_name;
        $rfp_bid->contact_phone = $request->contact_phone;
        $rfp_bid->contact_email = $request->contact_email;
        $rfp_bid->terms = $request->terms;
        $query = $rfp_bid->save();

        $maildata = [
            'rfp' => $rfp,
            'rfp_bid' => $rfp_bid
        ];

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'RFP Bid submitted successfully'], 200);
        }
        // Mail Bhijwani hain
        return response()->json(['msg' => 'error', 'response' => 'RFP Bid not submitted'], 500);
    }

    public function show($rfp_id)
    {
        $rfp = RFP::where('id', $rfp_id)->first();
        if (!$rfp) {
            return response()->json(['msg' => 'error', 'response' => 'RFP not found'], 404);
        }

        $rfp_bids = RFPBid::where('rfp_id', $rfp_id)->get();
        if ($rfp_bids->count() > 0) {
            foreach ($rfp_bids as $rfp_bid) {
                $rfp_bid->user = $rfp_bid->user;
                $rfp_bid->company = $rfp_bid->company;
            }
            return response()->json(['msg' => 'success', 'response' => 'RFP Bids retrieved successfully.', 'data' => $rfp_bids], 200);
        }

        return response()->json(['msg' => 'success', 'response' => 'No RFP Bids Submitted Yet'], 200);
    }

    public function showByCompany($company_id)
    {
        $company = Company::where('id', $company_id)->first();
        if (!$company) {
            return response()->json(['msg' => 'error', 'response' => 'Company not found'], 404);
        }
        $rfp_bids = RFPBid::where('company_id', $company_id)->get();
        if ($rfp_bids->count() > 0) {
            foreach ($rfp_bids as $rfp_bid) {
                $rfp_bid->rfp_post = $rfp_bid->rfp;
                $rfp_bid->user = $rfp_bid->user;
                $rfp_bid->company = $rfp_bid->company;
            }
            return response()->json(['msg' => 'success', 'response' => 'RFP Bids Retrieved successfully', 'data' => $rfp_bids], 200);
        }
        return response()->json(['msg' => 'success', 'response' => 'No RFP Bids Submitted Yet'], 200);
    }

    public function showByUser()
    {
        $user_id = Auth::id();
        $rfp_bids = RFPBid::where('user_id', $user_id)->get();
        if ($rfp_bids->count() > 0) {
            foreach ($rfp_bids as $rfp_bid) {
                $rfp_bid->rfp_post = $rfp_bid->rfp;
                $rfp_bid->user = $rfp_bid->user;
                $rfp_bid->company = $rfp_bid->company;
            }
            return response()->json(['msg' => 'success', 'response' => 'RFP Bids Retrieved successfully', 'data' => $rfp_bids], 200);
        }
        return response()->json(['msg' => 'success', 'response' => 'No RFP Bids Submitted Yet'], 200);
    }
}
