@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-8 col-sm-8 col-xs-8">
		<h2>Driver Ad Details </h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin/driver-ads') }}">Driver Ad</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Driver Ad Details </strong>
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
					<li class="show_details"><a class="nav-link active show" data-toggle="tab" href="#tab-1">Driver Ad Details</a></li>
					<li class="show_reponses"><a class="nav-link" data-toggle="tab" href="#tab-2">Responses</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active show" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Advertisement Details</h5>
								<div class="ibox-tools">
									<span class="label label-primary float-right">Active</span>
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
											<label class="col-8 col-form-label">{{ $driverAd->company->name }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>User :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->user->fname . ' ' . $driverAd->user->lname}}</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Driver Type :</strong>
											</label>
											<label class="col-8 col-form-label">{{ mapDriverType($driverAd->type) }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Compensation :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->compensation . ' / ' . $driverAd->compensation_type}}</label>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Vehicle Types :</strong>
											</label>
											<label class="col-8 col-form-label">
												@foreach(json_decode($driverAd->vehicle_types) as $vehicleType)
												{{ map_vehicle($vehicleType) }}
												@endforeach
											</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Reefer :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->reefer == 1 ? 'Required' : 'Not Required'  }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Hazmat :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->hazmat == 1 ? 'Required' : 'Not Required'  }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Lift Gate :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->lift_gate == 1 ? 'Required' : 'Not Required'  }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>TSA Certified :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->tsa_certified == 1 ? 'Required' : 'Not Required'  }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>City :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->city }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>State :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->state }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Zip :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->zip ?? '-' }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Experience :</strong>
											</label>
											<label class="col-8 col-form-label">{{ mapExperience($driverAd->experience) }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Insurance Coverage :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->insurance_coverage}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Contact Email :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->contact_email }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Division/Branch :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $driverAd->div_id}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Ad Title :</strong>
											</label>
											<label class="col-12 col-form-label">{{ $driverAd->ad_title }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Description :</strong>
											</label>
											<label class="col-12 col-form-label">{{ $driverAd->description }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong>Response Information :</strong>
											</label>
											<label class="col-12 col-form-label">{{ $driverAd->response_info ?? 'N/A' }}</label>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
					<div id="tab-2" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Responses</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl" class="table table-striped table-bordered dt-responsive" style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Driver Name</th>
												<th>Company</th>
												<th>City</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 1)
											@foreach($responses as $item)
											<tr class="gradeX">
												<td>{{ $i++ }}</td>
												<td>{{ $item->name }}</td>
												<td>{{ $item->company->name }}</td>
												<td>{{ $item->city }}</td>
												<td>
													<button class="btn btn-primary btn-sm btn_response_details" data-id="{{$item->id}}" type="button"><i class="fa-solid fa-file-text-o"></i> Details</button>
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
	$(document).on("click", ".btn_response_details", function() {
		var id = $(this).attr('data-id');
		$.ajax({
			url: "{{ url('admin/driver-ads/responseDetails') }}",
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