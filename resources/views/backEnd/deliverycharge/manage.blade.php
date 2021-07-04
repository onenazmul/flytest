@extends('backEnd.layouts.master')
@section('title','Manage Delivery Charge')
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
                          <h5>Manage Delivery Charge</h5>
                        </div>
                        <div class="quick-button">
                          <a href="{{url('admin/deliverycharge/add')}}" class="btn btn-primary btn-actions btn-create">
                          <i class="fa fa-plus"></i> Add
                          </a>
                        </div>
                      </div>
                    </div>
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped custom-table">
                      <thead>
                      <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Sub-Title</th>
                        <th>D. Charge</th>
                        <th>E.D Charge</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$value->title}}</td>
                          <td>{{$value->subtitle}}</td>
                          <td>{{$value->deliverycharge}}</td>
                          <td>{{$value->extradeliverycharge}}</td>
                          <td>{{$value->status==1? "Active":"Inactive"}}</td>
                          <td>
                            <ul class="action_buttons">
                                <li>
                                  @if($value->status==1)
                                  <form action="{{url('admin/deliverycharge/inactive')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                    <button type="submit" class="thumbs_up" title="unpublished"><i class="fa fa-thumbs-up"></i></button>
                                  </form>
                                  @else
                                    <form action="{{url('admin/deliverycharge/active')}}" method="POST">
                                      @csrf
                                      <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                      <button type="submit" class="thumbs_down" title="published"><i class="fa fa-thumbs-down"></i></button>
                                    </form>
                                  @endif
                                </li>
                                <li>
                                    <a class="edit_icon" href="{{url('admin/deliverycharge/edit/'.$value->id)}}" title="Edit"><i class="fa fa-edit"></i></a>
                                </li>
                                <li>
                                  <form action="{{url('admin/deliverycharge/delete')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                    <button type="submit" onclick="return confirm('Are you delete this this?')" class="trash_icon" title="Delete"><i class="fa fa-trash"></i></button>
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