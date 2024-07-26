<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:255',
            'mail_address_1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'company_type' => 'required | integer | max: 4',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'phone' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'c_password' => 'required| min:6 |string|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $company = new Company();
        $company->name = $request->company;
        $company->mail_address_1 = $request->mail_address_1;
        $company->mail_address_2 = $request->mail_address_2 ?? '';
        $company->city = $request->city;
        $company->state = $request->state;
        $company->country = $request->country;
        $company->zip = $request->zip;
        $company->company_type = $request->company_type;
        $company->motor_carrier_no = $request->motor_carrier_no ?? '';
        $company->dot_no = $request->dot_no ?? '';
        $company->intrastate_no = $request->intrastate_no ?? '';
        $query = $company->save();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Could not create company.'], 400);
        } else {
            $company_id = $company->id;
        }

        $user = new User();
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->username = $request->email;
        $user->title = $request->title;
        $user->phone = $request->phone;
        $user->fax = $request->fax ?? $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->company_id = $company_id;
        $user->is_major_user = 1;
        $query_two = $user->save();
        if ($query_two) {

            $maildata = [
                'name' => $user->fname . ' ' . $user->lname,
                'company' => $company->name,
                'username' => $user->username,
                'password' => $request->password
            ];

            $headers = "From: webmaster@example.com\r\n";
            $headers .= "Reply-To: webmaster@example.com\r\n";
            $headers .= "Content-Type: text/html\r\n";
            $subject = 'Welcome to Drivv Powered By Courier Board';
            $emailTemplate = view('emails.welcome', compact(['maildata']))->render();
            $sendMail = mail($request->email, $subject, $emailTemplate, $headers);
            if (!$sendMail) {
                return response()->json(['msg' => 'error', 'response' => 'Could not send email.'], 400);
            }
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['msg' => 'error', 'response' => 'Unauthorized'], 401);
            }
            $user = Auth::user();
            return response()->json(['msg' => 'success', 'response' => 'Account created successfully.', 'user' => $user, 'token' => $this->respondWithToken($token)], 200);
        }
        return response()->json(['msg' => 'error', 'response' => 'Something went wrong. Could not create an account.'], 400);
    }
    public function homepage_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pickup_date' => 'required',
            'pickup_time' => 'required',
            'pickup_zip' => 'required',
            'delivery_zip' => 'required',
            'delivery_time' => 'required',
            'dimensions' => 'required',
            'weight' => 'required',
            'description' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'company_name' => 'required',
            'your_zip' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $company = new Company();
        $company->name = $request->company_name;
        $company->zip = $request->your_zip;
        $company->company_type = 0;
        $query = $company->save();
        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Could not create company.'], 400);
        } else {
            $company_id = $company->id;
        }
        $password = rand(100000, 999999) . $request->fname . rand(1, 99);
        $user = new User();
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->username = $request->email;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->fax = $request->phone;
        $user->password = bcrypt($password);
        $user->company_id = $company_id;
        $user->is_major_user = 1;
        $user->zip = $request->your_zip;
        $query_two = $user->save();
        if (!$query_two) {
            return response()->json(['msg' => 'error', 'response' => 'Could not create user.'], 400);
        } else {
            $user_id = $user->id;
        }
        $mileage = mileageCalculator($request->pickup_zip, $request->delivery_zip);
        $pickup_addr = calculate_address(substr($request->pickup_zip, 0, 5));
        $delivery_addr = calculate_address(substr($request->delivery_zip, 0, 5));
        $quoteRequest = new QuoteRequest();
        $quoteRequest->pickup_date = $request->pickup_date;
        $quoteRequest->pickup_time = $request->pickup_time;
        $quoteRequest->pickup_zip = $request->pickup_zip;
        $quoteRequest->start_point = $request->start_point;
        if ($mileage != null) {
            $quoteRequest->estimated_mileage = $mileage;
        }
        if ($pickup_addr != null) {
            $quoteRequest->pickup_city = $pickup_addr['city'];
            $quoteRequest->pickup_state = $pickup_addr['state'];
            $quoteRequest->pickup_country = $pickup_addr['country'];
        }
        if ($delivery_addr != null) {
            $quoteRequest->delivery_city = $delivery_addr['city'];
            $quoteRequest->delivery_state = $delivery_addr['state'];
            $quoteRequest->delivery_country = $delivery_addr['country'];
        }
        $quoteRequest->weight = $request->weight;
        $quoteRequest->dimensions = $request->dimensions;
        $quoteRequest->description = $request->description;
        $quoteRequest->pickup_contact_name = $request->fname . ' ' . $request->lname;
        $quoteRequest->pickup_contact_phone = $request->phone;
        $quoteRequest->pickup_contact_email = $request->email;
        $quoteRequest->pickup_company = $company->name;
        $quoteRequest->user_id = $user_id;
        $quoteRequest->company_id = $company_id;
        $query_three = $quoteRequest->save();
        if (!$query_three) {
            return response()->json(['msg' => 'error', 'response' => 'Could not create quote request.'], 400);
        }

        // log user in
        $credentials = [
            'email' => $request->email,
            'password' => $password
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['msg' => 'error', 'response' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $maildata = [
            'name' => $user->fname . ' ' . $user->lname,
            'company' => $company->name,
            'username' => $user->username,
            'password' => $password
        ];

        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: webmaster@example.com\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $subject = 'Welcome to Drivv Powered By Courier Board';
        $emailTemplate = view('emails.welcome', compact(['maildata']))->render();
        $sendMail = mail($request->email, $subject, $emailTemplate, $headers);

        if (!$sendMail) {
            return response()->json(['msg' => 'error', 'response' => 'Could not send email.'], 400);
        }

        return response()->json(['msg' => 'success', 'response' => 'Company, Account, and Quote Request created successfully.', 'user' => $user, 'token' => $this->respondWithToken($token), 'quote_request' => $quoteRequest], 200);
    }
    public function premium_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company' => 'required|string|max:255',
            'mail_address_1' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'drivers' => 'required|string|max:255',
            'insurance_company' => 'required|string|max:255',
            'gen_liability' => 'required|string|max:255',
            'cargo_insurance' => 'required|string|max:255',
            'insurance_company' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'company_phone' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
            'c_password' => 'required| min:6 |string|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $company = new Company();
        $company->name = $request->company;
        $company->mail_address_1 = $request->mail_address_1;
        $company->mail_address_2 = $request->mail_address_2 ?? '';
        $company->city = $request->city;
        $company->state = $request->state;
        $company->country = $request->country;
        $company->zip = $request->zip;
        $company->company_type = 3;
        $company->motor_carrier_no = $request->motor_carrier_no ?? '';
        $company->dot_no = $request->dot_no ?? '';
        $company->intrastate_no = $request->intrastate_no;
        $company->website = $request->website;
        $company->drivers = $request->drivers;
        $company->insurance_company = $request->insurance_company;
        $company->gen_liability = $request->gen_liability;
        $company->cargo_insurance = $request->cargo_insurance;
        $company->other_insurance = $request->other_insurance ?? '';
        if ($request->hasFile('insurance_declaration')) {
            $file = $request->file('insurance_declaration');
            $filename = $company->name . time() . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/insurance_declarations', $filename);
            $company->insurance_declaration = $filename;
        }
        // $company->company_phone = $request->company_phone;
        // $company->company_mobile = $request->company_mobile ?? '';
        $company->account_type = 1;
        $query = $company->save();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Could not create company.'], 400);
        } else {
            $company_id = $company->id;
        }

        $user = new User();
        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->username = $request->email;
        $user->title = $request->title;
        $user->email = $request->email;
        $user->phone = $request->company_phone;
        $user->fax = $request->company_phone;
        $user->password = bcrypt($request->password);
        $user->company_id = $company_id;
        $user->is_major_user = 1;
        $query_two = $user->save();
        if ($query_two) {

            $maildata = [
                'name' => $user->fname . ' ' . $user->lname,
                'company' => $company->name,
                'username' => $user->username,
                'password' => $request->password
            ];

            $headers = "From: webmaster@example.com\r\n";
            $headers .= "Reply-To: webmaster@example.com\r\n";
            $headers .= "Content-Type: text/html\r\n";
            $subject = 'Welcome to Drivv Powered By Courier Board';
            $emailTemplate = view('emails.welcome', compact(['maildata']))->render();
            $sendMail = mail($request->email, $subject, $emailTemplate, $headers);
            if (!$sendMail) {
                return response()->json(['msg' => 'error', 'response' => 'Could not send email.'], 400);
            }
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['msg' => 'error', 'response' => 'Unauthorized'], 401);
            }
            $user = Auth::user();
            return response()->json(['msg' => 'success', 'response' => 'Account created successfully.', 'user' => $user, 'token' => $this->respondWithToken($token)], 200);
        }
        return response()->json(['msg' => 'error', 'response' => 'Something went wrong. Could not create an account.'], 400);
    }
    public function premium_billing_info(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
            'card_number' => 'required|string|max:16|min:16',
            'cvv' => 'required|max:4|min:3',
            'expiry_month' => 'required|string|max:255',
            'expiry_year' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $company = Company::where('id', $request->company_id)->first();
        if (!$company) {
            return response()->json(['msg' => 'error', 'response' => 'Company not found.'], 404);
        }
        $company->billing_info_status = 1;
        $company->card_number = $request->card_number;
        $company->cvv = $request->cvv;
        $company->expiry_month = $request->expiry_month;
        $company->expiry_year = $request->expiry_year;
        $query = $company->save();
        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Billing information added successfully.'], 200);
        }
        return response()->json(['msg' => 'error', 'response' => 'Could not add billing information.'], 400);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('username', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['msg' => 'error', 'response' => 'Incorrect username or password.'], 401);
        }

        $user = Auth::user();

        if ($user->status == 0) {
            auth()->logout();
            return response()->json(['msg' => 'error', 'response' => 'Your account has been blocked by administration. Please contact support.'], 401);
        } else if ($user->status == 2) {
            auth()->logout();
            return response()->json(['msg' => 'error', 'response' => 'Your account has been deactivated by your company. Please contact support.'], 401);
        }

        return response()->json(['msg' => 'success', 'response' => 'Login successful.', 'user' => $user, 'token' => $this->respondWithToken($token)], 200);
    }
    public function forgot(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json(['msg' => 'error', 'response' => 'User not found.'], 404);
        }

        $newPassword = $user->username . rand(100000, 999999);

        $user->password = bcrypt($newPassword);
        $query = $user->save();

        if ($query) {
            $maildata = [
                'name' => $user->fname . ' ' . $user->lname,
                'company' => $user->company,
                'username' => $user->username,
                'password' => $newPassword
            ];

            $headers = "From: webmaster@example.com\r\n";
            $headers .= "Reply-To: webmaster@example.com\r\n";
            $headers .= "Content-Type: text/html\r\n";
            $subject = 'Password Reset Request';
            $emailTemplate = view('emails.reset', compact(['maildata']))->render();
            $sendMail = mail($user->email, $subject, $emailTemplate, $headers);

            if (!$sendMail) {
                return response()->json(['msg' => 'error', 'response' => 'Could not send email.'], 400);
            }

            return response()->json(['msg' => 'success', 'response' => 'Please check your inbox on registered email address to access your account and further instructions.'], 200);
        }
    }

    public function me()
    {
        $user = Auth::user();
        $company = $user->company;
        return response()->json(['msg' => 'success', 'response' => 'User details.', 'user' => $user], 200);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json(['msg' => 'success', 'response' => 'Successfully logged out']);
    }
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 10800
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string',
            'c_new_password' => 'required| min:6 |string|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $user = Auth::user();
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['msg' => 'error', 'response' => 'Incorrect old password.'], 400);
        }

        $user->password = bcrypt($request->new_password);
        $query = $user->save();

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Password updated successfully.'], 200);
        }
        return response()->json(['msg' => 'error', 'response' => 'Could not update password.'], 400);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $authUser = Auth::user();

        // check if $request->email is different from $authUser->email
        if ($request->email != $authUser->email) {
            $user = User::where('email', $request->email)->first();
            if ($user) {
                return response()->json(['msg' => 'error', 'response' => 'Email already exists.'], 400);
            }
        }
        
        $authUser->fname = $request->fname;
        $authUser->lname = $request->lname;
        $authUser->title = $request->title;
        $authUser->phone = $request->phone;
        $authUser->fax = $request->fax ??  $authUser->fax; 
        $authUser->email = $request->email;
        $query = $authUser->save();

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Profile updated successfully.', 'user' => $authUser], 200);
        }
    }
}
