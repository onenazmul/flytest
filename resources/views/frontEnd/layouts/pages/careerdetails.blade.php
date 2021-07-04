@extends('frontEnd.layouts.master')
@section('title','Career Details')
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
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">JOIN US</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row">
                 <div class="col-lg-6 col-md-6 col-xs-12">
                     <!--Quicktech Carrier Item Starts -->
                     <div class="quickTech-carrier-item wow fadeInRight" data-wow-delay="0.2s">

                         <div class="contetn">
                             <div class="info-text">
                                 <h3><a>{{$careerdetails->title}}</a></h3>
                                 <p>Experience: {{$careerdetails->exprience}}</p>
                             </div>
                             <p>{!! $careerdetails->text  !!}</p>
                             <ul class="social-icons">
                                 <li><a class="facebook" href="https://www.facebook.com/packenmove"><i class="lni-facebook-filled"></i></a></li>
                                 <li><a class="twitter" href="#"><i class="lni-twitter-filled"></i></a></li>
                                 <li><a class="instagram" href="https://www.instagram.com/packenmove/"><i class="lni-instagram-filled"></i></a></li>
                                 <li><a class="linkedin" href="https://www.linkedin.com/in/packen-move-22aa80205/"><i class="lni-linkedin-filled"></i></a></li>
                             </ul>
                         </div>
                     </div>
                     <!--Quicktech Carrier Item Ends -->
                 </div>
                 <div class="col-lg-6 col-md-6 col-xs-12">
                     <!--Quicktech Carrier Item Starts -->
                     <div class="quickTech-carrier-item wow fadeInRight" data-wow-delay="0.2s">

                         <div class="contetn">
                             <div class="info-text">
                                 <h3><a>Apply Now</a></h3>
                               
                             </div>

                             <div class="contact-block">
                                 <form action="{{url('career/apply')}}" method="POST" enctype="multipart/form-data">
                                     @csrf
                                     <div class="row">
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="name" name="name" placeholder="Name" required data-error="Please enter your name">
                                                 <div class="help-block with-errors"></div>
                                             </div>
                                         </div>
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <input type="text" placeholder="Phone " id="phone" class="form-control" name="phone" required data-error="Please enter your Phone">
                                                 <div class="help-block with-errors"></div>
                                             </div>
                                         </div>
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <input type="text" placeholder="Email" id="email" class="form-control" name="email" required data-error="Please enter your email">
                                                 <div class="help-block with-errors"></div>
                                             </div>
                                         </div>
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <input type="text" class="form-control" id="address" name="address" placeholder="Address" required data-error="Please enter your address">
                                                 <div class="help-block with-errors"></div>
                                             </div>
                                         </div>
                                         
                                         <div class="col-md-12">
                                             <div class="form-group">
                                                 <input type="text" placeholder="Job Post" id="msg_subject" name="subject" class="form-control" required data-error="Please enter your Job Post">
                                                 <div class="help-block with-errors"></div>
                                             </div>
                                         </div>
                                         <div class="col-md-12">
                                             <div class="form-group">
                                                <label for="cv">Resume</label>
                                                 <input type="file"  id="cv" class="form-control" name="cv" required data-error="Please Select a cv from your computer">
                                             </div>
                                             <div class="submit-button text-left">
                                                 <button class="btn btn-common" type="submit">Submit</button>
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

             </div>
         </div>
     </section>
     <!--Quicktech Carrier Section End -->


@endsection