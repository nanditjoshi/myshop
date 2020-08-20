@extends('layout.default')

@section('pagespecificstyles')

<link href="{{asset('css/radio-button.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
@stop

@section('content')


<section  id="step1" >
 <div class="container">
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
												
											    <div class="col-md-6   " id="booking">
												  <h4>Accommodation</h4>
												  <p><strong>{{$property_details->propertyname}}</strong><br>{{$property_details->propertyaddress}}</p>
                                                  <div class="clearfix"></div><br>
												    
												    <div class="col-md-6 mr-pd col-xs-6">
													
														<p>Deposit Payble today </p>
														<p>Remaining balance is payable by 31 May 2021</p>
													
														<p>Price per person</p>								
													</div>

													<div class="col-md-4 col-xs-6  holiday">
													
														<h6>€ {{ $order_details->deposit_pay }}</h6>
														<h6>€ {{ $order_details->remaning_pay }}</h6>
													
														<h6>€ {{ $order_details->price_per_persion }}</h6>									
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
													@endif  
												</div>
												<div class="clearfix"></div><br>

												<div class="dotted-bdr">
													
                                                   <div class="col-md-6 " id="booking"><br>												  
												  <p><strong>check-in:</strong> {{$property_details->checkin}} </p>	
												  <p><strong>check-out:</strong> {{$property_details->checkout}} </p><br>
												  
												  <p><strong>Passengers:</strong> {{ $total_guests = $order_details->adults + $order_details->children }} Adults</p>
												  <p><strong>Duration:</strong>  nights</p>
												  <p><strong>From:</strong>  <strong>To:</strong> </p>

												</div>

												 <div class="col-md-6 " id="booking"><br>												  
												 <img src="{{asset('images/booking-summary.png')}}" alt="" class="img-responsive">
												</div>

												</div>

												<div class="clearfix"></div><br>
												<div class="dotted-bdr">
													
                                                   <div class="col-md-6  " id="booking"><br>
	                                                   <h4>Travel Insurance</h4>											  
													   <div class="col-md-6 mr-pd col-xs-6">
															<p>Standard single trip induviduals insurance</p>
													    </div>

														<div class="col-md-4 col-xs-6 holiday">
															<h6>€ 35.34 pp</h6>				
														</div>
												   </div>

												   <div class="col-md-6  " id="booking"><br>
														  <h4>Transfers</h4>												  
														  <div class="col-md-8 mr-pd col-xs-6 ">
																<p>2 x Returns transfer 1 to 3 person</p>
														  </div>
														  <div class="col-md-4 col-xs-6  holiday">
																<h6>€ 285</h6>					
														  </div>
												   </div>
												   		<div class="clearfix"></div><br>
												<div class="dotted-bdr">
													
                                                   <div class="col-md-6  " id="booking"><br>
	                                                   <h2>Total Price</h2>
												   </div>

												   <div class="col-md-6   text-right" id="booking"><br>
														  <h2>€ {{ $order_details->total_price }}</h2>
												   </div>

												</div>

												</div>

											
											</div>

                                        </div>
                                    </div>
									
                                    
									 
                                </div>
                                
                            </div>	
	                 
		            <div class="col-sm-2">
						 
		            </div>
		             
    </div><!--End row-->
	
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
