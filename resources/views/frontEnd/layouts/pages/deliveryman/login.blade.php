@extends('frontEnd.layouts.master')
@section('title','Supporting Agent Login')
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
                 <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Flingex Login</h2>
                 <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
             </div>
             <div class="row justify-content-md-center">
                 <div class="col-lg-6 col-md-12 col-xs-12">
                     <!--Quicktech Carrier Item Starts -->
                     <div class="quickTech-carrier-item wow fadeInRight" data-wow-delay="0.2s">

                         <div class="contetn">
                             <div class="info-text">
                                 <h3><a>Supporting Agent </a></h3>

                             </div>

                             <div class="contact-block">
                                <form action="{{url('auth/deliveryman/login')}}" method="post">
                                   @csrf
                                     <div class="row">

                                         <div class="col-md-12">
                                             <div class="form-group">
                                                 <input type="text" placeholder="Email Address " id="email" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="email" required data-error="Please enter your Email">
                                                 <div class="help-block with-errors"></div>
                                                  @if ($errors->has('email'))
                                                    <span class="invalid-feedback">
                                                      <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                  @endif
                                             </div>
                                         </div>

                                         <div class="col-md-12">
                                             <div class="form-group">
                                                 <input type="password" placeholder="Password" id="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required data-error="Please enter your Password">
                                                 <div class="help-block with-errors"></div>
                                                 @if ($errors->has('password'))
                                                    <span class="invalid-feedback">
                                                      <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                  @endif
                                             </div>
                                         </div>
                                         <div class="col-sm-6">
                                             <div class="rememberme text-danger">
                                                 <input type="checkbox" name="rememberme" id="rememberme"> <label for="rememberme"> Remember Me</label>
                                             </div>
                                         </div>
                                         <div class="col-sm-6 text-right">
                                             <a href="{{url('deliveryman/forget/password')}}" class="text-danger">Forget Password</a>
                                         </div>
                                         <div class="col-md-12">
                                             <div class="submit-button text-left mt-3">
                                                 <button class="btn btn-common btn-success" id="form-submit" type="submit">Login Now</button>
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
