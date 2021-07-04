@extends('frontEnd.layouts.master')
@section('title','About Us')
@section('content')
<div class="quicktech-all-page-header-bg">
         <div class="container">
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                    
                 </ol>
             </nav>
         </div>
     </div>
     <!-- Hero Area End -->
      <!-- About Section start -->
     <div class="about-area section-padding">
         <div class="container">
            <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">About Us</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             @foreach($aboutus as $key=>$value)
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
          <!-- Call To Action Section Start -->
     <section id="cta" class="section-padding bg-gray">
         <div class="container">
             <div class="row">
                 <div class="col-lg-6 col-md-6 col-xs-12 wow fadeInLeft" data-wow-delay="0.3s">
                     <div class="cta-text">
                         <h4>Get 30 days free trial</h4>
                         <p>Praesent imperdiet, tellus et euismod euismod, risus lorem euismod erat, at finibus neque odio quis metus. Donec vulputate arcu quam. </p>
                     </div>
                 </div>
                 <div class="col-lg-6 col-md-6 col-xs-12 text-right wow fadeInRight" data-wow-delay="0.3s">
                     <a href="#" class="btn btn-common">Register Now</a>
                 </div>
             </div>
         </div>
     </section>
     <!-- Call To Action Section Start -->

@endsection