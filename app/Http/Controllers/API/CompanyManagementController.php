<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use App\Models\RFP;
use Illuminate\Http\Request;

class CompanyManagementController extends Controller
{
    public function rfpsCount()
    {
        $authCompany = Auth::user()->company;
        $rfpsCount = RFP::whereHas('user', function ($query) use ($authCompany) {
            $query->where('company_id', $authCompany->id);
        })->count();
        return response()->json(['msg' => 'success', 'response' => 'RFPs count retrieved successfully', 'count' => $rfpsCount], 200);
    }

    public function quoteCount()
    {
        $authCompany = Auth::user()->company;
        $quotes = $authCompany->quoteRequests;
        $count = $quotes->count();
        return response()->json(['msg' => 'success', 'response' => 'Quotes count retrieved successfully', 'count' => $count], 200);
    }

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
        $request->alert_rfp && $request->alert_rfp  == 1 ? $company->alert_rfp = 1 : $company->alert_rfp = 0;
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
        $company->profile = CompanyProfile::where('company_id', $company->id)->first();
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
        $cordinates = return_cordinates($request->zip);
        $company = Company::where('id', $user->company->id)->first();
        $company->name = $request->name ?? $company->name;
        $company->mail_address_1 = $request->mail_address_1 ?? $company->mail_address_1;
        $company->mail_address_2 = $request->mail_address_2 ?? $company->mail_address_2;
        $company->city = $request->city ?? $company->city;
        $company->state = $request->state ?? $company->city;
        $company->country = $request->country ?? $company->city;
        $company->zip = $request->zip;
        $company->lat = $cordinates['lat'] ?? null;
        $company->long = $cordinates['long'] ?? null;
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

    public function updateCompanyProfileDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'error', 'response' => $validator->errors()], 400);
        }
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

    public function UpdateChecklist(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reefer' => 'required',
            'hazmat' => 'required',
            'lift_gate' => 'required',
            'hr_24_dispatch' => 'required',
            'tsa_certified' => 'required',
            'on_demand_service' => 'required',
            'scheduled_routes' => 'required',
            'distributed_delivery' => 'required',
            'warehouse_facility' => 'required',
            'climate_controlled' => 'required',
            'biohazard_exp' => 'required',
            'pharma_distribution' => 'required',
            'international_freight' => 'required',
            'indirect_aircarrier' => 'required',
            'gps_fleet_system' => 'required',
            'uniformed_drivers' => 'required',
            'interstate_service' => 'required',
            'whiteglove_service' => 'required',
            'process_legal_service' => 'required',
            'car' => 'required',
            'minivan' => 'required',
            'suv' => 'required',
            'cargo_van' => 'required',
            'sprinter' => 'required',
            'covered_pickup' => 'required',
            'ft_16_truck' => 'required',
            'ft_18_truck' => 'required',
            'ft_20_truck' => 'required',
            'ft_22_truck' => 'required',
            'ft_24_truck' => 'required',
            'ft_26_truck' => 'required',
            'flatbed' => 'required',
            'tractor_trailer' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $company = Auth::user()->company;

        $companyProfile = CompanyProfile::where('company_id', $company->id)->first();
        if (!$companyProfile) {
            $companyProfile = new CompanyProfile();
            $companyProfile->company_id = $company->id;
        }

        $companyProfile->reefer = $request->reefer;
        $companyProfile->hazmat = $request->hazmat;
        $companyProfile->lift_gate = $request->lift_gate;
        $companyProfile->hr_24_dispatch = $request->hr_24_dispatch;
        $companyProfile->tsa_certified = $request->tsa_certified;
        $companyProfile->on_demand_service = $request->on_demand_service;
        $companyProfile->scheduled_routes = $request->scheduled_routes;
        $companyProfile->distributed_delivery = $request->distributed_delivery;
        $companyProfile->warehouse_facility = $request->warehouse_facility;
        $companyProfile->climate_controlled = $request->climate_controlled;
        $companyProfile->biohazard_exp = $request->biohazard_exp;
        $companyProfile->pharma_distribution = $request->pharma_distribution;
        $companyProfile->international_freight = $request->international_freight;
        $companyProfile->indirect_aircarrier = $request->indirect_aircarrier;
        $companyProfile->gps_fleet_system = $request->gps_fleet_system;
        $companyProfile->uniformed_drivers = $request->uniformed_drivers;
        $companyProfile->interstate_service = $request->interstate_service;
        $companyProfile->whiteglove_service = $request->whiteglove_service;
        $companyProfile->process_legal_service = $request->process_legal_service;
        $companyProfile->car = $request->car;
        $companyProfile->minivan = $request->minivan;
        $companyProfile->suv = $request->suv;
        $companyProfile->cargo_van = $request->cargo_van;
        $companyProfile->sprinter = $request->sprinter;
        $companyProfile->covered_pickup = $request->covered_pickup;
        $companyProfile->ft_16_truck = $request->ft_16_truck;
        $companyProfile->ft_18_truck = $request->ft_18_truck;
        $companyProfile->ft_20_truck = $request->ft_20_truck;
        $companyProfile->ft_22_truck = $request->ft_22_truck;
        $companyProfile->ft_24_truck = $request->ft_24_truck;
        $companyProfile->ft_26_truck = $request->ft_26_truck;
        $companyProfile->flatbed = $request->flatbed;
        $companyProfile->tractor_trailer = $request->tractor_trailer;
        $query = $companyProfile->save();
        if (!$query) {
            return response()->json(['msg' => 'error', 'response' => 'Could not update company features checklist. Please try again.'], 500);
        }

        $company->features = $companyProfile;

        return response()->json(['msg' => 'success', 'response' => 'Company Features Checklist udpated successfully.', 'data' => $company], 200);
    }

    public function showFeaturesChecklist()
    {
        $company = Company::where('id', Auth::user()->company->id)->first();
        if (!$company) {
            return response()->json(['msg' => 'error', 'response' => 'Could not find company. Something went wrong. Try again later.'], 404);
        }
        $features = CompanyProfile::where('company_id', $company->id)->first();
        if (!$features) {
            $features = new CompanyProfile();
            $features->company_id = $company->id;
            $features->save();
        }
        $company->features = $features;
        return response()->json(['msg' => 'success', 'response' => 'Company Features CheckList retreived successfully.', 'data' => $company], 200);
    }
}
