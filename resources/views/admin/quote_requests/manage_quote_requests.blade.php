@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8 col-sm-8 col-xs-8">
        <h2> Quote Requests </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong> Quote Requests </strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form id="search_form" action="{{url('admin/quote-requests')}}" method="GET" enctype="multipart/form-data">
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_query" placeholder="Search by Company, Pickup, Delivery, or Date" value="{{ old('search_query', $searchParams['search_query'] ?? '') }}">
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
                                    <th>Company</th>
                                    <th>Pickup Zip</th>
                                    <th>Delivery Zip</th>
                                    <th>Pickup Date</th>
                                    <th>Estimated Mileage</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($quoteRequests as $item)
                                <tr class="gradeX">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->company->name }}</td>
                                    <td>{{$item->pickup_zip}}</td>
                                    <td>{{$item->delivery_zip}}</td>
                                    <td>{{$item->pickup_date}}</td>
                                    <td>{{$item->estimated_mileage ?? '-'}}</td>
                                    <td>
                                        @if($item->status == 0 || 1)
                                        <span class="label label-dark">Listed</span>
                                        @elseif($item->status == 2)
                                        <span class="label label-primary">Bid Accepted</span>
                                        @elseif($item->status == 3)
                                        <span class="label label-success">Delivered</span>
                                        @elseif($item->status == 4)
                                        <span class="label label-red">Removed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('admin/quote-requests/detail') }}/{{ $item->id }}" class="btn btn-primary btn-sm" data-placement="top" title="Details"><i class="fa-solid fa-file-text-o"></i> Details </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p>Showing {{ $quoteRequests->firstItem() }} to {{ $quoteRequests->lastItem() }} of {{ $quoteRequests->total() }} entries</p>
                        </div>
                        <div class="col-md-3 text-right">
                            {{ $quoteRequests->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush