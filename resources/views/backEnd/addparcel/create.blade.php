@extends('backEnd.layouts.master')
@section('title','Create Parcel')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h5 class="m-0 text-dark">Welcome !! {{auth::user()->name}}</h5>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="#">Parcel</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">
    <div class="bulk-upload">
        <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal"> Bulk Upload</a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <thead>
                        <tr>
                            <td>Excel File Column Instruction <a href="{{asset('public/frontEnd/images/example.xlsx')}}"
                                    download> (Template ) </a></td>
                        </tr>
                    </thead>
                    <table class="table table-bordered table-striped mt-1">
                        <tbody>
                            <tr>
                                <td>Customer Name</td>
                                <td>Product Type</td>
                                <td>Customer Phone</td>
                                <td>Cash Collection Amount</td>
                                <td>Customer Address</td>
                                <td>Hub ID</td>
                                <td>Weight</td>
                                <td>merchantId</td>
                                <td>Order Type</td>

                            </tr>
                        </tbody>
                    </table>
                    <form action="{{url('editor/parcel/import')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Excel</label>
                            <input class="form-control" type="file" name="excel" accept=".xlsx, .xls">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="manage-button">
                    <div class="body-title">
                        <h5>Create Parcel</h5>
                    </div>
                    <div class="quick-button">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="box-content">
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add Parcel Info</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" action="{{url('editor/parcel/store')}}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label for="daytype">Order Type </label>
                                            <select class="form-control select2{{ $errors->has('daytype') ? ' is-invalid' : '' }}"
                                                value="{{ old('daytype') }}" name="daytype"  required>
                                                <option value="">Select...</option>
                                                @foreach($delivery as $deliveryopton)
                                                <option value="{{$deliveryopton->id}}">{{$deliveryopton->title}}
                                                </option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('daytype'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('daytype') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <div class="row">
                                                <label for="">Percel Type</label>
                                                <select type="text" class="form-control{{ $errors->has('percelType') ? ' is-invalid' : '' }}"
                                                    value="{{ old('percelType') }}" name="percelType"
                                                    placeholder="Invoice or Memo Number" required>
                                                    <option value="">Select...</option>
                                                    <option value="1">Reguler</option>
                                                    <option value="2">Liquid</option>
                                                </select>
                                                @if ($errors->has('percelType'))
                                                <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('percelType') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- form group -->
                                        <div class="form-group">
                                            <label for="merchantId">Merchant</label>
                                            <select
                                                class="form-control select2{{ $errors->has('merchantId') ? ' is-invalid' : '' }}"
                                                value="{{ old('merchantId') }}" name="merchantId" required >
                                                <option value="">--selsect merchant--</option>

                                                @foreach($merchants as $value)
                                                <option value="{{$value->id}}">{{$value->companyName}}
                                                    ({{$value->phoneNumber}})</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('merchantId'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('merchantId') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                                <label for="merchantId"> Area</label>
											<select type="text"  class="form-control select2 {{ $errors->has('reciveZone') ? ' is-invalid' : '' }}" value="{{ old('reciveZone') }}" name="reciveZone" placeholder="Delivery Area" required>
											    <option value=""> Area...</option>
											    @foreach($areas as $area)
											    <option value="{{$area->id}}">{{$area->zonename}}</option>
											    @endforeach
											</select>    
											 @if ($errors->has('reciveZone'))
					                            <span class="invalid-feedback">
					                              <strong>{{ $errors->first('reciveZone') }}</strong>
					                            </span>
					                          @endif
										</div>
                                        <!-- form group -->
                                        <div class="form-group">
                                            <label for="cod">COD Amount</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('cod') ? ' is-invalid' : '' }}"
                                                value="{{ old('cod') }}" name="cod" id="cod"
                                                placeholder="Cash amount including delivery charge" required >
                                            @if ($errors->has('cod'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('cod') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- form group -->
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                value="{{ old('name') }}" name="name" id="name"
                                                placeholder="Recipient Name" required>
                                            @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- form group -->
                                        <div class="form-group">
                                            <label for="weight">Weight</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('weight') ? ' is-invalid' : '' }}"
                                                value="{{ old('weight') }}" name="weight" id="weight"
                                                placeholder="Product Weight" required>
                                            @if ($errors->has('weight'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('weight') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- form group -->
                                        <div class="form-group">
                                            <label for="address">Address (maximum 500 characters)</label>
                                            <textarea type="text"
                                                class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                value="{{ old('address') }}" name="address"
                                                placeholder="Recipient Aderess" required></textarea>


                                            @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- form group -->
                                        <div class="form-group">
                                            <label for="phonenumber">Phone Number</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('phonenumber') ? ' is-invalid' : '' }}"
                                                value="{{ old('phonenumber') }}" name="phonenumber" id="phonenumber"
                                                placeholder="Phone Number" required="required">
                                            @if ($errors->has('phonenumber'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phonenumber') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label for="invoiceNo">Invoice Number</label>
                                            <input type="text"
                                                class="form-control {{ $errors->has('invoiceNo') ? ' is-invalid' : '' }}"
                                                value="{{ old('invoiceNo') }}" name="invoiceNo" id="invoiceNo"
                                                placeholder="Invoice Number" required="required">
                                            @if ($errors->has('invoiceNo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('invoiceNo') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- form group -->
                                        <div class="form-group">
                                            <label for="note">Note (maximum 300 characters)</label>
                                            <textarea type="text"
                                                class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}"
                                                value="{{ old('note') }}" name="note"
                                                placeholder="Note Optional"></textarea>
                                            @if ($errors->has('note'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('note') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-2"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection