<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Company;
use App\Models\Message;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ChatController extends Controller
{
    public function send(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required',
            'quote_request_id' => 'required',
            'receiver_company_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        $quote_request = QuoteRequest::where('id', $request->quote_request_id)->first();

        if (!$quote_request) {
            return response()->json([
                'msg' => 'error',
                'response' => 'Quote request not found.'
            ], 404);
        }

        $receiver_company = Company::where('id', $request->receiver_company_id)->first();

        if (!$receiver_company) {
            return response()->json([
                'msg' => 'error',
                'response' => 'Receiver company not found.'
            ], 404);
        }

        $auth_company =Auth::user()->company;
        $chat = Chat::where('quote_request_id', $quote_request->id)
            ->where(function ($query) use ($auth_company, $receiver_company) {
                $query->where('sender_company_id', $auth_company->id)
                    ->orWhere('receiver_company_id', $auth_company->id)
                    ->orWhere('sender_company_id', $receiver_company->id)
                    ->orWhere('receiver_company_id', $receiver_company->id);
            })
            ->first();

        if (!$chat) {
            $chat = new Chat();
            $chat->quote_request_id = $quote_request->id;
            $chat->sender_company_id = Auth::user()->company_id;
            $chat->sender_id = Auth::user()->id;
            $chat->receiver_company_id = $receiver_company->id;
            $chat->save();
        }

        $message = new Message();
        $message->chat_id = $chat->id;
        $message->sender_id = Auth::user()->id;
        $message->sender_company_id = Auth::user()->company_id;
        $message->receiver_company_id = $receiver_company->id;
        $message->message = $request->message;
        $query = $message->save();

        if (!$query) {
            return response()->json([
                'msg' => 'error',
                'response' => 'Failed to send message.'
            ], 500);
        }

        return response()->json([
            'msg' => 'success',
            'response' => 'Message sent successfully.'
        ], 200);
    }

    public function getThread(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quote_request_id' => 'required',
            'other_company_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'msg' => 'error',
                'response' => $validator->errors()->first()
            ], 400);
        }

        $other_company_id = $request->other_company_id;
        $quote_request_id = $request->quote_request_id;

        $auth_company = Auth::user()->company;
        $other_company = Company::where('id', $other_company_id)->first();

        if (!$other_company) {
            return response()->json([
                'msg' => 'error',
                'response' => 'Other company not found.'
            ], 404);
        }

        $chat = Chat::where('quote_request_id', $quote_request_id)
            ->where(function ($query) use ($auth_company, $other_company) {
                $query->where('sender_company_id', $auth_company->id)
                    ->orWhere('receiver_company_id', $auth_company->id)
                    ->orWhere('sender_company_id', $other_company->id)
                    ->orWhere('receiver_company_id', $other_company->id);
            })
            ->first();

        if (!$chat) {
            return response()->json([
                'msg' => 'error',
                'response' => 'Chat not found.'
            ], 404);
        }

        $messages = Message::where('chat_id', $chat->id)->get();

        $thread = [];
        foreach ($messages as $message) {
            $thread[] = [
                'id' => $message->id,
                'message' => $message->message,
                'sender_user_name' => $message->sender->fname . ' ' . $message->sender->lname,
                'sender_user_id' => $message->sender->id,
                'sender_company_name' => $message->senderCompany->name,
                'sender_company_id' => $message->senderCompany->id,
                'receiver_company_id' => $message->receiverCompany->id,
                'send_at' => $message->created_at
            ];
        }

        return response()->json([
            'msg' => 'success',
            'response' => 'Chat thread fetched successfully.',
            'data' => $thread,
        ], 200);
    }
}
