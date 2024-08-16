<div>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Edit Airport</h5>
    </div>
    <div class="modal-body">
        <form id="edit_airport_form" method="post">
            @csrf
            <input type="hidden" name="id" class="form-control" value="{{ $airport['id'] }}">
            <div class="form-group row">
                <label class="col-sm-4 col-form-label"><strong>Name</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control" placeholder="name" value="{{ $airport['name'] }}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label"><strong>Airport Code *</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="code" required class="form-control" value="{{$airport['code']}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label"><strong>City</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="city" class="form-control" value="{{$airport['city']}}">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label"><strong>Country</strong></label>
                <div class="col-sm-8">
                    <input type="text" name="country" required class="form-control" value="{{$airport['country']}}">
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="update_airport_button">Save Changes</button>
    </div>