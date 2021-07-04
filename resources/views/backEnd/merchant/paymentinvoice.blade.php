@extends('backEnd.layouts.master')
@section('title','Manage Merchant Payment')
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
                        <div class="body-title">
                          <h5>Manage Merchant Payment</h5>
                        </div>
                      </div>
                    </div>
                  <div class="card-body">
                    <table id="example" class="table table-bordered table-striped custom-table">
                      <thead>
                      <tr>
                        <th>Id</th>
                        <th>Date</th>
                        <th>Total Invoice</th>
                        <th>Total Payment</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($merchantInvoice as $key=>$value)
                         @php
                            $totalpayment = App\Parcel::where('paymentInvoice',$value->id)->sum('merchantPaid');
                            $totalinvoice = App\Parcel::where('paymentInvoice',$value->id)->count();
                         @endphp
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$value->created_at}}</td>
                          <td>{{$totalinvoice}}</td>
                          <td>{{$totalpayment}}</td>
                          <td>
                            <ul class="action_buttons dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action Button
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                  <li>
                                      <a class="edit_icon" href="{{url('editor/merchant/payment/invoice-details/'.$value->id)}}" title="View"><i class="fa fa-eye"></i> View</a>
                                  </li>
                              </ul>
                          </td>
                        </tr>
                        @endforeach
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
          </div>
        </div>
    </div>
  </section>
<!-- Modal Section  -->
@endsection