@extends('frontEnd.layouts.master')
@section('title','One Time Service')
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
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">One Time Services</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>

             <!--Quicktech Carrier Item Starts -->
             <div class="quickTech-carrier-item wow fadeInRight" data-wow-delay="0.2s">

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
										    <option value="{{$area->id}}">{{$area->zonename}}</option>
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
             <!--Quicktech Carrier Item Ends -->

         </div>
     </section>
     <!--Quicktech Carrier Section End -->

@endsection