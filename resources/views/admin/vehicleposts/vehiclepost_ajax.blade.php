<div>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Vehicle Post Details</h5>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong>Company :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost->company->name }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong>Date :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost->date_available }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong>Vehicle :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ map_vehicle($vehiclePost->vehicle_type )}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong>Route Type :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost->route_type == 0 ? 'On Demand' : 'Scheduled'}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Start City :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['start_city'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Start State :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['start_state'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Start Zip :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['start_zip'] ?? 'N/A' }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Departure :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['departure']  }} hrs</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Destination City :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['destination_city'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Destination State :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['destination_state'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Destination Zip :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['destination_zip'] ?? 'N/A' }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Arrival :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['arrival']  }} hrs</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Mileage :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['mileage'] ?? '-' }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Reefer :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['reefer'] == 0 ? 'Yes' : 'No' }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Liftgate :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['lift_gate'] == 0 ? 'Yes' : 'No' }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Hazmat :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['hazmat'] == 0 ? 'Yes' : 'No' }}</label>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Contact Phone:</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['contact_phone'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Contact Email:</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $vehiclePost['contact_email'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Status:</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ mapVehicleStatus($vehiclePost['status']) }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Stops:</strong></label>
            </div>
            <div class="col-12">
                @foreach($vehiclePost->stops as $stop)
                <label for="" class="col-form-label">{{$stop->arrival . ' hrs : ' .  $stop->city . ', ' . $stop->state }}</label> <br>
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Other Information:</strong></label>
            </div>
            <div class="col-12">
                <label for="" class="col-form-label">{{ $vehiclePost['other_info'] ?? 'N/A' }}</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>