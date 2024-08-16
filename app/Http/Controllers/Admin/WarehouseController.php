<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $query = Warehouse::query();
        $search_query = $request->input('search_query');
        if (($request->has('search_query') && !empty($search_query))) {
            $query->where(function ($query) use ($search_query) {
                $query->where('name', 'like', '%' . $search_query . '%')
                    ->orWhere('city', 'like', '%' . $search_query . '%')
                    ->orWhere('country', 'like', '%' . $search_query . '%')
                    ->orWhere('zip', 'like', '%' . $search_query . '%')
                    ->orWhereHas('company', function ($query) use ($search_query) {
                        $query->where('name', 'like', '%' . $search_query . '%');
                    });
            });
        }
        $data['warehouses'] = $query->orderBy('id', 'DESC')->paginate(50);
        $data['searchParams'] = $request->all();
        return view('admin/warehouses/manage_warehouses', $data);
    }

    public function show(Request $request)
    {
        $warehouse = Warehouse::where('id', $request->id)->first();
        if (!empty($warehouse)) {
            $htmlresult = view('admin/warehouses/warehouse_ajax', compact('warehouse'))->render();
            $finalResult = response()->json(['msg' => 'success', 'response' => $htmlresult]);
            return $finalResult;
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Warehouse not found.']);
        }
    }
}
