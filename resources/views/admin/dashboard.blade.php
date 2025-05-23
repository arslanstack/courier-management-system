@extends('admin.admin_app')
@section('content')
<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>Companies</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('companies')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/companies')}}"><span class="label label-primary">View</span></a></div>
					<small>Companies</small>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>Users</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('users')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/users')}}"><span class="label label-primary">View</span></a></div>
					<small>Users</small>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>Quote Requests</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('quote_requests')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/quote-requests')}}"><span class="label label-primary">View</span></a></div>
					<small>Requests</small>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>RFP Postings</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('rfps')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/rfps')}}"><span class="label label-primary">View</span></a></div>
					<small>Posts</small>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>Airports</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('airports')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/airports')}}"><span class="label label-primary">View</span></a></div>
					<small>Airports</small>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>Warehouses</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('warehouses')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/warehouses')}}"><span class="label label-primary">View</span></a></div>
					<small>Operational</small>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>Vehicle Posts</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('vehicle_posts')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/vehicle-posts')}}"><span class="label label-primary">View</span></a></div>
					<small>Posts</small>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>Driver Ads</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('driver_ads')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/driver-ads')}}"><span class="label label-primary">View</span></a></div>
					<small>Ads</small>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<span class="label label-success pull-right">Total</span>
					<h5>Classified Ads</h5>
				</div>
				<div class="ibox-content">
					<h1 class="no-margins">{{count_records('classifieds')}}</h1>
					<div class="stat-percent font-bold text-primary"><a href="{{url('admin/classifieds')}}"><span class="label label-primary">View</span></a></div>
					<small>Ads</small>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection