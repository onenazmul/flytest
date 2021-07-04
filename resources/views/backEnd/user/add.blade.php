@extends('backEnd.layouts.master')
@section('title','Create User')
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
                      <h5>Create User</h5>
                    </div>
                    <div class="quick-button">
                      <a href="{{url('superadmin/user/manage')}}" class="btn btn-primary btn-actions btn-create">
                      Manage User
                      </a>
                    </div>  
                  </div>
                </div>
              <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h3 class="card-title">Add a new user</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                   <form action="{{url('superadmin/user/save')}}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="main-body">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="name">Name</label>
                          <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">
                           @if ($errors->has('name'))
                            <span class="invalid-feedback">
                              <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                       
                      </div>
                      <!-- column end -->

                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="username">Username</label>
                          <input type="text" name="username" id="username" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" value="{{ old('username') }}">
                          @if ($errors->has('username'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('username') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="email">Email</label>
                          <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}">
                          @if ($errors->has('email'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="phone">Phone</label>
                          <input type="text" name="phone" id="phone" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" value="{{ old('phone') }}">
                          @if ($errors->has('phone'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('phone') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="designation">Designation</label>
                          <input type="text" name="designation" id="designation" class="form-control {{ $errors->has('designation') ? ' is-invalid' : '' }}" value="{{ old('designation') }}">
                          @if ($errors->has('designation'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('designation') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" >
                          @if ($errors->has('password'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="password">Confirm Password</label>
                          <input type="password" name="password" id="password" class="form-control">
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="role_id">Roll</label>
                          <select name="role_id" id="role_id" class="form-control {{ $errors->has('role_id') ? ' is-invalid' : '' }}" value="{{ old('role_id') }}">
                            <option value="">==Select Role==</option>
                            @foreach($user_role as $value)
                            <option value="{{$value->id}}">{{$value->user_role}}</option>
                            @endforeach
                          </select>
                          @if ($errors->has('role_id'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('role_id') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->
                      <div class="col-sm-6">
                        <div class="form-group">
                          <label for="image">Image</label>
                          <input type="file" name="image" id="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}" value="{{ old('image') }}">
                          @if ($errors->has('image'))
                              <span class="invalid-feedback">
                                <strong>{{ $errors->first('image') }}</strong>
                              </span>
                            @endif
                        </div>
                      </div>
                      <!-- column end -->

                      <div class="col-sm-6">
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
                      </div>
                      <div class="col-sm-12">
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
@endsection