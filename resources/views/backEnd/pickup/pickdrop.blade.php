@extends('backEnd.layouts.master')
@section('title',' Pick & Drop')
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
                                    <h5>Pick & Drop </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped custom-table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Estimated Parcel </th>
                                        <th> Phone</th>
                                        <th>Pickup Address</th>
                                        <th>Time</th>
                                        <th>Note</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($show_data as $key=>$value)
                                    <tr>
                                        <td>{{$value->id}}</td>
                          
                                        <td>{{$value->estimate}}</td>
                                        <td>{{$value->phone}}</td>
                                        <td>{{$value->address}}</td>
                                        <td>{{date("g:i a", strtotime($value->created_at))}},
                                            {{date('d M Y', strtotime($value->created_at))}}</td>
                                        <td>{{$value->note}}</td>
                                        
                                        
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