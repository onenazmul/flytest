@extends('frontEnd.layouts.master')
@section('title','Notice Details')
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
     <!--Quicktech Carrier Section Start -->
     <section id="quickTech-carrier" class="section-padding bg-gray">
         <div class="container">
             <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Notice</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row">
                 <div class="col-lg-12 col-md-12 col-xs-12">
                     <!--Quicktech Carrier Item Starts -->
                     <div class="quickTech-carrier-item wow fadeInRight" data-wow-delay="0.2s">

                         <div class="contetn">
                             <div class="info-text">
                                 <h3><a>{{$noticedetails->title}}</a></h3>
                                 <p>{{$noticedetails->created_at}}</p>
                             </div>
                             <p>{!! $noticedetails->text !!}</p>

                         </div>
                     </div>
                     <!--Quicktech Carrier Item Ends -->
                 </div>

             </div>
         </div>
     </section>
     <!--Quicktech Carrier Section End -->

@endsection