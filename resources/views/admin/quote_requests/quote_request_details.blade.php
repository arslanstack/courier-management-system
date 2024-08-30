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
		<a class="btn btn-primary t_m_25" href="{!! URL::previous() !!}">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Go Back
		</a>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="tabs-container">
				<ul class="nav nav-tabs" role="tablist">
					<li class="show_details"><a class="nav-link active show" data-toggle="tab" href="#tab-1">Quote Requests Details</a></li>
					<li class="show_bids"><a class="nav-link" data-toggle="tab" href="#tab-2">Bids</a></li>
					<li class="chats"><a class="nav-link" data-toggle="tab" href="#tab-3">Chats</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active show" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Quote Requests Details</h5>
								<div class="ibox-tools">
									@if($quoteRequests->status == 0 || 1)
									<span class="label label-dark float-right">Listed</span>
									@elseif($quoteRequests->status == 2)
									<span class="label label-primary float-right">Bid Accepted</span>
									@elseif($quoteRequests->status == 3)
									<span class="label label-success float-right">Delivered</span>
									@elseif($quoteRequests->status == 4)
									<span class="label label-red float-right">Removed</span>
									@endif
								</div>
							</div>
							<div class="ibox-content">
								<!-- company and user posting -->
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
								</div>
								<!-- Pickup And Delviery date time -->
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

											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_time . ' ' . 'hrs' }}</label>
										</div>
									</div>
								</div>
								<!-- mileage -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Estimated Mileage :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->estimated_mileage ?? 'N/A' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Posted On :</strong>
											</label>
											<label class="col-8 col-form-label">{{ date_formated($quoteRequests->created_at) }}</label>
										</div>
									</div>
								</div>
								<!-- weight and dimensions -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Cargo Weight:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->weight }} lbs</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Cargo Dimension:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->dimensions }}</label>
										</div>
									</div>
								</div>
								<!-- vehicle and reefer -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Vehicle:</strong>
											</label>
											<label class="col-8 col-form-label">{{ map_vehicle($quoteRequests->vehicle )}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Reefer:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->reefer = 0 ? 'Not Required' : 'Required' }}</label>
										</div>
									</div>
								</div>
								<!-- hazmat and lift -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Hazmat:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->hazmat = 0 ? 'Not Required' : 'Required' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Lift Gate:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->lift_gate = 0 ? 'Not Required' : 'Required' }}</label>
										</div>
									</div>
								</div>
								<!-- description -->
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<label class="col-2 col-form-label">
												<strong>Description:</strong>
											</label>
											<label class="col-10 col-form-label">{{ $quoteRequests->description }}</label>
										</div>
									</div>
								</div>
								<!-- start and delivery point -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Starting Point:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->start_point }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Point:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_point }}</label>
										</div>
									</div>
								</div>
								<!-- pickup ad 1 and 2 -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Address 1 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_address_1 ?? 'N/A' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Address 2 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_address_2 ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<!-- delivery ad 1 and 2 -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Address 1 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_address_1 ?? 'N/A' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Address 2 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_address_2 ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<!-- pickup and delivery zip -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Zip:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_zip }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Zip:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_zip }}</label>
										</div>
									</div>
								</div>
								<!-- pick and drop city -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup City:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_city }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery City:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_city }}</label>
										</div>
									</div>
								</div>
								<!-- pick and drop state -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup State:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_state }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery State:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_state }}</label>
										</div>
									</div>
								</div>
								<!-- pick and drop country -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Country:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_country }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Country:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_country }}</label>
										</div>
									</div>
								</div>
								<!-- pick and drop Contact  -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Contact:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_contact_name ? $quoteRequests->pickup_contact_name : ($quoteRequests->user->fname . $quoteRequests->user->lname) }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Contact:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_contact_name ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<!-- pick and drop phone  -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Phone:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_contact_phone ? $quoteRequests->pickup_contact_phone : ($quoteRequests->user->phone) }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Phone:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_contact_phone ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<!-- pick and drop email  -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Email:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_contact_email ? $quoteRequests->pickup_contact_email : ($quoteRequests->user->email) }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Email:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_contact_email ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<!-- pick and drop company  -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Pickup Company:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->pickup_company ? $quoteRequests->pickup_company : ($quoteRequests->company->name) }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Company:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $quoteRequests->delivery_company ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-2" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Bids</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl" class="table table-striped table-bordered dt-responsive" style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Bidding Company</th>
												<th>Amount</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 1)
											@foreach($quoteBids as $item)
											<tr class="gradeX">
												<td>{{ $i++ }}</td>
												<td>{{ $item->company->name }}</td>
												<td>{{$item->amount}}</td>
												<td>
													@if($item->status == 0)
													<span class="label label-dark">Listed</span>
													@elseif($item->status == 1)
													<span class="label label-warning">Unlisted</span>
													@elseif($item->status == 2)
													<span class="label label-primary">Bid Accepted</span>
													@elseif($item->status == 3)
													<span class="label label-success">Delivered</span>
													@elseif($item->status == 4)
													<span class="label label-red">Removed</span>
													@endif
												</td>
												<td>
													<button class="btn btn-primary btn-sm btn_bid_details" data-id="{{$item->id}}" type="button"><i class="fa-solid fa-file-text-o"></i> Details</button>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-3" class="tab-pane" role="tabpanel">
						<div class="ibox chat-view">
							<div class="ibox-title">
								Chats
								<!-- <small class="float-right text-muted">Last message: Mon Jan 26 2015 - 18:39:23</small>
								Chat room panel -->
							</div>
							<div class="ibox-content">
								<div class="row">
									<div class="col-md-9 ">
										<div class="chat-discussion">
										</div>
									</div>
									<div class="col-md-3">
										<div class="chat-users">
											<div class="users-list">
												@foreach($chats as $chat)
												<div class="chat-user" data-id="{{$chat->id}}" data-thisCompany="{{$quoteRequests->company->id}}" id="OpenChat" style="cursor:pointer">
													<img class="chat-avatar" src="{{ asset('admin_assets/img/a1.jpg') }}" alt="">
													<div class="chat-user-name">
														<a>{{ $chat->otherCompany->name}}</a>
													</div>
												</div>
												@endforeach
											</div>
										</div>
									</div>
								</div>
							</div>
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
	$(document).on('click', '#OpenChat', function() {
		event.preventDefault();
		var id = $(this).attr('data-id');
		var thisCompany = $(this).attr('data-thisCompany');
		$.ajax({
			url: "{{ url('admin/quote-requests/chatDetails') }}",
			type: 'POST',
			dataType: 'json',
			data: {
				"_token": "{{ csrf_token() }}",
				'id': id,
				'thisCompany': thisCompany
			},
			success: function(status) {
				$(".chat-discussion").html(status.response);
			}
		});
	});

	$(document).on("click", ".btn_bid_details", function() {
		var id = $(this).attr('data-id');
		$.ajax({
			url: "{{ url('admin/quote-requests/bidDetails') }}",
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