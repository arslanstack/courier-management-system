<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
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
        return view('admin/companies/company_details', $data);
    }
}
