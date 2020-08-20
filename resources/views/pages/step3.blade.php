@extends('layout.default')

@section('pagespecificstyles')

<link href="{{asset('css/radio-button.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
@stop

@section('content')


<section  id="step1" >
 <div class="container">
 <form method="POST" action="{{ action('BookingController@reviewBookingDetails') }}" id="step3Form">   

	<div class="row">
	
	<div class="step1">
	    <div class="col-md-4 col-sm-4 col-xs-4 mr-pd">
			
			<span class="yellow-active" ><i class="fa fa-check-circle" aria-hidden="true"></i></span>
			<div class="hr"></div>
			<h5>Holiday Extras</h5>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4 mr-pd st-centr">
			<span class="yellow-active" ><i class="fa fa-check-circle" aria-hidden="true"></i></span>
			<div class="hr-middle"></div>
			<h5>Passenger Details</h5>
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4 mr-pd st-rgt">
			<span class="yellow-active" ><i class="fa fa-check-circle" aria-hidden="true"></i></span>
			<div class="hr-right"></div>
			<h5>Payment Details</h5>
		</div>
	</div>
	<div class="clearfix"></div>
	<div class="step navbar-collapse collapse sidebar-navbar-collapse">
                         
                                <div class="collapse-group">
                                   <div class="step panel panel-default">
                                        <div class="step panel-heading" role="tab" id="headingNine">
                                            <div class="panel-title"> <a role="button" data-toggle="collapse" href="#collapseNine" aria-expanded="true" aria-controls="collapseNine" class="trigger "> Booking Summary</a></div>
                                        </div>
                                        <div id="collapseNine" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingNine">
                                            <div class="step panel-body"> 
												@php 
													
												$dateDiff = \Carbon\Carbon::parse(Session::get('date'))->diffInDays( Carbon\Carbon::now() );

												$date        =   Session::get('date');

												$nofonights = Session::get('night');  

												$enddate	= \Carbon\Carbon::parse( Session::get('date'))->addDay(Session::get('night'));

												$total_guests = Session::get('adult') + Session::get('children');    

												foreach($property_details as $k => $v)
												{
													$parr[] = $v->propertycode;

												}       

												$price = App\Http\Controllers\PropertyController::getPrice($date,$nofonights,$parr);
												//$rate = (int)$propertyprices[$property_details->propertycode]['price']['rate'];

												$rate = (int)$price;

												$priceperperson = $rate/$total_guests;
													
												$totalprice = $rate;

												$deposit = $totalprice*30/100;

												$remaningpay = $totalprice - $deposit;

												$remainbalpaydate = \Carbon\Carbon::parse( Session::get('date') )->subDays(70)->format('j M Y');
													
												@endphp
											    <div class="col-md-6  " id="booking">
												  <h4>Accommodation</h4>
												  <p><strong>
												  	@if(Session::get('vp_name'))
														{{ Session::get('vp_name') }}
													@else
														{{$property_details[0]->propertyname}}
													@endif
												  </strong><br>{{$property_details[0]->propertyaddress}}</p>
                                                  <div class="clearfix"></div><br>
												    
												    <div class="col-md-6 mr-pd col-xs-6">
													@if ($dateDiff >=80 )
														<p>Deposit Payble today </p>
														<p>Remaining balance is payable by {{ $remainbalpaydate }}</p>
													@endif
														<p>Price per person</p>								
													</div>

													<div class="col-md-4 col-xs-6  holiday">
													@if ($dateDiff >=80 )
														<h6>€{{ number_format($deposit,0)}}</h6>
														<h6>€{{ number_format($remaningpay,0)}}</h6>
													@endif
														<h6>€{{ number_format($priceperperson,0)}}</h6>									
													</div>

												</div>
												
												 <div class="col-md-6  " id="booking">
												  <h4>Passenger Summary</h4>
												  @foreach($order_details->orderPassangers as $passengers)
												  	<p>{{ $passengers->title }} {{ $passengers->firstname }} {{ $passengers->surname }}</p>	
												  @endforeach	
												  
												  @if($order_details->orderPassangers[0]->is_lead == 1)
													<h4>Billing Address</h4>
												  	<p>{{ $order_details->orderPassangers[0]->house_name }}</p>
													<p>{{ $order_details->orderPassangers[0]->address1 }}</p>
													<p>{{ $order_details->orderPassangers[0]->address2 }}</p>
													<p>{{ $order_details->orderPassangers[0]->city }}</p>
													<p>{{ $order_details->orderPassangers[0]->country }}</p>
													<p>{{ $order_details->orderPassangers[0]->post_code_add }}</p>
													<br>
													<p>{{ $order_details->orderPassangers[0]->email }}</p>
													<p>{{ $order_details->orderPassangers[0]->telephone_no }}</p>
													<br>
													<p>{{ $order_details->orderPassangers[0]->comment }}</p>
													@endif  
												</div>
												<div class="clearfix"></div><br>

												<div class="dotted-bdr">
													
                                                   <div class="col-md-6 " id="booking"><br>												  
												  <p><strong>check-in:</strong> {!! \Carbon\Carbon::parse($date )->format('j M Y') !!} {{$property_details[0]->checkin}}</p>	
												  <p><strong>check-out:</strong> {!! \Carbon\Carbon::parse($enddate)->format('j M Y') !!} {{$property_details[0]->checkout}}</p><br>
												  
												  <p><strong>Passengers:</strong> @if($order_details->adults) {{ $order_details->adults }} Adult @endif
                      @if($order_details->children) {{ $order_details->children }} Children @endif</p>
												  <p><strong>Duration:</strong> {{ \Carbon\Carbon::parse( $order_details->startdate )->diffInDays( $order_details->enddate ) }} nights</p>
												  <p><strong>From:</strong> {!! \Carbon\Carbon::parse($order_details->startdate)->format('j M Y') !!} <strong>To:</strong> {!! \Carbon\Carbon::parse($order_details->enddate)->format('j M Y') !!}</p>

												</div>

												 <div class="col-md-6 " id="booking"><br>												  
												 <!--<img src="{{asset('images/booking-summary.png')}}" alt="" class="img-responsive">-->
												 {!! $property_details[0]->propertyImages[0]->main !!}
												</div>

												</div>

												<div class="clearfix"></div><br>
												<div class="dotted-bdr">
													
                                                   <!--<div class="col-md-6  " id="booking"><br>
	                                                   <h4>Travel Insurance</h4>											  
													   <div class="col-md-6 mr-pd col-xs-6">
															<p>Standard single trip induviduals insurance</p>
													    </div>

														<div class="col-md-4 col-xs-6 holiday">
															<h6>€ 35.34 pp</h6>				
														</div>
												   </div> -->
												   @if($order_details->transfer == '1')
												   <div class="col-md-6  " id="booking"><br>
														  <h4>Transfers</h4>												  
														  <div class="col-md-8 mr-pd col-xs-6 ">
																<p>{{$order_details->number_of_taxi}} Returns transfer {{ $total_guests = Session::get('adult') + Session::get('children')}} person</p>
														  </div>
														  <div class="col-md-4 col-xs-6  holiday">
																<h6>€{{ number_format($order_details->taxi_price*$order_details->number_of_taxi,0)}}</h6>
														  </div>
												   </div>
												   <div class="clearfix"></div><br>
												   <div class="dotted-bdr">
												   @endif
													
                                                   <div class="col-md-6  " id="booking"><br>
	                                                   <h2>Total Price</h2>
												   </div>

												   <div class="col-md-6   text-right" id="booking"><br>
														  <h2>€{{ number_format($order_details->total_price,0)}}</h2>
												   </div>

												</div>

												</div>

											
											</div>

                                        </div>
                                    </div>
									
                                    <div class="step panel panel-default">
                                        <div class=" step panel-heading" role="tab" id="headingEigt">
                                            <div class="panel-title"> <a role="button" data-toggle="collapse" href="#collapseEigt" aria-expanded="true" aria-controls="collapseEigt" class="trigger "> Important Information</a></div>
                                        </div>
                                        <div id="collapseEigt" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingEigt">
                                            <div class="step panel-body">
												<div class="col-sm-12  mr-pd">
													<h5>Essential Information </h5>
													<h5>Booking Condition</h5><br>													
												</div>
												
												 <div class="col-sm-12 dotted-bdr mr-pd  "><br>
												  <p>We reccomend you purchase trave insurance to ensure you are adequately covered for your holiday.</p>
												  <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" value="1" name="tc" id="tc" required="required" checked="checked" /> <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span> I have read and accept all of the above Terms and Conditions</label>
                                                </div>
												</div>
												
											</div>
                                        </div>
                                    </div>
									 <div class="step panel panel-default">
                                        <div class=" step panel-heading" role="tab" id="headingOne">
                                            <div class="panel-title"> <a role="button" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="trigger "> Pay online</a></div>
                                        </div>
                                        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                            <div class="step panel-body">
												<div class="col-sm-12 text-right">
													<img src="{{asset('images/visa.png')}}" alt="" class="">	
													<img src="{{asset('images/master.png')}}" alt="" class="">													
												</div>
												<br><div class="clearfix"></div>
											
												<div class="col-md-12">
													<ul class="donate-now">
													@if ($dateDiff >=80 )
														@if(isset($order_details) && $order_details->transfer == '1')
													  	<li>
													    <input type="radio" id="deposit" name="amount" value="{{ $deposit+$order_details->taxi_price*$order_details->number_of_taxi }}" />
													    <label for="deposit"><h3>Book holiday today for just</h3>
                                                    	<h5>Deposit amount</h5>
														<h4 >€{{ number_format($deposit+$order_details->taxi_price*$order_details->number_of_taxi,0)}}</h4>
														</label>
														</li>
														@else
														<li>
													    <input type="radio" id="deposit" name="amount" value="{{ $deposit }}" />
													    <label for="deposit"><h3>Book holiday today for just</h3>
                                                    	<h5>Deposit amount</h5>
														<h4 >€{{ number_format($deposit,0)}}</h4>
														</label>
														</li>	
														@endif
													  
													@endif
													  <li>
													    <input type="radio" id="fullpay" name="amount" value="{{ $totalprice }}" checked="checked" />
													    <label for="fullpay"><h2>Full amount</h2><h1>€{{ number_format($order_details->total_price,0)}}</h1></label>
													  </li>
												
													</ul>
												</div>
												
												
											</div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>	
	                 <div class="col-sm-5 col-xs-6 mr-pd">
						 <a href="javascript:void(0)" class="pre-bok" onclick="history.back();"> Previous</a>
		             </div>
		            <div class="col-sm-2">
						 
		             </div>
		             <div class="col-sm-5 col-xs-6 mr-pd">
					 		<input name="propertycode" type="hidden" value="{{ $order_details->propertycode }}"/>
							<input name="orders_id" type="hidden" value="{{ $order_details->id }}"/>
							<input name="totalprice" type="hidden" value="{{ $order_details->total_price }}"/>
							<input name="payment" id="payment" type="hidden" value="fullpay"/>
							<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
							<button type="submit" class="hide"></button>
						 	<a href="javascript:void(0)" class="cont-bok" onclick="submitForm();">Continue Booking</a>
							 
		             </div>
				 			
    </div><!--End row-->
	</form>	
</div>	 
</section>
        
@endsection


@section('pagespecificscripts')

<script>
        
	$(document).ready(function() {
		$('body').attr('id', 'ibd');
		$("#deposit").click(function() {
			$('#payment').val('deposit');
		});
		$("#fullpay").click(function() {
			$('#payment').val('fullpay');
		});
		
	});

	function submitForm(){
		//alert('Go for payment and check booking');
		$('#step3Form').find('[type="submit"]').trigger('click');
	}

	
</script>
   
@stop
