@if(count($property_list)>0)
                        @php $pagination = $property_list->links(); @endphp
                        @foreach($property_list as $property_list=>$property)
                            <div class="shdborder">
                                <div class="col-sm-7">
                                    <div class="carousel slide article-slide" id="article-photo-carousel{{ $property->id }}">
                                        <div class="carousel-inner cont-slider">
                                            <div class="item active">
                                                @if(count($property->propertyImages) > 0)
                                                    {!! $property->propertyImages[0]->main !!}
                                                @else
                                                    <img alt="" title="" src="images/small-slider/2/sl-01.jpg"
                                                         class="img-responsive">
                                                @endif
                                            </div>
                                            @for($j=1; $j < count($property->propertyImages); $j++)

                                                <div class="item">
                                                    {!! $property->propertyImages[$j]->main !!}
                                                </div>
                                            @endfor
                                        </div>
                                        <a class="left carousel-control" href="#article-photo-carousel{{ $property->id }}"
                                           data-slide="prev"> <span
                                                class="glyphicon glyphicon-chevron-left"></span> <span
                                                class="sr-only">Previous</span> </a>
                                        <a class="right carousel-control" href="#article-photo-carousel{{ $property->id }}"
                                           data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right"></span> <span
                                                class="sr-only">Next</span> </a>
                                        <ol class="carousel-indicators">
                                            {{--<li class="active" data-slide-to="0" data-target="#article-photo-carousel{{ $property->id }}">
                                                @if(count($property->propertyImages) > 0)
                                                    {!! $property->propertyImages[0]->tiny !!}
                                                @else
                                                    <img
                                                        alt="" title=""
                                                        src="{{asset('images/small-slider/2/th-01.jpg')}}"
                                                        class="img-responsive">
                                                @endif
                                            </li>--}}
                                            @php $i = 0; @endphp
                                            @foreach($property->propertyImages as $image)
                                                
                                                <li class="tiny" data-slide-to="{{ $i }}" data-target="#article-photo-carousel{{ $property->id }}">
                                                    {!! $image->tiny !!}

                                                    {{--<img alt="" title="" src="{{asset('images/small-slider/2/th-02.jpg')}}" class="img-responsive">--}}
                                                </li>
                                                @php $i++; @endphp
                                            @endforeach
                                            
                                        </ol>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-5 pdl">
                                    <h4>{{$property->propertyname}}</h4>
                                    <ul class="list-inline">
                                       <!-- <li class="dottd"><img src="{{asset('images/icon/i1.png')}}" alt="" class="">Indoor Facilities
                                        </li>
                                        <li class="dottd"><img src="{{asset('images/icon/i2.png')}}" alt="" class="">
Spa and Pool Facilities

                                        </li>
                                        <li class="dottd"><img src="{{asset('images/icon/i3.png')}}" alt="" class="">Bedrooms
                                        </li>
                                        <li class="dottd"><img src="{{asset('images/icon/i4.png')}}" alt="" class="">
                                        </li>
                                        <li class="dottd"><img src="{{asset('images/icon/i5.png')}}" alt="" class="">
Cooling & Heating

                                        </li>
                                        <li class="dottd"><img src="{{asset('images/icon/i6.png')}}" alt="" class="">
General Facilities

                                        </li>
                                        <li class="dottd"><img src="{{asset('images/icon/i7.png')}}" alt="" class="">Bathrooms
                                        </li>
                                        <li class="dottd"><img src="{{asset('images/icon/i8.png')}}" alt="" class="">
Wi-fi available

                                        </li>-->
                                        @foreach($property->propertyVariables as $variables)
                                        

                                        @if($variables->varcatname == 'Indoor Facilities')
                                            <li class="dottd"><img src="{{asset('images/icon/i1.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables->varcatname == 'Spa and Pool Facilities')
                                            <li class="dottd"><img src="{{asset('images/icon/i2.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables->varcatname == 'Bedrooms')
                                            <li class="dottd"><img src="{{asset('images/icon/i3.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables->varcatname == 'Cooling & Heating')
                                            <li class="dottd"><img src="{{asset('images/icon/i5.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables->varcatname == 'General Facilities')
                                            <li class="dottd"><img src="{{asset('images/icon/i6.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables->varcatname == 'Bathrooms')
                                            <li class="dottd"><img src="{{asset('images/icon/i7.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables->varcatname == 'Wi-fi available')
                                            <li class="dottd"><img src="{{asset('images/icon/i8.png')}}" alt="" class=""></li>
                                        @endif
                                        
                                        @endforeach
                                    </ul>
                                    <p>{{ Str::limit($property->webdescription, 100) }}</p>
                                    <ul class="list-inline">
                                        <!--<li><span class="sortlist">Shortlist &nbsp <i class="fa fa-heart-o"></i></span></li>-->
                                        <li>
                                            @php if($property->propertystars >= 5){ $star = 5; }else{ $star = $property->propertystars; } @endphp
                                            @for($i=0;$i< $star;$i++)
                                                <i class="fa fa-star yi"></i>
                                            @endfor
                                        </li>
                                    </ul>
                                    <div class="adbox">
                                        @php

                                        $total_guests = Session::get('adult') + Session::get('children');    
                                        $discount = (int)$propertyprices[$property->propertycode]['price']['discount'];
                                        $rate = (int)$propertyprices[$property->propertycode]['price']['rate'];
                                        
                                        @endphp 
                                        <div class="col-xs-6 col-sm=6 bdr">
                                            @if($discount > '0.00')
                                            <h2>{{ number_format($discount,0)}}</h2>
                                            @endif
                                            <h3>€{{ number_format($rate/$total_guests,0)}}pp</h3></div>
                                        <div class="col-xs-6 col-sm=6 rgt" class="">
                                            <h3>Total Price<br><br>
                                                <!--OFFER ENDS SOON<br> Was €<del>2,334</del>€1,838-->
                                                €{{ number_format($rate,0) }}
                                            </h3>
                                            <!--<span><i class="fa fa-calendar"></i> &nbsp; SAT 29 FEB 2020, 7 NIGHT</span>-->
                                        </div>
                                    </div>
                                    <div class="more-detail"><a
                                            href="{{ route('property.details',$property->propertycode)}}">More
                                            Details</a></div>
                                </div>
                            </div>
                        @endforeach

                    <!-- paganation div start -->
                    <div class="pagtn">
                        
                            {{ $pagination }}
                        
                    </div>
                    <!-- paganation div end -->    
                        
                    @else
                    <div class="shdborder">
                        <span> No Result Found !</span>
                    </div>                    
                    @endif


<script type="text/javascript">
$(document).ready(function(){
    $('.item > img').addClass('img-responsive');
    $('.tiny > img').addClass('img-responsive');
    $(".cont-slider").each(function() {
        if($(this).children('.item').length == 1){
            $(this).children('.item').children('img').attr('style', 'max-height: 345px;');
        }
    });
});
</script>