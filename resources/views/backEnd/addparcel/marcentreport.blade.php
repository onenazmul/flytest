@extends('backEnd.layouts.master')
@section('title','Report Parcel')
@section('content')
<div class="profile-edit mrt-30">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <form action="{{url('editor/parcel/report')}}" method="get" class="">
            @csrf
            <div class="row">
              
            <div class="col-sm-6">
              <select name="mid" id=""  class="form-control select2">
            <option value="Allmarcent">All Merchant </option>
              @foreach ($merchants as $mar)
              <option <?php if ($id==$mar->id) {
                 echo "selected";
              } ?> value="{{$mar->id}}">{{$mar->companyName}} ({{$mar->phoneNumber}})</option>
              @endforeach
              </select>
              </div>
              <!-- col end -->
              <div class="col-sm-2">
                <input type="date" class="flatDate form-control" placeholder="Date Form" name="startDate" value="">
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
        <div class="row">
              <table id="exampled" class="table  table-striped " width="100%">
                    
                      <thead>
                      <tr>
                      	<th><input type="checkbox"  id="My-Button"></th>
                       
                        <th>Id</th>
                        <th>Date</th>
                        <th>COD</th>
                        <th>C. Update</th>
                        <th>Subtotal</th>
                        <th>Paid Bills</th>
                        <th>Due Bills</th>
                        <th>C. Charge</th>
                        <th>D. Charge</th>
                        <th>Pay Status</th>
                        <th>Status</th>
                        
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                          
                          <td>{{$loop->iteration}}</td>
                          <td>{{$value->trackingCode}}</td>
                          <td> {{date('F d Y', strtotime($value->created_at))}} {{date('H:i:s:A', strtotime($value->created_at))}}</td>
                          <td>{{$value->cod}}</td>
                          <td>{{date('F d, Y', strtotime($value->updated_at))}}</td>
                          <td>{{$value->merchantAmount}}</td>
                          <td>{{$value->merchantPaid}}</td>
                          <td>{{$value->merchantDue}}</td>
                          <td>{{$value->codCharge}}</td>
                          <td>{{$value->deliveryCharge}}</td>
                         <td>@if($value->merchantpayStatus==NULL)Unpaid   @elseif($value->merchantpayStatus==0) Processing @else Paid @endif</td>
                          <td>@php $parceltype = App\Parceltype::find($value->status); @endphp @if($parceltype!=NULL) {{$parceltype->title}} @endif</td>
                          
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="tab-inner table-responsive">
            <table id="exampled" class="table  table-striped">
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
                   <th>Delivery Charge</th>
                   <th>Cod Charge</th>
                   <th>Collected Amount</th>
                   <th>Paid Amount</th>
                   <th>Unpaid Amount</th>
                 
                   
                 </tr>
                 </thead>
                <tbody>
               
                 <tr>
                    <td>
                       {{$parcelcount}}          
                    </td>
                    <td>
                        {{$parcelr}}@if($parcelr)({{round(($parcelr*100)/$parcelcount,2)}}%)
                        @endif
                    </td>
                    <td>{{$parcelpa}}@if($parcelpa)({{round(($parcelpa*100 )/$parcelcount,2)}}%)
                    @endif
                    </td>
                    <td>{{$parcelc}}@if($parcelc)({{round(($parcelc*100)/$parcelcount,2)}}%)
                    @endif</td>
                    <td>{{$parcelre}}@if($parcelre)({{round(($parcelre*100)/$parcelcount,2)}}%)@endif</td>
                    <td>{{$parcelpictd}}@if($parcelpictd)({{round(($parcelpictd*100)/$parcelcount,2)}}%)@endif</td>
                    <td>{{$parcelinterjit}}@if($parcelinterjit)({{round(($parcelinterjit*100)/$parcelcount,2)}}%)@endif</td>
                    <td>{{$parcelhold}}@if($parcelhold)({{round(($parcelhold*100)/$parcelcount,2)}}%)
                    @endif</td>
                    <td>{{$parcelrrtupa}}@if($parcelrrtupa)({{round(($parcelrrtupa*100)/$parcelcount,2)}}%)@endif</td>
                    <td>{{$parcelrrhub}}@if($parcelrrhub)({{round(($parcelrrhub*100)/$parcelcount,2)}}%)
                    @endif</td>
                    
                    <td>{{$parcelpriceCOD}}</td>
                    <td>{{$deliveryCharge}}</td>
                    <td>{{$codCharge}}</td>
                    <td>{{$Collectedamount}}</td>
                     <td>{{$paid}}</td>
                      <td>{{$unpaid}}</td>
                  
                   
                 </tr>
           
                </tbody>
               </table>
             </div>
        </div>
    </div>
    <!-- row end -->
</div>
@endsection