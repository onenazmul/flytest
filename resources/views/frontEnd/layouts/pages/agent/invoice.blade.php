@extends('frontEnd.layouts.pages.agent.agentmaster')
@section('title','Parcel Invoice')
@section('content')
  <!-- Main content -->
  <html>
<head>
    <meta charset="utf-8">
    <title>A simple, clean, and responsive HTML invoice template</title>
    
    <style>
    .modal-content {
    	margin: 20px 0;
    }
      @page { size: auto;  margin: 0mm; }
      @media print {
        header,
        footer,.heading-bar,.dash-sidebar,.modal-header {
            display: none !important;
        }
      }
      .modal-body.printSection {
    	width: 435px;
    	border: 1px solid #222;
    	margin: 35px auto;
    }
    .invoice-box {
        max-width: 400px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    .table.table-bordered.parcel-invoice td {
      padding: 5px 20px;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    p{
        margin:0;
    }
    </style>
</head>

<body>
<!-- Modal content-->
    <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title">Parcel Invoice</h5>
    <h5 class="modal-title text-right">Invoice- {{$show_data->invoiceNo}}</h5>
    </div>
    <div class="modal-body printSection" >
    <button onclick="myFunction2()" style="color: #fff;border: 0;padding: 6px 12px;margin-bottom: 8px;background: green"><i class="fa fa-print"></i></button>
    <div class="bar-code" style="width:50px;float: right">
    <?php echo DNS2D::getBarcodeHTML('{{url("/track/parcel")}}/'.$show_data->trackingCode, 'QRCODE',2,2); ?>
    </div>
    <div id="printableArea">
       <div class="invoice-logo">
           @foreach($whitelogo as $key=>$logo)
           <img src="{{asset($logo->image)}}">
           @endforeach
       </div>
       <div class="invoice-date">
           <strong>{{date('M-d-Y', strtotime($show_data->created_at))}}</strong>
       </div>
       <div class="marchent-info">
           <p><strong>Merchant :</strong> {{$show_data->companyName}} </p>
           <h4>{{$show_data->phoneNumber}}</h4>
       </div>
       <div class="customer-info">
           <p><strong>Customer :</strong> {{$show_data->recipientName}}</p>
           <h4>{{$show_data->recipientPhone}}</h4>
       </div>
       <div class="shipping-info">
           <p><strong>Address : </strong>{{$show_data->recipientAddress}}</p>
       </div>
       <div class="shipping-info">
           <p><strong>Tracking ID : </strong>{{$show_data->trackingCode}}</p>
       </div>
       <div class="instruction-info">
           <strong>Instruction</strong>
           <div class="codingo">
               <ul>
                   <li><strong>COD</strong></li>
                   <li><strong>TK {{$show_data->cod}}</strong></li>
                </ul>
           </div>
       </div>
       <div class="deliveryprocess action_buttons ">
           <ul>
               <li>
               <div class="form-group">
                   <input type="checkbox">
                   <label>DELIVERY</label>
                </div>
              </li>
               <li>
               <div class="form-group">
                   <input type="checkbox">
                   <label>CANCELLED</label>
                </div>
              </li>
               <li>
               <div class="form-group">
                   <input type="checkbox">
                   <label>HOLD</label>
                </div>
              </li>
           </ul>
       </div>
       <div class="merchant-note">
           <p>Note: 104/1 polpar , Mohommadpur Dhaka</p>
           <p> Phone: 01977593593 Email:  Info@flingex.com</p>
       </div>
    </div>
    <script>
      function myFunction2() {
          window.print();
      }
    </script>
    </div>
    </div>
</body>
</html>
<!-- Modal Section  -->
@endsection