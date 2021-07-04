@extends('frontEnd.layouts.master')
@section('title','Contact Us')
@section('content')
<!-- page details -->
<!-- banner -->
<div class="quicktech-all-page-header-bg">
 <div class="container">
     <nav aria-label="breadcrumb">
         <ol class="breadcrumb">
            
         </ol>
     </nav>
 </div>
</div>
	 <!-- Contact Section Start -->
     <section id="contact" class="section-padding bg-gray">
         <div class="container">
             <div class="section-header text-center">
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Contact Us</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row contact-form-area wow fadeInUp" data-wow-delay="0.3s">
                 <div class="col-lg-7 col-md-12 col-sm-12">
                     <div class="contact-block">
                         <form id="contactForm">
                             <div class="row">
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <input type="text" class="form-control" id="name" name="name" placeholder="Name" required data-error="Please enter your name">
                                         <div class="help-block with-errors"></div>
                                     </div>
                                 </div>
                                 <div class="col-md-6">
                                     <div class="form-group">
                                         <input type="text" placeholder="Email" id="email" class="form-control" name="email" required data-error="Please enter your email">
                                         <div class="help-block with-errors"></div>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <input type="text" placeholder="Subject" id="msg_subject" class="form-control" required data-error="Please enter your subject">
                                         <div class="help-block with-errors"></div>
                                     </div>
                                 </div>
                                 <div class="col-md-12">
                                     <div class="form-group">
                                         <textarea class="form-control" id="message" placeholder="Your Message" rows="7" data-error="Write your message" required></textarea>
                                         <div class="help-block with-errors"></div>
                                     </div>
                                     <div class="submit-button text-left">
                                         <button class="btn btn-common" id="form-submit" type="submit">Send Message</button>
                                         <div id="msgSubmit" class="h3 text-center hidden"></div>
                                         <div class="clearfix"></div>
                                     </div>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
                 <div class="col-lg-5 col-md-12 col-xs-12">
                     <div class="map">
                       <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14609.532256356075!2d90.381236!3d23.7337156!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf87b71cdf14fa2ac!2sPackeN%20Move!5e0!3m2!1sen!2sbd!4v1614923873295!5m2!1sen!2sbd" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                     </div>
                 </div>
             </div>
         </div>
     </section>
     <!-- Contact Section End -->
@endsection