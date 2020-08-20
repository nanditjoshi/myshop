@extends('layout.default')

@section('pagespecificstyles')
<style>
    md {
        color: red;
    }
</style>
@stop

@section('content')

    @include('layout.partials.searchbar')

    <div class="clearfix"></div>
    <section  id="contact">
<div class="container">
<div class="row">
 <div class=" col-sm-12 col-sm-12 wow fadeInLeftBig animated shdborder-l pdl " >
	
	 <br>
	 <!--contact form-->
    @if (session()->has('message'))    
        <div class="col-md-12"><span><h4 class="m-l-o">{{ session()->get('message') }}</h4></span></div>    
    @endif
	 <div class="col-md-6">
            
			<form id="contact-form" method="post" action="{{ action('HomeController@addContactUs') }}">
				<h4 class="m-l-o">Enquiry Form</h4><br> 
					<div class="messages"></div>

					<div class="controls l-r-o">

						<div class="">
							<div class="col-md-6">
								<div class="form-group has-error has-danger">
									<label for="Firstname">Firstname <md>*</md></label>
									<input id="name" type="text" name="name" class="form-control" placeholder="Firstname" required="required" />
									 <!--<div class="help-block with-errors"><ul class="list-unstyled"><li>Firstname is required.</li></ul></div>-->
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_lastname">Lastname<md>*</md></label>
									<input id="surname" type="text" name="surname" class="form-control" placeholder="Lastname" required="required" />
									<!--<div class="help-block with-errors"></div>-->
								</div>
							</div>
						</div>
						<div class="">
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_email">Email<md>*</md></label>
									<input id="email" type="email" name="email" class="form-control" placeholder="Email" required="required" />
									<!--<div class="help-block with-errors"></div>-->
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_phone">Phone<md>*</md></label>
									<input id="phone" type="number" name="phone" class="form-control" placeholder="Phone" required="required"/>
									<!--<div class="help-block with-errors"></div>-->
								</div>
							</div>
						</div>
						<div class="">
					   <div class="col-md-6">
							<div class="form-group has-error has-danger">
								<label for="form_need">Your classification</label>
								<select id="classification" name="classification" class="form-control">
									<option value=""></option>
									<option value="Request quotation">Request quotation</option>
									<option value="Request order status">Request order status</option>
									<option value="Request copy of an invoice">Request copy of an invoice</option>
									<option value="Other">Other</option>
								</select>
								 <!--<div class="help-block with-errors"><ul class="list-unstyled"><li>Please specify your need.</li></ul></div>-->
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group has-error has-danger">
								<label for="form_need">Reason for communication?</label>
								<select id="communication" name="communication" class="form-control">
									<option value=""></option>
									<option value="Request quotation">Request quotation</option>
									<option value="Request order status">Request order status</option>
									<option value="Request copy of an invoice">Request copy of an invoice</option>
									<option value="Other">Other</option>
								</select>
								<!--<div class="help-block with-errors"><ul class="list-unstyled"><li>Please specify your need.</li></ul></div>-->
							</div>
						</div>
					</div>
							<div class="">
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_email">Villa Code</label>
									<input id="property_code" type="text" name="property_code" class="form-control" placeholder="Villa Code" />
									<!--<div class="help-block with-errors"></div>-->
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="form_phone">Booking Reference</label>
									<input id="booking_reference" type="text" name="booking_reference" class="form-control" placeholder="Booking Reference" />
									<!--<div class="help-block with-errors"></div>-->
								</div>
							</div>
						</div>
						<div class="">
							<div class="col-md-12">
								<div class="form-group">
									<label for="form_email">Preferred Contact Method</label>
									<input id="preferred_contact_method" type="text" name="preferred_contact_method" class="form-control" placeholder="" />
									<!--<div class="help-block with-errors"></div>-->
								</div>
							</div>
			 
						</div>
						<div class="">
							<div class="col-md-12">
								<div class="form-group">
									<label for="form_email">Subject</label>
									<input id="Subject" type="text" name="subject" class="form-control" placeholder="Subject" />
									<!--<div class="help-block with-errors"></div>-->
								</div>
							</div>
			 
						</div> 							
						<div class="">
							<div class="col-md-12">
								<div class="form-group">
									<label for="form_message">Message<md>*</md></label>
									<textarea id="message" name="message" class="form-control" placeholder="Message" rows="4" required="required"></textarea>
									<!--<div class="help-block with-errors"></div>-->
								</div>
							</div>
							
							<div class="col-md-6">
							  <div class="form-group">
									<div class="g-recaptcha" data-sitekey="{{ config('site-config.site_key') }}" data-callback="verifyRecaptchaCallback" data-expired-callback="expiredRecaptchaCallback"></div>
+									<input class="form-control hidden" data-recaptcha="true" required data-error="">
                                    <!--<input type="hidden" name="recaptcha" id="recaptcha">-->
								</div>
							</div>
							<div class="col-md-6">
                                <input name="_token" type="hidden" value="{{csrf_token() }}" />
                                <button type="submit" class="contact-sbmt">Submit</button>
							</div>
						</div>
					  
					</div>

				</form>


	 </div>
	 <div class="col-md-6 ">
	 <div class="col-sm-12">
	 <h4 class="mrgtp" >Contact Info</h4><br>
	 <h5><span class="icn"><img src="images/phone2.png" alt=""></span>By Phone:-</h5>
	 <p> 
		U.K. Freephone - 08000 80 72 83<br>
		U.K. Phone - 0044 161 818 9799<br>
		C.Y. Phone - 0090 533 885 2408
	 </p>

	 <p>Please note that our telephone lines are often very 
busy so if you cannot get through send us an email 
or speak to someone on our livechat.</p><br>

<h5><span class="icn"><img src="images/email.png" alt=""></span>Email:</h5> <p><a href="mailto:bookings@cyprusinthesun.com">bookings@cyprusinthesun.com</a></p><br>
<h5><span class="icn"><img src="images/skype.png" alt=""></span>Skype:-</h5> <p>CyprusInTheSun.com</p><br>
<h5><span class="icn"><img src="images/chat.png" alt=""></span>Live Chat:-</h5> <p>Speak to one of our livechat agents live on our website</p><br>
<h5><span class="icn"><img src="images/social.png" alt=""></span>By Social Media:-</h5> <br>
				<ul class="social-network social-circle">
					
					<li><a href="#" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#" class="icoRss" title="Rss"><i class="fa fa-instagram"></i></a></li>
					<li><a href="#" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#" class="icoGoogle" title="Google +"><i class="fa fa-youtube-square"></i></a></li>
					
				</ul>		
	 </div>
	 </div>
	 <div class="clearfix"></div>
	     <div class="container">
		    <br>
           <hr>
		   <h4>Map</h4>
		   <div id="map-container-google-1" class="z-depth-1-half map-container" style="min-height:320px">
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26143.94774150275!2d34.038603729170184!3d35.006868643133444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14dfc4696337e2f7%3A0x1325a046b0910fac!2sProtaras%2C%20Cyprus!5e0!3m2!1sen!2sin!4v1584252267830!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
							</div>
		 </div>
		 
    </div> 
	  


<!--content--> 
 

</div> <!--/row-->
<!--/content-->          

</div>

</section>

@endsection
@section('pagespecificscripts')
    <script>
        document.body.setAttribute('id', 'ibd');
        $('#sbar').addClass('vbar');

    </script>

<script src="https://www.google.com/recaptcha/api.js"></script>

@stop
