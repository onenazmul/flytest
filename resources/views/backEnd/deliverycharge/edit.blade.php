@extends('backEnd.layouts.master')
@section('title','Delivery Charge Edit')
@section('content')
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="box-content">
            <div class="row">
              <div class="col-sm-12">
                  <div class="manage-button">
                    <div class="body-title">
                      <h5>Delivery Charge Edit</h5>
                    </div>
                    <div class="quick-button">
                      <a href="{{url('admin/deliverycharge/manage')}}" class="btn btn-primary btn-actions btn-create">
                      Manage
                      </a>
                    </div>  
                  </div>
                </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Delivery Charge Edit</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                   <form action="{{url('admin/deliverycharge/update')}}" method="POST" enctype="multipart/form-data" name="editForm">
                  @csrf
                  <div class="main-body">
                    <div class="row">
                       <input type="hidden" value="{{$edit_data->id}}" name="hidden_id">
                        <div class="col-sm-6">
                        <div class="form-group">
                          <label for="title">Title</label>
                          <input type="text" name="title" id="title" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ $edit_data->title}}">
                           @if ($errors->has('title'))
                            <span class="invalid-feedback">
                              <strong>{{ $errors->first('title')}}</strong>
                            </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="subtitle">Sub Title</label>
                          <input type="text" name="subtitle" id="subtitle" class="form-control {{ $errors->has('subtitle') ? ' is-invalid' : '' }}" value="{{ $edit_data->subtitle}}">
                           @if ($errors->has('subtitle'))
                            <span class="invalid-feedback">
                              <strong>{{ $errors->first('subtitle')}}</strong>
                            </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="time">Time</label>
                          <input type="text" name="time" id="time" class="form-control {{ $errors->has('time') ? ' is-invalid' : '' }}" value="{{ $edit_data->time}}">
                           @if ($errors->has('time'))
                            <span class="invalid-feedback">
                              <strong>{{ $errors->first('time')}}</strong>
                            </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="deliverycharge">Delivery Charge</label>
                          <input type="text" name="deliverycharge" id="deliverycharge" class="form-control {{ $errors->has('deliverycharge') ? ' is-invalid' : '' }}" value="{{ $edit_data->deliverycharge}}">
                           @if ($errors->has('deliverycharge'))
                            <span class="invalid-feedback">
                              <strong>{{ $errors->first('deliverycharge')}}</strong>
                            </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="extradeliverycharge">Extra Delivery Charge</label>
                          <input type="text" name="extradeliverycharge" id="extradeliverycharge" class="form-control {{ $errors->has('extradeliverycharge') ? ' is-invalid' : '' }}" value="{{ $edit_data->extradeliverycharge}}">
                           @if ($errors->has('extradeliverycharge'))
                            <span class="invalid-feedback">
                              <strong>{{ $errors->first('extradeliverycharge')}}</strong>
                            </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="description">Description</label>
                          <textarea type="text" name="description" id="description" class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" >{{$edit_data->description}}</textarea>
                           @if ($errors->has('description'))
                            <span class="invalid-feedback">
                              <strong>{{ $errors->first('description')}}</strong>
                            </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->


                      <div class="col-sm-12">
                        <div class="form-group">
                          <div class="custom-label">
                            <label>Publication Status</label>
                          </div>
                          <div class="box-body pub-stat display-inline">
                              <input class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" type="radio" id="active" name="status" value="1">
                              <label for="active">Active</label>
                              @if ($errors->has('status'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('status')}}</strong>
                              </span>
                              @endif
                          </div>
                          <div class="box-body pub-stat display-inline">
                              <input class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" type="radio" name="status" value="0" id="inactive">
                              <label for="inactive">Inactive</label>
                              @if ($errors->has('status'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('status') }}</strong>
                              </span>
                              @endif
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-12 mrt-15">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                </div>
              </div>
              <!-- col end -->

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script type="text/javascript">
      document.forms['editForm'].elements['status'].value="{{$edit_data->status}}"
    </script>
@endsection