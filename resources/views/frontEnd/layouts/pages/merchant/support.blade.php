@extends('frontEnd.layouts.pages.merchant.merchantmaster')
@section('title','Dashboard')
@section('content')
<div class="profile-edit mrt-30">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <form action="{{url('merchant/support')}}" method="POST" name="editForm">
                @csrf
                @php
                    $merchantInfo = App\Merchant::find(Session::get('merchantId'));
                @endphp
                   <div class="form-group row">
                      <div class="col-lg-3 col-md-4 col-sm-4"><p>Suject</p></div>
                      <div class="col-lg-6 col-md-8 col-sm-8">
                        <select type="text" name="subject" class="form-control">
                            <option value="Pick Up">Pick Up</option>
                            <option value="Delivery">Delivery</option>
                            <option value="Payment">Payment</option>
                            <option value="Billing & Charge">Billing & Charge</option>
                            <option value="Serice">Service</option>
                            <option value="Other">Other</option>
                        </select>
                      </div>
                  </div>
                  <!-- form-group end -->
                  <div class="form-group row">
                      <div class="col-lg-3 col-md-4 col-sm-4"><p>Description</p></div>
                      <div class="col-lg-6 col-md-8 col-sm-8">
                        <textarea name="description" class="form-control" rows="8"></textarea>
                      </div>
                  </div>
                  <!-- form-group end -->
                  <div class="form-group row">
                      <div class="col-sm-3"><p></p></div>
                      <div class="col-sm-3"><input type="submit" value="Send Message"class="common-btn"></div>
                  </div>
            </div>
            </form>
        </div>
    </div>
    <!-- row end -->
</div>
@endsection