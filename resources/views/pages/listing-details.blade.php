@extends('layout.default')
@section('pagespecificstyles')

<!--<script src="https://code.jquery.com/jquery-1.9.1.js"></script>-->
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>    
<link href="{{asset('css/ver-gallery.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />
<style>
.slick-slide img{
    max-height: 500px;    
}
</style>
@stop
@section('content')
    <div id="inr">
    @include('layout.partials.searchbar')
    </div>
    <div class="clearfix"></div>
    <section id="ver-gallery">
        <div class="container">
            <div class="row">
                <div class="col-md-9 slideInLeft animated pdl" data-wow-delay="0s">
                    <div class="shdborder-l">
                        <h4>{{$property_details->propertyname}}</h4>
                        
                        <h5>
                            <en>{{$property_details->propertyaddress}}</en>
                        </h5>
                        <span class="">{{$property_details->bedrooms_new}} Bedrooms, Sleeps up to {{$property_details->sleeps}}
                            @php if($property_details->propertystars >= 5){ $star = 5; }else{ $star = $property_details->propertystars; } @endphp
                            @for($i=0;$i < $star;$i++)
                            <i class="fa fa-star yi"></i>
                            @endfor
                        </span>
                        <div class="clearfix"></div>
                        
                        <div class="synch-carousels">
                            <div class="left child">
                                 <!-- loop for thumb multiple images -->
                                <div class="gallery">
                                    @foreach($property_details->propertyImages as $image)
                                        <div class="item">
                                        {!! $image->thumb !!}
                                        </div>
                                    @endforeach
                                </div>
                                <!-- End thumb loop -->
                            </div>
                            <div class="right child">
                                <!-- loop for main multiple images -->
                                <div class="gallery2">
                                    @foreach($property_details->propertyImages as $image)
                                        <div class="item">
                                        {!! $image->main !!}
                                        </div>
                                    @endforeach
                                </div>
                                 <!-- End main loop -->
                                <div class="nav-arrows">
                                    <button class="arrow-left"><span class="glyphicon glyphicon-chevron-left"></span>
                                    </button>
                                    <button class="arrow-right"><span class="glyphicon glyphicon-chevron-right"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="shdborder-l pd-l-o">
                        <div class="col-sm-12 pdl" id="overview">
                            <h4>Overview</h4>
                            <p>{!! $property_details->webdescription !!}</p>
                            
                        </div>
                        <!-- hide this section-->
                        <!--
                        <div class="col-sm-5 pdl">
                            <div class="hotel-type">
                                <div class="gre-tab"> <i class="flowr"></i><span>Hotel Type :</span>
                                    <h5>5 Star (4 Bed 3 Bath)</h5></div>
                                <div class="gre-tab"> <i class="flowr"></i><span>Sea View :</span>
                                    <h5>10 / 10</h5></div>
                                <div class="gre-tab"> <i class="flowr"></i><span>Location :</span>
                                    <h5>7 / 10</h5></div>
                                <div class="gre-tab"> <i class="flowr"></i><span>Our Rating :</span>
                                    <h5>9 / 10</h5></div>
                                <div class="gre-tab"> <i class="flowr"></i><span>Wow Factor :</span>
                                    <h5>9 / 10</h5></div>
                                <div class="gre-tab zromrgn"> <i class="flowr"></i><span>Overall Value :</span>
                                    <h5>9 / 10</h5></div>
                            </div>
                        </div>-->
                    </div>
                    <div class="shdborder-l pd-l-o">
                        <div class="col-sm-12 pdl" id="amenities">
                            <h4>Amenities</h4>
                            <ul class="amenities clearfix style1">

                                <!-- Loop for aminities if applicable ---------------------------------------->
                                @foreach($property_details->propertyVariables as $variables)
                                @if($variables->varcatname == 'Bathrooms')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-tub"></i>Bathrooms</div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Bedrooms')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-bdrom"></i>Bedrooms</div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Indoor Facilities')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-washing"></i>Indoor Facilities
                                    </div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Outdoor Facilities')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-outdoor"></i>Outdoor Facilities
                                    </div>
                                </li>
                                
                                @elseif($variables->varcatname == 'General Facilities')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-kitchen"></i>General Facilities
                                    </div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Local Activities')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-gitar"></i>Local Activities</div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Services')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-services"></i>Services</div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Cooling & Heating')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-own"></i>Cooling & Heating</div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Spa and Pool Facilities')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-swimer"></i>Spa and Pool Facilities
                                    </div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Leisure and Games')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-games"></i>Leisure and Games</div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Category')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-award"></i>Category</div>
                                </li>
                                
                                @elseif($variables->varcatname == 'Wi-fi')
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-wi-fi"></i>Wi-fi available</div>
                                </li>
                                @else
                                <li class="col-md-4 col-sm-6">
                                    <div class="icon-box style1"><i class="soap-icon-wi-fidfd"></i>{!! $variables->varcatname !!}</div>
                                </li>
                                @endif
                                @endforeach
                                <!-- End loop ---------------------------------------------------------------------------------->
                            </ul>
                        </div>
                    </div>
                    <!-- Availabilities hide -->
                    <!--<div class="shdborder-l pd-l-o">
                        <div class="pdl" id="amenities">
                            <h4>Availabilities</h4>
                            <form>
                                <div class="availb-search clearfix">
                                    <div class="col-md-4">
                                        <h4 class="title">When</h4>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Start Date</label>
                                                <input type="text" class="datepicker2" placeholder="" readonly="true" /><i class=""></i></div>
                                            <div class="col-sm-6">
                                                <label>End Date</label>
                                                <input type="text" class="datepicker2" placeholder="" readonly="true" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <h4 class="title">Who</h4>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-4">
                                                <label>ROOMS</label>
                                                <div class="input-group incr-box ">
                                                <div class="incre-decre"> <span class="input-group-btn qnty"> <button type="button" class="btn btn-default btn-number mins" disabled="disabled" data-type="minus" data-field="quant[3]"> <span class="glyphicon glyphicon-minus bt1"></span> </button>
                                                    </span>
                                                    <input type="text" name="quant[3]" class="form-control input-number nubrs" value="1" min="1" max="99"> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-number incrs" data-type="plus" data-field="quant[3]"> <span class="glyphicon glyphicon-plus"></span> </button>
                                                    </span>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <label>ADULTS</label>
                                                <div class="input-group incr-box ">
                                                <div class="incre-decre"> <span class="input-group-btn qnty"> <button type="button" class="btn btn-default btn-number mins" disabled="disabled" data-type="minus" data-field="quant[4]"> <span class="glyphicon glyphicon-minus bt1"></span> </button>
                                                    </span>
                                                    <input type="text" name="quant[4]" class="form-control input-number nubrs" value="1" min="1" max="99"> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-number incrs" data-type="plus" data-field="quant[4]"> <span class="glyphicon glyphicon-plus"></span> </button>
                                                    </span>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-4">
                                                <label>KIDS</label>
                                                <div class="input-group incr-box ">
                                                <div class="incre-decre"> <span class="input-group-btn qnty"> <button type="button" class="btn btn-default btn-number mins" disabled="disabled" data-type="minus" data-field="quant[5]"> <span class="glyphicon glyphicon-minus bt1"></span> </button>
                                                    </span>
                                                    <input type="text" name="quant[5]" class="form-control input-number nubrs" value="1" min="1" max="99"> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-number incrs" data-type="plus" data-field="quant[5]"> <span class="glyphicon glyphicon-plus"></span> </button>
                                                    </span>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h4 class="visible-md visible-lg">&nbsp;</h4>
                                        <label class="visible-md visible-lg">&nbsp;</label>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button class="sbtn" type="submit">SEARCH NOW</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>-->
                    <div class="shdborder-l ">
                        <div class=" " id="amenities">
                            <div class="col-sm-12 map ">
                                <h4>Map</h4>
                                <div id="map-container-google-1" class="z-depth-1-half map-container"
                                     style="min-height:320px">
                                    <!--<iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26143.94774150275!2d34.038603729170184!3d35.006868643133444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14dfc4696337e2f7%3A0x1325a046b0910fac!2sProtaras%2C%20Cyprus!5e0!3m2!1sen!2sin!4v1584252267830!5m2!1sen!2sin"
                                        width="600" height="450" frameborder="0" style="border:0;" allowfullscreen=""
                                        aria-hidden="false" tabindex="0"></iframe>-->
                                        
                                        <iframe src="https://maps.google.com/maps?q={{$property_details->latitude }}, {{$property_details->longitude }}&z=15&output=embed" width="360" height="270" frameborder="0" style="border:0"></iframe>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="shdborder-l ">
                        <div class=" " id="amenities">
                            <div class="col-sm-6 map">
                                <h4>House Rules</h4>
                                <div class="hotel-type">
                                    <!-- loop for house rules if applica -------------------------------------------------->
                                    <div class="gre-tab"><i class="flowr"></i><span>Check In : <en>{{$property_details->checkin}}</en></span><span>Check out: <en>{{$property_details->checkout}}</en></span>
                                    </div>
                                    <div class="gre-tab"><i class="flowr"></i><span>Maximum guest {{$property_details->sleeps}}</span></div>
                                    @php $hr = explode('_',$property_details->house_rules); @endphp
                                    @foreach($hr as $value)
                                    <div class="gre-tab"><i class="flowr"></i><span>{{$value}}</span></div>
                                    @endforeach
                                    <!-- End loop ------------------------------------------------------------------------------>
                                </div>
                            </div>
                            @if($property_details->cancellation_policy != '' && $property_details->cancellation_policy != 'null')
                            <div class="col-sm-6 map">
                                <h4>Cancellation Policy</h4>
                                <div class="hotel-type">
                                    <p>{!! $property_details->cancellation_policy !!}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <!-- hide this section -->
                    <!--<div class="shdborder-l ">
                        <div id="amenities">
                            <h4>Frquently Asked Questions</h4>
                            <div class="faq">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"> How far is the nearest beach? </a></h4></div>
                                        <div id="collapseOne" class="panel-collapse collapse in">
                                            <div class="panel-body"> The Corel Beach is 50m from the beach</div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingTwo">
                                            <div class="panel-title"> <a role="button" data-toggle="collapse" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" class="trigger collapsed"> Distence from Airport </a></div>
                                        </div>
                                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                            <div class="panel-body"> The Corel Beach is 28km from Paphos International Airport.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
                <div class="col-md-3 slideInLeft animated" data-wow-delay="0s" id="right-pnl">
                    <div class="shdborder-l">
                        <div class="dark-st">
                            <h4>{{-- $propertyprices[$property_details->propertycode]['price']['@attributes']['currency'] --}}
                             €{{ number_format((int)$propertyprices[$property_details->propertycode]['price']['rate'],0) }}</h4><span>{{ \Carbon\Carbon::parse( $propertyprices[$property_details->propertycode]['price']['startdate'] )->diffInDays( $propertyprices[$property_details->propertycode]['price']['enddate'] ) }} night total</span></div>
                        <!--<ul class="list-inline">
                            <li><i class="fa fa-star yi"></i> <i class="fa fa-star yi"></i> <i
                                    class="fa fa-star yi"></i> <i class="fa fa-star yi"></i></li>
                            <li><span class="like">21 Reviews &nbsp; </span></li>
                        </ul>
                        <p>Excellent! 4.6/5 - Good for families</p>-->
                        <!--<ul class="list-inline">
                            <li><a href=""><i class="shar"></i> <span>Share<span></a></li>
                            <li><a href=""><i class="save"></i> <span>Save</span></a></li>
                        </ul> <i class="arobox"></i> <span class="arbox">Share</span>-->
                        <div class="chekin">
                            <div class="col-xs-6 col-sm=6 ckin">
                                <h4>Check-in</h4> <span>{!! \Carbon\Carbon::parse($propertyprices[$property_details->propertycode]['price']['startdate'])->format('j M,  D Y') !!}</span></div>
                            <div class="col-xs-6 col-sm=6 ckin ckin2">
                                <h4>Check-out</h4> <span>{!! \Carbon\Carbon::parse($propertyprices[$property_details->propertycode]['price']['enddate'])->format('j M,  D Y') !!}</span></div>
                            <div class="col-xs-12 col-sm=12 ckin3 ">
                                
                                <h4>Guests</h4> <span>{{ $total_guests = Session::get('adult') + Session::get('children')}} guests</span>
                            </div>
                                
                        </div>
                        <ul class="list-inline r-vew">
                            <li>
                                <h5 class="totl">Total</h5><!--<span class="inclds">Includes taxes and<br>fees</span>-->
                            </li>
                            <li class="text-right">
                                <h5 class="totl">€{{ number_format((int)$propertyprices[$property_details->propertycode]['price']['rate'],0)}}</h5> <!--<a href="">View details</a>--></li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="r-btn"><a href="" class=""></a>
                       <form method="POST" action="{{ action('BookingController@bookProperty') }}">
                            <button type="submit" class="btn btn-info blue-btn" data-toggle="modal"
                                    data-target="#myModal1">Book Now
                            </button>
                            <!--<br> <a href="" class="yel-btn">Add to whislist <i class="fa fa-heart"></i></a>-->
                            <input name="propertycode" type="hidden" value="{{ $property_details->propertycode }}"/>
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            </form>
                        </div>
                    </div>
                    @if($property_details->nearest_beach != '' || $property_details->airport_distence != '')
                    <div class="shdborder-l" id="fa-q">
                        @if($property_details->nearest_beach != '')
                        <p><i class="fa fa-caret-right blu-clr"></i>&nbsp;<strong>How far is the nearest beach?</strong>
                        </p> <span>{!! $property_details->nearest_beach !!}</span>
                        @endif
                        
                        @if($property_details->airport_distence != '')
                        <p><i class="fa fa-caret-right blu-clr"></i>&nbsp;<strong>Distence from Airport</strong></p>
                        <span>{!! $property_details->airport_distence !!}</span>
                        @endif
                    </div>
                    @endif
                    <div class="shdborder-l" id="fa-q"><img src="{{asset('images/phone.png')}}" alt=""
                                                            class="img-responsive center-block"> <a href="javascript: void(0)" class="">Book

                            by phone</span></a>
                        <h2>03333 603 973</h2></div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('modal')
      <div class="modal fade" id="myModal" role="dialog">
<div class="modal-dialog">
<form method="POST" action="{{ action('BookingController@bookProperty') }}">
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">×</button>
      <h4 class="modal-title">Holiday Details</h4>
    </div>
    <div class="modal-body">
      <h3>Refine your holiday</h3>
      <div class="ami-box">
        <h4>When</h4><hr>
        <div class="availb-search clearfix" id="amenities">
            <div class="row">
            <div class="col-sm-6">
            <label>Start Date</label>
            <input type="text" class="datepicker2" placeholder="" readonly="true" value="{{\Carbon\Carbon::parse($propertyprices[$property_details->propertycode]['price']['startdate'])->format('d-m-Y')}}"><i class=""></i></div>
            <div class="col-sm-6">
            <label>End Date</label>
            <input type="text" class="datepicker2" placeholder="" readonly="true" value="{{\Carbon\Carbon::parse($propertyprices[$property_details->propertycode]['price']['enddate'])->format('d-m-Y')}}">
            </div>
            </div>
        </div>
        <br><br>
        <h4>Who</h4><hr>
        <div class="availb-search clearfix" id="amenities">
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <label>ROOMS</label>
                    <div class="input-group incr-box ">
                    <div class="incre-decre"> <span class="input-group-btn qnty"> <button type="button" class="btn btn-default btn-number mins" disabled="disabled" data-type="minus" data-field="quant[3]"> <span class="glyphicon glyphicon-minus bt1"></span> </button>
                        </span>
                        <input type="text" name="quant[3]" class="form-control input-number nubrs" value="1" min="1" max="99"> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-number incrs" data-type="plus" data-field="quant[3]"> <span class="glyphicon glyphicon-plus"></span> </button>
                        </span>
                    </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <label>ADULTS</label>
                    <div class="input-group incr-box ">
                    <div class="incre-decre"> <span class="input-group-btn qnty"> <button type="button" class="btn btn-default btn-number mins" disabled="disabled" data-type="minus" data-field="quant[4]"> <span class="glyphicon glyphicon-minus bt1"></span> </button>
                        </span>
                        <input type="text" name="quant[4]" class="form-control input-number nubrs" value="{{Session::get('adult')}}" min="0" max="99"> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-number incrs" data-type="plus" data-field="quant[4]"> <span class="glyphicon glyphicon-plus"></span> </button>
                        </span>
                    </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <label>KIDS</label>
                    <div class="input-group incr-box ">
                    <div class="incre-decre"> <span class="input-group-btn qnty"> <button type="button" class="btn btn-default btn-number mins" disabled="disabled" data-type="minus" data-field="quant[5]"> <span class="glyphicon glyphicon-minus bt1"></span> </button>
                        </span>
                        <input type="text" name="quant[5]" class="form-control input-number nubrs" value="{{ Session::get('children') }}" min="0" max="99"> <span class="input-group-btn"> <button type="button" class="btn btn-default btn-number incrs" data-type="plus" data-field="quant[5]"> <span class="glyphicon glyphicon-plus"></span> </button>
                        </span>
                    </div>
                    </div>
                </div>
                </div>
        </div>

      </div>
    </div>
    <div class="modal-footer">
      <input name="propertycode" type="hidden" value="{{ $property_details->propertycode }}"/>
      <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
      <button type="submit" class="btn btn-default holi-apply">Apply & Continue Booking</button>
    </div>
  </div>
 <!-- Modal content End-->
</form>
</div>
</div>
@endsection
@section('pagespecificscripts')
<script>
$(window).load(function() {
$('.item > img').addClass('img-responsive');
$('#sbar').addClass('vbar');
<!-- Modal -->
    $(".se-pre-con").fadeOut("slow");;
});
(function($) {

    $("#owl-demo").owlCarousel({
        autoPlay: 3000,
        items: 6,
        itemsDesktop: [1199, 4],
        itemsDesktopSmall: [979, 3]
    });
});
</script>
<script type="text/javascript">
$('.datepicker2').datepicker({
   format: 'dd-mm-yyyy'
 });
</script>
 <script type="text/javascript">
        document.body.setAttribute('id', 'ibd');
    </script>
    <script src="{{asset('js/lodash.min.js')}}"></script>
    <script src="{{asset('js/slick.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        const $left = $(".left");
        const $gl = $(".gallery");
        const $gl2 = $(".gallery2");
        const $photosCounterFirstSpan = $(".photos-counter span:nth-child(1)");
        $gl2.on("init", (event, slick) => {
            $photosCounterFirstSpan.text(`${slick.currentSlide + 1}/`);
            $(".photos-counter span:nth-child(2)").text(slick.slideCount);
        });
        $gl.slick({
            rows: 0,
            slidesToShow: 4,
            arrows: false,
            draggable: false,
            useTransform: false,
            mobileFirst: true,
            responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 4
                }
            }, {
                breakpoint: 1023,
                settings: {
                    slidesToShow: 1,
                    vertical: true
                }
            }]
        });
        $gl2.slick({
            rows: 0,
            useTransform: false,
            prevArrow: ".arrow-left",
            nextArrow: ".arrow-right",
            fade: true,
            asNavFor: $gl
        });

        function handleCarouselsHeight() {
            if (window.matchMedia("(min-width: 1024px)").matches) {
                const gl2H = $(".gallery2").height();
                $left.css("height", gl2H);
            } else {
                $left.css("height", "auto");
            }
        }

        $(window).on("load", () => {
            handleCarouselsHeight();
            setTimeout(() => {
                $(".loading").fadeOut();
                $("body").addClass("over-visible");
            }, 300);
        });
        $(window).on("resize", _.debounce(() => {
            handleCarouselsHeight();
        }, 200));
        $(".gallery .item").on("click", function () {
            const index = $(this).attr("data-slick-index");
            $gl2.slick("slickGoTo", index);
        });
        $gl2.on("afterChange", (event, slick, currentSlide) => {
            $photosCounterFirstSpan.text(`${slick.currentSlide + 1}/`);
        });
    });
    </script>

@stop
