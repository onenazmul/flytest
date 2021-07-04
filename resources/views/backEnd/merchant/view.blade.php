@extends('backEnd.layouts.master')
@section('title','View Merchant')
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="box-content">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card custom-card">
                        <div class="col-sm-12">
                            <div class="manage-button">
                                <div class="body-titleer">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h5>{{$merchantInfo->companyName}}</h5>
                                        </div>
                                        <div class="col-sm-6 text-right"><button class="btn btn-primary" title="Action"
                                                data-toggle="modal" data-target="#fullprofile"><i class="fa fa-eye"></i>
                                                Full Profile</button>
                                            <a class="btn btn-dark"
                                                href="{{url('editor/merchant/payment/invoice/'.$merchantInfo->id)}}">Invoice</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="supplier-profile">
                                <div class="company-name">
                                    <h2>Contact Info</h2>
                                </div>
                                <div class="supplier-info">
                                    <table class="table table-bordered table-responsive">
                                        <tr>
                                            <td>Name</td>
                                            <td>{{$merchantInfo->firstName}} {{$merchantInfo->lastName}}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone</td>
                                            <td>{{$merchantInfo->phoneNumber}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{$merchantInfo->emailAddress}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="supplier-profile">
                                <div class="invoice slogo-area">
                                    <div class="supplier-logo">
                                        <img src="{{asset($merchantInfo->image)}}" alt="">
                                    </div>
                                </div>
                                <div class="supplier-info">

                                    <div class="supplier-basic">
                                        <h5>{{$merchantInfo->companyName}}</h5>
                                        <p>Member Since : {{date('M-d-Y', strtotime($merchantInfo->created_at))}}</p>
                                        <p>Member Status : {{$merchantInfo->status==1? 'Active':'Inactive'}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="supplier-profile">
                                <div class="purchase">
                                    <h2>Account Info</h2>
                                </div>
                                <div class="supplier-info">
                                    <table class="table table-bordered table-responsive">
                                        <tr>
                                            <td>Total Invoice </td>
                                            <td>{{$parcel}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Amount (<small><b>include Cod</b> </small>)</td>
                                            <td>{{$totalamount}}</td>
                                        </tr>
                                        <tr>
                                            <td>Marchent Amount (<small><b>without cancel</b> </small>)</td>
                                            <td>{{$marcentamount}}</td>
                                        </tr>
                                        <tr>
                                            <td>Delivery Charge (<small><b>without cancel </b> </small>)</td>
                                            <td>{{$deliverycharge}}</td>
                                        </tr>
                                        <tr>
                                            <td>Collected Amount </td>
                                            <td>{{$collectedAmount}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Paid Amount (<small><b>without cancel</b> </small>)</td>
                                            <td>{{$merchantPaid}}</td>
                                        </tr>

                                        <tr>
                                            <td>Current Due (<small><b>without cancel</b> </small>)</td>
                                            <td>{{$totaldue}}</td>
                                        </tr>
                                        <tr>
                                            <td>Payment Method</td>
                                            <td>
                                                @if($merchantInfo->paymentMethod==1) Bkash @endif
                                                @if($merchantInfo->paymentMethod==2) Bank @endif
                                                @if($merchantInfo->paymentMethod==3) Cash @endif
                                                @if($merchantInfo->paymentMethod==4) Others @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Payment Mode</td>
                                            <td>
                                                {{ $merchantInfo->paymentmode }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="card-body p-5">
                            <form action="{{url('admin/merchant-payment/bulk-option')}}" method="POST" id="myform">
                                <input type="hidden" value="{{$merchantInfo->id}}" name="merchantId">
                                <input type="hidden" value="{{$merchantInfo->id}}" name="parcelId">
                                @csrf
                                <table id="sampleTable"
                                    class="table table-hover table-bordered  table-striped custom-table table-responsive">
                                    @if(Auth::user()->role_id <= 2) <select name="selectptions" class="bulkselect"
                                        form="myform" required="required">
                                        <option value="">Select..</option>
                                        <option value="0">Processing</option>
                                        <option value="1">Paid</option>
                                        </select>
                                        <button type="submit" class="bulkbutton"
                                            onclick="return confirm('Are you want change this?')">Apply</button>
                                        @endif
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="My-Button"></th>
                                                <th>SL</th>
                                                <th>Id</th>
                                                <th>Date</th>
                                                <th>COD</th>
                                                <th>Partial</th>
                                                <th>L. Update</th>
                                                <th>Subtotal</th>
                                                <th>Paid Bills</th>
                                                <th>Due Bills</th>
                                                <th>C. Charge</th>
                                                <th>D. Charge</th>
                                                <th>Pay Status</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($parcels as $key=>$value)
                                            <tr>
                                                <td><input type="checkbox" value="{{$value->id}}" name="parcel_id[]"
                                                        form="myform"></td>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$value->trackingCode}}</td>
                                                <td> {{date('F d Y', strtotime($value->created_at))}}
                                                    {{date('H:i:s:A', strtotime($value->created_at))}}</td>
                                                <td>{{$value->cod}}</td>
                                                <td> <?php if ($value->partial_pay==null) {
                            $partial=0;
                          } else {
                            $partial=$value->cod-$value->partial_pay;
                          }
                           ?> {{$value->partial_pay}}</td>
                                                <td>{{date('F d, Y', strtotime($value->updated_at))}}</td>
                                                <td>{{($value->cod-$value->deliveryCharge)-$partial}}</td>
                                                <td>{{($value->merchantPaid)}}</td>
                                                <td>{{($value->merchantDue)}}</td>
                                                <td>{{$value->codCharge}}</td>
                                                <td>{{$value->deliveryCharge}}</td>
                                                <td>@if($value->merchantpayStatus==NULL) <span
                                                        class="btn btn-sm btn-danger">Unpaid</span>
                                                    @elseif($value->merchantpayStatus==0) Processing @else <span
                                                        class="btn btn-sm btn-info">Paid</span> @endif</td>
                                                <td>@php $parceltype = App\Parceltype::find($value->status); @endphp
                                                    @if($parceltype!=NULL) {{$parceltype->title}} @endif</td>
                                                <td>
                                                    <ul class="action_buttons">
                                                        @if($value->status==3)
                                                        <li>
                                                            <a class="edit_icon anchor" a
                                                                href="{{url('editor/parcel/invoice/'.$value->id)}}"
                                                                title="Invoice"><i class="fa fa-list"></i></a>
                                                            <!-- Modal -->
                                                        </li>
                                                        @endif
                                                        <li>
                                                            <a class="edit_icon" href="#" data-toggle="modal"
                                                                data-target="#merchantParcel{{$value->id}}"
                                                                title="View"><i class="fa fa-eye"></i></a>
                                                            <div id="merchantParcel{{$value->id}}" class="modal fade"
                                                                role="dialog">
                                                                <div class="modal-dialog">
                                                                    <!-- Modal content-->
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Parcel Details</h5>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <table
                                                                                class="table table-bordered table-responsive-sm">
                                                                                <tr>
                                                                                    <td>Recipient Name</td>
                                                                                    <td>{{$value->recipientName}}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Recipient Address</td>
                                                                                    <td>{{$value->recipientAddress}}
                                                                                    </td>
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
                                                                                <tr>
                                                                                    <td>Last Update</td>
                                                                                    <td>{{$value->updated_at}}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-dismiss="modal">Close</button>
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
            </div>
        </div>
    </div>
    <div id="fullprofile" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Merchant Profile</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-responsive table-striped">
                        <tbody>
                            <tr>
                                <td>Name</td>

                                <td>{{$merchantInfo->firstName}} {{$merchantInfo->lastName}}</td>
                            </tr>
                            <tr>
                                <td>User Name</td>
                                <td>{{$merchantInfo->username}}</td>
                            </tr>
                            <tr>
                                <td>Company</td>
                                <td>{{$merchantInfo->companyName}}</td>
                            </tr>
                            <tr>
                                <td>Phone Number</td>
                                <td>{{$merchantInfo->phoneNumber}}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{$merchantInfo->emailAddress}}</td>
                            </tr>
                            <tr>
                                <td>Pickup Location</td>
                                <td>{{$merchantInfo->pickLocation}}</td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td>{{$merchantInfo->nameOfBank}}</td>
                            </tr>
                            <tr>
                                <td>Branch</td>
                                <td>{{$merchantInfo->nameOfBank}}</td>
                            </tr>
                            <tr>
                                <td>Acc Holder</td>
                                <td>{{$merchantInfo->bankAcHolder}}</td>
                            </tr>
                            <tr>
                                <td>Bank Account No</td>
                                <td>{{$merchantInfo->bankAcNo}}</td>
                            </tr>
                            <tr>
                                <td>Bkash Number</td>
                                <td>{{$merchantInfo->bkashNumber}}</td>
                            </tr>
                            <tr>
                                <td>Roket Number</td>
                                <td>{{$merchantInfo->roketNumber}}</td>
                            </tr>
                            <tr>
                                <td>Nagod Number</td>
                                <td>{{$merchantInfo->nogodNumber}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
</section>
@endsection