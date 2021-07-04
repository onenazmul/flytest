<div class="row">
	<div class="col-sm-8">
		<p>Cach Collection</p>
	</div>
	<div class="col-sm-4">
		<p>{{Session::get('codpay')}} Tk</p>
	</div>
	</div>
	<!-- row end -->
	<div class="row">
	<div class="col-sm-8">
		<p>Delivery Charge</p>
	</div>
	<div class="col-sm-4">
		<p>{{Session::get('pdeliverycharge')}} Tk</p>
	</div>
	</div>
	<!-- row end -->
	<div class="row">
	<div class="col-sm-8">
		<p>Code Charge</p>
	</div>
	<div class="col-sm-4">
		<p>{{Session::get('pcodecharge')}} Tk</p>
	</div>
	</div>
	<!-- row end -->
	<div class="row total-bar">
	<div class="col-sm-8">
		<p>Total Payable Amount</p>
	</div>
	<div class="col-sm-4">
		<p>{{Session::get('codpay') - (Session::get('pdeliverycharge')+Session::get('pcodecharge'))}} Tk</p>
	</div>
	</div>
	<!-- row end -->
	<div class="row">
	<div class="col-sm-12">
		<p class="text-center">Note : <span class="">If you pick up a request after 7pm ,It will be received the next day</span></p>
	</div>
	</div>
	<!-- row end -->