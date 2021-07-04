@extends('backEnd.layouts.master')
@section('title','Super Admin Dashboard')
@section('content')
 <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard v1</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
<!-- Main content -->
  <section class="content">
    <div class="container-fluid">
     <div class="box-content">
      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card custom-card dashboard-body">
                  <div class="col-sm-12">
                    <div class="manage-button">
                      <div class="body-title">
                        <h5>Parcel Overall Status</h5>
                      </div>
                    </div>
                  </div>
                <div class="card-body">
                    <div class="row">
                      @foreach($parceltypes as $key=>$value)
                      @php
                        $parcelcount = App\Parcel::where('status',$value->id)->count();
                      @endphp
                       <div class="col-md-4 col-sm-6 col-12">
                          <div class="info-box box-bg-{{$key}}">
                            <span class="info-box-icon"><i class="far fa-star"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">{{$value->title}}</span>
                              <span class="info-box-number">{{$parcelcount}}</span>
                            </div>
                            <!-- /.info-box-content -->
                          </div>
                          <!-- /.info-box -->
                        </div>
                        <!-- col end -->
                        @endforeach
                    </div>
                </div>
              </div>
          </div>
          <!-- main col end -->
           <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card custom-card dashboard-body">
                  <div class="col-sm-12">
                    <div class="manage-button">
                      <div class="body-title">
                        <h5>Payment Overall Status</h5>
                      </div>
                    </div>
                  </div>
                <div class="card-body">
                    <div class="row">
                      <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box box-bg-1">
                          <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Total Amount</span>
                            <span class="info-box-number">{{$totalamounts}}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- col end -->
                      <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box box-bg-2">
                          <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Merchant Due Amount  </span>
                            <span class="info-box-number">{{$merchantsdue}}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- col end -->
                      <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box box-bg-3">
                          <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Merchant Paid Amount  </span>
                            <span class="info-box-number">{{$merchantspaid}}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- col end -->
                      <div class="col-md-4 col-sm-6 col-12">
                        <div class="info-box box-bg-7">
                          <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">Today Monthly Payment</span>
                            <span class="info-box-number">{{$todaymerchantspaid}}</span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                      </div>
                      <!-- col end -->
                    </div>
                </div>
              </div>
          </div>
          <!-- main col end -->
           <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="card custom-card dashboard-body">
                  <div class="col-sm-12">
                    <div class="manage-button">
                      <div class="body-title">
                        <h5>Overall Status</h5>
                      </div>
                    </div>
                  </div>
              </div>
          </div>
          <!-- main col end -->
       </div>
       <div class="row">
        <div class="col-sm-12">
         <div class="card">
           <div class="card-header">
             <h3>Parcel Statistics</h3>
           </div>
           <div class="card-body">
             <canvas id="myChart"></canvas>
           </div>
         </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
   var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'pie',

    // The data for our dataset
    data: {
        labels: [@foreach($parceltypes as $parceltype)'{{$parceltype->title}}',@endforeach],
        datasets: [{
            label: 'Parcel Statistics',
            backgroundColor:['#1D2941','#5F45DA','#670A91','#096709','#FFAC0E','#AAB809','#2094A0','#9A8309','#C21010'],
            borderColor:['#1D2941','#5F45DA','#670A91','#096709','#FFAC0E','#AAB809','#2094A0','#9A8309','#C21010'],
             data: [@foreach($parceltypes as $parceltype)
             @php
             $parcelcount = App\Parcel::where('status',$parceltype->id)->count();
             @endphp {{$parcelcount}}, @endforeach]
        }]
    },

    // Configuration options go here
    options: {}
});
 </script>
@endsection