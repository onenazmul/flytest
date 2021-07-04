@extends('frontEnd.layouts.pages.merchant.merchantmaster')
@section('title','Dashboard')
@section('content')
	<section class="section-padding">
		<div class="container">
			<div class="row">
			  <div class="profile-inner">
				<div class="col-sm-12">
					<div class="profile-title">
						<h3>Profile Information</h3>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="profile-edit-btn">
						<a href="{{url('merchant/profile/edit')}}"><i class="fa fa-edit"></i></a>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="profiles-details">
						<div class="profile-image">
							<a href="#"><img src="{{asset('public/frontEnd')}}/images/avator.png" alt=""></a>
						</div>
						<div class="profile-info">
							@php
                    			$merchantInfo = App\Merchant::find(Session::get('merchantId'));
                			@endphp
							<table class="table custom-table">
								<tr>
									<th>User ID : </th>
									<td>{{$merchantInfo->id}}</td>
								</tr>
								<tr>
									<th>Company Name : </th>
									<td>{{$merchantInfo->companyName}}</td>
								</tr>
								<tr>
									<th>Owner Name : </th>
									<td>{{$merchantInfo->firstName}} {{$merchantInfo->lastName}}</td>
								</tr>
								<tr>
									<th>Phone Number : </th>
									<td>{{$merchantInfo->phoneNumber}}</td>
								</tr>
								<tr>
									<th>Email Address</th>
									<td>{{$merchantInfo->emailAddress}}</td>
								</tr>
								<tr>
									<th>Office Address : </th>
									<td>{{$merchantInfo->pickLocation}}</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</section>
@endsection