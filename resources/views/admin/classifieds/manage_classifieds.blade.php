@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8 col-sm-8 col-xs-8">
        <h2>Classifieds</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Classifieds</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form id="search_form" action="{{url('admin/classifieds')}}" method="GET" enctype="multipart/form-data">
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_query" placeholder="Search by Title, State, Location, or Company" value="{{ old('search_query', $searchParams['search_query'] ?? '') }}">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table id="manage_tbl" class="table table-striped table-bordered dt-responsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sr #</th>
                                    <th>Title</th>
                                    <th>Company</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($classifieds as $item)
                                <tr class="gradeX">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->title ?? '-' }}</td>
                                    <td>{{$item->company->name ?? '-'}}</td>
                                    <td>{{$item->location . ' ' . $item->state}}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm btn_classified_edit" data-id="{{$item->id}}" type="button"><i class="fa-solid fa-details"></i> Details</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p>Showing {{ $classifieds->firstItem() }} to {{ $classifieds->lastItem() }} of {{ $classifieds->total() }} entries</p>
                        </div>
                        <div class="col-md-3 text-right">
                            {{ $classifieds->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal inmodal show fade" id="edit_modalbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content animated flipInY" id="edit_modalbox_body">
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
    $(document).on("click", ".btn_classified_edit", function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: "{{ url('admin/classifieds/show') }}",
            type: 'POST',
            dataType: 'json',
            data: {
                "_token": "{{ csrf_token() }}",
                'id': id
            },
            success: function(status) {
                $("#edit_modalbox_body").html(status.response);
                $("#edit_modalbox").modal('show');
            }
        });
    });
</script>
@endpush