@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8 col-sm-8 col-xs-8">
        <h2> Recurring Freight Postings </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('admin') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                <strong> Recurring Freight Postings </strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form id="search_form" action="{{url('admin/rfps')}}" method="GET" enctype="multipart/form-data">
                        <div class="form-group row justify-content-end">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_query" placeholder="Search by Company, Pickup, Delivery, or Insurance" value="{{ old('search_query', $searchParams['search_query'] ?? '') }}">
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
                                    <th>Pickup</th>
                                    <th>Delivery</th>
                                    <th>Insurance Coverage</th>
                                    <th>Estimated Mileage</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($rfps as $item)
                                <tr class="gradeX">
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item->user->company->name }}</td>
                                    <td>{{$item->start_point}}</td>
                                    <td>{{$item->delivery_point}}</td>
                                    <td>{{$item->insurance_coverage}}</td>
                                    <td>{{$item->estimated_mileage ?? '-'}}</td>
                                    
                                    <td>
                                        <a href="{{ url('admin/rfps/detail') }}/{{ $item->id }}" class="btn btn-primary btn-sm" data-placement="top" title="Details"><i class="fa-solid fa-file-text-o"></i> Details </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <p>Showing {{ $rfps->firstItem() }} to {{ $rfps->lastItem() }} of {{ $rfps->total() }} entries</p>
                        </div>
                        <div class="col-md-3 text-right">
                            {{ $rfps->links('pagination::bootstrap-4') }}
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