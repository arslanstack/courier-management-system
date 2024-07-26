<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyManagementController extends Controller
{
    public function updateCompanyAlertMails(Request $request)
    {
        $authUser = Auth::user();
        if ($authUser->is_major_user == 0 && $authUser->has_acc_info == 0) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to perform this action'], 401);
        }
        $company = Company::where('id', $authUser->company->id)->first();
        $company->alert_email_1 = $request->alert_email_1 ??  null;
        $company->alert_email_2 = $request->alert_email_2 ??  null;
        $query = $company->save();
        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Alert emails could not be updated. Please try later'], 500);
        }
        return response()->json(['msg' => 'success', 'response' => 'Alert emails updated successfully'], 200);
    }

    public function updateAlertPref(Request $request)
    {
        $authUser = Auth::user();
        if ($authUser->is_major_user == 0 && $authUser->has_alerts == 0) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to perform this action'], 401);
        }

        $company = Company::where('id', $authUser->company->id)->first();
        $request->alert_freight && $request->alert_freight  == 1 ? $company->alert_freight = 1 : $company->alert_freight = 0;
        $request->alert_vehicle && $request->alert_vehicle == 1 ? $company->alert_vehicle = 1 : $company->alert_vehicle = 0;
        $request->alert_rpf && $request->alert_rpf  == 1 ? $company->alert_rpf = 1 : $company->alert_rpf = 0;
        $request->alert_driver && $request->alert_driver == 1 ? $company->alert_driver = 1 : $company->alert_driver = 0;
        $query = $company->save();
        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Alert preference could not be updated. Please try later'], 500);
        }
        return response()->json(['msg' => 'success', 'response' => 'Alert preference updated successfully'], 200);
    }

    public function getCompanyInfo()
    {
        $user = Auth::user();
        $company = Company::where('id', $user->company->id)->first();
        return response()->json(['msg' => 'success', 'response' => 'Company info retrieved successfully', 'company' => $company], 200);
    }

    public function updateCompanyInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'mail_address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'company_type' => 'required',
        ]);
        $user = Auth::user();

        if ($user->is_major_user == 0 && $user->has_acc_info == 0) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to perform this action'], 401);
        }

        $company = Company::where('id', $user->company->id)->first();
        $company->name = $request->name ?? $company->name;
        $company->mail_address_1 = $request->mail_address_1 ?? $company->mail_address_1;
        $company->mail_address_2 = $request->mail_address_2 ?? $company->mail_address_2;
        $company->city = $request->city ?? $company->city;
        $company->state = $request->state ?? $company->city;
        $company->country = $request->country ?? $company->city;
        $company->zip = $request->zip ?? $company->city;
        $company->company_type = $request->company_type ?? $company->city;
        $company->motor_carrier_no = $request->motor_carrier_no ?? $company->city;
        $company->dot_no = $request->dot_no ?? $company->city;
        $company->intrastate_no = $request->intrastate_no ?? $company->city;
        $query = $company->save();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Company info could not be updated. Please try later'], 500);
        }

        return response()->json(['msg' => 'success', 'response' => 'Company info updated successfully', 'company' => $company], 200);
    }

    public function updateCreditCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            'cvv' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'error', 'response' => $validator->errors()], 400);
        }

        $user = Auth::user();
        $company = Company::where('id', $user->company->id)->first();

        if ($user->is_major_user == 0 && $user->has_acc_info == 0) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to perform this action'], 401);
        }

        $company->card_number = $request->card_number;
        $company->expiry_month = $request->expiry_month;
        $company->expiry_year = $request->expiry_year;
        $company->cvv = $request->cvv;
        $query = $company->save();

        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Credit card info could not be updated. Please try later'], 500);
        }

        return response()->json(['msg' => 'success', 'response' => 'Credit card info updated successfully', 'company' => $company], 200);
    }
}
