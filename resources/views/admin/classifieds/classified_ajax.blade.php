<div>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <h5 class="modal-title">Classified Details</h5>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Author :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $classified->user->fname . ' ' . $classified->user->lname }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Screen Name :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $classified->user->screen_name }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Location :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $classified['location'] ?? '-' }}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> State :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ $classified['state']}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Category :</strong></label>
            </div>
            <div class="col-6">
                <label for="" class="col-form-label">{{ mapCategory($classified['category'])}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Title :</strong></label>
            </div>
            <div class="col-12">
                <label for="" class="col-form-label">{{ $classified['title']}}</label>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="" class="col-form-label"><strong> Description :</strong></label>
            </div>
            <div class="col-12">
                <label for="" class="col-form-label">{{ $classified['description']}}</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
    </div>