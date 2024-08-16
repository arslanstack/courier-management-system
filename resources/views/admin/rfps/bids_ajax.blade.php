<div>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">RFP Bid Details</h5>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Bidding Company :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $bid['company'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Bidding User :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $bid['user'] }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Bid Amount :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $bid['amount'] }} USD</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Contact Name :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $bid['contact_name']}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Contact Phone :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $bid['contact_phone']}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Contact Email :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $bid['contact_email']}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Terms of Contract :</strong></label>
            </div>
            <div class="col-12">
                <label for="" class="col-form-label">{{ $bid['terms']}}</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>