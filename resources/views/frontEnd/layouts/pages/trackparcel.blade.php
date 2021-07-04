@extends('frontEnd.layouts.master')
@section('title','Track your Parcel - FlingEx')
@section('content')
<!-- Hero Area Start -->
 <div class="quicktech-all-page-header-bg">
     <div class="container">
         <nav aria-label="breadcrumb">
             <ol class="breadcrumb">
               
             </ol>
         </nav>
     </div>
 </div>
 <!-- Hero Area End -->
   
<section class="pb-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="row addpercel-inner">
                    <div class="col-sm-5">
                        <div class="track-left">
                            <h4>Track Parcel</h4>
                         
                            @foreach($trackInfos as $trackInfo)
							<div class="tracking-step">
								<div class="tracking-step-left">
									<strong>{{date('h:i A', strtotime($trackInfo->created_at))}}</strong>
									<p>{{date('M d, Y', strtotime($trackInfo->created_at))}}</p>
								</div>
								<div class="tracking-step-right">
                                    <strong>{{$trackInfo->parcelStatus}}</strong>
									<p>{{$trackInfo->note}}</p>
								</div>
							</div>
							@endforeach
						
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="track-right">
                            <h4>Customer and Parcel Details</h4>
                            <div class="item">
                                <p>Parcel ID</p>
                                <h6><strong>{{@$trackparcel->trackingCode}}</strong></h6>
                            </div>
                            <div class="item">
                                <p>Customer Name :</p>
                                <h6><strong>{{@$trackparcel->recipientName}}</strong></h6>
                            </div>
                            <div class="item">
                                <p>Customer Address :</p>
                                <h6><strong>{{@$trackparcel->recipientAddress}}</strong></h6>
                            </div>
                        
                            <div class="item">
                                <p>Area :</p>
                                <h6><strong>{{@$trackparcel->zonename}}</strong></h6>
                            </div>
                            @if(!empty($trackparcel->deliverymanId))
                            
                            @php
                                $deliverymanInfo = App\Deliveryman::find($trackparcel->deliverymanId);
                            @endphp
                            <div class="item">
                                <p>Rider Name :</p>
                                <h6><strong>{{@$deliverymanInfo->name}}</strong></h6>
                            </div>
                            <div class="item">
                                <p>Rider Phone :</p>
                                <h6><strong>{{@$deliverymanInfo->phone}}</strong></h6>
                            </div>
                            @endif
                            <div class="item">
                                <p>Last Update :</p>
                                <h6>{{@$trackparcel->updated_at}}</h6>
                            </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>
  
 <section id="cta" class="quicktech-traking section-padding bg-lightblue">
     <div class="container">
         <div class="row">
             <div class="col-lg-6 col-md-6 col-xs-12 wow fadeInLeft" data-wow-delay="0.3s">
                 <div class="cta-text">
                     <h4 style="color: #F68A1F">Flingex </h4>
                     <p>Pack, Send And Relax</p>
                 </div>
             </div>
             <div class="col-lg-6 col-md-6 col-xs-12 wow fadeInRight" data-wow-delay="0.3s">
                 <form action="{{url('/track/parcel/')}}" method="POST" class="form-row">
                    @csrf
                     <div class="col-lg-8 col-md-4 col-xs-12">
                 <input type="text" name="trackparcel" class="form-control" placeholder="Stay Updated!" required="" data-error="Please enter your tracking number">
             </div>
             <div class="col-lg-2 col-md-4 col-xs-12 text-right">
                 <button type ="submit" class="btn btn-common">TRACK PARCEL</button>
             </div>
                 </form>
             </div>
             
         </div>
     </div>
 </section>
@endsection