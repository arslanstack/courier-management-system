<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    public function allUsers()
    {
        $authUser = Auth::user();
        $company = Company::where('id', $authUser->company->id)->first();
        $users = User::where('company_id', $company->id)->where('status', '!=', 2)->get();
        return response()->json([
            'msg' => 'success', 
            'response' => 'Users retrieved successfully', 
            'users' => $users
        ], 200);

    }
    public function showUser($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if(!$user){
            return response()->json([
                'msg' => 'error', 
                'response' => 'User not found'
            ], 404);
        }
        return response()->json([
            'msg' => 'success', 
            'response' => 'User retrieved successfully', 
            'user' => $user
        ], 200);

    }
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $password = rand(100000, 999999) . 'aA#' . rand(1, 99);
        $fname = explode('@', $request->email)[0];
        $lname = 'User';
        $authUser = Auth::user();
        $company = $authUser->company;
        $user = new User();
        $user->fname = $fname;
        $user->lname = $lname;
        $user->phone = $request->phone ? $request->phone : '00000000000';
        $user->fax = $request->fax ? $request->fax : '00000000000';

        if ($request->is_major_user) {
            $user->is_major_user = 1;
            $user->has_post_func = 1;
            $user->has_acc_info = 1;
        } else {
            $user->is_major_user = 0;
            $request->has_post_func ? $user->has_post_func = 1 : null;
            $request->has_acc_info ? $user->has_acc_info = 1 : null;
        }

        $request->has_alerts ? $user->has_alerts = 1 : null;
        $user->email = $request->email;
        $user->username = $request->email;
        $user->password = bcrypt($password);
        $user->company_id = $company->id;
        $query = $user->save();

        if (!$query) {
            return response()->json([
                'msg' => 'error', 
                'response' => 'User could not be created. Please try later'
            ], 500);
        }

        $maildata = [
            'name' => $fname . ' ' . $lname,
            'email' => $request->email,
            'password' => $password,
            'company' => $company->name
        ];

        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: webmaster@example.com\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $subject = 'Welcome to Drivv | New User Invitation';
        $emailTemplate = view('emails.invite', compact(['maildata']))->render();
        $sendMail = mail($user->email, $subject, $emailTemplate, $headers);

        if (!$sendMail) {
            return response()->json([
                'msg' => 'error', 
                'response' => 'User created but email could not be sent. Please try later'
            ], 500);
        }

        return response()->json([
            'msg' => 'success', 
            'response' => 'User created successfully', 
            'user' => $user
        ], 200);
    }

    public function updateUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $authUser = Auth::user();

        if ($authUser->is_major_user == 0) {
            return response()->json([
                'msg' => 'error', 
                'response' => 'You are not authorized to perform this action'
            ], 401);
        }

        $user = User::where('id', $request->user_id)->first();
        if(!$user){
            return response()->json([
                'msg' => 'error', 
                'response' => 'User not found'
            ], 404);
        }

        if ($request->is_major_user) {
            $user->is_major_user = 1;
            $user->has_post_func = 1;
            $user->has_acc_info = 1;
        } else {
            $user->is_major_user = 0;
            $request->has_post_func ? $user->has_post_func = 1 : null;
            $request->has_acc_info ? $user->has_acc_info = 1 : null;
        }

        $request->has_alerts ? $user->has_alerts = 1 : null;
        $request->phone ? $user->phone = $request->phone : null;
        $query = $user->save();

        if (!$query) {
            return response()->json([
                'msg' => 'error', 
                'response' => 'User could not be updated. Please try later'
            ], 500);
        }

        return response()->json([
            'msg' => 'success', 
            'response' => 'User updated successfully', 
            'user' => $user
        ], 200);
    }

    public function ResetUserPassword($userId)
    {
        $authUser = Auth::user();
        if($authUser->is_major_user == 0){
            return response()->json([
                'msg' => 'error', 
                'response' => 'You are not authorized to perform this action'
            ], 401);
        }
        $user = User::where('id', $userId)->first();
        if(!$user){
            return response()->json([
                'msg' => 'error', 
                'response' => 'User not found'
            ], 404);
        }

        $password = rand(100000, 999999) . 'aA#' . rand(1, 99);
        $user->password = bcrypt($password);
        $query = $user->save();

        if (!$query) {
            return response()->json([
                'msg' => 'error', 
                'response' => 'Password could not be reset. Please try later'
            ], 500);
        }

        $maildata = [
            'name' => $user->fname . ' ' . $user->lname,
            'email' => $user->email,
            'password' => $password,
            'company' => $user->company->name
        ];

        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: webmaster@example.com\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $subject = 'Urgent | Password Reset Request Recieved';
        $emailTemplate = view('emails.resetpasspanel', compact(['maildata']))->render();
        $sendMail = mail($user->email, $subject, $emailTemplate, $headers);

        if (!$sendMail) {
            return response()->json([
                'msg' => 'error', 
                'response' => 'Password changed, but could not send updated credentials via email. Please try again!'
            ], 500);
        }

        return response()->json([
            'msg' => 'success', 
            'response' => 'Password reset successfully. Updated credentials dispatched via email.'
        ], 200);

    }
    
    public function addPhoneToUser(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'phone' => 'required',
        ]);

        $authUser = Auth::user();
        if($authUser->is_major_user == 0){
            return response()->json([
                'msg' => 'error', 
                'response' => 'You are not authorized to perform this action'
            ], 401);
        }

        $user = User::where('id', $request->user_id)->first();
        if(!$user){
            return response()->json([
                'msg' => 'error', 
                'response' => 'User not found'
            ], 404);
        }

        $user->phone = $request->phone;
        $query = $user->save();
        if(!$query){
            return response()->json([
                'msg' => 'error', 
                'response' => 'Phone number could not be added. Please try later'
            ], 500);
        }

        return response()->json([
            'msg' => 'success', 
            'response' => 'Phone number added successfully'
        ], 200);
    }

    public function deleteUser(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        $authUser = Auth::user();
        if($authUser->is_major_user == 0){
            return response()->json([
                'msg' => 'error', 
                'response' => 'You are not authorized to perform this action'
            ], 401);
        }

        $user = User::where('id', $request->user_id)->first();
        if(!$user){
            return response()->json([
                'msg' => 'error', 
                'response' => 'User not found'
            ], 404);
        }

        $user->status = 2;
        $query = $user->save();
        if(!$query){
            return response()->json([
                'msg' => 'error', 
                'response' => 'User could not be deleted. Please try later'
            ], 500);
        }

        return response()->json([
            'msg' => 'success', 
            'response' => 'User deleted successfully'
        ], 200);
    }
}
