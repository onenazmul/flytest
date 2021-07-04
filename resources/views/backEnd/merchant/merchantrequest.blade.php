@extends('backEnd.layouts.master')
@section('title','Manage Merchant Reqeust')
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
                          <h5>Manage Merchant Reqeust</h5>
                        </div>
                      </div>
                    </div>
                  <div class="card-body">
                    <table id="example" class="table table-bordered table-striped custom-table">
                      <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($merchants as $key=>$value)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$value->firstName}} {{$value->lastName}}</td>
                          <td>{{$value->companyName}}</td>
                          <td>{{$value->phoneNumber}}</td>
                          <td>{{$value->emailAddress}}</td>
                          <td>{{$value->status==1? "Active":"Inactive"}}</td>
                          <td>
                            <ul class="action_buttons dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action Button
                                <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                <li>
                                    <form action="{{url('editor/merchant/active')}}" method="POST">
                                      @csrf
                                      <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                      <button type="submit" class="thumbs_up" title="published"><i class="fa fa-thumbs-up"></i> Active</button>
                                    </form>
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