@extends('frontEnd.layouts.master')
@section('title','Register')
@section('content')
<!-- Hero Area Start -->
<!-- <div class="">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <div class="section-header text-center">
            
            </ol>
        </nav>
    </div>
</div> -->
<!-- Hero Area End -->

<!--Quicktech Carrier Section Start -->
<section id="quickTech-carrier" class="section-padding bg-gray">
    <div class="container">


        <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">Register Now</h2>

        <div class="shape wow fadeInDown" data-wow-delay="0.3s"></div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-xs-12">
            <!--Quicktech Carrier Item Starts -->
            <div class="quickTech-carrier-item wow fadeInRight" data-wow-delay="0.2s">

                <div class="img">
                    <img class="img-fluid" src="{{asset('public/frontEnd/')}}/assets/img/service.jpg" alt="">
                </div>
            </div>
            <!--Quicktech Carrier Item Ends -->
        </div>
        <div class="col-lg-6 col-md-6 col-xs-12">
            <!--Quicktech Carrier Item Starts -->
            <div class="quickTech-carrier-item wow fadeInRight" data-wow-delay="0.2s">

                <div class="contetn">
                    <div class="info-text">
                        <h3><a>Become a Merchant</a></h3>

                    </div>

                    <div class="contact-block">
                        <form action="{{url('auth/merchant/register')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control {{ $errors->has('companyName') ? ' is-invalid' : '' }}"
                                            id="companyName" name="companyName" placeholder="Name of Business "
                                            data-error="Please enter Name of Business" value="{{ old('companyName') }}"
                                            autocomplete="companyName" autofocus>
                                        @error('companyName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control {{ $errors->has('firstName') ? ' is-invalid' : '' }}"
                                            id="firstName" name="firstName" placeholder="Your Name "
                                            value="{{ old('firstName') }}" autocomplete="firstName" autofocus
                                            data-error="Please enter your Name">
                                        @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Phone " id="phoneNumber"
                                            class="form-control {{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}"
                                            name="phoneNumber" data-error="Please enter your Phone "
                                            value="{{ old('companyName') }}" autocomplete="companyName" autofocus>
                                        @error('phoneNumber')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Email " id="emailAddress"
                                            class="form-control {{ $errors->has('emailAddress') ? ' is-invalid' : '' }}"
                                            name="emailAddress" data-error="Please enter your email *"
                                            value="{{ old('emailAddress') }}" autocomplete="emailAddress" autofocus>
                                        @error('emailAddress')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                            id="username" name="username" placeholder="Username " data-error="Username"
                                            value="{{ old('username') }}" autocomplete="username" autofocus>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control {{ $errors->has('socialLink') ? ' is-invalid' : '' }}"
                                            id="link" name="link" placeholder="Please Enter Business URL"
                                            data-error="Please enter your Business URL "
                                            value="{{ old('socialLink') }}" autocomplete="socialLink" autofocus>
                                        @error('socialLink')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control {{ $errors->has('pickLocation') ? ' is-invalid' : '' }}"
                                            id="pickLocation" name="pickLocation" placeholder="Pickup Address "
                                            data-error="Please enter your address" value="{{ old('pickLocation') }}" autocomplete="pickLocation" autofocus>
                                        @error('pickLocation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <select name="paymentMethod"
                                        class="custom-select form-control {{ $errors->has('paymentMethod') ? ' is-invalid' : '' }}"
                                        placeholder="Payment Method " value="{{ old('paymentMethod') }}" autocomplete="paymentMethod" autofocus> 
                                        <option selected>Payment Mode </option>
                                        <option value="1">Bkash</option>
                                        <option value="2">Bank</option>
                                        <option value="3">Cash</option>
                                        <option value="3">Others</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control {{ $errors->has('paymentDetails') ? ' is-invalid' : '' }}"
                                            id="payment" name="paymentmode" placeholder="Payment Mode Details"
                                            data-error="Please enter your aPayment Mode Details" value="{{ old('paymentmode') }}" autocomplete="paymentmode" autofocus>
                                        @error('paymentDetails')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" placeholder="Password " id="password"
                                            class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            name="password" data-error="Please enter your Password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" placeholder="Confirm Password " id="confirmed"
                                            class="form-control {{ $errors->has('confirmed') ? ' is-invalid' : '' }}"
                                            name="confirmed" data-error="Please enter your Confirm Password">
                                        @error('confirmed')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="checkbox"
                                            class=" {{ $errors->has('agree') ? ' is-invalid' : '' }}"
                                            name="agree" id="agree" name="agree" value="1">
                                        @error('agree')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="agree">I agree to <a href="{{url('terms-condition')}}">terms and
                                                condition.</a> </label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="submit-button text-left">
                                        <button class="btn btn-common" id="form-submit" type="submit">Register</button>
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
@endsection