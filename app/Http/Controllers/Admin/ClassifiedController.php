<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classified;
use Illuminate\Http\Request;

class ClassifiedController extends Controller
{
    public function index(Request $request)
    {
        $query = Classified::query();
        $search_query = $request->input('search_query');
        if (($request->has('search_query') && !empty($search_query))) {
            $query->where(function ($query) use ($search_query) {
                $query->where('location', 'like', '%' . $search_query . '%')
                    ->orWhere('state', 'like', '%' . $search_query . '%')
                    ->orWhere('title', 'like', '%' . $search_query . '%')
                    ->orWhereHas('company', function ($query) use ($search_query) {
                        $query->where('name', 'like', '%' . $search_query . '%');
                    });
            });
        }
        $data['classifieds'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/classifieds/manage_classifieds', $data);
    }

    public function show(Request $request)
    {
        $classified = Classified::where('id', $request->id)->first();
        if (!empty($classified)) {
            $htmlresult = view('admin/classifieds/classified_ajax', compact('classified'))->render();
            $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
            return $finalResult;
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Classified not found.']);
        }
    }
}
