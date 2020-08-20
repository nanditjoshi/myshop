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
                        @php 
                            $property_count =   count($property_details);  
                            $bedrooms_new = $sleeps = $star = 0;
                            for($i=0;$i < $property_count;$i++)
                            {
                                $bedrooms_new   +=  $property_details[$i]->bedrooms_new;
                                $sleeps         +=  $property_details[$i]->sleeps;
                                $star           +=  $property_details[$i]->propertystars;
                            }
                            $star = $star/$property_count;
                            $vp_name = $property_details[0]->propertyname.'--'.$property_details[0]->id.'-'.$property_details[1]->propertycode;
                            session()->put('vp_name',$vp_name);
                        @endphp
                        <!--<h4>{{$property_details[0]->propertyname}}--{{$property_details[0]->id}}-{{$property_details[1]->propertycode}}</h4>-->
                        <h4>{{ Session::get('vp_name') }}</h4>
                        <h5>
                            <en>{{$property_details[0]->propertyaddress}}</en>
                        </h5>
                        <span class="">
                            {{$bedrooms_new}} Bedrooms, Sleeps up to {{$sleeps}}
                            
                            @php if($star >= 5)
                                { $star = 5; }
                            else
                                { $star = $star; }
                             @endphp
                            
                            @for($i=0;$i < $star;$i++)
                            <i class="fa fa-star yi"></i>
                            @endfor
                        </span>
                        <div class="clearfix"></div>
                        
                        <div class="synch-carousels">
                            <div class="left child">
                                 <!-- loop for thumb multiple images -->
                                <div class="gallery">
                                @for($i=0;$i < $property_count;$i++)
                                    @foreach($property_details[$i]->propertyImages as $image)
                                        <div class="item">
                                        {!! $image->thumb !!}
                                        </div>
                                    @endforeach
                                @endfor
                                </div>
                                <!-- End thumb loop -->
                            </div>
                            <div class="right child">
                                <!-- loop for main multiple images -->
                                <div class="gallery2">
                                @for($i=0;$i < $property_count;$i++)
                                    @foreach($property_details[$i]->propertyImages as $image)
                                        <div class="item">
                                        {!! $image->main !!}
                                        </div>
                                    @endforeach
                                @endfor
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
                            @for($i=0;$i < $property_count;$i++)
                                <p>{!! $property_details[$i]->webdescription !!}</p>
                            @endfor
                            
                        </div>
                        
                    </div>
                    <div class="shdborder-l pd-l-o">
                        <div class="col-sm-12 pdl" id="amenities">
                            <h4>Amenities</h4>
                            <ul class="amenities clearfix style1">

                                <!-- Loop for aminities if applicable ---------------------------------------->
                                @php $variablesArr = [];  @endphp
                                @for($i=0;$i < $property_count;$i++)
                                    @php @endphp
                                    @foreach($property_details[$i]->propertyVariables as $variables)
                                    @php
                                        if(!in_array($variables->varcatname,$variablesArr))
                                            $variablesArr[]    = $variables->varcatname;
                                    @endphp
                                    @endforeach
                                @endfor 
                                
                                @foreach($variablesArr as $value)   
                                    @if($value == 'Bathrooms')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-tub"></i>Bathrooms</div>
                                    </li>
                                    
                                    @elseif($value == 'Bedrooms')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-bdrom"></i>Bedrooms</div>
                                    </li>
                                    
                                    @elseif($value == 'Indoor Facilities')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-washing"></i>Indoor Facilities
                                        </div>
                                    </li>
                                    
                                    @elseif($value == 'Outdoor Facilities')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-outdoor"></i>Outdoor Facilities
                                        </div>
                                    </li>
                                    
                                    @elseif($value == 'General Facilities')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-kitchen"></i>General Facilities
                                        </div>
                                    </li>
                                    
                                    @elseif($value == 'Local Activities')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-gitar"></i>Local Activities</div>
                                    </li>
                                    
                                    @elseif($value == 'Services')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-services"></i>Services</div>
                                    </li>
                                    
                                    @elseif($value == 'Cooling & Heating')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-own"></i>Cooling & Heating</div>
                                    </li>
                                    
                                    @elseif($value == 'Spa and Pool Facilities')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-swimer"></i>Spa and Pool Facilities
                                        </div>
                                    </li>
                                    
                                    @elseif($value == 'Leisure and Games')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-games"></i>Leisure and Games</div>
                                    </li>
                                    
                                    @elseif($value == 'Category')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-award"></i>Category</div>
                                    </li>
                                    
                                    @elseif($value == 'Wi-fi')
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-wi-fi"></i>Wi-fi available</div>
                                    </li>
                                   @else
                                    <li class="col-md-4 col-sm-6">
                                        <div class="icon-box style1"><i class="soap-icon-wi-fidfd"></i>{{$value}}</div>
                                    </li>
                                    @endif
                                @endforeach
                                <!-- End loop ---------------------------------------------------------------------------------->
                            </ul>
                        </div>
                    </div>
                    
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
                                        
                                        <iframe src="https://maps.google.com/maps?q={{$property_details[0]->latitude }}, {{$property_details[0]->longitude }}&z=15&output=embed" width="360" height="270" frameborder="0" style="border:0"></iframe>
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
                                    <div class="gre-tab"><i class="flowr"></i><span>Check In : <en>{{$property_details[0]->checkin}}</en></span><span>Check out: <en>{{$property_details[0]->checkout}}</en></span>
                                    </div>
                                    <div class="gre-tab"><i class="flowr"></i><span>Maximum guest {{$property_details[0]->sleeps + $property_details[1]->sleeps}}</span></div>
                                    @php $hr = explode('_',$property_details[0]->house_rules); @endphp
                                    @foreach($hr as $value)
                                    <div class="gre-tab"><i class="flowr"></i><span>{{$value}}</span></div>
                                    @endforeach
                                    <!-- End loop ------------------------------------------------------------------------------>
                                </div>
                            </div>
                            <div class="col-sm-6 map">
                                <h4>Cancellation Policy</h4>
                                <div class="hotel-type">
                                    <p>All cancellations must be submitted to Cyprus In The Sun in writing, either by
                                        email or by post and will be considered effective from the date of receipt by
                                        us.
                                        You may cancel your booking at any time; however, a cancellation fee will apply
                                        as follows:<br><br>30% Deposit if more than 10 weeks before the arrival date.
                                        Between 6 to 10 weeks before arrival: 50% of rental cost. Less than 6 weeks
                                        before arrival: 100% of rental cost. Travel Insurance is strongly
                                        recommended.​Cancellation by Property Owners The property owner reserves the
                                        right to cancel any reservation. In this unlikely event, you will be offered the
                                        option of renting another property (subject to availability) with the price
                                        difference payable/refundable as appropriate or a full refund. Cyprus In The Sun
                                        will not pay any compensation.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
                <div class="col-md-3 slideInLeft animated" data-wow-delay="0s" id="right-pnl">
                    <div class="shdborder-l">
                        <div class="dark-st">
                            @php

                            $total_guests = Session::get('adult') + Session::get('children');    
                            $date        =   Session::get('date');
                            $night       =   Session::get('night');
                            
                            foreach($property_details as $k => $v)
                            {
                                $parr[] = $v->propertycode;

                            }  
                                        
                            $price = App\Http\Controllers\PropertyController::getPrice($date,$night,$parr);
                            //http://api.supercontrol.co.uk/xml/get_price.asp?siteid=40908&id=545278&startdate=2020-07-24&numbernights=7;
                            
                            $discount = (int)0;
                            $rate = (int)$price;
                            
                            @endphp
                            <h4>{{-- $propertyprices[$property_details->propertycode]['price']['@attributes']['currency'] --}} 
                            €{{ number_format((int)$rate,0) }}</h4>
                            <span>{{ Session::get('night') }} night total</span></div>
                      
                        <div class="chekin">
                            <div class="col-xs-6 col-sm=6 ckin">
                                <h4>Check-in</h4> <span>{!! \Carbon\Carbon::parse(Session::get('date'))->format('j M,  D Y') !!}
                                </span></div>
                            <div class="col-xs-6 col-sm=6 ckin ckin2">
                                <h4>Check-out</h4> <span>{!! \Carbon\Carbon::parse( Session::get('date'))->addDay(Session::get('night'))->format('j M,  D Y') !!}</span></div>
                            <div class="col-xs-12 col-sm=12 ckin3 ">
                                
                                <h4>Guests</h4> <span>{{ $total_guests = Session::get('adult') + Session::get('children')}} guests</span>
                            </div>
                                
                        </div>
                        <ul class="list-inline r-vew">
                            <li>
                                <h5 class="totl">Total</h5><!--<span class="inclds">Includes taxes and<br>fees</span>-->
                            </li>
                            <li class="text-right">
                                <h5 class="totl">€{{ number_format((int)$rate,0)}}</h5> <!--<a href="">View details</a>--></li>
                        </ul>
                        <div class="clearfix"></div>
                        <div class="r-btn"><a href="" class=""></a>
                       <form method="POST" action="{{ action('BookingController@bookProperty') }}">
                            <button type="submit" class="btn btn-info blue-btn" data-toggle="modal"
                                    data-target="#myModal1">Book Now
                            </button>
                            <!--<br> <a href="" class="yel-btn">Add to whislist <i class="fa fa-heart"></i></a>-->
                            <input name="propertycode" type="hidden" value="{{ implode('_',$parr) }}"/>
                            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                            </form>
                        </div>
                    </div>
                    <div class="shdborder-l" id="fa-q">
                        <p><i class="fa fa-caret-right blu-clr"></i>&nbsp;<strong>How far is the nearest beach?</strong>
                        </p> <span>The Corel Beach is 50m from the beach</span>
                        <br>
                        <p><i class="fa fa-caret-right blu-clr"></i>&nbsp;<strong>Distence from Airport</strong></p>
                        <span>The Corel Beach is 28km from Paphos International Airport.</span></div>
                    <div class="shdborder-l" id="fa-q"><img src="{{asset('images/phone.png')}}" alt=""
                                                            class="img-responsive center-block"> <a href="" class="">Book

                            by phone</span></a>
                        <h2>03333 603 973</h2></div>
                </div>
            </div>
        </div>
    </section>
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
