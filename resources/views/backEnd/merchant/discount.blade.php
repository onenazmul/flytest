@extends('backEnd.layouts.master')
@section('title','Manage Merchant')
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
                                    <h5>{{$merchants->firstName}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                        <div class="row " id="examp">
                                            <div class="col-md-6" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Discount</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                        <form action="{{url('editor/merchant/discount')}}"
                                                            method="post">
                                                            @csrf
                                                            <label for="">Delivery Type</label>
                                                            <select name="delivery_id" id="" class="form-control">
                                                                @foreach($delivery as $deli)
                                                                <option value="{{$deli->id}}">{{$deli->title}}</option>
                                                                @endforeach
                                                            </select>
                                                            
                                                            <label for="">Discount </label>
                                                            <input type="hidden" name="maID" value="{{$merchants->id}}">
                                                            <input type="text" name="discount" id=""
                                                                class="form-control">

                                                    </div>

                                                    <div class="modal-footer">
                                                        
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                    </form>
                                                
                                                </div>
                                              
                                            </div>

                                            <div class="col-md-6" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Discount Type</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">

                                                    <table class="table">
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Discount Type</th>
                                                            <th>Discount</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        <?php  $discount=App\Discount::where('maID', $merchants->id)->get();?>
                                                        @foreach($discount as $dis)
                                                        <tr>
                                                            <td>{{$dis->id}}</td>
                                                            <td>{{$dis->dliveryTypeName}}</td>
                                                            <td>{{$dis->discount}}</td>
                                                            <td><a onclick="return confirm('Are you sure you want to delete this Discount !!')" href="{{url('editor/merchant/discount/delete/'.$dis->id)}}" class="btn btn-sm btn-danger">Delete</a></td>
                                                        </tr>
                                                        @endforeach
                                                    </table>

                                                    </div>

                                                
                                                </div>
                                              
                                            </div>
                                        </div>
                                      
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

<!-- Modal -->

@endsection