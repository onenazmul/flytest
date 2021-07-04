@extends('frontEnd.layouts.master')
@section('title','Register')
@section('content')
 <!-- Hero Area Start -->
 <div class="">
     <div class="container">
         <nav aria-label="breadcrumb">
             <ol class="breadcrumb">
               
             </ol>
         </nav>
     </div>
 </div>
 <!-- Hero Area End -->

<!--Quicktech Carrier Section Start -->
 <section id="quickTech-carrier" class="section-padding bg-gray">
     <div class="container">
         <div class="section-header text-center">
             <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Terms & Conditions</h2>
             <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
         </div>
         <div class="row">
             <div class="col-sm-12">
                  <iframe src="{{asset('public/frontEnd/images/Terms-Conditions.pdf')}}" width="100%" height="800px">
             </div>
         </div>
     </div>
 </section>
@endsection
