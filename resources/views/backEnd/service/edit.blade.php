@extends('backEnd.layouts.master')
@section('title','Update Service Info')
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
            <li class="breadcrumb-item active"><a href="#">Service</a></li>
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
                <h5>Update Service Info</h5>
              </div>
              <div class="quick-button">
                <a href="{{url('editor/service/manage')}}" class="btn btn-primary btn-actions btn-create">
                Manage
                </a>
                <a href="{{url('editor/service/create')}}" class="btn btn-primary btn-actions btn-create">
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
                      <h3 class="card-title">Service Info Update</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{url('editor/service/update')}}" method="POST" enctype="multipart/form-data" name="editForm">
                      @csrf
                      <input type="hidden" value="{{$edit_data->id}}" name="hidden_id">
                      <div class="card-body">
                        <div class="form-group">
                          <label for="icon">Icon</label>
                              <input type="text" class="form-control {{ $errors->has('icon') ? ' is-invalid' : '' }}" value="{{$edit_data->icon }}" name="icon" id="icon">
                               @if ($errors->has('icon'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('icon') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <label for="title">Title</label>
                              <input type="text" class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{$edit_data->title }}" name="title" id="title">
                               @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <label for="text">Description</label>
                          <textarea type="text" class="summernote form-control {{ $errors->has('text') ? ' is-invalid' : '' }}"  name="text">{{ $edit_data->text}}</textarea>
                           @if ($errors->has('text'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('text') }}</strong>
                            </span>
                            @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <label for="image">Image</label>
                              <input type="file" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" value="{{ old('image') }}" accept="image/png*" name="image" id="image">
                            <img src="{{asset($edit_data->image)}}" class="backend_image" alt="">
                               @if ($errors->has('image'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                        </div>
                        <!-- form group -->
                        <div class="form-group">
                          <div class="custom-label">
                            <label>Publication Status</label>
                          </div>
                          <div class="box-body pub-stat display-inline">
                              <input class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }}" type="radio" id="active" name="status" value="1">
                              <label for="active">Active</label>
                              @if ($errors->has('status'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('status') }}</strong>
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
                        <!-- /.form-group -->
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
      document.forms['editForm'].elements['status'].value="{{$edit_data->status}}"
    </script>
@endsection
