@extends('layout.default')

@section('pagespecificstyles')

<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
@stop

@section('content')
<section  id="step1" >
 <div class="container">
    
 @if( $msg == 'true' )
    
    <div class="row">
    	<div class="notificate">
    		 <h3>Thank you for making your booking with <span>Cyprus In The Sun.</span> </h3>
    		 <div class="col-md-3"><img src="{{asset('images/confirm-icon.png')}}" alt="" class="img-responsive center-block" ></div>
    		 <div class="col-md-9">
    		 	<h4>Your booking is now confirmed and your unique booking 
					reference is <span>CITS{{$order_details->id}}</span>. Please print a copy of your 
					confirmation to take with you to the accommodation when 
					you check in. Please see your bookings details below
				</h4>
    		 </div>
    		
    	</div>
    </div>
@else

    <div class="row">
    	<div class="notificate">    		
    		 <div class="col-md-3"><img src="{{asset('images/sad.png')}}" alt="" class="img-responsive center-block" ></div>
    		 <div class="col-md-9">
    		 	<h4>Sorry your payment has been unsuccessful and booking is not yet confirmed. Please check your card details and try again
				</h4>
				<!--<button class="blue-btn" onclick="window.location.href='step3.html';">TRY AGAIN</button>-->

				{{ $msg }}
    		 </div>

    		
    	</div>
    </div>
@endif   
	@if($msg == 'true')
    <div class="row">

	<div class="clearfix"></div>
	<div class="watmark">
		<div class="bordr-watmark">
			<div class="step panel-body">
			   <div class="prints"><!--<a href=""><img src="{{asset('images/print.png')}}" alt="" class="img-fluid"></a>--></div> 
				<div class="row">
					<div class="col-sm-7"><h3>Booking Confirmation: <span>CITS{{$order_details->id}}</span></h3></div>
					<div class="col-sm-7"><h3>Booking Ref: <span>{{$order_details->bookingID}}</span></h3></div>				    <div class="col-sm-4"><h3>Booking Date: <span>{{ \Carbon\Carbon::parse($order_details->created_at)->format('j M Y') }}</span></h3></div>
				</div>

				<div class="dotted-bdr"></div>
				<div class="col-md-6 mr-pd " id="booking">
						 <h4>Accommodation</h4>
						 <p><strong>{{$property_details->propertyname}}</strong><br>{{$property_details->propertyaddress}}</p>
                         <div class="clearfix"></div><br>
					<div class="col-md-6 mr-pd col-xs-6">
						@if((int)$order_details->deposit_pay > 0)
						<p>Deposit paid </p>
						<p>Remaining balance is payable by {{ \Carbon\Carbon::parse($order_details->remainbalpaydate)->format('j M Y') }} </p>
						@endif
						<p>Price per person</p>								
					</div>
					<div class="col-md-4 mr-pd col-xs-6  holiday">
						@if((int)$order_details->deposit_pay > 0)
          				<h6>€{{ number_format($order_details->deposit_pay,0)}}</h6>
						<h6>€{{ number_format($order_details->remaning_pay,0)}}</h6>
						@endif
						<h6>€{{ number_format($order_details->price_per_persion,0)}}</h6>									
					</div>
				</div>
				<div class="col-md-6 mr-pd " id="booking">
						<h4>Passenger Summary</h4>
						@foreach($order_details->orderPassangers as $passengers)
							<p>{{ $passengers->title }} {{ $passengers->firstname }} {{ $passengers->surname }}</p>	
						@endforeach
						<h4>Billing Address</h4>
						@if($order_details->orderPassangers[0]->is_lead == 1)
						<p>{{ $order_details->orderPassangers[0]->house_name }}</p>
						<p>{{ $order_details->orderPassangers[0]->address1 }}</p>
						<p>{{ $order_details->orderPassangers[0]->address2 }}</p>
						<p>{{ $order_details->orderPassangers[0]->city }}</p>
						<p>{{ $order_details->orderPassangers[0]->country }}</p>
						<p>{{ $order_details->orderPassangers[0]->post_code_add }}</p>
						@endif 
						<p>{{ $order_details->orderPassangers[0]->email }}</p>
						<p>{{ $order_details->orderPassangers[0]->telephone_no }}</p>
				</div>
				<div class="clearfix"></div><br>

					<div class="dotted-bdr">
													
                    <div class="col-md-6 mr-pd " id="booking"><br>												  
						<p><strong>check-in:</strong> {{ \Carbon\Carbon::parse($order_details->startdate)->format('j M Y') }} {{$property_details->checkin}}</p>	
						<p><strong>check-out:</strong> {{ \Carbon\Carbon::parse($order_details->enddate)->format('j M Y') }} {{$property_details->checkout}}</p><br>												  
						<p><strong>Passengers:</strong> {{ $total_guests = $order_details->adults + $order_details->children }} </p>
						<p><strong>Duration:</strong> {{$order_details->nofonights}} nights</p>
						<p><strong>From:</strong> {{ \Carbon\Carbon::parse($order_details->startdate)->format('j M Y') }} <strong>To:</strong> {{ \Carbon\Carbon::parse($order_details->enddate)->format('j M Y') }}</p>
					</div>

					<div class="col-md-6  mr-pd" id="booking"><br>												  
					    <img src="{{asset('images/booking-summary.png')}}" alt="" class="img-responsive">
					</div>
					</div>
                    <div class="clearfix"></div><br>
					<div class="dotted-bdr">
					<!--<div class="col-md-6 mr-pd " id="booking"><br>
	                <h4>Travel Insurance</h4>											  
					<div class="col-md-6 mr-pd col-xs-6">
					<p>Standard single trip induviduals insurance</p>
					</div>

					<div class="col-md-4 col-xs-6 holiday">
						<h6>€ 35.34 pp</h6>				
					</div>
					</div>-->
					@if($order_details->transfer == '1')
					<div class="col-md-6 mr-pd  " id="booking"><br>
							<h4>Transfers</h4>												  
							<div class="col-md-8 mr-pd col-xs-6 ">
							<p> {{ $order_details->number_of_taxi}} Returns transfer {{ $order_details->adults + $order_details->children }} person</p>
							</div>
							<div class="col-md-4 col-xs-6  holiday">
								<h6>€ {{ $order_details->taxi_price*$order_details->number_of_taxi }}</h6>					
							</div>
						</div>
					<div class="clearfix"></div><br>
					<div class="dotted-bdr">
					@endif							
                        <div class="col-md-6 mr-pd col-xs-6  " id="booking"><br>
	                        <h2>Total Price</h2>
							</div>

						<div class="col-md-6  col-xs-6  text-right" id="booking"><br>
							 <h2>€{{number_format($order_details->total_price,0)}}</h2>
						</div>

						</div>

						</div>

											
					</div>							 
		</div>
	</div>
	            
     </div><!--End row-->
	 @endif
</div>	<!--End Container--> 
</section>
        
@endsection


@section('pagespecificscripts')

<script>
        
        $(document).ready(function() {
            $('body').attr('id', 'ibd');
        });
    </script>
   
@stop
