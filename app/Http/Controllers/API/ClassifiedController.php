<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Classified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ClassifiedController extends Controller
{
    public function index()
    {
        $classifieds = Classified::where('status', 1)->get();
        foreach ($classifieds as $classified) {
            $classified->user;
            $classified->company;
            $classified->photo = url('public/uploads/classifieds/' . $classified->photo);
        }
        return response()->json(['msg' => 'success', 'response' => 'Classifieds retreived successfully.', 'data' => $classifieds], 200);
    }

    public function show($id)
    {
        $classified = Classified::find($id);
        if (!$classified) {
            return response()->json(['msg' => 'error', 'response' => 'Classified not found'], 404);
        }
        $classified->user;
        $classified->company;
        $classified->photo = url('public/uploads/classifieds/' . $classified->photo);
        return response()->json(['msg' => 'success', 'response' => 'Classified retreived successfully.', 'data' => $classified], 200);
    }

    public function reply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'classified_id' => 'required|integer',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $classified = Classified::find($request->classified_id);
        if(Auth::user()->company_id == $classified->company_id) {
            return response()->json(['msg' => 'error', 'response' => 'You cannot reply to your own classified'], 400);
        }
        $classifiedAuthor = $classified->user;

        if (!$classified) {
            return response()->json(['msg' => 'error', 'response' => 'Classified not found'], 404);
        }

        $maildata = [
            'classifiedAuthor' => $classifiedAuthor,
            'name' => Auth::user()->fname . ' ' . Auth::user()->lname,
            'subject' => $request->subject,
            'body' => $request->message,
            'classified' => $classified,
        ];

        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: webmaster@example.com\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $subject = 'A reply from ' . Auth::user()->company->name . ' regarding your classified';
        $emailTemplate = view('emails.classifiedReply', compact(['maildata']))->render();
        $sendMail = mail($classifiedAuthor->email, $subject, $emailTemplate, $headers);
        if(!$sendMail) {
            return response()->json(['msg' => 'error', 'response' => 'Failed to send email'], 500);
        }

        return response()->json(['msg' => 'success', 'response' => 'Email sent successfully'], 200);
    }

    public function setScreenName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'screen_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = Auth::user();
        $user->screen_name = $request->screen_name;
        $query = $user->save();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Failed to set screen name'], 500);
        }

        return response()->json(['msg' => 'success', 'response' => 'Screen name set successfully'], 200);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->screen_name == null) {
            return response()->json(['msg' => 'error', 'response' => 'Please set your screen name first'], 400);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required',
            'state' => 'required',
            'category' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $classified = new Classified();
        $classified->user_id = $user->id;
        $classified->company_id = $user->company_id;
        $classified->screen_name = $user->screen_name;
        $classified->title = $request->title;
        $classified->description = $request->description;
        $classified->location = $request->location;
        $classified->state = $request->state;
        $classified->category = $request->category;
        $classified->status = 1;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = str_replace(' ', '-', Auth::user()->company->name) . rand(0000, 9999) . time() . '.' . $file->getClientOriginalExtension();
            $file->move('public/uploads/classifieds', $filename);
            $classified->photo = $filename;
        }
        $query = $classified->save();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Failed to create classified'], 500);
        }

        return response()->json(['msg' => 'success', 'response' => 'Classified created successfully', 'data' => $classified], 200);
    }
}
