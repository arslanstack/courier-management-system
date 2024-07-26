<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class QuoteRequestController extends Controller
{
    public function index()
    {
        $quoteRequests = QuoteRequest::all();
        foreach ($quoteRequests as $request) {
            $request->company = $request->company;
            $request->user = $request->user;
        }
        return response()->json(['msg' => 'success', 'response' => 'Quote Requests retrieved successfully', 'quoteRequests' => $quoteRequests], 200);
    }
    
    public function getByUser()
    {
        $quoteRequests = QuoteRequest::where('user_id', Auth::user()->id)->get();
        foreach ($quoteRequests as $request) {
            $request->company = $request->company;
            $request->user = $request->user;
        }
        return response()->json(['msg' => 'success', 'response' => 'Quote Requests retrieved successfully', 'quoteRequests' => $quoteRequests], 200);
    }

    public function getByCompany($company_id)
    {
        $quoteRequests = QuoteRequest::where('company_id', $company_id)->get();
        foreach ($quoteRequests as $request) {
            $request->company = $request->company;
            $request->user = $request->user;
        }
        return response()->json(['msg' => 'success', 'response' => 'Quote Requests retrieved successfully', 'quoteRequests' => $quoteRequests], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup_date' => 'required',
            'pickup_time' => 'required',
            'start_point' => 'required',
            'delivery_point' => 'required',
            'delivery_time' => 'required',
            'weight' => 'required',
            'dimensions' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $mileage = mileageCalculator($request->start_point, $request->delivery_point);
        $pickup_addr = calculate_address(substr($request->start_point, 0, 5));
        $delivery_addr = calculate_address(substr($request->delivery_point, 0, 5));
        $quoteRequest = new QuoteRequest();
        $quoteRequest->pickup_date = $request->pickup_date;
        $quoteRequest->pickup_time = $request->pickup_time;
        $quoteRequest->delivery_time = $request->delivery_time;
        $quoteRequest->start_point = $request->start_point;
        $quoteRequest->delivery_point = $request->delivery_point;
        $quoteRequest->weight = $request->weight;
        $quoteRequest->dimensions = $request->dimensions;
        $quoteRequest->description = $request->description;
        $quoteRequest->vehicle = $request->vehicle ?? 0;
        $quoteRequest->reefer = $request->reefer ?? 0;
        $quoteRequest->hazmat = $request->hazmat ?? 0;
        $quoteRequest->lift_gate = $request->lift_gate ?? 0;
        $quoteRequest->user_id = Auth::user()->id;
        $quoteRequest->company_id = Auth::user()->company->id;
        $quoteRequest->estimated_mileage = $mileage;
        $quoteRequest->pickup_zip = substr($request->start_point, 0, 5);
        $quoteRequest->pickup_city = $pickup_addr['city'] ?? substr($request->start_point, 0, 5);
        $quoteRequest->pickup_state = $pickup_addr['state'] ?? substr($request->start_point, 0, 5);
        $quoteRequest->pickup_country = $pickup_addr['country'] ?? substr($request->start_point, 0, 5);
        $quoteRequest->delivery_zip = substr($request->delivery_point, 0, 5);
        $quoteRequest->delivery_city = $delivery_addr['city'] ?? substr($request->delivery_point, 0, 5);
        $quoteRequest->delivery_state = $delivery_addr['state'] ?? substr($request->delivery_point, 0, 5);
        $quoteRequest->delivery_country = $delivery_addr['country'] ?? substr($request->delivery_point, 0, 5);
        $quoteRequest->pickup_contact_name = $request->contact_name;
        $quoteRequest->pickup_contact_phone = $request->contact_phone;
        $quoteRequest->pickup_contact_email = $request->contact_email;
        $quoteRequest->delivery_contact_name = $request->contact_name;
        $quoteRequest->delivery_contact_phone = $request->contact_phone;
        $quoteRequest->delivery_contact_email = $request->contact_email;
        $query = $quoteRequest->save();
        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Quote Request submitted successfully', 'quoteRequest' => $quoteRequest], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Quote Request submission failed'], 200);
        }
    }

    public function updateRequest(Request $request)
    {
        $quote_request = QuoteRequest::where('id', $request->id)->first();
        if (!$quote_request) {
            return response()->json(['msg' => 'error', 'response' => 'Quote Request not found.'], 404);
        }
        if ($quote_request->user_id != Auth::id()) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to update this quote request.'], 401);
        }
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'pickup_date' => 'required',
            'pickup_time' => 'required',
            'start_point' => 'required',
            'delivery_point' => 'required',
            'delivery_time' => 'required',
            'weight' => 'required',
            'dimensions' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
        }

        $mileage = mileageCalculator($request->start_point, $request->delivery_point);
        $pickup_addr = calculate_address(substr($request->start_point, 0, 5));
        $delivery_addr = calculate_address(substr($request->delivery_point, 0, 5));

        $quote_request->pickup_date = $request->pickup_date;
        $quote_request->pickup_time = $request->pickup_time;
        $quote_request->delivery_time = $request->delivery_time;
        $quote_request->start_point = $request->start_point;
        $quote_request->delivery_point = $request->delivery_point;
        $quote_request->weight = $request->weight;
        $quote_request->dimensions = $request->dimensions;
        $quote_request->description = $request->description;
        $quote_request->vehicle = $request->vehicle ?? 0;
        $quote_request->reefer = $request->reefer ?? 0;
        $quote_request->hazmat = $request->hazmat ?? 0;
        $quote_request->lift_gate = $request->lift_gate ?? 0;
        $quote_request->estimated_mileage = $mileage;
        $quote_request->pickup_zip = substr($request->start_point, 0, 5);
        $quote_request->pickup_city = $pickup_addr['city'] ?? substr($request->start_point, 0, 5);
        $quote_request->pickup_state = $pickup_addr['state'] ?? substr($request->start_point, 0, 5);
        $quote_request->pickup_country = $pickup_addr['country'] ?? substr($request->start_point, 0, 5);
        $quote_request->delivery_zip = substr($request->delivery_point, 0, 5);
        $quote_request->delivery_city = $delivery_addr['city'] ?? substr($request->delivery_point, 0, 5);
        $quote_request->delivery_state = $delivery_addr['state'] ?? substr($request->delivery_point, 0, 5);
        $quote_request->delivery_country = $delivery_addr['country'] ?? substr($request->delivery_point, 0, 5);
        $quote_request->pickup_contact_name = $request->contact_name;
        $quote_request->pickup_contact_phone = $request->contact_phone;
        $quote_request->pickup_contact_email = $request->contact_email;
        $quote_request->delivery_contact_name = $request->contact_name;
        $quote_request->delivery_contact_phone = $request->contact_phone;
        $quote_request->delivery_contact_email = $request->contact_email;
        $query = $quote_request->save();
        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Quote Request updated successfully', 'quoteRequest' => $quote_request], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Quote Request update failed'], 200);
        }
    }

    public function updateAddress(Request $request)
    {
        $quote_request = QuoteRequest::where('id', $request->id)->first();
        if (!$quote_request) {
            return response()->json(['msg' => 'error', 'response' => 'Quote Request not found.'], 404);
        }
        if ($quote_request->user_id != Auth::id()) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to update this quote request.'], 401);
        }
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'pickup_city' => 'required',
            'pickup_state' => 'required',
            'pickup_zip' => 'required',
            'pickup_contact_name' => 'required',
            'pickup_contact_phone' => 'required',
            'delivery_city' => 'required',
            'delivery_state' => 'required',
            'delivery_zip' => 'required',
            'delivery_contact_name' => 'required',
            'delivery_contact_phone' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(array('msg' => 'lvl_error', 'response' => $validator->errors()->all()));
        }
        $mileage = mileageCalculator($request->pickup_zip, $request->delivery_zip);
        $request->pickup_address_1 ? $quote_request->pickup_address_1 = $request->pickup_address_1 : '';
        $request->pickup_address_2 ? $quote_request->pickup_address_2 = $request->pickup_address_2 : '';
        $request->pickup_company ? $quote_request->pickup_company = $request->pickup_company : '';
        $request->delivery_address_1 ? $quote_request->delivery_address_1 = $request->delivery_address_1 : '';
        $request->delivery_company ? $quote_request->delivery_address_2 = $request->delivery_address_2 : '';
        $request->delivery_address_2 ? $quote_request->delivery_company = $request->delivery_company : '';
        $quote_request->pickup_city = $request->pickup_city;
        $quote_request->pickup_state = $request->pickup_state;
        $quote_request->pickup_zip = $request->pickup_zip;
        $quote_request->pickup_contact_name = $request->pickup_contact_name;
        $quote_request->pickup_contact_phone = $request->pickup_contact_phone;
        $quote_request->delivery_city = $request->delivery_city;        
        $quote_request->delivery_state = $request->delivery_state;
        $quote_request->delivery_zip = $request->delivery_zip;
        $quote_request->delivery_contact_name = $request->delivery_contact_name;
        $quote_request->delivery_contact_phone = $request->delivery_contact_phone;
        $quote_request->estimated_mileage = $mileage;
        $query = $quote_request->save();
        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Quote Request updated successfully', 'quoteRequest' => $quote_request], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Quote Request update failed'], 200);
        }
    }
}
