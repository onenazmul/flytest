@extends('frontEnd.layouts.pages.agent.agentmaster')
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
                        <th>Merchant Phone</th>
                        <th>Pickup Address</th>
                        <th>Area</th>
                        <th>Asign</th>
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
                            $deliverymanInfo = App\Deliveryman::find($value->deliveryman);
                          @endphp
                          <td>{{$merchant->companyName}} {{$merchant->NULL}}</td>
                          <td>{{$merchant->phoneNumber}}</td>
                          <td>{{$value->pickupAddress}}</td>
                          <th>{{$merchant->area}}</th>
                          <td>@if($value->deliveryman) {{$deliverymanInfo->name}} @else <button class="btn btn-primary" data-toggle="modal" data-target="#asignModal{{$value->id}}">Asign</button> @endif</td>
                          <td>@if($value->status==0)Not Assigned @elseif($value->status==1) Pending @elseif($value->status==2) Accepted @elseif($value->status==3)Cancelled @endif</td>
                          <!-- Modal -->
                          <div id="asignModal{{$value->id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title">Delivery Man Asign</h5>
                                </div>
                                <div class="modal-body">
                                     @if($value->deliveryman==NULL)
                                      <form action="{{url('agent/pickup/deliveryman/asign')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                        <div class="form-group">
                                          <select name="deliveryman" class="form-control" id="">
                                            @foreach($deliverymen as $key=>$deliveryman)
                                              <option value="{{$deliveryman->id}}">{{$deliveryman->name}}</option>
                                            @endforeach
                                          </select>
                                        </div>
                                        <!-- form group end -->
                                        <div class="form-group">
                                          <button class="btn btn-success">Update</button>
                                        </div>
                                        <!-- form group end -->
                                      </form>
                                      @else
                                      <h4>{{$deliverymanInfo->name}}</h4>
                                      @endif
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- Modal end -->
                          <td>
                            <ul>
                                  <li>
                                      <button class="btn btn-info" title="Action" data-toggle="modal" data-target="#sUpdateModal{{$value->id}}"><i class="fa fa-sync-alt"></i></button>
                                      <!-- Modal -->
                                      <div id="sUpdateModal{{$value->id}}" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                          <!-- Modal content-->
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Pickup Status Update</h5>
                                            </div>
                                            <div class="modal-body">
                                              <form action="{{url('agent/pickup/status-update')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                                <input type="hidden" name="merchant_phone"  value="{{$merchant->phoneNumber}}">
                                                <div class="form-group">
                                                    <select name="status"  class="form-control" id="">
                                                        <option value="1"@if($value->status==1) selected="selected" @endif>Pending</option>
                                                        <option value="2"@if($value->status==2) selected="selected" @endif>Accepted</option>
                                                        <option value="3"@if($value->status==3) selected="selected" @endif>Cancelled</option>
                                                  </select>
                                                </div>                                    
                                                <!-- form group end -->
                                                <div class="form-group">
                                                  <button class="btn btn-success">Update</button>
                                                </div>
                                                <!-- form group end -->
                                              </form>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                      <!-- Modal end -->
                                  </li>
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
                                            <td>area</td>
                                            <td>{{$merchant->area}}</td>
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