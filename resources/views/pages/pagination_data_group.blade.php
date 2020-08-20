@if(count($property_list)>0)
                        @php $pagination = $property_list->links(); @endphp
                        @foreach($property_list as $property_list=>$property)
                            <div class="shdborder">
                                <div class="col-sm-7">
                                    <div class="carousel slide article-slide" id="article-photo-carousel{{ $property->propertycode }}{{ $property->bpropertycode }}">
                                        <div class="carousel-inner cont-slider">
                                            <div class="item active">
                                            @php
                                            
                                            $PropertyDetails = \App\Models\PropertyDetails::with(['propertyImages','propertyVariables'])->where('propertycode', $property->propertycode)->get()->toArray();
                                            //dd($PropertyDetails[0]['property_images'][0]['main']);
                                            //dd($PropertyDetails[0]property_variables);
                                            
                                            @endphp

                                                @if(count($PropertyDetails[0]['property_images']) > 0)
                                                    {!! $PropertyDetails[0]['property_images'][0]['main'] !!}
                                                @else
                                                    <img alt="" title="" src="images/small-slider/2/sl-01.jpg"
                                                         class="img-responsive">
                                                @endif
                                            </div>
                                            @for($j=1; $j < count($PropertyDetails[0]['property_images']); $j++)
                                                <div class="item">
                                                    {!! $PropertyDetails[0]['property_images'][$j]['main'] !!}
                                                </div>
                                            @endfor
                                        </div>
                                        <a class="left carousel-control" href="#article-photo-carousel{{ $property->propertycode }}{{ $property->bpropertycode }}"
                                           data-slide="prev"> <span
                                                class="glyphicon glyphicon-chevron-left"></span> <span
                                                class="sr-only">Previous</span> </a>
                                        <a class="right carousel-control" href="#article-photo-carousel{{ $property->propertycode }}{{ $property->bpropertycode }}"
                                           data-slide="next">
                                            <span class="glyphicon glyphicon-chevron-right"></span> <span
                                                class="sr-only">Next</span> </a>
                                        <ol class="carousel-indicators">
                                            @php $i = 0; @endphp
                                            @foreach($PropertyDetails[0]['property_images'] as $image)
                                                <li class="tiny" data-slide-to="{{ $i }}" data-target="#article-photo-carousel{{ $property->propertycode }}{{ $property->bpropertycode }}">
                                                    {!! $image['tiny'] !!}
                                                </li>
                                                @php $i++; @endphp
                                            @endforeach
                                        </ol>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-sm-5 pdl">
                                        @php if($query_for == 2){ @endphp
                                            <h4>{{$property->propertyname}}--{{$property->id}}-{{$property->bpropertycode}}</h4>
                                        @php }else{ @endphp
                                            <h4>{{$property->propertyname}}--{{$property->id}}-{{$property->bpropertycode}}-{{$property->cpropertycode}}</h4>
                                        @php } @endphp
                                    
                                    
                                    <ul class="list-inline">
                                       
                                        @foreach($PropertyDetails[0]['property_variables'] as $variables)
                                        

                                        @if($variables['varcatname'] == 'Indoor Facilities')
                                            <li class="dottd"><img src="{{asset('images/icon/i1.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables['varcatname'] == 'Spa and Pool Facilities')
                                            <li class="dottd"><img src="{{asset('images/icon/i2.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables['varcatname'] == 'Bedrooms')
                                            <li class="dottd"><img src="{{asset('images/icon/i3.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables['varcatname'] == 'Cooling & Heating')
                                            <li class="dottd"><img src="{{asset('images/icon/i5.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables['varcatname'] == 'General Facilities')
                                            <li class="dottd"><img src="{{asset('images/icon/i6.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables['varcatname'] == 'Bathrooms')
                                            <li class="dottd"><img src="{{asset('images/icon/i7.png')}}" alt="" class=""></li>
                                        @endif
                                        @if($variables['varcatname'] == 'Wi-fi available')
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
                                        $date        =   Session::get('date');
                                        $night       =   Session::get('night');
                                        
                                        //$pgroupcode  =   $property->propertycode.'_'.$property->bpropertycode;
                                        //$discount = (int)$propertyprices[$property->propertycode]['price']['discount'];
                                        //$rate = (int)$propertyprices[$property->propertycode]['price']['rate'];
                                        if($query_for == 2){
                                            $parr   =   array($property->propertycode,$property->bpropertycode);
                                        }else{
                                            $parr   =   array($property->propertycode,$property->bpropertycode,$property->cpropertycode);
                                        }
                                        
                                        $price = App\Http\Controllers\PropertyController::getPrice($date,$night,$parr);
                                        //http://api.supercontrol.co.uk/xml/get_price.asp?siteid=40908&id=545278&startdate=2020-07-24&numbernights=7;
                                        
                                        $discount = (int)0;
                                        $rate = (int)$price;
                                        
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
                                            href="{{ route('property.detailsgroup',implode('_',$parr))}}">More
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