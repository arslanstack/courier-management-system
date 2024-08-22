@extends('admin.admin_app')
@push('styles')
@endpush
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-8 col-sm-8 col-xs-8">
		<h2> Company Details </h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin/companies') }}">Companies</a>
			</li>
			<li class="breadcrumb-item active">
				<strong> Company Details </strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-4 col-sm-4 col-xs-4 text-right">
		<a class="btn btn-primary t_m_25" href="{{ url('admin/companies') }}">
			<i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Companies
		</a>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="tabs-container">
				<ul class="nav nav-tabs" role="tablist">
					<li class="show_details"><a class="nav-link active show" data-toggle="tab" id="tab1-link"
							href="#tab-1">Company Details</a></li>
					<li class="show_users"><a class="nav-link" data-toggle="tab" id="tab2-link" href="#tab-2">Users</a>
					</li>
					<li class="show_requests"><a class="nav-link" data-toggle="tab" id="tab3-link" href="#tab-3">Quote
							Requests</a></li>
					<li class="show_bids"><a class="nav-link" data-toggle="tab" id="tab4-link" href="#tab-4">Recent
							Bids</a></li>
					<li class="show_warehouses"><a class="nav-link" data-toggle="tab" id="tab5-link"
							href="#tab-5">Warehouses</a></li>
					<li class="show_airports"><a class="nav-link" data-toggle="tab" id="tab6-link" href="#tab-6">Airport
							Operations</a></li>
					<li class="show_vehicle_posts"><a class="nav-link" data-toggle="tab" id="tab7-link" href="#tab-7">Vehicle Posts</a></li>
					<li class="show_driver_ads"><a class="nav-link" data-toggle="tab" id="tab8-link" href="#tab-8">Driver Ads</a></li>
					<li class="show_billing"><a class="nav-link" data-toggle="tab" id="tab9-link" href="#tab-9">Billing
							History</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active show" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Company Details</h5>
								<div class="ibox-tools">
									@if($company->account_type == 0)
									<span class="label label-primary float-right">Exchange Account</span>
									@else
									<span class="label label-success float-right">Premium Account</span>
									@endif
								</div>
							</div>
							<div class="ibox-content">
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Company Name :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->name }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Company Type :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ map_company_type($company->company_type) }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Mail Address 1 :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->mail_address_1 }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Mail Address 2 :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->mail_address_2 ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> City :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->city }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> State :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->state }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Zip :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->zip }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Country :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->country }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Motor Carrier :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->motor_carrier_no ?? 'N/A' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> US Dot No :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->dot_no ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Intrastate No :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->intrastate_no ?? 'N/A' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> No of Drivers :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->drivers ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Website :</strong>
											</label>
											<label class="col-8 col-form-label">
												@if($company->website)
												<a href="{{ $company->website }}" target="_blank">
													<i class="fa fa-external-link"></i> {{ $company->website }}
												</a>
												@else
												N/A
												@endif
											</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Created On :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ date_formated($company->created_at) }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Insurance Company :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->insurance_company ?? 'N/A' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Insurance Declaration :</strong>
											</label>
											<label class="col-8 col-form-label">
												@if($company->insurance_declaration)
												<a href="{{ url('/public/uploads/insurance_declarations/' . $company->insurance_declaration) }}"
													target="_blank">{{ $company->insurance_declaration }}</a>
												@else
												N/A
												@endif
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> General Liability :</strong>
											</label>
											<label class="col-8 col-form-label">
												@if($company->general_liability)
												$company->general_liability . ' USD'
												@else
												N/A
												@endif
											</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Cargo Insurance :</strong>
											</label>
											<label class="col-8 col-form-label">
												@if($company->cargo_insurance)
												{{$company->cargo_insurance }} USD
												@else
												N/A
												@endif
											</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Other Insurance :</strong>
											</label>
											<label class="col-8 col-form-label">
												@if($company->other_insurance)
												{{$company->other_insurance}} USD
												@else
												N/A
												@endif
											</label>
										</div>
									</div>
									<div class="col-md-6"></div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Alert Receipient 1 :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->alert_email_1 ?? 'N/A'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Alert Receipient 2 :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->alert_email_2 ?? 'N/A'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Freight Post Alerts :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->alert_freight == 1 ? 'On' : 'Off' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Vehicle Post Alerts :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->alert_vehicle == 1 ? 'On' : 'Off' }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> RPF Post Alerts :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->alert_rpf == 1 ? 'On' : 'Off' }}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> New Driver Alerts :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->alert_driver == 1 ? 'On' : 'Off' }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Company Phone :</strong>
											</label>
											<label class="col-8 col-form-label">{{ $company->company_phone ?? 'N/A'}}
											</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Company Mobile :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->company_mobile ?? 'N/A' }}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Account Type :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{ $company->account_type == 0 ? 'Exchange' : 'Premium'}}
											</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Billing Card :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$company->card_number ? substr($company->card_number, 0, 4) . '************' : 'N/A'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> CVV :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$company->card_number ? '***' : 'N/A'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Expiry Date :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$company->card_number ? $company->expiry_month . '/' . $company->expiry_year : 'N/A'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Reefer :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->reefer == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Hazmat :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->hazmat == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Liftgate :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->lift_gate == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> 24 Hours Dispatch Service :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->hr_24_dispatch == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> TSA Certified Drivers :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->tsa_certified == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> On Demand Service :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->on_demand_service == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Scheduled Routes :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->scheduled_routes == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Distribution Delivery Service:</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->distributed_delivery == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Warehouse Facility :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->warehouse_facility == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Climate Controlled :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->climate_controlled == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Biohazard Experience :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->biohazard_exp == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Pharmaceutical Distribution Experience :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->pharma_distribution == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> International Freight Experience :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->international_freight == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Indirect Air Carrier :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->indirect_aircarrier == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> GPS Fleet System:</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->gps_fleet_system == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Uniformed Drivers :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->uniformed_drivers == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Inter-state Service :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->interstate_service == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> White Glove Service :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->whiteglove_service == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Process/Legal Service :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->process_legal_service == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Car :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->car == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Minivan :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->minivan == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> SUV :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->suv == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Cargo Van :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->cargo_van == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Sprinter :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->sprinter == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Covered Pickup :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->covered_pickup == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> 16 Ft. Truck :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->ft_16_truck == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> 18 Ft. Truck :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->ft_18_truck == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> 20 Ft. Truck :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->ft_20_truck == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> 22 Ft. Truck :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->ft_22_truck == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> 24 Ft. Truck :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->ft_24_truck == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> 26 Ft. Truck :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->ft_26_truck == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Flatbed :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->flatbed == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<label class="col-4 col-form-label">
												<strong> Tractor Trailer :</strong>
											</label>
											<label
												class="col-8 col-form-label">{{$features->tractor_trailer == '1' ? 'Yes' : 'No'}}</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-2" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Users</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl" class="table table-striped table-bordered dt-responsive"
										style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Name</th>
												<th>Title</th>
												<th>Phone</th>
												<th>Status</th>
												<th>Access</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 1)
											@foreach($users as $item)
											<tr class="gradeX">
												<td>{{ $i++ }}</td>
												<td>{{ $item->fname . ' ' . $item->lname }}</td>
												<td>{{$item->title ?? 'N/A'}}</td>
												<td>{{$item->phone}}</td>
												<td>
													@if($item->status == 0)
													<span class="label label-danger">Blocked</span>
													@elseif($item->status == 1)
													<span class="label label-primary">Active</span>
													@elseif($item->status == 2)
													<span class="label label-warning">Deleted</span>
													@endif
												</td>
												<td>
													@if($item->is_major_user == 0)
													<span class="label label-primary">Sub-user</span>
													@else
													<span class="label label-success">Super-user</span>
													@endif
												</td>
												<td>
													<a href="{{ url('admin/users/detail') }}/{{ $item->id }}"
														class="btn btn-primary btn-sm" data-placement="top"
														title="Details"><i class="fa-solid fa-file-text-o"></i> Details
													</a>
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
						<div class="ibox">
							<div class="ibox-title">
								<h5>Quote Requests</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl2" class="table table-striped table-bordered dt-responsive"
										style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
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
													<a href="{{ url('admin/quote-requests/detail') }}/{{ $item->id }}"
														class="btn btn-primary btn-sm" data-placement="top"
														title="Details"><i class="fa-solid fa-file-text-o"></i> Details
													</a>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-4" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Quote Bids</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl3" class="table table-striped table-bordered dt-responsive"
										style="width:100%">
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
													<button class="btn btn-primary btn-sm btn_bid_details"
														data-id="{{$item->id}}" type="button"><i
															class="fa-solid fa-file-text-o"></i> Details</button>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-5" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Warehouses</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl" class="table table-striped table-bordered dt-responsive"
										style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Name</th>
												<th>Zip Code</th>
												<th>City</th>
												<th>State</th>
												<th>Country</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 1)
											@foreach($warehouses as $item)
											<tr class="gradeX">
												<td>{{ $i++ }}</td>
												<td>{{ $item->name ?? '-' }}</td>
												<td>{{$item->zip}}</td>
												<td>{{$item->city ?? '-'}}</td>
												<td>{{$item->state ?? '-'}}</td>
												<td>{{$item->country ?? '-'}}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-6" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Airports</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl" class="table table-striped table-bordered dt-responsive"
										style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Name</th>
												<th>Airport Code</th>
												<th>City</th>
												<th>Country</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 1)
											@foreach($airports as $item)
											<tr class="gradeX">
												<td>{{ $i++ }}</td>
												<td>{{ $item->name ?? '-' }}</td>
												<td>{{$item->code}}</td>
												<td>{{$item->city ?? '-'}}</td>
												<td>{{$item->country ?? '-'}}</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-7" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Vehicle Posts</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl" class="table table-striped table-bordered dt-responsive" style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Date</th>
												<th>Start Point</th>
												<th>Destination</th>
												<th>Mileage</th>
												<th>Company</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 1)
											@foreach($vehiclePosts as $item)
											<tr class="gradeX">
												<td>{{ $i++ }}</td>
												<td>{{$item->date_available}}</td>
												<td>{{$item->start_city . ', ' . $item->start_state}}</td>
												<td>{{$item->destination_city . ', ' . $item->destination_state}}</td>
												<td>{{$item->mileage ?? '-'}}</td>
												<td>{{ $item->company->name ?? '-' }}</td>
												<td>
													<button class="btn btn-primary btn-sm btn_vehiclePost_edit" data-id="{{$item->id}}" type="button"><i class="fa-solid fa-page"></i> Details</button>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-8" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Driver Ads</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl" class="table table-striped table-bordered dt-responsive" style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Company</th>
												<th>City</th>
												<th>State</th>
												<th>Zip</th>
												<th>Posted On</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											@php($i = 1)
											@foreach($driverAds as $item)
											<tr class="gradeX">
												<td>{{ $i++ }}</td>
												<td>{{ $item->company->name }}</td>
												<td>{{$item->city}}</td>
												<td>{{$item->state}}</td>
												<td>{{$item->zip ?? '-'}}</td>
												<td>{{formated_date($item->created_at)}}</td>

												<td>
													<a href="{{ url('admin/driver-ads/detail') }}/{{ $item->id }}" class="btn btn-primary btn-sm" data-placement="top" title="Details"><i class="fa-solid fa-file-text-o"></i> Details </a>
												</td>
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div id="tab-9" class="tab-pane" role="tabpanel">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Billing History</h5>
							</div>
							<div class="ibox-content">
								<div class="table-responsive">
									<table id="manage_tbl4" class="table table-striped table-bordered dt-responsive"
										style="width:100%">
										<thead>
											<tr>
												<th>Sr #</th>
												<th>Billing Period</th>
												<th>Amount</th>
												<th>Payment Card</th>
												<th>Status</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
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
<div class="modal inmodal show fade" id="edit_modalbox" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
	aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content animated flipInY" id="edit_modalbox_body">
		</div>
	</div>
</div>
@endsection
@push('scripts')
<script>
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
	$(document).on('click', '.show_billing', function() {
		if (!($("table#manage_tbl2").hasClass("dataTable"))) {
			$('#manage_tbl2').dataTable({
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
	document.addEventListener('DOMContentLoaded', function() {
		var tabLinks = document.querySelectorAll('.nav-tabs a.nav-link');
		tabLinks.forEach(function(tabLink) {
			tabLink.addEventListener('click', function(event) {
				event.preventDefault();
				var targetTabId = tabLink.getAttribute('href');
				var tabParamsMap = {
					'#tab-1': 'details',
					'#tab-2': 'users',
					'#tab-3': 'requests',
					'#tab-4': 'bids',
					'#tab-5': 'warehouses',
					'#tab-6': 'airports',
					'#tab-7': 'vehicle_posts',
					'#tab-8': 'driver_ads',
					'#tab-9': 'billing',
				};
				var tabParam = tabParamsMap[targetTabId];
				var currentUrl = new URL(window.location.href);
				currentUrl.searchParams.set('tab', tabParam);
				history.replaceState(null, null, currentUrl);
				$(targetTabId).tab('show');
			});
		});
		var urlParams = new URLSearchParams(window.location.search);
		var tabParam = urlParams.get('tab');
		if (tabParam) {
			var tabIdsMap = {
				'details': '#tab-1',
				'users': '#tab-2',
				'requests': '#tab-3',
				'bids': '#tab-4',
				'warehouses': '#tab-5',
				'airports': '#tab-6',
				'vehicle_posts': '#tab-7',
				'driver_ads': '#tab-8',
				'billing': '#tab-9',
			};
			var tabId = tabIdsMap[tabParam];
			$('a[href="' + tabId + '"]').tab('show');
		}
	});

	$(document).on("click", ".btn_vehiclePost_edit", function() {
		var id = $(this).attr('data-id');
		$.ajax({
			url: "{{ url('admin/vehicle-posts/show') }}",
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