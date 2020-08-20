@extends('layout.default')

@section('pagespecificstyles')
<link href="{{asset('css/form.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<style>
form span{
	color: #21bbef !important;
	font-size: 14px !important;
}

#datetimepicker1, #datetimepicker2{
	width: 35%;
}
</style>

@stop

@section('content')

<form method="POST" action="{{ action('BookingController@addOrderDetails') }}" id="step1Form">
<section id="step1">
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
				<span class="dark-active-middle"><i class="fa fa-circle" aria-hidden="true"></i></span>
				<div class="hr-middle"></div>
				<h5>Passenger Details</h5>
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4 mr-pd st-rgt">
				<span class="dark-active-middle"><i class="fa fa-circle" aria-hidden="true"></i></span>
				<div class="hr-right"></div>
				<h5>Payment Details</h5>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="step navbar-collapse collapse sidebar-navbar-collapse">
	                            
	                                <div class="collapse-group">
	                                     <div class="step panel panel-default">
                                        <div class="step panel-heading" role="tab" id="headingss">
                                            <div class="panel-title"> <a role="button" data-toggle="collapse" href="#collapsess" aria-expanded="true" aria-controls="collapsess" class="trigger "> Transfer Options</a></div>
                                        </div>
                                        <div id="collapsess" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingss">
                                            <div class="step panel-body"> 
											   <div class="col-sm-6 mr-pd"><img src="{{asset('images/transfer-option.pngw')}}" alt="" class="img-responsive center-block"></div>
											   <div class="col-sm-6 mr-pd mr-pd-rvrs ">
												  <h5>Private Transfer</h5>
												  <p>We'll whisk you from the airport to your accommodation.</p>
											      <span>Read our Essential Information for more details</span><br>
												  	<select name="airport" id="airport">
														<option value="" selected>Select Airport </option>
														<option value="Paphos Airport (PFO)">Paphos Airport (PFO)</option>
														<option value="Larnaca Airport (LCA)">Larnaca Airport (LCA)</option>
													</select>
												  <p>Return Transfer for  {{ Session::get('adult') + Session::get('children') }} people</p>
											      <p id="transfer_options">
												  </p>
												  <span>PICK UP {!! \Carbon\Carbon::parse(Session::get('date'))->format('j M,  D Y') !!}</span><br>
												  <p>Flight Arrival Time</p>
													<div class='input-group' id='datetimepicker1'>
														<input type='text' class="form-control" name="arrival_time" id="arrival_time" />
															<span class="input-group-addon">
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div><br>
												  <span>RETURN	{!! \Carbon\Carbon::parse( Session::get('date'))->addDay(Session::get('night'))->format('j M,  D Y') !!} </span><br>
												  <p>Flight Departure Time</p>
													<div class='input-group' id='datetimepicker2'>
														<input type='text' class="form-control" name="departure_time" id="departure_time" />
															<span class="input-group-addon">
															<span class="glyphicon glyphicon-calendar"></span>
														</span>
													</div>
													<br/><br/><br/>
												  <a href="javascript: void(0)" class="transfer" id="addtransfer">Add Transfers</a> 
												</div>										
											
											</div>
                                        </div>
                                    </div>


										<!-- pannel2 closed-->
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
														<h6>€{{ number_format($deposit,0)}}</h6>
														<h6>€{{ number_format($remaningpay,0)}}</h6>
													@endif
														<h6><strong>€{{ number_format($priceperperson,0)}}pp</strong></h6>
														<h2 id="totalprice">€{{ number_format($totalprice,0)}}</h2>														
													</div>
                                                    <div class="clearfix"></div>
                                                    @if ($dateDiff >=80 )			
                                                    	<div class="col-sm-12 dashed-box">
                                                    	<h3><strong>Book holiday today for just</strong></h3>
                                                    	<h4>Deposit amount</h4>
                                                    	<h5><strong>€{{ number_format($deposit,0)}}</strong></h5>
                                                    	</div>
													@endif

												</div>
	                                        </div>
	                                    </div>
	                                </div>
	                                
	                            </div>	
		                 <div class="col-sm-6 col-xs-6 mr-pd">
							 <a href="{{ route('property.details',implode('_',$parr))}}" class="pre-bok"> Previous</a>
			             </div>
			           
			             <div class="col-sm-6 col-xs-6 mr-pd">
						 	<button type="submit" class="hide"></button>
						 	<a href="javascript:void(0)" class="cont-bok" onclick="submitForm();">Continue Booking</a>
			             </div>
			</div>
			@include('layout.partials.booking-sidebar')
		
	    </div><!--End row-->
	
	</div>	 
	<input name="propertycode" type="hidden" value="{{ implode('_',$parr) }}"/>
	<input name="price_per_persion" type="hidden" value="{{ $priceperperson }}"/>
	<input name="total_price" id="total_price" type="hidden" value="{{ $totalprice }}"/>
	<input name="number_of_taxi" id="number_of_taxi" type="hidden" value="0"/>
	<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
	</section>
	</form>
        
@endsection


@section('pagespecificscripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>




<script>
        
$(document).ready(function() {
	$('body').attr('id', 'ibd');

	$('#datetimepicker1').datetimepicker({
        format: 'HH:mm',
	});
	  
	$('#datetimepicker2').datetimepicker({
        format: 'HH:mm'
  	});  

	$('#datetimepicker1 input').click(function(event){
		$('#datetimepicker1 ').data("DateTimePicker").show();
	});
	$('#datetimepicker2 input').click(function(event){
		$('#datetimepicker2 ').data("DateTimePicker").show();
	});
	
	$("#airport").change(function() {
	
		var airport 	= 	$("#airport").val();
		var destination =  	"{{ Session::get('destination') }}";

		if(airport == '') { alert('Please select airport.'); return false; }

		$.ajax(
		{
			type:'POST',
            url:'/transfers',
            data:{
				'_token' : '<?php echo csrf_token() ?>', 
				'airport': airport,
				'destination': destination,
			},

			success: function(data) {
				//console.log(data);
				//$(data.addresses).each(function( index ) {
				//	console.log( addresses[index] );
				//});
				$("#transfer_options").html('');
				$.each( data.transfers_details, function( key, value ) {
					
					$("#transfer_options").append('<input class="to" type="radio" id="'+key+'" name="taxi_type" value="'+key+'_'+value.final_price+'_'+value.no_of_passenger+'"/> '+key+'('+ value.no_of_passenger +')'+' €'+value.final_price+' Per Car<br>');


				});

			},
			error : function() {
				alert("Error...");
			}
		});
	});

	$("#addtransfer").click(function() {

		var airport 	= 	$("#airport").val();
		if(airport == '') { alert('Please select airport.'); return false; }
		
		var arrival_time 	= 	$("#arrival_time").val();
		if(arrival_time == '') { alert('Please add arrival time.'); return false; }

		var departure_time 	= 	$("#departure_time").val();
		if(departure_time == '') { alert('Please add departure time.'); return false; }

		var radioValue = $("input[name='taxi_type']:checked").val();
		
		
		var type_price = radioValue.split("_");

		var taxi_type 		= type_price[0]; // Taxi type
		var taxi_price 		= type_price[1]; // Taxi price
		var taxi_capacity 	= type_price[2]; // Taxi capacity

		/*if(taxi_type == 'Private Taxi'){
			 var cap = 4; 
			 var taxi_no = ({{ $total_guests }}/cap); alert(taxi_no); 
		}
		if(taxi_type == 'Limousine'){
			 var cap = 6; var taxi_no = ({{ $total_guests }}/cap); alert(taxi_no);
		}*/
		
		var number_of_taxi		=	Math.ceil(Number({{ $total_guests }})/Number(taxi_capacity));
		var toatl_taxi_price	=	Number(taxi_price)*Number(number_of_taxi);

		$("#transferdiv").html('<p><strong>Transfer Option</strong></p><div class="col-xs-8 mr-pd">'+ number_of_taxi +' X Return Transfer for {{ $total_guests }} people</div><div class="col-xs-4 mr-pd text-right">€'+ toatl_taxi_price +'</div><p></p>');

		var toatlprice = Number(toatl_taxi_price) + Number({{ $totalprice }});
		
		$("#totalprice").html('€'+toatlprice);
		$("#totalprice_sidebar").html('€'+toatlprice);
		$("#total_price").val(toatlprice);
		$("#number_of_taxi").val(number_of_taxi);
		



	});

});

function submitForm(){
	$('#step1Form').find('[type="submit"]').trigger('click');
}
</script>
   
@stop
