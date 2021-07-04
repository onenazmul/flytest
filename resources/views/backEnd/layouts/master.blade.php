<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Flingex || @yield('title','Dashbaord')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
   <link rel="icon" type="image/png" sizes="96x96" href="{{asset('public/frontEnd/')}}/images/icon/apple-icon-57x57.png">
    <!-- fabeicon css -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/summernote/summernote-bs4.css">
  <!-- select2 -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/select2/css/select2.min.css">
  <!-- select2 -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/owlcarousel/owl.carousel.css">
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/plugins/owlcarousel/owl.theme.default.min.css">
  <!-- owl.theme.default.min -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <!-- flatpickr -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/dist/css/toastr.min.css">
  <!-- datatable -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css">
    <!-- custom css -->
  <link rel="stylesheet" href="{{asset('public/backEnd/')}}/dist/css/custom.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="https://cdn.jsdelivr.net/npm/excellentexport@3.6.0/dist/excellentexport.min.js"></script>
  @yield('extracss')
</head>
<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse" onload="startTime()">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li>
    <a href="{{url('/superadmin/dashboard')}}" class="nav-link">Flingex    </a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/')}}"  class="nav-link"><i class="far fa-clock"></i> <?php echo date("D") ?> <?php echo date("d M Y"); ?> <span id="time" class="time"></span></a>
      </li>
      <!-- nav item end -->
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/')}}" target="_blank"  class="nav-link"><i class="fa fa-globe"></i> Visit Website</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/clear-cache')}}" target=""  class="nav-link"><i class="fa fa-box"></i> Clear-cache</a>
      </li>
      <!-- nav item end -->

    </ul>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item has-treeview">
           <a class="nav-link anchor" title="Screen Lock">
           <i class="fas fa-lock"></i> 
          </a>
       </li>
       <!-- nav item end -->
        <li class="nav-item has-treeview">
           <a  id="goFS" class="nav-link anchor" title="Full Screen">
           <i class="fas fa-expand"></i> 
          </a>
       </li>
       <!-- nav item end -->
        <li class="nav-item has-treeview">
          <a href="{{url('password/change')}}" class="nav-link" title="Change Password">
           <i class="fas fa-key"></i>
          </a>
        </li>
        <!-- nav item end -->
        <li class="nav-item has-treeview">
            <a href="{{ route('logout') }}" title="Logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
             <i class="fas fa-sign-out-alt"></i>
             <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
             </form>
            </a>
       </li>
       <!-- nav item end -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('/superadmin/dashboard')}}" class="brand-link">
      <span class="brand-text font-weight-light">Flingex</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="user-image">
          <img src="{{asset(auth::user()->image)}}" class="img-circle" alt="User Image">
        </div>
        <div class="user-info">
          <a href="#" class="d-block">{{auth::user()->name}}</a>
          <i class="fas fa-circle"></i>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column modify-sidebar" data-widget="treeview" role="menu" data-accordion="false">
          
          
         
          <!-- nav item end -->
          <!-- nav item end -->

          
          @if(Auth::user()->role_id <= 3 )
                     <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-gift"></i>
              <p>
               Parcel Manage
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">  
              <li class="nav-item">
                <a href="{{url('/editor/parcel/create')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Parcel Create</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{url('/editor/parcel/all-parcel')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>All Parcel (<?php echo App\Parcel::get()->count();  ?> )</p>
                </a>
              </li>
              
              @foreach($parceltypes as $parceltype)
              @php
                  $parcelcount = App\Parcel::where('status',$parceltype->id)->count();
                @endphp
              <li class="nav-item">
                <a href="{{url('editor/parcel',$parceltype->slug)}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>{{$parceltype->title}} ({{$parcelcount}})</p>
                </a>
              </li>
              @endforeach
            </ul>
          </li>
          
             @if(Auth::user()->role_id <= 2  )
             
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-briefcase"></i>
              <p>
                Report
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
              <li class="nav-item">
                <a href="{{url('/admin/hub/report')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Hub Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/asing/report')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Hub Asign Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/parcel/parcelreport')}}" class="nav-link">
                  <i class="fas fa-cicle-o"></i>
                    <p> Parcel Report</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{url('/editor/parcel/report')}}" class="nav-link">
                  <i class="fas fa-cicle-o"></i>
                    <p> Merchant Report</p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-briefcase"></i>
              <p>
                Hub
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{url('/admin/agent/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Hub</p>
                </a>
              </li>
            
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-briefcase"></i>
              <p>
                Merchant
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/editor/merchant-request/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Merchant Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/merchant/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Manage</p>
                </a>
              </li>
             
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-users"></i>
              <p>
              Manage Deliveryman
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/deliveryman/add')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Add Deliveryman</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/deliveryman/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Manage Deliveryman</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- nav item end -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-map-marker"></i>
              <p>
               Nearest Zone
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/nearestzone/add')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/nearestzone/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Manage</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- nav item end -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fab fa-angellist"></i>
              <p>
               Delivery Charge
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/deliverycharge/add')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/deliverycharge/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Manage</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- nav item end -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-award"></i>
              <p>
               Cod Charge
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/codcharge/add')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/codcharge/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Manage</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- nav item end -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-chart-pie"></i>
              <p>
               HR
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/department/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Department</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/employee/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Employee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/agent/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Agent</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/deliveryman/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Delivery Man</p>
                </a>
              </li>
            </ul>
          </li>
           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-bookmark"></i>
              <p>
                  Website
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/editor/logo/manage')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Logo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/banner/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Banner</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/about/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>About</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/service/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Service</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/price/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Pricing</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/feature/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Feature</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/clientfeedback/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Client Feedback</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/career/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Career</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/gallery/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Gallery</p>v
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/notice/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Notice</p>
                </a>
              </li>
            </ul>
          </li>
             <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-truck"></i>
              <p>
               Pickup Request
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{url('/editor/new/pickdrop')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Pick & Drop </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/new/pickup')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>New Pickup ({{$newpickup->count()}})</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/pending/pickup')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Pending Pickup ({{$pendingpickup->count()}})</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/accepted/pickup')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Accepted Pickup ({{$acceptedpickup->count()}})</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/editor/cancelled/pickup')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Cancelled Pickup ({{$cancelledpickup->count()}})</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- nav item end -->
 @endif

          @endif
          
        @if(Auth::user()->role_id == 1 )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-user-tie"></i>
              <p>
                Panel User
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/superadmin/user/add')}}" class="nav-link">
                <i class="fas fa-cicle-o"></i>
                    <p>Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/superadmin/user/manage')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Manage</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- nav item end -->
          @endif
           @if(Auth::user()->role_id ==4  )
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
            <i class="fas fa-briefcase"></i>
              <p>
                Report
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
              <li class="nav-item">
                <a href="{{url('/author/hub/report')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Hub Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/author/asign/report')}}" class="nav-link">
                 <i class="fas fa-cicle-o"></i>
                    <p>Hub Asign Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/author/parcel/report')}}" class="nav-link">
                  <i class="fas fa-cicle-o"></i>
                    <p> Parcel Report</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{url('/author/marchent/report')}}" class="nav-link">
                  <i class="fas fa-cicle-o"></i>
                    <p> Merchant Report</p>
                </a>
              </li>
            </ul>
          </li>
           @endif
       
          <!-- nav item end -->
          <!-- nav item end -->
          
          <!-- nav item end -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('content')
  </div>
  <div class="search-product-inner" id="live_data_show"></div> 

  <footer class="main-footer">
    <strong>Copyright &copy;<a href="{{url('/')}}">Flingex</a></strong>
    All rights reserved.
  </footer>

<!-- jQuery -->
<script src="{{asset('public/backEnd/')}}/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/backEnd/')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/table2csv@1.1.4/src/table2csv.min.js"></script>
<script src="{{asset('public/backEnd/')}}/plugins/bootstrap/js/popper.min.js" ></script>
<script src="{{asset('public/backEnd/')}}/plugins/bootstrap/js/bootstrap.min.js" ></script>
<script src="{{asset('public/backEnd/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('public/backEnd/')}}/dist/js/adminlte.js"></script>
<!-- Summernote -->
<script src="//cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>


 <script>
 
  // Replace the <textarea id="editor1"> with a CKEditor 4
  // instance, using default configuration.
  CKEDITOR.replace( 'editor1' );
</script>
<!-- overlayScrollbars -->
<script src="{{asset('public/backEnd/')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- FastClick -->
<script src="{{asset('public/backEnd/')}}/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('public/backEnd/')}}/plugins/owlcarousel/owl.carousel.min.js"></script>
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
<!-- flatpicker -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
$("#export").click(function(){

  $("table").tableToCSV();

});
</script>
<script>

    $(function () {
          $('.select2').select2();
     flatpickr("#flatpicker", {
      minDate:"today",
     });
    })
</script>
<script>
  flatpickr(".flatDate",{});
</script>
<script src="{{asset('public/backEnd/')}}/plugins/select2/js/select2.full.min.js"></script>
<!-- Select2 -->
<script src="{{asset('public/backEnd/')}}/plugins/chart.js/Chart.min.js"></script>
<script src="{{asset('public/backEnd/')}}/plugins/sparklines/sparkline.js"></script>
<script src="{{asset('public/backEnd/')}}/dist/js/toastr.min.js"></script>
{!! Toastr::message() !!}
<script src="{{asset('public/backEnd/')}}/dist/js/demo.js"></script>
<!-- ChartJS -->
<script type="text/javascript">
$('#sampleTable').DataTable({order:[]});

</script>
<script>
  $(function () {
   
    //Initialize Select2 Elements
  
    $('#example1').DataTable({
         "paging": true
      
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
       rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
      
    });

  })
</script>
<script type="text/javascript">
    $("#search_data").on('keyup', function(){
       var keyword = $(this).val();
       $.ajax({
        type: "GET",
        url: "{{url('/')}}/search_data/" +keyword,
        data: { keyword: keyword },
        success: function (data) {
          console.log(data);
          $("#live_data_show").html('');
          $("#live_data_show").html(data);
        }
       });
    });
</script>
<script>
  function percelDelivery(that) {
    if (that.value == "4") {
            document.getElementsByClassName("customerpaid").style.display = "block";
        } else {
            document.getElementsByClassName("customerpaid").style.display = "none";
        }
    }
</script>
<script>
    function myPrintFunction() {
        window.print();
    }
  </script>
    <script>
        jQuery("#My-Button").click(function() {
        jQuery(':checkbox').each(function() {
          if(this.checked == true) {
            this.checked = false;                        
          } else {
            this.checked = true;                        
          }      
        });
      });
    </script>
    <script>
       $(document).ready(function() {
          $('#example').DataTable( {
              dom: 'Bfrtip',
              buttons: [
                  {
                      extend: 'copy',
                      text: 'Copy',
                      exportOptions: {
                           columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ,12 ]
                      }
                  },
                  {
                      extend: 'excel',
                      text: 'Excel',
                      exportOptions: {
                           columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ,12 ]
                      }
                  },
                  {
                      extend: 'csv',
                      text: 'Csv',
                      exportOptions: {
                           columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ,12 ]
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      exportOptions: {
                           columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ,12 ]
                      }
                  },
                  
                  {
                      extend: 'print',
                      text: 'Print',
                      exportOptions: {
                           columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11 ,12 ]
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
              .appendTo( '#example_wrapper .col-md-6:eq(0)' );
      });
</script>
<script>
    
    $(document).ready(function() {
    $('#exampled').DataTable( {
       
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</script>
<!-- page script -->
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Digital Goods',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Electronics',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [65, 59, 80, 81, 56, 55, 40]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = jQuery.extend(true, {}, areaChartOptions)
    var lineChartData = jQuery.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, { 
      type: 'line',
      data: lineChartData, 
      options: lineChartOptions
    })

    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          'Chrome', 
          'IE',
          'FireFox', 
          'Safari', 
          'Opera', 
          'Navigator', 
      ],
      datasets: [
        {
          data: [700,500,400,600,300,100],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = jQuery.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = jQuery.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    var stackedBarChart = new Chart(stackedBarChartCanvas, {
      type: 'bar', 
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
</body>
</html>
