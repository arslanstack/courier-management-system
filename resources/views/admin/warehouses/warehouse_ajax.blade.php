<div>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Warehouse Details</h5>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Owner Company :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $warehouse->company->name }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Zip Code :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $warehouse['zip'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> City :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $warehouse['city'] ?? '-'}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> State :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $warehouse['state'] ?? '-'}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Country :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $warehouse['country'] ?? '-'}}</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>