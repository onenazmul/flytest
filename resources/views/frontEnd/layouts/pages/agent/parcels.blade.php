@extends('frontEnd.layouts.pages.agent.agentmaster')
@section('title','Dashboard')
@section('content')
<div class="profile-edit mrt-30">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <form action="" class="filte-form">
                @csrf
                <div class="row">
                    <input type="hidden" value="1" name="filter_id">
                    <div class="col-sm-2">
                        <input type="text" class="form-control" placeholder="Track Id" name="trackId">
                    </div>
                    <!-- col end -->
                    <div class="col-sm-2">
                        <input type="number" class="form-control" placeholder="Phone Number" name="phoneNumber">
                    </div>
                    <!-- col end -->
                    <div class="col-sm-2">
                        <input type="date" class="flatDate form-control" placeholder="Date Form" name="startDate">
                    </div>
                    <!-- col end -->
                    <div class="col-sm-2">
                        <input type="date" class="flatDate form-control" placeholder="Date To" name="endDate">
                    </div>
                    <!-- col end -->
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success">Submit </button>
                    </div>
                    <!-- col end -->
                </div>
            </form>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="tab-inner table-responsive">
                <table id="example" class="table  table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>Sl ID</th>
                            <th>Tracking ID</th>
                            <th>Date</th>
                            <th>Shop Name</th>
                            <th>Phone</th>
                            <th>Delivery Man</th>

                            <th>Status</th>
                            <th>Total</th>
                            <th>Partial</th>
                            <th>Charge</th>
                            <th>Sub Total</th>
                            <th>Payment Status</th>
                            <th>Note</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $subtotal=0; ?>
                        @foreach($allparcel as $key=>$value)
                        <tr>
                            @php
                            $deliverymanInfo = App\Deliveryman::find($value->deliverymanId);
                            $merchantInfo = App\Merchant::find($value->merchantId);
                            @endphp
                            <td>{{@$value->id}}</td>
                            <td>{{$value->trackingCode}}</td>
                            <td>{{$value->created_at}}</td>
                            <td>{{$value->companyName}}</td>
                            <td>{{$value->recipientPhone}}</td>
                            <td>
                                @if($value->deliverymanId) {{$deliverymanInfo->name}} <button
                                    class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#asignModal{{$value->id}}">Change Asign</button> @else <button
                                    class="btn btn-primary" data-toggle="modal"
                                    data-target="#asignModal{{$value->id}}">Asign</button> @endif
                                <div id="asignModal{{$value->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delivery Man Asign</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{url('agent/deliveryman/asign')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                                    <input type="hidden" name="merchant_phone"
                                                        value="{{$merchantInfo->phoneNumber}}">
                                                    <div class="form-group">
                                                        <select name="deliverymanId" class="form-control" id="">
                                                            <option value="">Select..</option>
                                                            @foreach($deliverymen as $key=>$deliveryman)
                                                            <option value="{{$deliveryman->id}}">{{$deliveryman->name}}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <!-- form group end -->
                                                    <div class="form-group mrt-15">
                                                        <textarea name="note" class="form-control" cols="30"
                                                            placeholder="Note"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-success">Update</button>
                                                    </div>
                                                    <!-- form group end -->
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal end -->
                            </td>
                            <td>
                                @php
                                $parcelstatus = App\Parceltype::find($value->status);
                                @endphp
                                {{$parcelstatus->title}} <br>
                                @if($value->agentAprove==null)
                                <span class="btn btn-sm btn-dark "><a
                                        href="{{url('agent/parcel/accept/'.$value->id)}}">Parcel not accept</a></span>
                                @else
                                <span class="btn btn-sm btn-success">Parcel accept</span>
                                @endif
                            </td>
                            <td> {{$value->cod}}</td>
                            <td> <?php if ($value->partial_pay==null) {
                            $partial=0;
                          } else {
                            $partial=$value->cod-$value->partial_pay;
                          }
                           ?> {{$value->partial_pay}}</td>
                            <td> {{$value->deliveryCharge+$value->codCharge}}</td>
                            <td><?php $subtotal+=($value->cod-($value->deliveryCharge+$value->codCharge))-$partial; ?>
                                {{($value->cod-($value->deliveryCharge+$value->codCharge))-$partial}}</td>
                            <td>@if($value->merchantpayStatus==NULL) NULL @elseif($value->merchantpayStatus==0)
                                Processing @else Paid @endif</td>
                            <td>
                                @php
                                $parcelnote =
                                App\Parcelnote::where('parcelId',$value->id)->orderBy('id','DESC')->first();
                                @endphp
                                @if(!empty($parcelnote))
                                {{$parcelnote->note}}
                                @endif
                            </td>
                            <td>
                                <li>
                                    <button class="btn btn-info" href="#" data-toggle="modal"
                                        data-target="#merchantParcel{{$value->id}}" title="View"><i
                                            class="fa fa-eye"></i></button>
                                </li>
                                <div id="merchantParcel{{$value->id}}" class="modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Parcel Details</h5>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>Merchant Name</td>
                                                        <td>{{$value->firstName}} {{$value->lastName}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Merchant Phone</td>
                                                        <td>{{$value->phoneNumber}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Merchant Email</td>
                                                        <td>{{$value->emailAddress}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Company</td>
                                                        <td>{{$value->companyName}}</td>
                                                    </tr>
                                                    <td>Recipient Name</td>
                                                    <td>{{$value->recipientName}}</td>
                        </tr>
                        <tr>
                            <td>Recipient Address</td>
                            <td>{{$value->recipientAddress}}</td>
                        </tr>
                        <tr>
                            <td>COD</td>
                            <td>{{$value->cod}}</td>
                        </tr>
                        <tr>
                            <td>C. Charge</td>
                            <td>{{$value->codCharge}}</td>
                        </tr>
                        <tr>
                            <td>D. Charge</td>
                            <td>{{$value->deliveryCharge}}</td>
                        </tr>
                        <tr>
                            <td>Sub Total</td>
                            <td>{{$value->merchantAmount}}</td>
                        </tr>
                        <tr>
                            <td>Paid</td>
                            <td>{{$value->merchantPaid}}</td>
                        </tr>
                        <tr>
                            <td>Due</td>
                            <td>{{$value->merchantDue}}</td>
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
<li><button class="btn btn-danger" title="Action" data-toggle="modal" data-target="#sUpdateModal{{$value->id}}"><i
            class="fa fa-sync-alt"></i></button></li>
<!-- Modal -->
<div id="sUpdateModal{{$value->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Parcel Status Update</h5>
            </div>
            <div class="modal-body">
                <form action="{{url('agent/parcel/status-update')}}" method="POST">
                    @csrf
                    <input type="hidden" name="hidden_id" value="{{$value->id}}">
                    <input type="hidden" name="customer_phone" value="{{$value->recipientPhone}}">
                    <div class="form-group">
                        <select name="status" onchange="percelDelivery(this)" class="form-control" id="">
                            @foreach($aparceltypes as $key=>$ptvalue)
                            <option value="{{$ptvalue->id}}" @if($value->status==$ptvalue->id) selected="selected"
                                @endif @if($value->status > $ptvalue->id) @endif @if($value->status ==4 ||
                                $value->status==9) disabled @endif>{{$ptvalue->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- form group end -->
                    <div class="form-group mrt-15">
                        <select name="snote" id="" class="form-control">
                            <option value="">Select Note
                            </option>
                            <option value="Parcel Pending">
                                Parcel Pending</option>
                            <option value="Successfully Picked">
                                Successfully Picked</option>
                            <option value="Parcel in Transit">
                                Parcel in Transit</option>
                            <option value="Successfully Delivered">
                                Successfully Delivered</option>
                            <option value="Parcel in Hold">
                                Parcel in Hold</option>
                            <option value="Parcel Return Pending">
                                Parcel Return Pending</option>
                            <option value="Parcel returned to Hub">
                                Parcel returned to Hub</option>
                            <option value="Parcel returned to Merchant">
                                Parcel returned to Merchant
                            </option>
                            <option value="Parcel Cancelled">
                                Parcel Cancelled</option>
                            <option value="Customer Refused  This Order! ">
                                Customer Refused This Order!
                            </option>
                            <option value="The customer couldn't receive this Parcel today.">
                                The customer couldn't receive
                                this Parcel today.</option>
                            <option value="The Customer will take this parcel tomorrow.">
                                The Customer will take this
                                parcel tomorrow.</option>
                            <option value="Returned from customer and hold in the hub!">
                                Returned from customer and hold
                                in the hub!</option>
                            <option value="The customer Didn't receive the call!">
                                The customer Didn't receive the
                                call!</option>
                            <option value="Sent to area HUB.">
                                Sent to area HUB.</option>
                            <option value="On the way to deliver!">
                                On the way to deliver!</option>
                            <option value="Wrong Product! return Pending!">
                                Wrong Product! return Pending!
                            </option>
                            <option value="This Parcel will be delivered tomorrow!">
                                This Parcel will be delivered
                                tomorrow!</option>


                        </select>
                    </div>
                    <div class="form-group mrt-15">

                        <p id="">Customize Note</p>

                        <div id="myDIV">
                            <textarea name="note" id="note" class="form-control" cols="30"
                                placeholder="Note"></textarea>
                        </div>

                    </div>
                    <!-- form group end -->
                    <div class="form-group">
                        <div id="customerpaid" style="display: none;">
                            <input type="text" class="form-control" value="{{old('customerpay')}}" id="customerpay"
                                name="customerpay" placeholder="customer pay" /><br />
                        </div>
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
@if($value->status >= 2)
<li><a class="btn btn-primary" a href="{{url('agent/parcel/invoice/'.$value->id)}}" title="Invoice"><i
            class="fas fa-list"></i></a></li>
@endif
@if($value->partial_pay==null)
<li>
    <a class="btn-info  btn" href="#" title="Invoice" data-toggle="modal" data-target="#partial_pay{{$value->id}}"><i
            class="fa fa-box"></i></a>
</li>
@endif
<div id="partial_pay{{$value->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Partial Pay </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{url('agent/partial_pay')}}" method="post">
                            @csrf

                            <label for="">Partial Pay</label>
                            <input type="hidden" name="id" value="{{$value->id}}">
                            <input class="form-control" type="text" name="partial_pay">
                            <input class="btn btn-sm btn-dark" type="submit" value="submit" name="">
                        </form>

                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="tab-inner table-responsive">
        <table id="example" class="table  table-striped">
            <thead>
                <tr>
                    <th>Parcel</th>
                    <th>Delivered</th>
                    <th> Panding</th>
                    <th>Cancelled</th>
                    <th>Returned to Merchant</th>
                    <th>Picked</th>
                    <th>In Transit</th>
                    <th>Hold</th>
                    <th>Return Pending</th>
                    <th>Return To Hub</th>

                    <th>Cod Price</th>
                    <th>Sub Total</th>


                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>
                        {{@$parcelcount}}
                    </td>
                    <td>
                        {{@$parcelr}}@if($parcelr)({{round(($parcelr*100)/$parcelcount,2)}}%)
                        @endif
                    </td>
                    <td>{{@$parcelpa}}@if($parcelpa)({{round(($parcelpa*100 )/$parcelcount,2)}}%)
                        @endif
                    </td>
                    <td>{{@$parcelc}}@if($parcelc)({{round(($parcelc*100)/$parcelcount,2)}}%)
                        @endif</td>
                    <td>{{@$parcelre}}@if($parcelre)({{round(($parcelre*100)/$parcelcount,2)}}%)@endif</td>
                    <td>{{@$parcelpictd}}@if($parcelpictd)({{round(($parcelpictd*100)/$parcelcount,2)}}%)@endif</td>
                    <td>{{@$parcelinterjit}}@if($parcelinterjit)({{round(($parcelinterjit*100)/$parcelcount,2)}}%)@endif
                    </td>
                    <td>{{@$parcelhold}}@if($parcelhold)({{round(($parcelhold*100)/$parcelcount,2)}}%)
                        @endif</td>
                    <td>{{@$parcelrrtupa}}@if($parcelrrtupa)({{round(($parcelrrtupa*100)/$parcelcount,2)}}%)@endif</td>
                    <td>{{@$parcelrrhub}}@if($parcelrrhub)({{round(($parcelrrhub*100)/$parcelcount,2)}}%)
                        @endif</td>

                    <td>{{@$parcelpriceCOD}}</td>
                    <td>{{@$subtotal}}</td>


                </tr>

            </tbody>
        </table>
    </div>
</div>
</div>
<!-- row end -->
</div>
<!-- Modal -->
@endsection