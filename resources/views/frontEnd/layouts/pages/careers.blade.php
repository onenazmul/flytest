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
     <!--Quicktech Carrier Section Start -->
     <section id="quickTech-carrier" class="section-padding bg-gray">
         <div class="container">
             <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Career</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row">
                @foreach($careers as $key=>$value)
                 <div class="col-lg-6 col-md-12 col-xs-12">
                     <!--Quicktech Carrier Item Starts -->
                     <div class="quickTech-carrier-item wow fadeInRight" data-wow-delay="0.2s">
                         <div class="contetn">
                             <div class="info-text">
                                 <h3><a href="{{url('career/'.$value->id.'/'.$value->slug)}}">{{$value->title}}</a></h3>
                                 <p>Experience: {{$value->exprience}}</p>
                             </div>
                             <p>{{substr($value->text,0,50)}}</p>
                            
                         </div>
                     </div>
                     <!--Quicktech Carrier Item Ends -->
                 </div>
                 @endforeach
             </div>
         </div>
     </section>
     <!--Quicktech Carrier Section End -->
@endsection