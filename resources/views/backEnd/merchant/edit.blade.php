@extends('backEnd.layouts.master')
@section('title','Edit Merchant Profile')
@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="box-content">
            <div class="row">
              <div class="col-sm-12">
                  <div class="manage-button">
                    <div class="body-title">
                      <h5>Edit Merchant Profile</h5>
                    </div>
                    <div class="quick-button">
                      <a href="{{url('editor/merchant/manage')}}" class="btn btn-primary btn-actions btn-create">
                      Manage User
                      </a>
                    </div>  
                  </div>
                </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Edit Merchant Profile</h3>
                    </div>
                    <div class="profile-edit mrt-30">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <nav class="custom-tab-menu">
                                  <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" data-toggle="tab" href="#companyinformation">Company Information</a>
                                    <a class="nav-item nav-link"  data-toggle="tab" href="#ownerinformation">Owner Information</a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#pickupmethod">Pickup Method</a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#paymentmethod">Payment Method</a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#bankaccount">Bank Account</a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#otheraccount">Other Account</a>
                                  </div>
                                </nav>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <form action="{{url('editor/merchant/profile/edit')}}" method="POST" name="editForm">
                                    @csrf
                                    <input type="hidden" value="{{$merchantInfo->id}}" name="hidden_id">
                                <div class="tab-content customt-tab-content" id="nav-tabContent">
                                  <div class="tab-pane fade" id="companyinformation" role="tabpanel">
                                      <div class="row">
                                          <div class="col-sm-12">
                                              <p class="title">Business Information</p>
                                              <div class="row">
                                                  <div class="col-sm-3"><p>Company Name</p></div>
                                                  <div class="col-sm-3"><p><strong>{{$merchantInfo->companyName}}</strong></p></div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="tab-pane fade" id="ownerinformation" role="tabpanel">
                                        <div class="row">
                                          <div class="col-sm-12">
                                              <p class="title">Owner Information</p>
                                              <div class="form-group row">
                                                  <div class="col-sm-3"><p>Name</p></div>
                                                  <div class="col-sm-3"><p><strong>{{$merchantInfo->firstName}} {{$merchantInfo->lastName}}</strong></p></div>
                                              </div>
                    
                                              <div class="form-group row">
                                                  <div class="col-sm-3"><p>Mobile Number</p></div>
                                                  <div class="col-sm-3"><input type="text" name="phoneNumber" value="{{$merchantInfo->phoneNumber}}" class="form-control"></div>
                                              </div>
                                              <div class="form-group row">
                                                  <div class="col-sm-3"><p>Email</p></div>
                                                  <div class="col-sm-3">{{$merchantInfo->emailAddress}}</div>
                                              </div>
                    
                                              <div class="form-group row">
                                                  <div class="col-sm-3"><p></p></div>
                                                  <div class="col-sm-3"><input type="submit" value="Update"class="common-btn"></div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="tab-pane fade show active" id="pickupmethod" role="tabpanel">
                                    <p class="title">Pickup Method</p>
                                       <div class="form-group row">
                                          <div class="col-sm-3"><p>Pickup Address</p></div>
                                          <div class="col-sm-3">
                                            <textarea name="pickLocation" class="form-control">{{$merchantInfo->pickLocation}}</textarea>
                                          </div>
                                      </div>
                                      <!-- form-group end -->
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>Nearest Zone</p></div>
                                          <div class="col-sm-3">
                                            <select type="text" name="nearestZone" class="form-control">
                                                <option value=""></option>
                                                @foreach($nearestzones as $key=>$value)
                                                <option value="{{$value->id}}">{{$value->zonename}}</option>
                                                @endforeach
                                            </select>
                                          </div>
                                      </div>
                                      <!-- form-group end -->
                                       <div class="form-group row">
                                          <div class="col-sm-3"><p>Pickup Preference</p></div>
                                          <div class="col-sm-3">
                                            <select type="text" name="pickupPreference" class="form-control">
                                                <option value="1">As Per Request</option>
                                                <option value="2">Daily</option>
                                            </select>
                                          </div>
                                      </div>
                                      <!-- form-group end -->
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p></p></div>
                                          <div class="col-sm-3"><input type="submit" value="Update"class="common-btn"></div>
                                      </div>
                                  </div>
                                  <div class="tab-pane fade" id="paymentmethod" role="tabpanel">
                                       <p class="title">Payment Method</p>
                                       <div class="form-group row">
                                          <div class="col-sm-3"><p>Default Payment</p></div>
                                          <div class="col-sm-3">
                                            <select type="text" name="paymentMethod" class="form-control">
                                                <option value="1">Bank</option>
                                                <option value="2">Bkash</option>
                                                <option value="3">Roket</option>
                                                <option value="4">Nogod</option>
                                            </select>
                                          </div>
                                      </div>
                                      <!-- form-group end -->
                                       <div class="form-group row">
                                          <div class="col-sm-3"><p>Withdrawal</p></div>
                                          <div class="col-sm-3">
                                            <select type="text" name="withdrawal" class="form-control">
                                                <option value="1">As Per Request</option>
                                                <option value="2">Daily</option>
                                                <option value="3">Weekly</option>
                                            </select>
                                          </div>
                                      </div>
                                      <!-- form-group end -->
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p></p></div>
                                          <div class="col-sm-3"><input type="submit" value="Update"class="common-btn"></div>
                                      </div>
                                      <!-- form group end -->
                                  </div>
                                  <div class="tab-pane fade " id="bankaccount" role="tabpanel">
                                      <p class="title">Bank Account</p>
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>Name Of Bank</p></div>
                                          <div class="col-sm-3"><input type="text" name="nameOfBank" value="{{$merchantInfo->nameOfBank}}" class="form-control"></div>
                                      </div>
                                      <!-- form-group end -->
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>Branch</p></div>
                                          <div class="col-sm-3"><input type="text" name="bankBranch" value="{{$merchantInfo->bankBranch}}" class="form-control"></div>
                                      </div>
                                      <!-- form-group end -->
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>A/C Holder Name</p></div>
                                          <div class="col-sm-3"><input type="text" name="bankAcHolder" value="{{$merchantInfo->bankAcHolder}}" class="form-control"></div>
                                      </div>
                                      <!-- form-group end -->
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>Bank A/C No</p></div>
                                          <div class="col-sm-3"><input type="text" name="bankAcNo" value="{{$merchantInfo->bankAcNo}}" class="form-control"></div>
                                      </div>
                                      <!-- form-group end -->
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p></p></div>
                                          <div class="col-sm-3"><input type="submit" value="Update"class="common-btn"></div>
                                      </div>
                                      <!-- form-group end -->
                                  </div>
                                  <div class="tab-pane fade " id="otheraccount" role="tabpanel">
                                      <p class="title">Other Account</p>
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>Bkash</p></div>
                                          <div class="col-sm-3"><input type="text" name="bkashNumber" value="{{$merchantInfo->bkashNumber}}" class="form-control"></div>
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>Roket</p></div>
                                          <div class="col-sm-3"><input type="text" name="roketNumber" value="{{$merchantInfo->roketNumber}}" class="form-control"></div>
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>Nogod</p></div>
                                          <div class="col-sm-3"><input type="text" name="nogodNumber" value="{{$merchantInfo->nogodNumber}}" class="form-control"></div>
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p>Discount</p></div>
                                          <div class="col-sm-3"><input type="text" name="discount" value="{{$merchantInfo->discount}}" class="form-control"></div>
                                      </div>
                                      <div class="form-group row">
                                          <div class="col-sm-3"><p></p></div>
                                          <div class="col-sm-3"><input type="submit" value="Update"class="common-btn"></div>
                                      </div>
                                  </div>
                                </div>
                                </form>
                            </div>
                        </div>
                        <!-- row end -->
                    </div>
                </div>
              </div>
              <!-- col end -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<script type="text/javascript">
      document.forms['editForm'].elements['paymentMethod'].value="{{$merchantInfo->paymentMethod}}"
      document.forms['editForm'].elements['withdrawal'].value="{{$merchantInfo->withdrawal}}"
      document.forms['editForm'].elements['nearestZone'].value="{{$merchantInfo->nearestZone}}"
      document.forms['editForm'].elements['pickupPreference'].value="{{$merchantInfo->pickupPreference}}"
  </script>
@endsection