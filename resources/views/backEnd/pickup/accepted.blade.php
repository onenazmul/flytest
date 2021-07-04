@extends('backEnd.layouts.master')
@section('title','Accepted Pickup')
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
                                    <h5>Accepted Pickup</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th>Id</th>

                                        <th> Phone</th>
                                        <th>Pickup Address</th>
                                        <th>Time</th>
                                        <th>Note</th>
                                        <th>Estimated Parcel</th>
                                        <th>Asign</th>
                                        <th>D.charge</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($show_data as $key=>$value)
                                    <tr>
                                        <td>{{$value->id}}</td>
                                        @php
                                        $deliveryman = App\Deliveryman::where('id',$value->deliveryId)->first();
                                        @endphp

                                        <td>{{$value->phone}}</td>
                                        <td>{{$value->address}}</td>
                                        <td>{{date("g:i a", strtotime($value->created_at))}},
                                            {{date('d M Y', strtotime($value->created_at))}}</td>
                                        <td>{{$value->note}}</td>
                                        <td>{{$value->estimate}}</td>
                                        
                                        <td> @if(@$deliveryman->name) {{@$deliveryman->name}} @else<button
                                                class="btn btn-primary" data-toggle="modal"
                                                data-target="#asignModal{{$value->id}}">Asign Deliveryman</button>
                                            @endif</td>
                                            <td>{{$value->price}}</td>
                                        <td><span class="btn btn-sm btn-danger">{{$value->status}}</span> </td>
                                        <!-- Modal -->
                                        <div id="asignModal{{$value->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Deliveryman Asign</h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{url('editor/pickup/agent/asign')}}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" name="hidden_id"
                                                                value="{{$value->id}}">
                                                            <input type="hidden" name="merchant_phone" value="">
                                                            <div class="form-group">
                                                                <select name="deliverid" class="form-control" id="">
                                                                    @foreach($delivery as $key=>$agent)
                                                                    <option value="{{$agent->id}}">{{$agent->name}}
                                                                    </option>
                                                                    @endforeach
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
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal end -->
                                        <td>
                                            <ul class="action_buttons">
                                                <li>
                                                    <button class="thumbs_up" title="Action" data-toggle="modal"
                                                        data-target="#sUpdateModal{{$value->id}}"><i
                                                            class="fa fa-sync-alt"></i></button>
                                                    <!-- Modal -->
                                                    <div id="sUpdateModal{{$value->id}}" class="modal fade"
                                                        role="dialog">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">PICK & DROP Status Update
                                                                    </h5>
                                                                </div>
                                                                <div class="modal-body">
                                                                    @if($value->status=='New')
                                                                    <form
                                                                        action="{{url('editor/pickup/status-update')}}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="hidden_id"
                                                                            value="{{$value->id}}">
                                                                        <input type="hidden" value="{{$value->status}}">
                                                                        <div class="form-group">
                                                                            <select name="status" class="form-control"
                                                                                id="" dissable="dissable">
                                                                                <option value="Pending" @if($value->
                                                                                    status=='Pending')
                                                                                    selected="selected" @endif>Pending
                                                                                </option>
                                                                                <option value="Accepted" @if($value->
                                                                                    status=='Accepted')
                                                                                    selected="selected" @endif>Accepted
                                                                                </option>
                                                                                <option value="Cancelled" @if($value->
                                                                                    status=='Cancelled')
                                                                                    selected="selected" @endif>Cancelled
                                                                                </option>
                                                                                <option value="Delivered" @if($value->
                                                                                    status=='Delivered')
                                                                                    selected="selected" @endif>Delivered
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                        <!-- form group end -->
                                                                        <div class="form-group">
                                                                            <button
                                                                                class="btn btn-success">Update</button>
                                                                        </div>
                                                                        <!-- form group end -->
                                                                    </form>
                                                                    @else
                                                                    <h4>Please asign a agent first</h4>
                                                                    @endif
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
                                                <li>


                                                    <!-- Modal end -->
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