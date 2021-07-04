@extends('frontEnd.layouts.pages.merchant.merchantmaster')
@section('title','Payments')
@section('content')
<div class="profile-edit mrt-30">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="row">
                    <div class="col-sm-12">
                      <h4 style="margin-bottom: 10px;">Payments</h4>
                    </div>
                     <div class="col-sm-12">
                         <div class="payments-inner table-responsive-sm">
                           <table class="table  table-striped">
                             <tr>
                               <th>SL</th>
                               <th>Date</th>
                               <th>Total Invoice</th>
                               <th>Total Payment</th>
                               <th>More</th>
                             </tr>
                             @foreach($merchantInvoice as $key=>$value)
                              @php
                                $totalpayment = App\Parcel::where('paymentInvoice',$value->id)->sum('merchantPaid');
                                $totalinvoice = App\Parcel::where('paymentInvoice',$value->id)->count();
                             @endphp
                            <tr>
                             <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$value->created_at}}</td>
                              <td>{{$totalinvoice}}</td>
                              <td>{{$totalpayment}}</td>
                              <td> <a class="btn btn-primary" href="{{url('merchant/payment/invoice-details/'.$value->id)}}" title="View"><i class="fa fa-eye"></i> View</a></td>
                             </tr>
                             @endforeach
                           </table>
                         </div>
                      </div>
                  </div>
        </div>
    </div>
    <!-- row end -->
</div>


@endsection