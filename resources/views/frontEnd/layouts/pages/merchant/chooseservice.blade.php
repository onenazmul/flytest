@extends('frontEnd.layouts.pages.merchant.merchantmaster')
@section('title','Choose Service')
@section('content')
	<section class="section-padding">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">
					<div class="choose-service-top">
						<h3>Choose Service Type</h3>
					</div>
					
				</div>
				<div class="col-sm-12">
					<div class="choose-inner">
						<div class="row">
							@foreach($pricing as $key=>$value)
							<div class="col-sm-4">
								<div class="choose-widget {{$value->slug}}">
									<a href="{{url('merchant/new-order/'.$value->slug)}}">
										<div class="hours">
											<span>{{$value->time}}</span>
											<h4>{{$value->title}}</h4>
											<p>Delivery</p>
										</div>
									</a>
								</div>
							</div>
						 @endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection