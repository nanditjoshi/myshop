<div class="se-pre-con"></div>
    <div class="top">
        <div class="container">
            <div class="col-sm-6 col-xs-6 text-left">
                <div class="top-text"><img src="{{asset('images/top/phone-with-wire.png') }}" alt=""> &nbsp; 03333 603 973</div>
            </div>
            <div class="col-sm-6 col-xs-6 icon0"><span><button type="submit" class="btn btn-info blue-btn" data-toggle="modal" data-target="#viewbookingModal">View Booking</button></span>
                <ul class="social-network social-circle">
                    <li>
                        <a href="javascript: void(0)" class="icoFacebook" title="Facebook"><img src="{{asset('images/top/facebook.png') }}" alt=""></a>
                    </li>
                    <li>
                        <a href="javascript: void(0)" class="icoTwitter" title="Twitter"><img src="{{asset('images/top/instagram.png') }}" alt=""></a>
                    </li>
                    <li>
                        <a href="javascript: void(0)" class="icoGoogle" title="Google +"><img src="{{asset('images/top/twitter.png') }}" alt=""></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <nav class="navbar navbar-inverse mn" id="navbar-main" role="navigation">
        <div class="container">
            <div class="col-md-2 col-sm-2">
                <a class="navbar-brand logom" href="/"><img src="{{asset('images/top/logo.png') }}" class="log logmrg " alt="logo"></a>
            </div>
            <div class="col-md-10 nv-pd">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                </div>
                <div class="collapse navbar-collapse navbar-right nv-pd">
                    <ul class="nav navbar-nav ngap">
                        <li><a href="javascript: void(0)"><span><img src="{{asset('images/top/marker.png') }}" alt=""></span> Resorts</a></li>
                        <li class="@if(request()->path() == 'flights') active @endif"><a href="flights"><span><img src="{{asset('images/top/plane.png') }}" alt=""> Flights</a></li>
                        <li><a href="javascript: void(0)"> <span><img src="{{asset('images/top/beach.png') }}" alt=""> Services</a></li>
						            <li><a href="javascript: void(0)"><span><img src="{{asset('images/top/hotel.png') }}" alt=""></span> Travel Guide</a></li>
                        <li><a href="javascript: void(0)"> <span><img src="{{asset('images/top/villa.png') }}" alt=""></span> Villa Sales</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    @section('modal')
      <div class="modal fade" id="viewbookingModal" role="dialog">
<div class="modal-dialog">
<form method="POST" action="{{ action('BookingController@viewBooking') }}">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">×</button>
      <h4 class="modal-title">View Booking Details</h4>
    </div>
    <div class="modal-body">
      <h3></h3>
      <div class="ami-box">
        <h4>Enter Booking Number</h4><hr>
        <div class="availb-search clearfix" id="amenities">
            <div class="row">
            <div class="col-sm-6">
            <input name="orders_id" type="text" class="form-control" placeholder="Booking Number" required="required">
            </div>
            </div>
        </div>
       
      </div>
    </div>
    <div class="modal-footer">
      <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
      <button type="submit" class="btn btn-default holi-apply">View Booking</button>
    </div>
  </div>
  <!-- Modal content End-->
</form>
</div>
</div>

<div class="modal fade" id="nlgModal" role="dialog">
<div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">×</button>
      <h4 class="modal-title">Sign-up to our newsletter</h4>
    </div>
    <div class="modal-body">
      <h3></h3>
      <div class="ami-box">
        <div class="availb-search clearfix" id="amenities">
            <div class="col-sm-6">
            <div class="col-sm-12">
            <h4>Name</h4><hr>
            <input name="user_name" id="user_name" type="text" class="form-control" placeholder="Name" required="required">
            </div>
            </div>
            <div class="col-sm-6">
            <div class="col-sm-12">
            <h4>Email</h4><hr>
            <input name="user_email" id="user_email" type="email" class="form-control" placeholder="Email" required="required">
            </div>
            </div>
        </div>
       
      </div>
      
    </div>
    <div class="modal-footer">
        <button id="request-newsletter-form" class="btn btn-default holi-apply">Sign Up For News Letter</button>
    </div>
  </div>
  <!-- Modal content End-->
</div>
</div>
@endsection
