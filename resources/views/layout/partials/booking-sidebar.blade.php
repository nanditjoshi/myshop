<div class="right-colm col-sm-4">
				<div class="right-colm-0">
				
				  <div class="gray-bg">
                      <!--<img src="{{asset('images/step-1-right.png')}}" alt="" class="img-responsive center-block">-->
                      {!! $property_details[0]->propertyImages[0]->thumb !!}<br>
                        <p>Holiday price</p>
						<h4 style="color: #fff;">€{{ number_format($totalprice,0)}}</h4>
						<h5>€{{ number_format($priceperperson,0)}} pp</h5>
				  </div>
				  <div class="right-colm-box text-left">

				   <h4><strong>
             @if(Session::get('vp_name'))
                {{ Session::get('vp_name') }}
             @else
                {{$property_details[0]->propertyname}}
             @endif
            </strong></h4>
				   <p>{{$property_details[0]->propertyaddress}}</p>
                  </div>
                  <div class="right-colm-box2">
                    <p>
                    	<strong>Passengers:</strong> @if(Session::get('adult')) {{ Session::get('adult') }} Adult @endif
                      @if(Session::get('children')) {{ Session::get('children') }} Children @endif <br>

						<strong>Duration:</strong> {{ $nofonights }} nights<br>
						<strong>From:</strong> {!! \Carbon\Carbon::parse($date )->format('j M Y') !!} <strong>To:</strong> {!! \Carbon\Carbon::parse($enddate)->format('j M Y') !!}<br>
					</p>				  
                  </div>
                  <div class="right-colm-box2 l-grey">
                    <p>
                    	<strong>check-in:</strong> {!! \Carbon\Carbon::parse($date )->format('j M Y') !!} {{$property_details[0]->checkin}}
                      <br>
                        <strong>check-out:</strong>{!! \Carbon\Carbon::parse($enddate)->format('j M Y') !!} {{$property_details[0]->checkout}}
					</p>				  
                  </div>

                  <!--<div class="right-colm-box2 l-grey">
                    <p>
                    	<strong>Travel Insurance</strong>
                        </p><div class="col-xs-8 mr-pd">Standard single trip induviduals insurance</div>
                        <div class="col-xs-4 mr-pd  text-right">€ 35.34 pp</div>
					<p></p>				  
                  </div>-->
                  @if(isset($order_details) && $order_details->transfer == '1')
                  <div class="right-colm-box2 l-grey" id="transferdiv">
                  <p><strong>Transfer Option</strong></p><div class="col-xs-8 mr-pd">{{ $order_details->number_of_taxi }} Return Transfer for {{ $total_guests }} people</div><div class="col-xs-4 mr-pd text-right">€{{ number_format($order_details->taxi_price*$order_details->number_of_taxi,0)}}</div><p></p> 		  
                  </div>
                  @else
                  <div class="right-colm-box2 l-grey" id="transferdiv">
                    		  
                  </div>
                  @endif
                  <div class="right-colm-box text-left">
                  @if ($dateDiff >=80 )
                  	<div class="col-xs-8 mr-pd">Deposit Payble today</div>
                    @if(isset($order_details) && $order_details->transfer == '1')
                    <div class="col-xs-4 text-right mr-pd">€{{ number_format($deposit+$order_details->taxi_price*$order_details->number_of_taxi,0)}}</div><br><br>
                    @else
                    <div class="col-xs-4 text-right mr-pd">€{{ number_format($deposit,0)}}</div><br><br>
                    @endif

                    <div class="col-xs-8 mr-pd">Remaining balance is payable by {{ $remainbalpaydate }} </div>
                    <div class="col-xs-4 text-right mr-pd">€{{ number_format($remaningpay,0)}}</div><br><br><br>
                  @endif  
                    <div class="col-xs-8 mr-pd"><strong>Price per person</strong></div>
                    <div class="col-xs-4 text-right mr-pd"><strong>€{{ number_format($priceperperson,0)}}</strong></div><br><br>    
                  </div>

                  <div class="right-colm-box3 text-left">
                  	<div class="col-xs-8 mr-pd">Total Price </div>
                    @if(isset($order_details) && $order_details != '')
                      <div class="col-xs-4 text-right mr-pd" id="totalprice_sidebar">€{{ number_format($order_details->total_price,0)}}</div><br><br>
                    @else
                    <div class="col-xs-4 text-right mr-pd" id="totalprice_sidebar">€{{ number_format($totalprice,0)}}</div><br><br>
                    @endif
                  </div>

                 <button type="button" class="btn btn-info right-btn" onclick="submitForm();">Continue Booking</button>

			</div>
			</div>
      