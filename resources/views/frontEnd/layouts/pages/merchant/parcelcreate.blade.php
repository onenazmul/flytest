@extends('frontEnd.layouts.pages.merchant.merchantmaster')
@section('title','Add Percel Next Day')
@section('content')	
<section class="section-padding">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="row addpercel-inner">
				    <div class="col-sm-12">
						<div class="bulk-upload">
							<a href="" data-toggle="modal" data-target="#exampleModal"> Bulk Upload</a>
						</div>
						<!-- Modal -->
						<div class="modal fade" id="exampleModal" tabindex="-1">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						          <thead>
						              <tr>
						                  <td>Excel File Column Instruction <a href="{{asset('public/frontEnd/images/example.xlsx')}}" download> (Template ) </a></td>
						              </tr>
						          </thead>
						          <table class="table table-bordered table-striped mt-1">
						              <tbody>
						                  <tr>
						                      <td>Customer Name</td>
						                      <td>Product Type</td>
						                      <td>Customer Phone</td>
						                      <td>Cash Collection Amount</td>
						                      <td>Customer Address</td>
						                      <td>Delivery Zone</td>
						                      <td>Weight</td>
						                      
						                  </tr>
						              </tbody>
						          </table>
						        <form action="{{url('merchant/parcel/import')}}" method="POST" enctype="multipart/form-data">
						        	@csrf
						        	<div class="form-group">
						        		<label for="file">Upload Excel</label>
						        		<input class="form-control" type="file" name="excel" accept=".xlsx, .xls">
						        	</div>
						        	<div class="form-group">
						        		<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button>
						        	</div>
						        </form>
						      </div>
						    </div>
						  </div>
						</div>
					</div>
						<div class="col-sm-12">
							<div class="addpercel-top">
								<h3>Add New Parcel ({{$ordertype->title}})</h3>
							</div>
						</div>
					
					    <div class="col-lg-7 col-md-7 col-sm-12">
						 <div class="fraud-search">
								<form action="{{url('merchant/add/parcel')}}" method="POST">
								@csrf
								@php
								 Session::put('deliverycharge',$ordertype->deliverycharge);
								 Session::put('ordertype',$ordertype->id);
								 Session::put('extradeliverycharge',$ordertype->extradeliverycharge);
								 Session::put('codcharge',$codcharge->codcharge);
								 Session::put('codtype',$codcharge->id);
								@endphp
									<div class="row">
										<div class="col-sm-6">
										   <div class="form-group">
											 <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" name="name" placeholder="Customer Name">
											 @if ($errors->has('name'))
					                            <span class="invalid-feedback">
					                              <strong>{{ $errors->first('name') }}</strong>
					                            </span>
					                          @endif
										    </div>
								       </div>
		                                
										<div class="col-sm-6">
											<select type="text"  class="form-control{{ $errors->has('percelType') ? ' is-invalid' : '' }}" value="{{ old('percelType') }}" name="percelType" placeholder="Invoice or Memo Number" required="required">
											    <option value="">Select...</option>
											    <option value="1">Regular</option>
											    <option value="2">Liquid</option>
											</select>    
											 @if ($errors->has('percelType'))
					                            <span class="invalid-feedback">
					                              <strong>{{ $errors->first('percelType') }}</strong>
					                            </span>
					                          @endif
										</div>
										 <div class="col-sm-6">
									          <div class="form-group">
												<input type="number" class="form-control{{ $errors->has('phonenumber') ? ' is-invalid' : '' }}" value="{{ old('phonenumber') }}" name="phonenumber" placeholder="Customer Phone Number">
												@if ($errors->has('phonenumber'))
						                            <span class="invalid-feedback">
						                              <strong>{{ $errors->first('phonenumber') }}</strong>
						                            </span>
						                          @endif
											</div>
										</div>

										<div class="col-sm-6">
										    <div class="form-group">
												<input type="number"  class="calculate cod form-control{{ $errors->has('cod') ? ' is-invalid' : '' }}" value="{{ old('cod') }}" name="cod" min="0" placeholder="Cash Collection Amount">
												@if ($errors->has('cod'))
						                            <span class="invalid-feedback">
						                              <strong>{{ $errors->first('cod') }}</strong>
						                            </span>
						                          @endif
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<textarea type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}" name="address"  placeholder="Customer Address"></textarea>
												@if ($errors->has('address'))
						                            <span class="invalid-feedback">
						                              <strong>{{ $errors->first('address') }}</strong>
						                            </span>
						                          @endif
											</div>
								        </div>
									    <div class="col-sm-6">
											<select type="text"  class="form-control select2 {{ $errors->has('reciveZone') ? ' is-invalid' : '' }}" value="{{ old('reciveZone') }}" name="reciveZone" placeholder="Delivery Area" required="required">
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
										<div class="col-sm-6">
								           <div class="form-group">
												<input type="number" class="calculate weight form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}" value="{{ old('weight') }}" name="weight" placeholder="Weight">
										    </div>
								       </div>

										<div class="col-sm-6">
								           <div class="form-group">
												<textarea type="text" name="note" value="{{old('note')}}" class="form-control" placeholder="Note"></textarea>
											</div>
									    </div>
										<div class="col-sm-8">
											<div class="form-group">
												<button type="submit" class="form-control">Submit</button>
											</div>
										</div>
								   </form>
							    </div>
							</div>
						</div>
					    <!-- col end -->
					    <div class="col-lg-1 col-md-1 col-sm-0"></div>
					    <div class="col-lg-4 col-md-4 col-sm-12">
						  <div class="parcel-details-instance">
							<h2>Delivery Charge Details</h2>
							<div class="content calculate_result">
								<div class="row">
									<div class="col-sm-8">
										<p>Cash Collection</p>
									</div>
									<div class="col-sm-4">
										<p>@if(Session::get('codpay')) {{Session::get('codpay')}} @else 0 @endif  Tk</p>
									</div>
								</div>
								<!-- row end -->
								<div class="row">
									<div class="col-sm-8">
										<p>Delivery Charge</p>
									</div>
									<div class="col-sm-4">
										<p>@if(Session::get('pdeliverycharge')) {{Session::get('pdeliverycharge')}} @else 0 @endif Tk</p>
									</div>
								</div>
								<!-- row end -->
								<div class="row">
									<div class="col-sm-8">
										<p>Cod Charge</p>
									</div>
									<div class="col-sm-4">
										<p>@if(Session::get('pcodecharge')) {{Session::get('pcodecharge')}} @else 0 @endif Tk</p>
									</div>
								</div>
								<!-- row end -->
								<div class="row total-bar">
									<div class="col-sm-8">
										<p>Total Payable Amount</p>
									</div>
									<div class="col-sm-4">
										<p>0 Tk</p>
									</div>
								</div>
								<!-- row end -->
								<div class="row">
									<div class="col-sm-12">
										<p class="text-center">Note : <span class="">If you pick up a request after 7pm ,It will be received the next day</span></p>
									</div>
								</div>
								<!-- row end -->
							</div>
						  </div>
					    </div>
					</div>
			</div>
		</div>
	</div>
</section>

@endsection