@extends('frontEnd.layouts.master')
@section('title','Career')
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
 <!-- QuickTech Gal Section start -->
     <div class="quickTech-gal-area section-padding ">
         <div class="container">
             <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Gallery</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row">
                @foreach($gallery as $key=>$value)
                 <div class="col-lg-6 col-md-4 col-xs-12 info">
                     <div class="gal-wrapper wow fadeInLeft" data-wow-delay="0.3s">
                         <div class="img">
                             <img class="img-fluid" src="{{asset($value->image)}}" alt="">
                         </div>
                         <div class="site-heading">
                             <p class="mb-3">{{$value->title}}</p>
                         </div>


                     </div>
                 </div>
                 @endforeach
               
             </div>
         </div>
     </div>
     <!-- QuickTech Gal Section End -->


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