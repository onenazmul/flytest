@extends('frontEnd.layouts.master')
@section('title','FlingEx - Pack, Send And Relax')
@section('description', 'FlingEx is one of the fastest and reliable courier service organization. We are delivering your parcel to your preferred destination with great care.')
@section('content')
<div id="hero-area" class="hero-area-bg quicktech-slider">
             <div class="">
                 <div id="quicktech-slider" class="owl-carousel wow fadeInUp" data-wow-delay="1.2s">
                      @foreach($banner as $key=>$value)
                     <div class="item">
                         <div class="row">
                             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                 <div class="intro-img">
                                   
                                     <img class="img-fluid" src="{{asset($value->image)}}" alt="">
                                     
                                 </div>
                             </div>
                         </div>
                     </div>
                     @endforeach
                    
                 </div>

             </div>
         </div>
         <!-- Hero Area End -->
  <!-- Call To Action Section Start -->
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
     <!-- Call To Action Section Start -->
     <!-- About Section start -->
     <div class="about-area section-padding bg-gray">
         <div class="container">
            <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">About Us</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             @foreach($about as $key=>$value)
             <div class="row">
                 <div class="col-lg-6 col-md-12 col-xs-12 info">
                     <div class="about-wrapper wow fadeInLeft" data-wow-delay="0.3s">
                         <div>
                             <div class="site-heading">
                                 <p class="mb-3">{{$value->title}}</p>
                                 <h2 class="section-title">{{$value->subtitle}}</h2>
                             </div>
                             <div class="content">
                                 <p>
                                     {!! $value->text !!}
                                 </p>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-6 col-md-12 col-xs-12 wow fadeInRight" data-wow-delay="0.3s">
                     <img class="img-fluid" src="{{asset('public/frontEnd')}}/assets/img/about/img-1.png" alt="">
                 </div>
             </div>
             @endforeach
         </div>
     </div>
     <!-- About Section End -->
     <!-- Services Section Start -->
     <section class="section-padding modify-services" style="background: #1E62B0">
         <div class="container">
             <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown white" data-wow-delay="0.3s">Services</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row">
                 <!-- Services item -->
                 @foreach($services as $key=>$value)
                 <div class="col-md-6 col-lg-3 col-xs-12">
                     <div class="services-item wow fadeInRight" data-wow-delay="0.3s">
                         <div class="icon">
                             <i class="lni {{$value->icon}}"></i>
                         </div>
                         <div class="services-content">
                             <h3><a href="#"> {{$value->title}}</a></h3>
                             <p>{!!$value->text!!}</p>
                         </div>
                     </div>
                 </div>
                 <!-- Services item -->
                 @endforeach
             </div>
         </div>
     </section>
     <!-- Services Section End -->
    
    <section id="one-time-service" class="section-padding bg-gray">
         <div class="container">
             <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Pick & Drop Service</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
<div class="row">
	<div class="col-md-6 wow fadeInLeft" data-wow-delay="0.2s">
		<div class="one-time-price-box">
			<div class="title-box">
				<h3><i class="fas fa-people-carry"></i> Pick & Drop</h3>
			</div>
			<div class="price-box">
				<p class="m-0">
					৳ 150
					<span>/per percel</span>
				</p>
			</div>
			<div class="price-desc">
				<ul class="fa-ul">
					<li><span class="fa-li"><i class="fas fa-check-square"></i></span> Instant Pickup</li>
					<li><span class="fa-li"><i class="fas fa-check-square"></i></span> Instant Delivery</li>
					<li><span class="fa-li"><i class="fas fa-check-square"></i></span> Instant Payment</li>
					<li><span class="fa-li"><i class="fas fa-check-square"></i></span> Same City</li>
					<li><span class="fa-li"><i class="fas fa-check-square"></i></span> Online Dashboard</li>
					<li><span class="fa-li"><i class="fas fa-check-square"></i></span> 3-4 Hours Delivery</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="col-md-6 wow fadeInRight" data-wow-delay="0.2s">
         <div class="quickTech-carrier-item">
             <div class="contetn">
                 <div class="contact-block">
                     <form action="{{url('auth/merchant/single-servicer')}}" method="POST">
                         @csrf
                         <div class="row">
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <input type="text" class="form-control" id="address" name="address" placeholder="PickUp Address" required data-error="Please enter your PickUp address">
                                     <div class="help-block with-errors"></div>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <select class="custom-select form-control" name="area">
                                     <option selected>Select Delivery Area</option>
                                      @foreach($areas as $area)
									    <option value="{{$area->zonename}}">{{$area->zonename}}</option>
									    @endforeach
                                 </select>
                             </div>
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <input type="text" name="note" placeholder="Note (Optional)"  class="form-control" >
                                     <div class="help-block with-errors"></div>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <input type="text" name="estimate" placeholder="Estimated Parcel (Optional)" class="form-control">
                                     <div class="help-block with-errors"></div>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="form-group">
                                     <input type="text" name="phone" placeholder="Phone Number" class="form-control">
                                     <div class="help-block with-errors"></div>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 
                                 <div class="submit-button text-left">
                                     <button class="btn btn-common" id="form-submit" type="submit">Send Request</button>
                                     <div id="msgSubmit" class="h3 text-center hidden"></div>
                                     <div class="clearfix"></div>
                                 </div>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
	</div>
</div>
         </div>
     </section>
    
    
     <!-- Pricing section Start -->
     <section id="pricing" class="section-padding">
         <div class="container">
             <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Pricing</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row">
                @foreach($prices as $key=>$value)
                 <div class="col-lg-3 col-md-6 col-xs-12">
                     <div class="table wow fadeInLeft" data-wow-delay="1.2s">
                         <div class="icon-box">
                             <i class="lni-package"></i>
                         </div>
                         <div class="pricing-header">
                             <p class="price-value">৳ {{$value->price}}<span> /per percel</span></p>
                         </div>
                         <div class="title">
                             <h3>{{$value->name}}</h3>
                         </div>
                         <ul class="description">
                             {!!$value->text!!}
                         </ul>
                         <a href="{{url('merchant/register')}}"><button class="btn btn-common">Book Now</button></a>
                     </div>
                 </div>
                @endforeach
             </div>
         </div>
     </section>
     <!-- Pricing Table Section End -->

     <!-- Features Section Start -->
     <section id="features" class="section-padding">
         <div class="container">
             <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Payment Mode Details</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row">
                 <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                     <div class="content-left">
                        @foreach($features as $key=>$value)
                         <div class="box-item wow fadeInLeft" data-wow-delay="0.3s">
                             <span class="icon">
                                 <i class="{{$value->icon}}"></i>
                             </span>
                             <div class="text">
                                 <h4>{{$value->title}}</h4>
                                 <p>{{$value->subtitle}}</p>
                             </div>
                         </div>
                         @endforeach
                     </div>
                 </div>
                 <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                     <div class="show-box wow fadeInUp" data-wow-delay="0.3s">
                         <img src="{{asset('public/frontEnd')}}/assets/img/feature/intro-mobile.png" alt="">
                     </div>
                 </div>
                 <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                     <div class="content-right">
                         <div class="box-item wow fadeInRight" data-wow-delay="0.3s">
                             <span class="icon">
                                 <i class="lni-leaf"></i>
                             </span>
                             <div class="text">
                                 <h4>Others</h4>
                                 <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="" data-error="please fill the words">

                             </div>
                         </div>
                      
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- Features Section End -->





     <!-- Testimonial Section Start -->
     <section id="testimonial" class="testimonial section-padding bg-gray-2">
         <div class="section-header text-center">
             <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Our Clients</h2>
             <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
         </div>
         <div class="container">
             <div class="row justify-content-center">
                 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                     <div id="testimonials" class="owl-carousel wow fadeInUp" data-wow-delay="1.2s">
                        @foreach($clientsfeedback as $key=>$value)
                         <div class="item">
                             <div class="testimonial-item">
                                 <div class="img-thumb">
                                     <img src="{{asset($value->image)}}" alt="" style="width:80px;height:80px;">
                                 </div>
                                 <div class="info">
                                     <h2><a href="#">{{$value->name}}</a></h2>
                                     <h3><a href="#">{{$value->subtitle}}</a></h3>
                                 </div>
                                 <div class="content">
                                     <p class="description">{{$value->description}}</p>
                                     <div class="star-icon mt-3">
                                         <span><i class="lni-star-filled"></i></span>
                                         <span><i class="lni-star-filled"></i></span>
                                         <span><i class="lni-star-filled"></i></span>
                                         <span><i class="lni-star-filled"></i></span>
                                         <span><i class="lni-star-filled"></i></span>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
     </section>

     <!-- Testimonial Section End -->

     <!-- Call To Action Section Start -->
     <section id="cta" class="section-padding bg-lightblue">
         <div class="container">
             <div class="row">
                 <div class="col-lg-8 col-md-8 col-xs-12 wow fadeInLeft" data-wow-delay="0.3s">
                     <div class="cta-text">
                         <!--<h4>Get free Register Now</h4>-->
                         <h5 class="mb-0 heading-font">Struggling on sending parcels efficiently? Give a try with us!</h5>
                     </div>
                 </div>
                 <div class="col-lg-4 col-md-4 col-xs-12 text-right wow fadeInRight" data-wow-delay="0.3s">
                     <a href="/merchant/register" class="btn btn-common">Register Now</a>
                 </div>
             </div>
         </div>
     </section>
     <!-- Call To Action Section Start -->
@endsection