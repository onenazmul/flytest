@extends('frontEnd.layouts.pages.merchant.merchantmaster')
@section('title','Parcel Details')
@section('content')
<section class="section-padding">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="row addpercel-inner">
					<div class="col-sm-6">
						<div class="track-left">
							<div class="track-title">
								<h4>Track Parcel</h4>
							</div>
							@foreach($trackInfos as $trackInfo)
							<div class="tracking-step">
								<div class="tracking-step-left">
									<strong>{{date('h:i A', strtotime($trackInfo->created_at))}}</strong>
									<p>{{date('M d, Y', strtotime($trackInfo->created_at))}}</p>
								</div>
								<div class="tracking-step-right">
									<p>{{$trackInfo->note}}</p>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					<div class="col-sm-6">
						<div class="track-right">
							<h4>Customer and Parcel Details</h4>
							<div class="item row">
								<div class="col-6">
									<p>Parcel ID</p>
								</div>
								<div class="col-6">
									<h6>{{$parceldetails->trackingCode}}</h6>
								</div>
								
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Parcel Status</p>
								</div>
								<div class="col-6">
									@php
				                      $parcelstatus = App\Parceltype::find($parceldetails->status);
				                   @endphp
				                    
									<h6>{{$parcelstatus->title}}</h6>
								</div>
								
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Asign Rider :</p>
								</div>
								@php
			                      $riderInfo = App\Deliveryman::find($parceldetails->deliverymanId);
			                   @endphp
								<div class="col-6">
									<h6>
										@if($riderInfo)
										{{$riderInfo->name}} @endif</h6>
								</div>
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Customer Name :</p>
								</div>
								<div class="col-6">
									<h6>{{$parceldetails->recipientName}}</h6>
								</div>
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Payment Status :</p>
								</div>
								<div class="col-6">
									<h6>@if($parceldetails->merchantpayStatus==1) Processing @elseif($parceldetails->merchantpayStatus==2) Paid @else # @endif</h6>
								</div>
							</div>
							<div class="item row">
								<div class="col-6"><p>Customer Address :</p></div>
								<div class="col-6"><h6>{{$parceldetails->recipientAddress}}</h6></div>
								
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Customer Phone :</p>
								</div>
								<div class="col-6"><h6>{{$parceldetails->recipientPhone}}</h6></div>
								
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Area :</p>
								</div>
								<div class="col-6">
									<h6>{{$parceldetails->zonename}}</h6>
								</div>
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Weight :</p>
								</div>
								<div class="col-6">
									<h6>{{$parceldetails->productWeight}}</h6>
								</div>
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Created Date :</p>
								</div>
								<div class="col-6">
									<h6>{{$parceldetails->created_at}}</h6>
								</div>
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Price :</p>
								</div>
								<div class="col-6"><h6>{{$parceldetails->productPrice}}</h6></div>
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Delivery Charge :</p>
								</div>
								<div class="col-6"><h6>{{$parceldetails->deliveryCharge}}</h6></div>
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Cod :</p>
								</div>
								<div class="col-6">
									<h6>{{$parceldetails->codCharge}}</h6>
								</div>
							</div>
							<div class="item row">
								<div class="col-6">
									<p>Last Update :</p>
								</div>
								<div class="col-6">
									<h6>{{$parceldetails->updated_at}}</h6>
								</div>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</section>

@endsection