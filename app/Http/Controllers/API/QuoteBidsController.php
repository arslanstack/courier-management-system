<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\QuoteBids;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuoteBidsController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'request_id' => 'required',
            'amount' => 'required',
            'contact_fname' => 'required',
            'contact_lname' => 'required',
            'contact_phone' => 'required',
            'contact_email' => 'required',
            'terms' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $quote_request = QuoteRequest::where('id', $request->request_id)->first();

        if (!$quote_request) {
            return response()->json(['msg' => 'error', 'response' => 'Quote Requests not found'], 404);
        }
        $user_id = Auth::id();
        $company = Auth::user()->company;
        $company_id = $company->id;

        if ($company->id == $quote_request->company_id) {
            return response()->json(['msg' => 'error', 'response' => 'You cannot bid on your own quote requests'], 401);
        }

        if ($company->company_type != 3) {
            return response()->json(['msg' => 'error', 'response' => 'Only Courier Companies can bid on quote requests'], 401);
        }

        $quote_bid = new QuoteBids();
        $quote_bid->request_id = $request->request_id;
        $quote_bid->company_id = $company_id;
        $quote_bid->user_id = $user_id;
        $quote_bid->amount = $request->amount;
        $quote_bid->contact_fname = $request->contact_fname;
        $quote_bid->contact_lname = $request->contact_lname;
        $quote_bid->contact_phone = $request->contact_phone;
        $quote_bid->contact_email = $request->contact_email;
        $quote_bid->terms = $request->terms;
        $query = $quote_bid->save();

        $maildata = [
            'quote_request' => $quote_request,
            'quote_bid' => $quote_bid
        ];

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Quote Bid submitted successfully'], 200);
        }
        // Mail Bhijwani hain
        return response()->json(['msg' => 'error', 'response' => 'Quote Bid not submitted'], 500);
    }

    public function show($request_id)
    {
        $request = QuoteRequest::where('id', $request_id)->first();
        if (!$request) {
            return response()->json(['msg' => 'error', 'response' => 'Quote Request not found'], 404);
        }

        $quote_bids = QuoteBids::where('request_id', $request_id)->get();
        if ($quote_bids->count() > 0) {
            foreach($quote_bids as $quote_bid) {
                $quote_bid->company = $quote_bid->company;
            }
            return response()->json(['msg' => 'success', 'response' => $quote_bids], 200);
        }

        return response()->json(['msg' => 'success', 'response' => 'No Quote Bids Submitted Yet'], 200);
    }

    public function showByCompany($company_id)
    {
        $company = Company::where('id', $company_id)->first();
        if (!$company) {
            return response()->json(['msg' => 'error', 'response' => 'Company not found'], 404);
        }
        $quote_bids = QuoteBids::where('company_id', $company_id)->get();
        if ($quote_bids->count() > 0) {
            foreach ($quote_bids as $quote_bid) {
                $quote_bid->request = $quote_bid->request;
            }
            return response()->json(['msg' => 'success', 'response' => $quote_bids], 200);
        }
        return response()->json(['msg' => 'success', 'response' => 'No Quote Bids Submitted Yet'], 200);
    }

    public function showByUser()
    {
        $user_id = Auth::id();
        $quote_bids = QuoteBids::where('user_id', $user_id)->get();
        if ($quote_bids->count() > 0) {
            foreach ($quote_bids as $quote_bid) {
                $quote_bid->request = $quote_bid->request;
            }
            return response()->json(['msg' => 'success', 'response' => $quote_bids], 200);
        }
        return response()->json(['msg' => 'success', 'response' => 'No Quote Bids Submitted Yet'], 200);
    }
}
