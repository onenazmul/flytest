@extends('frontEnd.layouts.master')
@section('title','Forget Password')
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
    <div class="section-auth-common section-padding bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="modal-content">
                    <div class="row">
            <div class="col-sm-6">
                <div class="auth-left">
                    <img src="{{asset('public/frontEnd/images/login.png')}}" alt="">
                </div>
            </div>
            <div class="col-sm-6">
                <div class="auth-common-right">
                    @foreach($whitelogo as $logo)
                <div class="logo">
                    <a href="{{url('/')}}">
                    <img src="{{asset($logo->image)}}" alt="">
                </a>
                </div>
                @endforeach

                <div class="form-content">
                    <h4>Forget Password</h4>
                    <p>Welcome back, please login to your account.</p>
                    <form action="{{url('auth/merchant/password/reset')}}" method="post" class="contact-wthree-do">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control contact-formquickTechls {{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}" type="text" value="{{old('phoneNumber')}}" placeholder="Phone Number" name="phoneNumber" required="">
                                     @if ($errors->has('phoneNumber'))
                                        <span class="invalid-feedback">
                                          <strong>{{ $errors->first('phoneNumber') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-cont-quicktech btn-block mt-2">SUBMIT</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div> 
    @endsection