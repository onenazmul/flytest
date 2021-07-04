@extends('frontEnd.layouts.pages.merchant.merchantmaster')
@section('title','Pickup')
@section('content')
<div class="profile-edit mrt-30">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="tab-inner table-responsive-sm">
               <table id="example1" class="table table-bordered table-striped custom-table">
                      <thead>
                      <tr>
                        <th>Id</th>
                        <th>Merchant</th>
                        <th>Area</th>
                        <th>Deliveryman</th>
                        <th>Merchant Phone</th>
                        <th>Pickup Address</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          @php
                            $merchant = App\Merchant::find($value->merchantId);
                            $areaInfo = App\Agent::find($value->agent);
                            $deliverymanInfo = App\Deliveryman::find($value->deliveryman);
                          @endphp
                          <td>{{$merchant->firstName}} {{$merchant->lastName}}</td>
                          <td>@if($value->agent!=NULL) {{$areaInfo->name}} @else Not Asign @endif</td>
                          <td>@if($value->deliveryman!=NULL) {{$deliverymanInfo->name}} @else Not Asign @endif</td>
                          <td>{{$merchant->phoneNumber}}</td>
                          <td>{{$value->pickupAddress}}</td>
                          <td>@if($value->status==0)Not Assigned @elseif($value->status==1) Pending @elseif($value->status==2) Accepted @elseif($value->status==3)Cancelled @endif</td>   
                          <td>
                            <ul>
                                  <li>
                                      <button class="btn btn-success" href="#"  data-toggle="modal" data-target="#merchantParcel{{$value->id}}" title="View"><i class="fa fa-eye"></i></button>
                                      <div id="merchantParcel{{$value->id}}" class="modal fade" role="dialog">
                                  <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title">Pickup Details</h5>
                                      </div>
                                      <div class="modal-body">
                                        <table class="table table-bordered">
                                          <tr>
                                            <td>Merchant Name</td>
                                            <td>{{$merchant->firstName}} {{$merchant->lastName}}</td>
                                          </tr>
                                          <tr>
                                            <td>Merchant Phone</td>
                                            <td>{{$merchant->phoneNumber}}</td>
                                          </tr>
                                          <tr>
                                            <td>Merchant Email</td>
                                            <td>{{$merchant->emailAddress}}</td>
                                          </tr>
                                          <tr>
                                            <td>Company</td>
                                            <td>{{$merchant->companyName}}</td>
                                          </tr>
                                          <tr>
                                            <td>Pickup Address</td>
                                            <td>{{$value->pickupAddress}}</td>
                                          </tr>
                                          <tr>
                                            <td>Pickup type</td>
                                            <td>@if($value->pickuptype==1) Next Day Delivery @elseif($value->pickuptype==2) Same Day Delivery @endif</td>
                                          </tr>
                                          <tr>
                                            <td>Note</td>
                                            <td>{{$value->note}}</td>
                                          </tr>
                                          <tr>
                                            <td>Estimed Parcel</td>
                                            <td>{{$value->estimedparcel}}</td>
                                          </tr>
                                        </table>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!-- Modal end -->
                                </li>
                              </ul>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
             </div>
        </div>
    </div>
    <!-- row end -->
</div>
<!-- Modal -->
@endsection