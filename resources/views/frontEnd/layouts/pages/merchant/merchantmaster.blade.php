<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Flingex | @yield('title','Move Everywhere')</title>
    <!-- Meta tag Keywords -->
     <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Startup Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta tag Keywords -->
    @foreach($whitelogo as $wlogo)
    <link rel="shortcut icon" type="image/jpg" href="{{asset($wlogo->image)}}"/>
    @endforeach
    <!-- Custom-Files -->
    <link rel="stylesheet" href="{{asset('public/frontEnd')}}/css/bootstrap4.min.css">
    <!-- Bootstrap-Core-CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- flaticon -->
    <link rel="stylesheet" href="{{asset('public/frontEnd')}}/css/merchant.css" type="text/css" media="all" />
    <link rel="stylesheet" href="{{asset('public/frontEnd')}}/css/swiper-menu.css" type="text/css" media="all" />
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/dist/css/toastr.min.css">
     <!-- datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css">
    <!-- Style-CSS -->
     <link href="{{asset('public/frontEnd')}}/css/fontawesome-all.min.css" rel="stylesheet">
    <!-- Font-Awesome-Icons-CSS -->
       <!-- select2 -->
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/select2/css/select2.min.css">
    <!-- //Custom-Files -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
</head>
<body>
    @php
        $merchantInfo = App\Merchant::find(Session::get('merchantId'));
    @endphp
     <section class="mobile-menu ">
        <div class="swipe-menu default-theme">
            <div class="postyourad">
                <a href="{{url('merchant/dashboard')}}">
                  @foreach($whitelogo as $key=>$value)
                    <img src="{{asset($value->image
                    )}}" alt="Your logo"/>
                    @endforeach
                </a>
                 <a  href="{{url('merchant/dashboard')}}" class="mobile-username">{{$merchantInfo->companyName}}</a>
            </div>
        <!--Navigation Icon-->
            <div class="nav-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="codehim-nav">
                 <div class="side-list">
                <ul>
                    <li>
                        <a href="{{url('/merchant/dashboard')}}">
                            <div class="list-icon"><i class="fa fa-home"></i></div>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/merchant/choose-service')}}">
                            <div class="list-icon"><i class="fa fa-gift"></i></div>
                            Create Parcel
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/parcel')}}">
                            <div class="list-icon"><i class="fa fa-car"></i></div>
                            All Parcel (<?php echo App\Parcel::where('merchantId',Session::get('merchantId'))->count(); ?>)
                        </a>
                    </li>
                           @foreach($parceltypes as $parceltype)
              @php
                  $parcelcount = App\Parcel::where('status',$parceltype->id)->where('merchantId',Session::get('merchantId'))->count();
                @endphp
              <li class="nav-item">
                <a href="{{url('merchant/parcels',$parceltype->slug)}}" class="nav-link">
                <div class="list-icon"><i class="fa fa-cogs"></i></div>
                    <p>{{$parceltype->title}} ({{$parcelcount}})</p>
                </a>
              </li>
              @endforeach
                     <li>
                        <a href="{{url('merchant/pickup/manage')}}">
                            <div class="list-icon"><i class="fa fa-truck"></i></div>
                            Pickup Manage
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/get/payments')}}">
                            <div class="list-icon"><i class="fa fa-credit-card"></i></div>
                            Invoice
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/report')}}">
                            <div class="list-icon"><i class="fa fa-box"></i></div>
                            Report
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/profile/settings')}}">
                            <div class="list-icon"><i class="fa fa-cogs"></i></div>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/support')}}">
                            <div class="list-icon"><i class="fa fa-envelope"></i></div>
                            Support
                        </a>
                    </li>
                </ul>
            </div>
            <!--//Tab-->
            </nav>
        </div>
    </section>
    <!-- mobile menu end -->
    <section class="main-area">
      <div class="dash-sidebar">
            <div class="sidebar-inner">
            <div class="profile-inner">
                <div class="profile-pic">
                    <a href="#"><img src="{{asset('public/frontEnd')}}/images/avator.png" alt=""></a>
                </div>
                <div class="profile-id">
                    @php
                        $merchantInfo = App\Merchant::find(Session::get('merchantId'));
                    @endphp
                    <p>{{$merchantInfo->companyName}}: {{$merchantInfo->id}}</p>
                </div>
                <div class="dashboard-button">
                    <a href="{{url('merchant/dashboard')}}">Dashboard</a>
                </div>
            </div>
            <div class="side-list">
                <ul>
                    <li>
                        <a href="{{url('/merchant/dashboard')}}">
                            <div class="list-icon"><i class="fa fa-home"></i></div>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/merchant/choose-service')}}">
                            <div class="list-icon"><i class="fa fa-gift"></i></div>
                            Create Parcel
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/parcel')}}">
                            <div class="list-icon"><i class="fa fa-car"></i></div>
                            All Parcel (<?php echo App\Parcel::where('merchantId',Session::get('merchantId'))->count(); ?>)
                        </a>
                    </li>
                           @foreach($parceltypes as $parceltype)
              @php
                  $parcelcount = App\Parcel::where('status',$parceltype->id)->where('merchantId',Session::get('merchantId'))->count();
                @endphp
              <li class="nav-item">
                <a href="{{url('merchant/parcels',$parceltype->slug)}}" class="nav-link">
                <div class="list-icon"><i class="fa fa-cogs"></i></div>
                    <p>{{$parceltype->title}} ({{$parcelcount}})</p>
                </a>
              </li>
              @endforeach
                     <li>
                        <a href="{{url('merchant/pickup/manage')}}">
                            <div class="list-icon"><i class="fa fa-truck"></i></div>
                            Pickup Manage
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/get/payments')}}">
                            <div class="list-icon"><i class="fa fa-credit-card"></i></div>
                            Invoice
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/report')}}">
                            <div class="list-icon"><i class="fa fa-box"></i></div>
                            Report
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/profile/settings')}}">
                            <div class="list-icon"><i class="fa fa-cogs"></i></div>
                            Settings
                        </a>
                    </li>
                    <li>
                        <a href="{{url('merchant/support')}}">
                            <div class="list-icon"><i class="fa fa-envelope"></i></div>
                            Support
                        </a>
                    </li>
                </ul>
            </div>
            </div>
        </div>
        <!-- Sidebar End -->
        <div class="dashboard-body">
            <div class="heading-bar">
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="pik-inner">
                            <ul>
                                <li>
                                    <div class="dash-logo">
                                        @foreach($whitelogo as $key=>$value)
                                        <a href="{{url('merchant/dashboard')}}"><img src="{{asset($value->image)}}" alt=""></a>
                                        @endforeach
                                    </div>
                                    
                                </li>
                                 <li>
                                    <div class="pik-icon">
                                        <a href="#"  data-toggle="modal" data-target="#pickupRequest"><i class="fa fa-truck"></i></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="heading-right">
                            <ul>
                            <!--    <li>-->
                            <!--        <div class="track-area">-->
                            <!--            <form action="{{url('/merchant/parcel/track')}}" method="POST">-->
                            <!--    @csrf-->
                            <!--    <input class="form-control" type="text" name="trackid" placeholder="Search your track number..." search>-->
                            <!--   <button>Submit</button>-->
                            <!--</form>-->
                            <!--        </div>-->
                                    
                            <!--    </li>-->
                                <li class="profile-area">
                                    <div class="profile">
                                        <a class="" ><img src="{{asset('public/frontEnd')}}/images/avator.png" alt="" >
                                                    
                                        </a>
                                            <ul>
                                                <li><a href="{{url('/merchant/profile')}}">Profile</a></li>
                                                <li><a href="{{url('merchant/profile/edit')}}">Setting</a></li>
                                                <li><a href="{{url('merchant/logout')}}">Logout</a></li>
                                            </ul>
                                        </div>

                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="main-body">
                <div class="col-sm-12">
                    @yield('content')
                </div>
            </div>
            <!-- Column End-->
        </div>
    </section>
<!-- pickup modal area start -->
    <div class="pickup-modal-area">
        <!-- Pickup Modal -->
        <div id="pickupRequest" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Select Pickup Request</h5>
                   <button  class="close" data-dismiss="modal">x</button>
                </div>
                <div class="modal-body">
                  <div class="row">
                      <div class="col-md-6 col-sm-12">
                          <div class="pickuptype nextday" data-toggle="modal" data-target="#pickNextday">
                              <div class="time">
                                  <p>24h</p>
                              </div>
                              <strong>Next Day</strong>
                              <span>Delivery</span>
                          </div>
                      </div>
                       <div class="col-md-6 col-sm-12">
                          <div class="pickuptype sameday" data-toggle="modal" data-target="#pickSameday">
                              <div class="time">
                                  <p>12h</p> 
                              </div>
                              <strong>Same Day</strong>
                              <span>Delivery</span>
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!--Pickup Modal end -->

        <!-- Pickup Next Day Modal -->
          <div id="pickNextday" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Next Day Pickup Request</h5>
                       <button  class="close" data-dismiss="modal">x</button>
                    </div>
                @php
                    $merchantInfo = App\Merchant::find(Session::get('merchantId'));
                    $pickupAddress = App\Nearestzone::where('id',$merchantInfo->nearestZone)->first();
                @endphp
                 <form action="{{url('merchant/pickup/request')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                      <div class="row">
                          <div class="col-md-12 col-sm-12">
                              <div class="pickup-content">
                                <input type="hidden" value="1" name="pickuptype">
                                  <div class="form-group">
                                    <label for=""><strong>Pickup Address</strong></label>
                                    <input type="text" name="pickupAddress" value="@if($pickupAddress) {{$pickupAddress->zonename}} @endif " class="form-control" required="required">
                                  </div>
                              </div>
                              <div class="form-group">
                                <label for="reciveZone">Select Area</label>
                                <select type="text"  class="form-control{{ $errors->has('reciveZone') ? ' is-invalid' : '' }}" value="{{ old('reciveZone') }}" name="reciveZone" placeholder="Delivery Area" required="required">
                                  <option value="">Delivery Area...</option>
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
                              <div class="form-group">
                                  <label for="note">Note(Optional)</label>
                                  <input type="text" class="form-control" name="note">
                              </div>

                              <div class="form-group">
                                  <label for="note">Estimated Parcel(Optional)</label>
                                  <input type="text" class="form-control" name="estimedparcel">
                              </div>
                          </div>
                    </div>
                    </div>
                    <!-- modal body -->
                    <div class="modal-footer">
                      <div class="col-sm-12">
                          <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <input type="checkbox" name="regulerpickup" value="1" checked="checked"> Reguler Pickup 
                                  </div>
                              </div>

                              <div class="col-sm-6 text-right">
                                  <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Send Request</button>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </form>
                  </div>
                </div>
            </div>
            <!--Next Day Pick Modal end -->

        <!-- Pickup Same Day Modal -->             
         <div id="pickSameday" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Same Day Pickup Request</h5>
                   <button  class="close" data-dismiss="modal">x</button>
                </div>
            @php
                $merchantInfo = App\Merchant::find(Session::get('merchantId'));
                $pickupAddress = App\Nearestzone::where('id',$merchantInfo->nearestZone)->first();
            @endphp
             <form action="{{url('merchant/pickup/request')}}" method="POST">
                @csrf
                <div class="modal-body">
                  <div class="row">
                      <div class="col-md-12 col-sm-12">
                          <div class="pickup-content">
                            <input type="hidden" value="2" name="pickuptype">
                              <div class="form-group">
                                <label for=""><strong>Pickup Address</strong></label>
                                <input type="text" name="pickupAddress" value="@if($pickupAddress) {{$pickupAddress->zonename}} @endif" class="form-control" required="required">
                              </div>
                          </div>
                           <div class="form-group">
                            <label for="reciveZone">Select Area</label>
                            <select type="text"  class="form-control{{ $errors->has('reciveZone') ? ' is-invalid' : '' }}" value="{{ old('reciveZone') }}" name="reciveZone" placeholder="Delivery Area" required="required">
                              <option value="">Delivery Area...</option>
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
                          <div class="form-group">
                              <label for="note">Note(Optional)</label>
                              <input type="text" class="form-control" name="note">
                          </div>

                          <div class="form-group">
                              <label for="note">Estimated Parcel(Optional)</label>
                              <input type="text" class="form-control" name="estimedparcel">
                          </div>                    
                  </div>
                <!-- modal body -->
                <div class="modal-footer">
                  <div class="col-sm-12">
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group">
                                  <input type="checkbox" name="regulerpickup" value="1" checked="checked"> Reguler Pickup 
                              </div>
                          </div>

                          <div class="col-sm-6 text-right">
                              <div class="form-group">
                                <button type="submit" class="btn btn-primary">Send Request</button>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
            </form>
              </div>
            </div>
        </div>
        <!--Next Day Pick Modal end -->
  <script src="{{asset('public/backEnd/')}}/plugins/jquery/jquery.min.js"></script>
  <script src="{{asset('public/frontEnd/')}}/js/bootstrap4.min.js" ></script>

  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="{{asset('public/frontEnd/')}}/js/swiper-menu.js" ></script>
  <script src="{{asset('public/backEnd/')}}/dist/js/toastr.min.js"></script>
  {!! Toastr::message() !!}
  <!-- Datatable -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="{{asset('public/backEnd/')}}/plugins/datatables/jquery.dataTables.js"></script>
  <script src="{{asset('public/backEnd/')}}/plugins/datatables/dataTables.bootstrap4.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js "></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js "></script>
  <script src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <!-- select2 -->
  <script src="{{asset('public/backEnd/')}}/plugins/select2/js/select2.full.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2').select2();
  $('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
          {
              extend: 'copy',
              text: 'Copy',
              exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
              }
          },
          {
              extend: 'excel',
              text: 'Excel',
              exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
              }
          },
          {
              extend: 'csv',
              text: 'Csv',
              exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
              }
          },
          {
              extend: 'pdfHtml5',
              exportOptions: {
                 columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
              }
          },
          
          {
              extend: 'print',
              text: 'Print',
              exportOptions: {
                  columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ]
              }
          },
          {
              extend: 'print',
              text: 'Print all',
              exportOptions: {
                  modifier: {
                      selected: null
                  }
              }
          },
          {
              extend: 'colvis',
          },
          
      ],
      select: true
  } );
  
   table.buttons().container()
      .appendTo( '#example_wrapper .col-md-6:eq(11)' );
});
</script>
  <script>
        function calculate_result(){
         $.ajax({
           type:"GET",
           url:"{{url('cost/calculate/result')}}",
                 dataType: "html",
                 success: function(deliverycharge){
                   $('.calculate_result').html(deliverycharge)
                 }
              });
          }
        $('.calculate').on('keyup paste click',function(){
            var cod = $('.cod').val();
            var weight = $('.weight').val();
             if(cod,weight){
                  $.ajax({
                   cache: false,
                   type:"GET",
                   url:"{{url('cost/calculate')}}/"+cod+'/'+weight,
                   dataType: "json",
                   success: function(deliverycharge){
                       return calculate_result();
                }
              });
            }
        });
    </script>
    <script>
      flatpickr(".flatDate", {});
    </script>

</body>

</html>