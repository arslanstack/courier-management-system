<div>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Driver Response Details</h5>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Driver Name :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $response['name'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> City :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $response['city'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> State :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $response['state'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Contact Email :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $response['contact_email'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Contact Phone :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $response['contact_phone'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Vehicles :</strong></label>
            </div>
            <div class="col-12">
                <label for="" class="col-form-label">
                    @foreach(json_decode($response['vehicle_types']) as $vehicleType)
                    {{ map_vehicle($vehicleType) }}
                    @endforeach
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Message :</strong></label>
            </div>
            <div class="col-12">
                <label for="" class="col-form-label">{{ $response['message']}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Posted By :</strong></label>
            </div>
            <div class="col-12">
                <label for="" class="col-form-label">{{ $response->user->fname . ' ' . $response->user->lname . ' From ' . $response->company->name}}</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>