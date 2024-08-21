<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\VehiclePost;
use App\Models\VehicleStop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VehiclePostController extends Controller
{
    public function index()
    {
        $authUser = Auth::user();
        $authCompany = $authUser->company;

        // all vehiclepostsby company
        $vehiclePosts = VehiclePost::where('company_id', $authCompany->id)->get();
        $vehiclePosts->load('vehicleStop');
        return response()->json(['msg' => 'success', 'response' => 'Vehicle posts retrieved successfully.', 'data' => $vehiclePosts], 200);
    }

    public function show($id)
    {
        $vehiclePost = VehiclePost::find($id);
        if ($vehiclePost) {
            $vehiclePost->load('vehicleStop');
            return response()->json(['msg' => 'success', 'response' => 'Vehicle post retrieved successfully.', 'data' => $vehiclePost], 200);
        }
        return response()->json(['msg' => 'error', 'response' => 'Vehicle post not found.'], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'route_type' => 'required',
            'vehicle_type' => 'required',
            'date_available' => 'required',
            'start_city' => 'required',
            'start_state' => 'required',
            'departure' => 'required',
            'destination_city' => 'required',
            'destination_state' => 'required',
            'arrival' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'contact_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = Auth::user();
        $company = $user->company;
        $start_cord = $this->getCoordinates($request->start_city, $request->start_state);
        $destination_cord = $this->getCoordinates($request->destination_city, $request->destination_state);
        $mileage = $this->calculateMileage($request->start_city, $request->start_state, $request->destination_city, $request->destination_state);
        $vehiclePost = new VehiclePost();
        $vehiclePost->user_id = $user->id;
        $vehiclePost->company_id = $company->id;
        $vehiclePost->route_type = $request->route_type;
        $vehiclePost->vehicle_type = $request->vehicle_type;
        $vehiclePost->date_available = $request->date_available;
        $vehiclePost->start_city = $request->start_city;
        $vehiclePost->start_state = $request->start_state;
        $vehiclePost->start_zip = $request->start_zip ?? null;
        $vehiclePost->start_lat = $start_cord['lat'] ?? null;
        $vehiclePost->start_lng = $start_cord['lng'] ?? null;
        $vehiclePost->departure = $request->departure;
        $vehiclePost->destination_city = $request->destination_city;
        $vehiclePost->destination_state = $request->destination_state;
        $vehiclePost->destination_zip = $request->destination_zip ?? null;
        $vehiclePost->destination_lat = $destination_cord['lat'] ?? null;
        $vehiclePost->destination_lng = $destination_cord['lng'] ?? null;
        $vehiclePost->arrival = $request->arrival;
        $vehiclePost->reefer = $request->reefer ?? 0;
        $vehiclePost->hazmat = $request->hazmat ?? 0;
        $vehiclePost->liftgate = $request->liftgate ?? 0;
        $vehiclePost->round_trip = $request->round_trip ?? 0;
        $vehiclePost->other_info = $request->other_info ?? null;
        $vehiclePost->contact_name = $request->contact_name;
        $vehiclePost->contact_phone = $request->contact_phone;
        $vehiclePost->contact_email = $request->contact_email;
        $vehiclePost->mileage = $mileage ?? null;
        $query = $vehiclePost->save();

        if ($query) {
            if ($request->stops) {
                $request->stops = json_decode($request->stops, true);
                foreach ($request->stops as $stop) {
                    $vehicleStop = new VehicleStop();
                    $vehicleStop->vehicle_post_id = $vehiclePost->id;
                    $vehicleStop->city = $stop['city'];
                    $vehicleStop->state = $stop['state'];
                    $vehicleStop->zip = $stop['zip'] ?? null;
                    $vehicleStop->arrival = $stop['arrival'];
                    $vehicleStop->save();
                }
            }
            $vehiclePost->load('vehicleStop');
            return response()->json(['msg' => 'success', 'response' => 'Vehicle post created successfully.', 'data' => $vehiclePost], 200);
        }

        return response()->json(['msg' => 'error', 'response' => 'Could not create vehicle post. Please try again later.'], 401);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_post_id' => 'required',
            'route_type' => 'required',
            'vehicle_type' => 'required',
            'date_available' => 'required',
            'start_city' => 'required',
            'start_state' => 'required',
            'departure' => 'required',
            'destination_city' => 'required',
            'destination_state' => 'required',
            'arrival' => 'required',
            'contact_name' => 'required',
            'contact_phone' => 'required',
            'contact_email' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $vehiclePost = VehiclePost::find($request->vehicle_post_id);

        if (!$vehiclePost) {
            return response()->json(['msg' => 'error', 'response' => 'Vehicle post not found.'], 404);
        }

        $authUser = Auth::user();
        $authCompany = $authUser->company;

        if ($vehiclePost->company_id != $authCompany->id) {
            return response()->json(['msg' => 'error', 'response' => 'You are not authorized to update this vehicle post.'], 401);
        }

        $start_cord = $this->getCoordinates($request->start_city, $request->start_state);
        $destination_cord = $this->getCoordinates($request->destination_city, $request->destination_state);
        $mileage = $this->calculateMileage($request->start_city, $request->start_state, $request->destination_city, $request->destination_state);

        $vehiclePost->route_type = $request->route_type;
        $vehiclePost->vehicle_type = $request->vehicle_type;
        $vehiclePost->date_available = $request->date_available;
        $vehiclePost->start_city = $request->start_city;
        $vehiclePost->start_state = $request->start_state;
        $vehiclePost->start_zip = $request->start_zip ?? null;
        $vehiclePost->start_lat = $start_cord['lat'] ?? null;
        $vehiclePost->start_lng = $start_cord['lng'] ?? null;
        $vehiclePost->departure = $request->departure;
        $vehiclePost->destination_city = $request->destination_city;
        $vehiclePost->destination_state = $request->destination_state;
        $vehiclePost->destination_zip = $request->destination_zip ?? null;
        $vehiclePost->destination_lat = $destination_cord['lat'] ?? null;
        $vehiclePost->destination_lng = $destination_cord['lng'] ?? null;
        $vehiclePost->arrival = $request->arrival;
        $vehiclePost->reefer = $request->reefer ?? 0;
        $vehiclePost->hazmat = $request->hazmat ?? 0;
        $vehiclePost->liftgate = $request->liftgate ?? 0;
        $vehiclePost->round_trip = $request->round_trip ?? 0;
        $vehiclePost->other_info = $request->other_info ?? null;
        $vehiclePost->contact_name = $request->contact_name;
        $vehiclePost->contact_phone = $request->contact_phone;
        $vehiclePost->contact_email = $request->contact_email;
        $vehiclePost->mileage = $mileage ?? null;
        $query = $vehiclePost->save();

        if ($query) {
            if ($request->stops) {
                $request->stops = json_decode($request->stops, true);
                VehicleStop::where('vehicle_post_id', $vehiclePost->id)->delete();
                foreach ($request->stops as $stop) {
                    $vehicleStop = new VehicleStop();
                    $vehicleStop->vehicle_post_id = $vehiclePost->id;
                    $vehicleStop->city = $stop['city'];
                    $vehicleStop->state = $stop['state'];
                    $vehicleStop->zip = $stop['zip'] ?? null;
                    $vehicleStop->arrival = $stop['arrival'];
                    $vehicleStop->save();
                }
            }

            $vehiclePost->load('vehicleStop');
            return response()->json(['msg' => 'success', 'response' => 'Vehicle post updated successfully.', 'data' => $vehiclePost], 200);
        }

        return response()->json(['msg' => 'error', 'response' => 'Could not update vehicle post. Please try again later.'], 401);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_available' => 'required',
            'vehicle_type' => 'required',
            'city' => 'required',
            'state' => 'required',
            'radius' => 'required',
            'post_time' => 'required',
            'reefer' => 'required',
            'hazmat' => 'required',
            'lift_gate' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $authUser = Auth::user();

        $vehiclePosts = VehiclePost::where('date_available', $request->date_available);

        $addr_cord = null;
        if ($request->has('zip')) {
            $addr_cord = $this->getCordinatesofAddr($request->zip);
        }

        if ($addr_cord == null) {
            $addr = $request->city . ', ' . $request->state;
            $addr = str_replace(" ", "+", $addr);
            $addr_cord = $this->getCordinatesofAddr($request->city, $request->state);

            if ($addr_cord == null) {
                return response()->json(['msg' => 'error', 'response' => 'Could not get coordinates of address. Could not create search parameter.'], 401);
            }
        }

        $search_param = $this->findSearchParameter($request->radius, $addr_cord['lat'], $addr_cord['lng']);

        $vehiclePosts = $vehiclePosts->where('start_lat', '>=', $search_param['min_lat'])
            ->where('start_lat', '<=', $search_param['max_lat'])
            ->where('start_lng', '>=', $search_param['min_lng'])
            ->where('start_lng', '<=', $search_param['max_lng']);


        if ($request->vehicle_type != 0) {
            $vehiclePosts = $vehiclePosts->whereIn('vehicle_type', [0, $request->vehicle_type]);
        }

        if ($request->reefer != 0 && $request->reefer != null) {
            $vehiclePosts = $vehiclePosts->where('reefer', 1);
        }

        if ($request->hazmat != 0 && $request->hazmat != null) {
            $vehiclePosts = $vehiclePosts->where('hazmat', 1);
        }
        if ($request->lift_gate != 0 && $request->lift_gate != null) {
            $vehiclePosts = $vehiclePosts->where('liftgate', 1);
        }
        if ($request->post_time == 1) {
            $startTime = now()->subMinutes(30);
            $vehiclePosts = $vehiclePosts->whereBetween('created_at', [$startTime, now()]);
        }
        if ($request->post_time == 2) {
            $startTime = now()->subHours(1);
            $vehiclePosts = $vehiclePosts->whereBetween('created_at', [$startTime, now()]);
        }
        if ($request->post_time == 3) {
            $startTime = now()->subHours(2);
            $vehiclePosts = $vehiclePosts->whereBetween('created_at', [$startTime, now()]);
        }
        if ($request->post_time == 4) {
            $startTime = now()->subHours(4);
            $vehiclePosts = $vehiclePosts->whereBetween('created_at', [$startTime, now()]);
        }
        if ($request->post_time == 5) {
            $startTime = now()->subHours(8);
            $vehiclePosts = $vehiclePosts->whereBetween('created_at', [$startTime, now()]);
        }
        $vehiclePosts = $vehiclePosts->get();
        $vehiclePosts->load('vehicleStop');

        return response()->json(['msg' => 'success', 'response' => 'Vehicle posts retrieved successfully.', 'data' => $vehiclePosts], 200);
    }


    public function sendMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_post_id' => 'required',
            'name' => 'required',
            'from_email' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $vehiclePost = VehiclePost::find($request->vehicle_post_id);

        if (!$vehiclePost) {
            return response()->json(['msg' => 'error', 'response' => 'Vehicle post not found.'], 404);
        }

        $authUser = Auth::user();

        if ($vehiclePost->company_id == $authUser->company->id) {
            return response()->json(['msg' => 'error', 'response' => 'You are not supposed to send mail for vehicle post by your own company.'], 401);
        }
        $from_company = $authUser->company->name;
        $maildata = [
            'start_addr' => $vehiclePost->start_city . ', ' . $vehiclePost->start_state,
            'destination_addr' => $vehiclePost->destination_city . ', ' . $vehiclePost->destination_state,
            'date' => $vehiclePost->date_available,
            'to_name' => $vehiclePost->contact_name,
            'from_name' => $request->name,
            'from_company' => $from_company,
            'from_email' => $request->from_email,
            'from_phone' => $request->phone,
            'subject' => $request->subject,
            'body' => $request->body,
        ];

        $headers = "From: webmaster@example.com\r\n";
        $headers .= "Reply-To: webmaster@example.com\r\n";
        $headers .= "Content-Type: text/html\r\n";
        $subject = 'A user showed interest in your vehicle available post';
        $emailTemplate = view('emails.vehicleInterest', compact(['maildata']))->render();
        $sendMail = mail($request->from_email, $request->subject, $emailTemplate, $headers);

        if($sendMail){
            return response()->json(['msg' => 'success', 'response' => 'Mail sent successfully.'], 200);
        } else {
            return response()->json(['msg' => 'error', 'response' => 'Could not send mail. Please try again later.'], 401);
        }
    }
    public function deleteMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_post_ids' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $vehiclePostIds = json_decode($request->vehicle_post_ids, true);

        $authUser = Auth::user();
        $authCompany = $authUser->company;

        $vehiclePosts = VehiclePost::whereIn('id', $vehiclePostIds)->get();

        foreach ($vehiclePosts as $vehiclePost) {
            if ($vehiclePost->company_id != $authCompany->id) {
                return response()->json(['msg' => 'error', 'response' => 'You are not authorized to delete this vehicle post.'], 401);
            }
        }

        $query = VehiclePost::whereIn('id', $vehiclePostIds)->delete();
        $query2 = VehicleStop::whereIn('vehicle_post_id', $vehiclePostIds)->delete();

        if ($query) {
            return response()->json(['msg' => 'success', 'response' => 'Vehicle posts deleted successfully.'], 200);
        }

        return response()->json(['msg' => 'error', 'response' => 'Could not delete vehicle posts. Please try again later.'], 401);
    }

    function getCoordinates($city, $state)
    {
        $address = $city . ', ' . $state;
        $address = str_replace(" ", "+", $address);
        $key = 'AIzaSyBy2l4KGGTm4cTqoSl6h8UAOAob87sHBsA';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=$key";
        $response = file_get_contents($url);
        $response = json_decode($response, true);
        if ($response['status'] == 'OK') {
            return $response['results'][0]['geometry']['location'];
        } else {
            return null;
        }
    }

    function  calculateMileage($start_city, $start_state, $destination_city, $destination_state)
    {
        $start_address = $start_city . ', ' . $start_state;
        $start_address = str_replace(" ", "+", $start_address);
        $destination_address = $destination_city . ', ' . $destination_state;
        $destination_address = str_replace(" ", "+", $destination_address);
        $key = 'AIzaSyBy2l4KGGTm4cTqoSl6h8UAOAob87sHBsA';
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin={$start_address}&destination={$destination_address}&key={$key}";
        $response = file_get_contents($url);
        $response = json_decode($response, true);
        if ($response['status'] == 'OK') {
            return $response['routes'][0]['legs'][0]['distance']['text'];
        } else {
            return null;
        }
    }

    function getCordinatesofAddr($addr)
    {
        $key = 'AIzaSyBy2l4KGGTm4cTqoSl6h8UAOAob87sHBsA';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$addr&key=$key";
        $response = file_get_contents($url);
        $response = json_decode($response, true);
        if ($response['status'] == 'OK') {
            return $response['results'][0]['geometry']['location'];
        } else {
            return null;
        }
    }

    function findSearchParameter($radius, $lat, $lng)
    {
        $earth_radius = 3960.00;
        $lat = deg2rad($lat);
        $lng = deg2rad($lng);
        $radius = $radius / $earth_radius;

        $min_lat = $lat - $radius;
        $max_lat = $lat + $radius;

        $min_lng = $lng - $radius;
        $max_lng = $lng + $radius;

        $min_lat = rad2deg($min_lat);
        $max_lat = rad2deg($max_lat);

        $min_lng = rad2deg($min_lng);
        $max_lng = rad2deg($max_lng);

        return ['min_lat' => $min_lat, 'max_lat' => $max_lat, 'min_lng' => $min_lng, 'max_lng' => $max_lng];
    }
}
