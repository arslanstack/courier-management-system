<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteBids;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = QuoteRequest::query();
        $search_query = $request->input('search_query');
        if (($request->has('search_query') && !empty($search_query))) {
            $query->where(function ($query) use ($search_query) {
                $query->where('pickup_zip', 'like', '%' . $search_query . '%')
                    ->orWhere('delivery_zip', 'like', '%' . $search_query . '%')
                    ->orWhere('pickup_date', 'like', '%' . $search_query . '%')
                    ->orWhereHas('company', function ($query) use ($search_query) {
                        $query->where('name', 'like', '%' . $search_query . '%');
                    });
            });
        }
        $data['quoteRequests'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/quote_requests/manage_quote_requests', $data);
    }

    public function details($id)
    {
        $quote_request = QuoteRequest::find($id);
        if (!$quote_request) {
            return redirect()->back()->with('error', 'Quote Requests not found');
        }
        $data['quoteRequests'] = $quote_request;
        $data['quoteBids'] = QuoteBids::where('request_id', $quote_request->id)->get();
        return view('admin/quote_requests/quote_request_details', $data);
    }

    public function bidDetails(Request $request)
    {
        $bid = QuoteBids::where('id', $request->id)->first();
        $bid['company'] = $bid->company->name;
        $bid['user'] = $bid->user->fname . ' ' . $bid->user->lname;
        if (!empty($bid)) {
            $htmlresult = view('admin/quote_requests/bids_ajax', compact('bid'))->render();
            $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
            return $finalResult;
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Quote Bid not found.']);
        }
    }
}
