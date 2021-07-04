@extends('backEnd.layouts.master')
@section('title','Update Parcel')
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
            <li class="breadcrumb-item active">Update</li>
          </ol>
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
                <h5>Update Parcel</h5>
              </div>
              <div class="quick-button">
                <a href="{{url('editor/parcel/create')}}" class="btn btn-primary btn-actions btn-create">
                Create
                </a>
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
                      <h3 class="card-title">Update Parcel</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{url('editor/parcel/update')}}" method="POST" enctype="multipart/form-data" name="editForm">
                      @csrf
                      <input type="hidden" value="{{$edit_data->id}}" name="hidden_id">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="daytype">Order Type</label>
                            <select class="form-control select2{{ $errors->has('daytype') ? ' is-invalid' : '' }}" value="{{ old('daytype') }}" name="daytype">
                                <option value="">Select....</option>
                                @foreach($delivery as $deliveryopton)
                                <option value="{{$deliveryopton->id}}">{{$deliveryopton->title}}</option>
                                @endforeach
                            </select>
                              
                               @if ($errors->has('daytype'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('daytype') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        
						<div class="form-group">
							<div class="row">
								 <label for="">Percel Type</label>
								<select type="text"  class="form-control{{ $errors->has('percelType') ? ' is-invalid' : '' }}" value="{{ old('percelType') }}" name="percelType" placeholder="Invoice or Memo Number" required="required">
								    <option value="">Select...</option>
								    <option value="1">Reguler</option>
								    <option value="2">Liquite</option>
								</select>    
								 @if ($errors->has('percelType'))
		                            <span class="invalid-feedback">
		                              <strong>{{ $errors->first('percelType') }}</strong>
		                            </span>
		                          @endif
							</div>
						</div>
                        <div class="form-group">
                          <label for="merchantId">Merchant</label>
                            <select class="form-control select2{{ $errors->has('merchantId') ? ' is-invalid' : '' }}" value="{{ old('merchantId') }}" name="merchantId">
                                <option value="">Select...</option>
                                
                                @foreach($merchants as $value)
                                <option value="{{$value->id}}">{{$value->lastName}} ({{$value->phoneNumber}})</option>
                                @endforeach
                            </select>
                              
                               @if ($errors->has('merchantId'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('merchantId') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <!-- form group -->
                        <div class="form-group">
                          <label for="cod">COD Amount</label>
                              <input type="text" class="form-control {{ $errors->has('cod') ? ' is-invalid' : '' }}" value="{{$edit_data->cod}}" name="cod" id="cod" placeholder="Cash amount including delivery charge">
                               @if ($errors->has('cod'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('cod') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <label for="name">Name</label>
                              <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{$edit_data->recipientName}}" name="name" id="name" placeholder="Recipient Name">
                               @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <label for="weight">Weight</label>
                              <input type="text" class="form-control {{ $errors->has('weight') ? ' is-invalid' : '' }}" value="{{$edit_data->productWeight}}" name="weight" id="weight" placeholder="Product Weight">
                               @if ($errors->has('weight'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('weight') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <label for="address">Address (maximum 500 characters)</label>
                            <textarea type="text" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}"  name="address" placeholder="Recipient Aderess">{{$edit_data->recipientAddress}}</textarea>
                            
                             
                               @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <label for="phonenumber">Phone Number</label>
                              <input type="text" class="form-control {{ $errors->has('phonenumber') ? ' is-invalid' : '' }}" value="{{$edit_data->recipientPhone}}" name="phonenumber" id="phonenumber" placeholder="Phone Number">
                               @if ($errors->has('phonenumber'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('phonenumber') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <label for="note">Note (maximum 300 characters)</label>
                              <textarea type="text" class="form-control {{ $errors->has('note') ? ' is-invalid' : '' }}" value="{{ old('note') }}" name="note" placeholder="Note Optional">{{$edit_data->note}}</textarea>
                               @if ($errors->has('note'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('note') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
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
    <script type="text/javascript">
    
      document.forms['editForm'].elements['percelType'].value="{{$edit_data->percelType}}"
      document.forms['editForm'].elements['daytype'].value="{{$edit_data->orderType}}"
      document.forms['editForm'].elements['merchantId'].value="{{$edit_data->merchantId}}"
      
    </script>
@endsection
