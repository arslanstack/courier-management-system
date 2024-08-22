<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\Company;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::query();
        $search_query = $request->input('search_query');
        if (($request->has('search_query') && !empty($search_query))) {
            $query->where(function ($query) use ($search_query) {
                $query->where('name', 'like', '%' . $search_query . '%')
                    ->orWhere('state', 'like', '%' . $search_query . '%')
                    ->orWhere('city', 'like', '%' . $search_query . '%')
                    ->orWhere('zip', 'like', '%' . $search_query . '%');
            });
        }
        $data['companies'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/companies/manage_companies', $data);
    }

    public function details($id)
    {
        $company = Company::find($id);
        if(!$company){
            return redirect()->back()->with('error', 'Company not found');
        }
        $data['users'] = $company->users;
        $data['company'] = $company;
        $data['features'] = CompanyProfile::where('company_id', $company->id)->first();
        $data['warehouses'] = $company->Warehouses;
        $data['vehiclePosts'] = $company->vehiclePosts;
        $data['driverAds'] = $company->driverAds;
        $companyAirports = $company->companyAirports;
        $data['airports'] = [];
        foreach ($companyAirports as $airport){
            $airportDetails = Airport::where('id', $airport->airport_id)->first();
            $data['airports'][] = $airportDetails;
        }
        $data['quoteRequests'] = $company->quoteRequests;
        $data['quoteBids'] = $company->quoteBids;
        return view('admin/companies/company_details', $data);
    }
}
