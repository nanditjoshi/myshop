@extends('layout.default')

@section('pagespecificstyles')

<link href="{{asset('css/form.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
@stop

@section('content')

<section  id="step2" >
	 <div class="container">
	    <div class="row">
			<div class="left-colm col-sm-8">
				<div class="step1">
		    <div class="col-md-4 col-sm-4 col-xs-4 mr-pd">
				<span class="yellow-active"><i class="fa fa-check-circle" aria-hidden="true"></i></span>
				<div class="hr"></div>
				<h5>Holiday Extras</h5>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 mr-pd st-centr">
				<span class="yellow-active" ><i class="fa fa-check-circle" aria-hidden="true"></i></span>
				<div class="hr-middle"></div>
				<h5>Passenger Details</h5>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 mr-pd st-rgt">
				<span class="dark-active-middle" ><i class="fa fa-circle" aria-hidden="true"></i></span>
				<div class="hr-right"></div>
				<h5>Payment Details</h5>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="step navbar-collapse collapse sidebar-navbar-collapse">
		<form method="POST" action="{{ action('BookingController@addPassengerDetails') }}" id="step2Form">
	                            	<div class="collapse-group">
										<!-- pannel 1 start-->
	                                   <div class="step panel panel-default">
	                                        <div class="step panel-heading" role="tab" id="headingNine">
	                                            <div class="panel-title"> <a role="button" data-toggle="collapse" href="#collapseNine" aria-expanded="true" aria-controls="collapseNine" class="trigger "> Adult 1 - Lead passenger</a></div>
	                                        </div>
	                                        <div id="collapseNine" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingNine">
	                                            <div class="step panel-body"> 
												<input name="type[]" type="hidden" value="Adult"/>
												<input name="is_lead[]" type="hidden" value="1"/>
													<div class="form-row">
														<div class="col-md-6">
															<label>Title<span>*</span></label>
															<select name="title[]" required="required">
																<option value="" selected>Select</option>
																<option value="Mr">Mr</option>
																<option value="Mrs">Mrs</option>
																<option value="Ms">Ms</option>
																<option value="Miss">Miss</option>
															</select>
                                                        </div>
														<div class=" col-md-6">
															<label>First name<span>*</span></label>	
															<input name="firstname[]" type="text" class="form-control" placeholder="First name" required="required" />
													    </div>
													</div>
                                                    <div class="clearfix"></div>
													<div class="form-row">
														<div class="col-md-6">
													    	<label>Surname<span>*</span></label>	
													      	<input name="surname[]" type="text" class="form-control" placeholder="Surname"  required="required" />
															<input name="age[]" type="hidden" />
													    </div>
													    <div class=" col-md-6">
														<label>Telephone<span>*</span></label>	
																	<input id="telephone_no" name="telephone_no" type="number" class="form-control" placeholder="Telephone"  required="required" />
													    </div>
													</div>
													<div class="clearfix"></div>
													<div class="form-row">
														<div class="col-md-6">
													    	<label>Email<span>*</span></label>	
													      	<input name="email" type="email" class="form-control" placeholder="Email"  required="required" />
													    </div>
													    <div class="col-md-6">
															<label>Comment</label>	
															<textarea class="form-control" rows="15" colum="6" name="comment" id="comment"></textarea>
														</div>
													</div>
													<div class="form-row">
														<div class="col-sm-12"><br><h4>Correspondence address</h4></div>	
													<div class="col-sm-6">
													  	<div class="input-group">
													  		<label>Postcode<span>*</span></label>	
												        	<input type="text" class="form-control" placeholder="Search" id="postcode"/>
															<button id="findaddress" class="add-btn" data-toggle="collapse" href="#resultaddress" role="button" aria-expanded="false" aria-controls="resultaddress">Find address<span><i class="fa fa-angle-double-right" aria-hidden="true"></i></span></button>
												        </div>
														<div class="collapse" id="resultaddress">
															<div class="panel panel-primary" id="result_panel">
																<div class="panel-heading"><h3 class="panel-title">Result List</h3>
																</div>
																<select class="as" name="addresslist" id="addresslist" size="6">
																	
																</select>
															</div>
															<div class="card card-body" id="selectedaddress">
																
															</div>
														</div>	
 													</div>
													<div class="col-md-6">
													    <div class="add-div"><button class="find-add" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
															<h4>or <span>enter address manually</span></h4></button></div>
													    </div>
													</div>
													<div class="collapse" id="collapseExample">
													  	<div class="card card-body">
															<div class="form-row">
																<div class="col-md-6">
																	<label>House name / flat no<span>*</span></label>	
																	<input name="house_name" id="house_name" type="text" class="form-control" placeholder="House name / flat no"  required="required" />
																</div>
																<div class="col-md-6">
																	<label>Address Line 1<span></span></label>	
																	<input name="address1" id="address1" type="text" class="form-control" placeholder="Address Line 1"  required="required" />
																</div>
															</div>
															<div class="form-row">
																<div class="col-md-6">
																	<label>Town/City<span>*</span></label>	
																	<input name="city" id="city" type="text" class="form-control" placeholder="Town/City"  required="required" />
																</div>
																<div class="col-md-6">
																	<label>Address Line 2<span></span></label>	
																	<input name="address2" id="address2" type="text" class="form-control" placeholder="Address Line 2"  required="required" />
																</div>
															</div>
															<div class="form-row">
																<div class="col-md-6">
																	<label>County<span>*</span></label>	
																	<input name="country" id="country" type="text" class="form-control" placeholder="County"  required="required" />
																</div>
																<div class="col-md-6">
																	<label>Postcode<span>*</span></label>	
																	<input name="post_code_add" id="post_code_add" type="text" class="form-control" placeholder="Postcode"  required="required" />
																</div>
															</div>
														</div>
													</div>
													<div class="clearfix"></div>
												</div>
	                                        </div>
	                                    </div><!-- pannel 1 close-->

										<!-- pannel2 start adult-->
										@for($i=0;$i < Session::get('adult')-1;$i++)
                                        <div class="step panel panel-default">
                                        	<div class="step panel-heading" role="tab" id="headingss">
                                            	<div class="panel-title"> <a role="button" data-toggle="collapse" href="#adult{{$i+2}}" aria-expanded="true" aria-controls="collapsess" class="trigger "> Adult {{$i+2}}</a></div>
                                        	</div>
                                        	<div id="adult{{$i+2}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingss">
                                            	<div class="step panel-body"> 
												<input name="type[]" type="hidden" value="Adult"/>
												<input name="is_lead[]" type="hidden" value="0"/>
											 		<div class="form-row">
															<div class=" col-md-6">										     	<label>Title<span>*</span></label>	
																<select name="title[]" required="required">
																	<option value="" selected>Select</option>
																	<option value="Mr">Mr</option>
																	<option value="Mrs">Mrs</option>
																	<option value="Ms">Ms</option>
																	<option value="Miss">Miss</option>
																</select>
															</div>
															<div class=" col-md-6">
															<label>First name<span>*</span></label> <input name="firstname[]" type="text" class="form-control" placeholder="First name"  required="required" />
															</div>

													</div>
													<div class="clearfix"></div>
													<div class="form-row">
															<div class="col-md-6">
															<label>Surname<span>*</span></label>	
															<input name="surname[]" type="text" class="form-control" placeholder="Surname"  required="required" />
															<input name="age[]" type="hidden" />
															</div>
													</div>									
											 	</div>
                                        	</div>
                                    	</div>
										@endfor
										<!-- pannel2 closed adult-->

										<!-- pannel2 start children-->
										@for($i=0;$i < Session::get('children');$i++)
                                        <div class="step panel panel-default">
                                        	<div class="step panel-heading" role="tab" id="headingss">
                                            	<div class="panel-title"> <a role="button" data-toggle="collapse" href="#children{{$i+2}}" aria-expanded="true" aria-controls="collapsess" class="trigger "> Children {{$i+1}}</a></div>
                                        	</div>
                                        	<div id="children{{$i+2}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingss">
                                            	<div class="step panel-body"> 
												<input name="type[]" type="hidden" value="children"/>
												<input name="is_lead[]" type="hidden" value="0"/>
											 		<div class="form-row">
															<div class=" col-md-6">										     	<label>Title<span>*</span></label>	
																<select name="title[]" required="required">
																	<option value="" selected>Select</option>
																	<option value="Ms">Ms</option>
																	<option value="Miss">Miss</option>
																</select>
															</div>
															<div class=" col-md-6">
															<label>First name<span>*</span></label> <input name="firstname[]" type="text" class="form-control" placeholder="First name"  required="required" />
															</div>

													</div>
													<div class="clearfix"></div>
													<div class="form-row">
															<div class="col-md-6">
															<label>Surname<span>*</span></label>	
															<input name="surname[]" type="text" class="form-control" placeholder="Surname"  required="required" />
															</div>
															<div class="col-md-6">
															<label>Age<span>*</span></label>	
															<input name="age[]" type="number" class="form-control" placeholder="Age"  required="required" min="0" max="14" />
															</div>
													</div>									
											 	</div>
                                        	</div>
                                    	</div>
										@endfor
										<!-- pannel2 closed children-->
										
	                                    <div class="step panel panel-default">
	                                        <div class=" step panel-heading" role="tab" id="headingEigt">
	                                            <div class="panel-title"> <a role="button" data-toggle="collapse" href="#collapseEigt" aria-expanded="true" aria-controls="collapseEigt" class="trigger "> Holiday Summary </a></div>
	                                        </div>
	                                        <div id="collapseEigt" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingEigt">
	                                            <div class="step panel-body">
													<div class="col-sm-6 col-xs-6 mr-pd">
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
													//var_dump($pc);

													$rate = (int)$price;

													$priceperperson = $rate/$total_guests;
													
													$totalprice = $rate;

													$deposit = $totalprice*30/100;

													$remaningpay = $totalprice - $deposit;
													
													$remainbalpaydate = \Carbon\Carbon::parse( Session::get('date') )->subDays(70)->format('j M Y');

																										
													@endphp
													@if ($dateDiff >=80 )
														<p>Deposit Payble today </p>
														<p>Remaining balance is payable by {{ $remainbalpaydate }}</p>
														<input name="remainbalpaydate" type="hidden" value="{{ \Carbon\Carbon::parse(Session::get('date'))->subDays(70) }}"/>
													@endif
														<p><strong>Price per person</strong></p>
														<h2>Total Price</h2>														
													</div>
													<div class="col-sm-6 col-xs-6 mr-pd holiday">
													@if ($dateDiff >=80)			
														<h6>€{{ number_format($deposit+$order_details->taxi_price*$order_details->number_of_taxi,0)}}</h6>
														<h6>€{{ number_format($remaningpay,0)}}</h6>
													@endif
														<h6><strong>€{{ number_format($priceperperson,0)}}pp</strong></h6>
														<h2>€{{ number_format($order_details->total_price,0)}}</h2>														
													</div>
                                                    <div class="clearfix"></div>
                                                    
                                                    
													@if ($dateDiff >=80 )			
                                                    	<div class="col-sm-12 dashed-box">
                                                    	<h3><strong>Book holiday today for just</strong></h3>
                                                    	<h4>Deposit amount</h4>
                                                    	<h5><strong>€{{ number_format($deposit+$order_details->taxi_price*$order_details->number_of_taxi,0)}}</strong></h5>
                                                    	</div>
													@endif
                                                    
                                               

												</div>
	                                        </div>
	                                    </div>
	                                </div>
	                                
	                            
						
		                 <div class="col-sm-6 col-xs-6 mr-pd">
							 <a href="javascript:void(0)" class="pre-bok" onclick="history.back();"> Previous</a>
			             </div>
			           
			             <div class="col-sm-6 col-xs-6 mr-pd">
								<input name="propertycode" type="hidden" value="{{ implode('_',$parr) }}"/>
								<input name="orders_id" type="hidden" value="{{ $orders_id }}"/>
								<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
								<button type="submit" class="hide"></button>
						 		<a href="javascript:void(0)" class="cont-bok" onclick="submitForm();">Continue Booking</a>
								 
			             </div>
						
						</form>	
						</div>
			</div>
			@include('layout.partials.booking-sidebar')
		
	    </div><!--End row-->
	</div>	 
	</section>
	
        
@endsection


@section('pagespecificscripts')

<script>
        
$(document).ready(function() {
	$('body').attr('id', 'ibd');


	$("#findaddress").click(function() {

		var postcode = $("#postcode").val();
		var apikey =  "{{ config('site-config.getAddressapikey') }}";
		
		if(postcode == '') { alert('Please enter postalcode.'); return false; }

		$.ajax(
		{
			type : "GET",
			url: "https://api.getAddress.io/find/"+postcode+"?api-key="+apikey,
			dataType: "json",
			data: {
				//address: address,
				sensor: "true"
			},
			success: function(data) {
				//console.log(data.addresses);
				//$(data.addresses).each(function( index ) {
				//	console.log( addresses[index] );
				//});
				$.each( data.addresses, function( key, value ) {
					//console.log( value );
					$('#addresslist').append($('<option>', { 	
						value: value,
						text : value 
					}));
					/*$("#addresslist").append($('<option>', { 	
						value: value.replace(/ ,/g , ''),
						text : value.replace(/ ,/g , '') 
					}));*/
				});
		
			},
			error : function() {
				alert("No Post code find.");
			}
		});
	});

	$("#addresslist").click(function() {
		var value = $(this).val();
		var res = value.split(",");

		$('.find-add').trigger('click');

		$("#selectedaddress").html('<div class="greenbox"><h5> <i class="fa fa-check-circle" aria-hidden="true"></i> Select Address</h5>'+value+'</div>');
		$("#selectedaddress").html($("#selectedaddress").html().replace(/ ,/g , ''));
		
			$("#house_name").val(res[0]);
			$("#address1").val(res[1]);
			$("#address2").val(res[2]+res[3]);
			//res[4] locality
			$("#city").val(res[5]);
			$("#country").val(res[6]);
			$("#post_code_add").val($("#postcode").val());
			
		
	});
});

function submitForm(){
	if(!$('#telephone_no').val().match('[0-9]{10}'))  {
		alert("Please put 10 digit mobile number");
		$("#telephone_no" ).focus();
		return false;;
	}  
	$('#step2Form').find('[type="submit"]').trigger('click');
}	
</script>
   
@stop

																	
																	
																