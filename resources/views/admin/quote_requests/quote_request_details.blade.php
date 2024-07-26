@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-8 col-sm-8 col-xs-8">
		<h2>Quote Requests Details </h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin/quote-requests') }}">Quote Requests</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Quote Requests Details </strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-4 col-sm-4 col-xs-4 text-right">
		<a class="btn btn-primary t_m_25" href="{{ url('admin/quote-requests') }}">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Quote Requests
		</a>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="tabs-container">
				<ul class="nav nav-tabs" role="tablist">
					<li class="show_details"><a class="nav-link active show" data-toggle="tab" href="#tab-1">Quote Requests Details</a></li>
					<li class="show_users"><a class="nav-link" data-toggle="tab" href="#tab-2">Bidding</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active show" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Quote Requests Details</h5>
							</div>
							<div class="ibox-content">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Company Name :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->company->name }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>User :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->user->fname . ' ' . $quoteRequests->user->lname}}</label>
										</div>
									</div>
									<!-- <div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Phone Number :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_contact_phone }}</label>
										</div>
									</div> -->
								</div>
								<!-- <div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Email :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_contact_email }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Company :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_company }}</label>
										</div>
									</div>
								</div> -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Date & Time :</strong>
											</label>

											<label class="col-8 col-form-label">{{ date_formated($quoteRequests->pickup_date) }} {{ $quoteRequests->pickup_time . 'hrs' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Latest Delivery Time :</strong>
											</label>

											<label class="col-8 col-form-label">{{ date_formated($quoteRequests->delivery_time) . ' ' . 'hrs' }}</label>
										</div>
									</div>
									<!-- <div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Start Point :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->start_point }}</label>
										</div>
									</div> -->
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Address 1 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_address_1 }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Address 2 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_address_2 }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>City :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_city }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>State :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_state }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Zip :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_zip }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Country :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_country }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Point :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_point }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Time :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_time }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Address 1 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_address_1 }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Address 2 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_address_2 }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery City :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_city }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery State :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_state }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Zip :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_zip }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Contact Name :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_contact_name}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Contact Phone :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_contact_phone }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Contact Email :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_contact_email }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Estimated Mmileage :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->estimated_mileage}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Weight :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->weight}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Dimensions :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->dimensions }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Description :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->description}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Vehicle :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->vehicle}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Reefer :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->reefer }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Hazmat :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->hazmat}} </label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Lift Gate :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->lift_gate }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Country :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_country}} </label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Company :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_company}}</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-2" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Bidding</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl" class="table table-striped table-bordered dt-responsive" style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Name</th>
												<th>Title</th>
												<th>Phone</th>
												<th>Access</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											{{-- @php($i = 1)
											@foreach($bidding as $item)
											<tr class="gradeX">
												<td>{{ $i++ }}</td>
												<td>{{ $item->fname . ' ' . $item->lname }}</td>
												<td>{{$item->title}}</td>
												<td>{{$item->phone}}</td>
												<td>
													@if($item->is_major_user == 0)
													<span class="label label-primary">Sub-user</span>
													@else
													<span class="label label-success">Admin</span>
													@endif
												</td>
												<td>
													<a href="{{ url('admin/users/detail') }}/{{ $item->id }}" class="btn btn-primary btn-sm" data-placement="top" title="Details"><i class="fa-solid fa-file-text-o"></i> Details </a>
												</td>
											</tr>
											@endforeach --}}
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
	$(document).on('click', '.show_users', function() {
		if (!($("table#manage_tbl").hasClass("dataTable"))) {
			$('#manage_tbl').dataTable({
				"paging": true,
				"searching": true,
				"bInfo": true,
				"responsive": true,
				"pageLength": 50,
				"columnDefs": [{
					"responsivePriority": 1,
					"targets": 0
				},
				{
					"responsivePriority": 2,
					"targets": -1
				},
				]
			});
		}
	});
</script>
@endpush