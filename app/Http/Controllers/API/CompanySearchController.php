<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\Company;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CompanySearchController extends Controller
{
    public function searchByLocation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'required',
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

        if (($request->has('zip') && $request->has('radius')) && ($request->zip != '' && $request->radius != '')) {
            $latLngRange = CalculateLatLngRange($request->zip, $request->radius);
        } else {
            $latLngRange = null;
        }
        $query = Company::where('city', 'like', '%' . $request->city . '%');

        if ($latLngRange == null) {
            if ($request->has('state') && $request->state != '') {
                $query->where('state', 'like', '%' . $request->state . '%');
            }
        } else {
            $query->whereBetween('lat', [$latLngRange['lat_min'], $latLngRange['lat_max']])
                ->whereBetween('long', [$latLngRange['lng_min'], $latLngRange['lng_max']]);
        }
        $query->whereHas('companyProfile', function ($q) use ($request) {
            if ($request->has('reefer') && $request->reefer == 1) {
                $q->where('reefer', 1);
            }
            if ($request->has('hazmat') && $request->hazmat == 1) {
                $q->where('hazmat', 1);
            }
            if ($request->has('lift_gate') && $request->lift_gate == 1) {
                $q->where('lift_gate', 1);
            }
            if ($request->has('hr_24_dispatch') && $request->hr_24_dispatch == 1) {
                $q->where('hr_24_dispatch', 1);
            }
            if ($request->has('tsa_certified') && $request->tsa_certified == 1) {
                $q->where('tsa_certified', 1);
            }
            if ($request->has('on_demand_service') && $request->on_demand_service == 1) {
                $q->where('on_demand_service', 1);
            }
            if ($request->has('scheduled_routes') && $request->scheduled_routes == 1) {
                $q->where('scheduled_routes', 1);
            }
            if ($request->has('distributed_delivery') && $request->distributed_delivery == 1) {
                $q->where('distributed_delivery', 1);
            }
            if ($request->has('warehouse_facility') && $request->warehouse_facility == 1) {
                $q->where('warehouse_facility', 1);
            }
            if ($request->has('climate_controlled') && $request->climate_controlled == 1) {
                $q->where('climate_controlled', 1);
            }
            if ($request->has('biohazard_exp') && $request->biohazard_exp == 1) {
                $q->where('biohazard_exp', 1);
            }
            if ($request->has('pharma_distribution') && $request->pharma_distribution == 1) {
                $q->where('pharma_distribution', 1);
            }
            if ($request->has('international_freight') && $request->international_freight == 1) {
                $q->where('international_freight', 1);
            }
            if ($request->has('indirect_aircarrier') && $request->indirect_aircarrier == 1) {
                $q->where('indirect_aircarrier', 1);
            }
            if ($request->has('gps_fleet_system') && $request->gps_fleet_system == 1) {
                $q->where('gps_fleet_system', 1);
            }
            if ($request->has('uniformed_drivers') && $request->uniformed_drivers == 1) {
                $q->where('uniformed_drivers', 1);
            }
            if ($request->has('interstate_service') && $request->interstate_service == 1) {
                $q->where('interstate_service', 1);
            }
            if ($request->has('whiteglove_service') && $request->whiteglove_service == 1) {
                $q->where('whiteglove_service', 1);
            }
            if ($request->has('process_legal_service') && $request->process_legal_service == 1) {
                $q->where('process_legal_service', 1);
            }
            if ($request->any != 1) {
                if ($request->car == 1) {
                    $q->where('car', $request->car);
                }
                if ($request->minivan == 1) {
                    $q->where('minivan', $request->minivan);
                }
                if ($request->suv == 1) {
                    $q->where('suv', $request->suv);
                }
                if ($request->cargo_van == 1) {
                    $q->where('cargo_van', $request->cargo_van);
                }
                if ($request->sprinter == 1) {
                    $q->where('sprinter', $request->sprinter);
                }
                if ($request->covered_pickup == 1) {
                    $q->where('covered_pickup', $request->covered_pickup);
                }
                if ($request->ft_16_truck == 1) {
                    $q->where('ft_16_truck', $request->ft_16_truck);
                }
                if ($request->ft_18_truck == 1) {
                    $q->where('ft_18_truck', $request->ft_18_truck);
                }
                if ($request->ft_20_truck == 1) {
                    $q->where('ft_20_truck', $request->ft_20_truck);
                }
                if ($request->ft_22_truck == 1) {
                    $q->where('ft_22_truck', $request->ft_22_truck);
                }
                if ($request->ft_24_truck == 1) {
                    $q->where('ft_24_truck', $request->ft_24_truck);
                }
                if ($request->ft_26_truck == 1) {
                    $q->where('ft_26_truck', $request->ft_26_truck);
                }
                if ($request->flatbed == 1) {
                    $q->where('flatbed', $request->flatbed);
                }
                if ($request->tractor_trailer == 1) {
                    $q->where('tractor_trailer', $request->tractor_trailer);
                }
            }
        });

        $companies = $query->get();
        if ($companies->count() > 0) {
            return response()->json(['msg' => 'success', 'response' => 'Companies retreived successfully', 'data' => $companies], 200);
        } else {
            return response()->json(['msg' => 'warning', 'response' => 'No Companies Found Matching The Search Parameters'], 404);
        }
    }

    public function searchByStates(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'states' => 'required',
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
        $states = json_decode($request->states);

        $query = Company::whereIn('state', $states);
        $query->whereHas('companyProfile', function ($q) use ($request) {
            if ($request->has('reefer') && $request->reefer == 1) {
                $q->where('reefer', 1);
            }
            if ($request->has('hazmat') && $request->hazmat == 1) {
                $q->where('hazmat', 1);
            }
            if ($request->has('lift_gate') && $request->lift_gate == 1) {
                $q->where('lift_gate', 1);
            }
            if ($request->has('hr_24_dispatch') && $request->hr_24_dispatch == 1) {
                $q->where('hr_24_dispatch', 1);
            }
            if ($request->has('tsa_certified') && $request->tsa_certified == 1) {
                $q->where('tsa_certified', 1);
            }
            if ($request->has('on_demand_service') && $request->on_demand_service == 1) {
                $q->where('on_demand_service', 1);
            }
            if ($request->has('scheduled_routes') && $request->scheduled_routes == 1) {
                $q->where('scheduled_routes', 1);
            }
            if ($request->has('distributed_delivery') && $request->distributed_delivery == 1) {
                $q->where('distributed_delivery', 1);
            }
            if ($request->has('warehouse_facility') && $request->warehouse_facility == 1) {
                $q->where('warehouse_facility', 1);
            }
            if ($request->has('climate_controlled') && $request->climate_controlled == 1) {
                $q->where('climate_controlled', 1);
            }
            if ($request->has('biohazard_exp') && $request->biohazard_exp == 1) {
                $q->where('biohazard_exp', 1);
            }
            if ($request->has('pharma_distribution') && $request->pharma_distribution == 1) {
                $q->where('pharma_distribution', 1);
            }
            if ($request->has('international_freight') && $request->international_freight == 1) {
                $q->where('international_freight', 1);
            }
            if ($request->has('indirect_aircarrier') && $request->indirect_aircarrier == 1) {
                $q->where('indirect_aircarrier', 1);
            }
            if ($request->has('gps_fleet_system') && $request->gps_fleet_system == 1) {
                $q->where('gps_fleet_system', 1);
            }
            if ($request->has('uniformed_drivers') && $request->uniformed_drivers == 1) {
                $q->where('uniformed_drivers', 1);
            }
            if ($request->has('interstate_service') && $request->interstate_service == 1) {
                $q->where('interstate_service', 1);
            }
            if ($request->has('whiteglove_service') && $request->whiteglove_service == 1) {
                $q->where('whiteglove_service', 1);
            }
            if ($request->has('process_legal_service') && $request->process_legal_service == 1) {
                $q->where('process_legal_service', 1);
            }
            if ($request->any != 1) {
                if ($request->car == 1) {
                    $q->where('car', $request->car);
                }
                if ($request->minivan == 1) {
                    $q->where('minivan', $request->minivan);
                }
                if ($request->suv == 1) {
                    $q->where('suv', $request->suv);
                }
                if ($request->cargo_van == 1) {
                    $q->where('cargo_van', $request->cargo_van);
                }
                if ($request->sprinter == 1) {
                    $q->where('sprinter', $request->sprinter);
                }
                if ($request->covered_pickup == 1) {
                    $q->where('covered_pickup', $request->covered_pickup);
                }
                if ($request->ft_16_truck == 1) {
                    $q->where('ft_16_truck', $request->ft_16_truck);
                }
                if ($request->ft_18_truck == 1) {
                    $q->where('ft_18_truck', $request->ft_18_truck);
                }
                if ($request->ft_20_truck == 1) {
                    $q->where('ft_20_truck', $request->ft_20_truck);
                }
                if ($request->ft_22_truck == 1) {
                    $q->where('ft_22_truck', $request->ft_22_truck);
                }
                if ($request->ft_24_truck == 1) {
                    $q->where('ft_24_truck', $request->ft_24_truck);
                }
                if ($request->ft_26_truck == 1) {
                    $q->where('ft_26_truck', $request->ft_26_truck);
                }
                if ($request->flatbed == 1) {
                    $q->where('flatbed', $request->flatbed);
                }
                if ($request->tractor_trailer == 1) {
                    $q->where('tractor_trailer', $request->tractor_trailer);
                }
            }
        });

        $companies = $query->get();

        if ($companies->isEmpty()) {
            return response()->json(['msg' => 'warning', 'response' => 'No Companies Found Matching The Search Parameters'], 404);
        } else {
            return response()->json(['msg' => 'success', 'response' => 'Companies retrieved successfully', 'data' => $companies], 200);
        }
    }

    public function searchByAirport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'airport_code' => 'required',
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

        $airport = Airport::where('code', $request->airport_code)->first();
        if (!$airport) {
            return response()->json(['msg' => 'error', 'response' => 'Airport not found in records.'], 404);
        }
        $query = Company::whereHas('companyAirports', function ($q) use ($request, $airport) {
            $q->where('airport_id', $airport->id);
        });
        $query->whereHas('companyProfile', function ($q) use ($request) {
            if ($request->has('reefer') && $request->reefer == 1) {
                $q->where('reefer', 1);
            }
            if ($request->has('hazmat') && $request->hazmat == 1) {
                $q->where('hazmat', 1);
            }
            if ($request->has('lift_gate') && $request->lift_gate == 1) {
                $q->where('lift_gate', 1);
            }
            if ($request->has('hr_24_dispatch') && $request->hr_24_dispatch == 1) {
                $q->where('hr_24_dispatch', 1);
            }
            if ($request->has('tsa_certified') && $request->tsa_certified == 1) {
                $q->where('tsa_certified', 1);
            }
            if ($request->has('on_demand_service') && $request->on_demand_service == 1) {
                $q->where('on_demand_service', 1);
            }
            if ($request->has('scheduled_routes') && $request->scheduled_routes == 1) {
                $q->where('scheduled_routes', 1);
            }
            if ($request->has('distributed_delivery') && $request->distributed_delivery == 1) {
                $q->where('distributed_delivery', 1);
            }
            if ($request->has('warehouse_facility') && $request->warehouse_facility == 1) {
                $q->where('warehouse_facility', 1);
            }
            if ($request->has('climate_controlled') && $request->climate_controlled == 1) {
                $q->where('climate_controlled', 1);
            }
            if ($request->has('biohazard_exp') && $request->biohazard_exp == 1) {
                $q->where('biohazard_exp', 1);
            }
            if ($request->has('pharma_distribution') && $request->pharma_distribution == 1) {
                $q->where('pharma_distribution', 1);
            }
            if ($request->has('international_freight') && $request->international_freight == 1) {
                $q->where('international_freight', 1);
            }
            if ($request->has('indirect_aircarrier') && $request->indirect_aircarrier == 1) {
                $q->where('indirect_aircarrier', 1);
            }
            if ($request->has('gps_fleet_system') && $request->gps_fleet_system == 1) {
                $q->where('gps_fleet_system', 1);
            }
            if ($request->has('uniformed_drivers') && $request->uniformed_drivers == 1) {
                $q->where('uniformed_drivers', 1);
            }
            if ($request->has('interstate_service') && $request->interstate_service == 1) {
                $q->where('interstate_service', 1);
            }
            if ($request->has('whiteglove_service') && $request->whiteglove_service == 1) {
                $q->where('whiteglove_service', 1);
            }
            if ($request->has('process_legal_service') && $request->process_legal_service == 1) {
                $q->where('process_legal_service', 1);
            }
            if ($request->any != 1) {
                if ($request->car == 1) {
                    $q->where('car', $request->car);
                }
                if ($request->minivan == 1) {
                    $q->where('minivan', $request->minivan);
                }
                if ($request->suv == 1) {
                    $q->where('suv', $request->suv);
                }
                if ($request->cargo_van == 1) {
                    $q->where('cargo_van', $request->cargo_van);
                }
                if ($request->sprinter == 1) {
                    $q->where('sprinter', $request->sprinter);
                }
                if ($request->covered_pickup == 1) {
                    $q->where('covered_pickup', $request->covered_pickup);
                }
                if ($request->ft_16_truck == 1) {
                    $q->where('ft_16_truck', $request->ft_16_truck);
                }
                if ($request->ft_18_truck == 1) {
                    $q->where('ft_18_truck', $request->ft_18_truck);
                }
                if ($request->ft_20_truck == 1) {
                    $q->where('ft_20_truck', $request->ft_20_truck);
                }
                if ($request->ft_22_truck == 1) {
                    $q->where('ft_22_truck', $request->ft_22_truck);
                }
                if ($request->ft_24_truck == 1) {
                    $q->where('ft_24_truck', $request->ft_24_truck);
                }
                if ($request->ft_26_truck == 1) {
                    $q->where('ft_26_truck', $request->ft_26_truck);
                }
                if ($request->flatbed == 1) {
                    $q->where('flatbed', $request->flatbed);
                }
                if ($request->tractor_trailer == 1) {
                    $q->where('tractor_trailer', $request->tractor_trailer);
                }
            }
        });

        $companies = $query->get();

        if ($companies->isEmpty()) {
            return response()->json(['msg' => 'warning', 'response' => 'No Companies Found Matching The Search Parameters'], 404);
        } else {
            return response()->json(['msg' => 'success', 'response' => 'Companies retrieved successfully', 'data' => $companies], 200);
        }
    }

    public function searchByName(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $companies = Company::where('name', 'like', '%' . $request->name . '%')->get();

        if ($companies->isEmpty()) {
            return response()->json(['msg' => 'warning', 'response' => 'No Companies Found Matching The Search Parameters'], 404);
        } else {
            return response()->json(['msg' => 'success', 'response' => 'Companies retrieved successfully', 'data' => $companies], 200);
        }
    }

    public function searchByWarehouse(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'city' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        if (($request->has('zip') && $request->has('radius')) && ($request->zip != '' && $request->radius != '')) {
            $latLngRange = CalculateLatLngRange($request->zip, $request->radius);
        } else {
            $latLngRange = null;
        }
        $query = Warehouse::where('city', 'like', '%' . $request->city . '%');

        if ($latLngRange == null) {
            if ($request->has('state') && $request->state != '') {
                $query->where('state', 'like', '%' . $request->state . '%');
            }
        } else {
            $query->whereBetween('lat', [$latLngRange['lat_min'], $latLngRange['lat_max']])
                ->whereBetween('long', [$latLngRange['lng_min'], $latLngRange['lng_max']]);
        }

        $warehouses = $query->get();
        if ($warehouses->isEmpty()) {
            return response()->json(['msg' => 'warning', 'response' => 'No Warehouses Found With in the Search Parameters'], 404);
        } else {
            foreach ($warehouses as $warehouse) {
                $warehouse->company = $warehouse->company; 
            }

            return response()->json(['msg' => 'success', 'response' => 'Warehouses retrieved successfully', 'data' => $warehouses], 200);
        }
    }
}
