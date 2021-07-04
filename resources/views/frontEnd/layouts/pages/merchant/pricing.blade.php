@extends('frontEnd.layouts.pages.merchant.merchantmaster')
@section('title','Pricing Next Day')
@section('content')

<section class="section-padding">
	<div class="container">
	<div class="pricing-area">
		<div class="row">
			<div class="col-sm-12">
				<div class="pricing-top">
					<h2>Pricing ({{$ordertype->title}})</h2>
					<p>{{$ordertype->subtitle}}</p>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="pricing-table">
					<table class="table table-bordered">
						<tr class="table-top">
							<th >Service Type</th>
							<th>Delivery Time *</th>
							<th>Up to 1kg **</th>
							<th>1kg+</th>
						</tr>

						<tr>
							<td>Same City</td>
							<td>24 Hours</td>
							<td>60 Tk</td>
							<td>20 Tk/kg</td>
						</tr>
						<tr>
							<td>Inter City</td>
							<td>48 Hours</td>
							<td><del>130</del> 100Tk</td>
							<td>30 Tk/kg</td>
						</tr>
						<tr>
							<td>3rd party Courie</td>
							<td>48 Hours</td>
							<td colspan="2">Booking Charge 30 Tk</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="pricing-bottom">
					<p>Dhaka Sub-Urban Area: Tongi, Savar, Keraniganj , Gazipur City, Narayanganj City- 100 Tk (Upto 1 KG). 30 Tk will be added for extra per KG.
					* Unavoidable circumstances may change in time of delivery. <br>
					** <strong>1% Cash Handling & Risk Management Charge</strong> will be added.</p>

					<div class="pricing-btn">
						<a href="{{url('merchant/new-order/next-day')}}">New Order</a>
					</div>
				</div>
			</div>

		</div>
		</div>
	</div>
</section>

@endsection