<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RFP;
use App\Models\RFPBid;
use Illuminate\Http\Request;

class RFPController extends Controller
{
    public function index(Request $request)
    {
        $query = RFP::query();
        $search_query = $request->input('search_query');
        if (($request->has('search_query') && !empty($search_query))) {
            $query->where(function ($query) use ($search_query) {
                $query->where('start_point', 'like', '%' . $search_query . '%')
                    ->orWhere('delivery_point', 'like', '%' . $search_query . '%')
                    ->orWhere('insurance_coverage', 'like', '%' . $search_query . '%')
                    ->orWhere('estimated_mileage', 'like', '%' . $search_query . '%')
                    ->orWhereHas('user.company', function ($query) use ($search_query) {
                        $query->where('name', 'like', '%' . $search_query . '%');
                    });
            });
        }
        $data['rfps'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/rfps/manage_rfps', $data);
    }

    public function details($id)
    {
        $rfp = RFP::where('id', $id)->first();
        if (!$rfp) {
            return redirect()->back()->with('error', 'Recurring Freight Posting not found');
        }
        $data['rfp'] = $rfp;
        $data['rfp_bids'] = RFPBid::where('rfp_id', $rfp->id)->get();
        return view('admin/rfps/rfps_details', $data);
    }
    public function bidDetails(Request $request)
    {
        $bid = RFPBid::where('id', $request->id)->first();
        $bid['company'] = $bid->company->name;
        $bid['user'] = $bid->user->fname . ' ' . $bid->user->lname;
        if (!empty($bid)) {
            $htmlresult = view('admin/rfps/bids_ajax', compact('bid'))->render();
            $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
            return $finalResult;
        } else {
            return response()->json(['msg' => 'error', 'response' => 'RFP Bid not found.']);
        }
    }
}
