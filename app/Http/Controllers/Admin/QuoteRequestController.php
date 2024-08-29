<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\QuoteBids;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $chats = Chat::where('quote_request_id', $quote_request->id)->get();

        foreach ($chats as $chat) {
            $chat->otherCompany = $chat->sender_company_id == $quote_request->company_id ? $chat->receiverCompany : $chat->senderCompany;
        }
        $data['chats'] = $chats;
        return view('admin/quote_requests/quote_request_details', $data);
    }

    public function chatDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'thisCompany' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $chat = Chat::where('id', $request->id)->first();
        if (!$chat) {
            return response()->json([
                'msg' => 'error',
                'response' => 'Chat not found.'
            ], 404);
        }

        $messages = $chat->messages;
        foreach ($messages as $message) {
            $message->sender_user = $message->sender->fname . ' ' . $message->sender->lname;
            $message->sender_company = $message->senderCompany->name;
            $message->side = $message->senderCompany->id == $request->thisCompany ? 'right' : 'left';
        }
        $htmlresult = view('admin/quote_requests/chat_ajax', compact('messages'))->render();
        $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
        return $finalResult;
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
