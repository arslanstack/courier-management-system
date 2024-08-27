<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DriverContactList;
use App\Models\DriverResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DriverContactListController extends Controller
{
    public function index()
    {
        $driverContactItems = DriverContactList::where('company_id', Auth::user()->company_id)->with('driverAd')->with('driverResponse')->get();
        return response()->json(['msg' => 'success', 'response' => 'Data retreived successfully', 'data' => $driverContactItems], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'driver_response_ids' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $responses = json_decode($request->driver_response_ids);

        foreach ($responses as $response) {
            $driverResponse = DriverResponse::where('id', $response)->first();
            if (!$driverResponse) {
                return response()->json(['msg' => 'error', 'response' => 'Driver Response not found'], 404);
            }

            if ($driverResponse->DriverAd->company_id != Auth::user()->company_id) {
                return response()->json(['msg' => 'error', 'response' => 'You can only add responses to contact list if your company received them.'], 404);
            }

            $driverContactList = new DriverContactList();
            $driverContactList->user_id = Auth::user()->id;
            $driverContactList->company_id = Auth::user()->company_id;
            $driverContactList->driver_ad_id = $driverResponse->driver_ad_id;
            $driverContactList->driver_response_id = $driverResponse->id;
            $driverContactList->email_sent = 0;
            $query = $driverContactList->save();

            if (!$query) {
                return response()->json(['msg' => 'error', 'response' => 'Failed to add response to contact list'], 500);
            }
        }

        return response()->json(['msg' => 'success', 'response' => 'Responses added to contact list successfully'], 200);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'list_item_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $driverContactList = DriverContactList::where('id', $request->list_item_id)->first();

        if (!$driverContactList) {
            return response()->json(['msg' => 'error', 'response' => 'Contact list item not found'], 404);
        }

        if ($driverContactList->company_id != Auth::user()->company_id) {
            return response()->json(['msg' => 'error', 'response' => 'You can only delete items from your own contact list'], 401);
        }

        $query = $driverContactList->delete();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Failed to delete item from contact list'], 500);
        }

        return response()->json(['msg' => 'success', 'response' => 'Item deleted from contact list successfully'], 200);
    }

    public function sendMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'list_item_id' => 'required',
            'subject' => 'required',
            'body' => 'required',
            'reply_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $listItem = DriverContactList::where('id', $request->list_item_id)->first();

        if (!$listItem) {
            return response()->json(['msg' => 'error', 'response' => 'Contact list item not found'], 404);
        }

        $driverAd = $listItem->driverAd;

        if ($driverAd->company_id != Auth::user()->company_id) {
            return response()->json(['msg' => 'error', 'response' => 'You can only send emails to responses received by your own company'], 401);
        }

        if($listItem->email_sent == 1) {
            return response()->json(['msg' => 'error', 'response' => 'Email already sent for this contact list item'], 401);
        }

        $driverResponse = $listItem->driverResponse;

        $maildata = [
            'name' => $driverResponse->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'reply_email' => $request->reply_email,
            'DriverAd' => $driverAd,
            'DriverResponse' => $driverResponse,
        ];

        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: webmaster@example.com\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $subject = 'A message from ' . Auth::user()->company->name . ' Regarding your response on there Driver Wanted Ad';
        $emailTemplate = view('emails.replyResponse', compact(['maildata']))->render();
        $sendMail = mail($driverResponse->contact_email, $subject, $emailTemplate, $headers);

        if(!$sendMail) {
            return response()->json(['msg' => 'error', 'response' => 'Failed to send email'], 500);
        }

        $listItem->email_sent = 1;
        
        $query = $listItem->save();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Email sent but failed to update contact list item'], 500);
        }

        return response()->json(['msg' => 'success', 'response' => 'Email sent successfully'], 200);
    }
}
