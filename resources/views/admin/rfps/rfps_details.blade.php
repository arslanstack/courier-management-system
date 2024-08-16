@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-8 col-sm-8 col-xs-8">
		<h2>Recurring Freight Posting Details </h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin/rfps') }}">Recurring Freight Posting</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Recurring Freight Posting Details </strong>
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
					<li class="show_details"><a class="nav-link active show" data-toggle="tab" href="#tab-1">RFP Details</a></li>
					<li class="show_bids"><a class="nav-link" data-toggle="tab" href="#tab-2">Bids</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active show" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>RFP Details</h5>
								<div class="ibox-tools">
									@if($rfp->status == 0 || 1)
									<span class="label label-dark float-right">Listed</span>
									@elseif($rfp->status == 2)
									<span class="label label-primary float-right">Bid Accepted</span>
									@elseif($rfp->status == 3)
									<span class="label label-success float-right">Delivered</span>
									@elseif($rfp->status == 4)
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
											<label class="col-8 col-form-label">{{ $rfp->user->company->name }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>User :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->user->fname . ' ' . $rfp->user->lname}}</label>
										</div>
									</div>
								</div>
								<!-- Route type & Multiple Routes -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Route Type :</strong>
											</label>

											<label class="col-8 col-form-label">{{$rfp->route_type == 0 ? 'Dedicated' : 'Distribution'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Multiple Routes :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->multiple_routes == 0 ? 'No' : 'Yes' }}</label>
										</div>
									</div>
								</div>
								<!-- mileage & Vehicle -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Estimated Mileage :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->estimated_mileage ?? 'N/A' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Vehicle Type :</strong>
											</label>
											<label class="col-8 col-form-label">{{ map_vehicle($rfp->vehicle )}}</label>
										</div>
									</div>
								</div>
								<!-- hazmat and reefer -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Reefer:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->reefer = 0 ? 'Not Required' : 'Required' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Hazmat:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->hazmat == 0 ? 'Not Required' : 'Required' }}</label>
										</div>
									</div>
								</div>
								<!-- lift & Bid Due Date -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Lift Gate:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->lift_gate = 0 ? 'Not Required' : 'Required' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Bid Due Date:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->bid_due }}</label>
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
											<label class="col-10 col-form-label">{{ $rfp->description }}</label>
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
											<label class="col-8 col-form-label">{{ $rfp->start_point }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Delivery Point:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->delivery_point }}</label>
										</div>
									</div>
								</div>
								<!-- Frequency & Payment Terms -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Frequency:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->frequency }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Payment Terms:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->payment_terms }}</label>
										</div>
									</div>
								</div>
								<!-- Insurance Covergae & Bid Price -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Insurance Coverage:</strong>
											</label>
											<label class="col-8 col-form-label">{{ $rfp->insurance_coverage }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Bid Price:</strong>
											</label>
											<label class="col-8 col-form-label">
												@if($rfp->bid_per_stop == 1 && $rfp->bid_per_route == 1)
												Per Stop & Per Route
												@elseif($rfp->bid_per_stop == 1 && $rfp->bid_per_route == 0)
												Per Stop
												@elseif($rfp->bid_per_stop == 0 && $rfp->bid_per_route == 1)
												Per Route
												@else
												Not Defined
												@endif
											</label>
										</div>
									</div>
								</div>
								<!-- Other Requirements -->
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<label class="col-2 col-form-label">
												<strong>Other Requirements:</strong>
											</label>
											<label class="col-10 col-form-label">{{ $rfp->other_requirements }}</label>
										</div>
									</div>
								</div>
								<!-- Relevant Documents -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Document 1:</strong>
											</label>
											<label class="col-8 col-form-label">
												@if($rfp->doc_1)
												<a href="{{url('public/uploads/rfp_docs/' . $rfp->doc_1)}}" target="_blank">{{$rfp->doc_1}}</a>
												@endif
											</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Document 2:</strong>
											</label>
											<label class="col-8 col-form-label">
												@if($rfp->doc_2)
												<a href="{{url('public/uploads/rfp_docs/' . $rfp->doc_2)}}" target="_blank">{{$rfp->doc_2}}</a>
												@endif
											</label>
										</div>
									</div>
								</div>
								<!-- Contact Company & Name -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Contact Company:</strong>
											</label>
											<label class="col-8 col-form-label">
												{{$rfp->contact_company}}
											</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Contact Name:</strong>
											</label>
											<label class="col-8 col-form-label">
												{{$rfp->contact_name}}
											</label>
										</div>
									</div>
								</div>
								<!-- Contact Phone & Email -->
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Contact Phone:</strong>
											</label>
											<label class="col-8 col-form-label">
												{{$rfp->contact_phone}}
											</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Contact Email:</strong>
											</label>
											<label class="col-8 col-form-label">
												{{$rfp->contact_email ?? 'N/A'}}
											</label>
										</div>
									</div>
								</div>
								<!-- Other Recepients -->
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<label class="col-2 col-form-label">
												<strong>Other Recepients:</strong>
											</label>
											<label class="col-10 col-form-label">
												@if($rfp->recipients)
												@php
												$recpes = explode_receps($rfp->recipients);
												@endphp
												@foreach($recpes as $recp)
												{{$recp}} ,
												@endforeach
												@endif
											</label>
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
											@foreach($rfp_bids as $item)
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

	$(document).on("click", ".btn_bid_details", function() {
		var id = $(this).attr('data-id');
		$.ajax({
			url: "{{ url('admin/rfps/bidDetails') }}",
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