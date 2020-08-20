@extends('layout.default')
@section('pagespecificstyles')
  <style>
  #facilities{
      max-height: 300px;
      overflow-y: scroll;
  }
  </style>
@stop
@section('content')

    @include('layout.partials.searchbar')

    <div class="clearfix"></div>
    <section>
        <div class="container">
            <!--  View Alternate Dates start -->
           {{-- <div class="date-colps">
                <div class="panel-group" id="accordion">
                    <div class="panel panel-default">
                        <div class="panel-heading sm-slde-head" role="tab" id="headingTwo">
                            <div class="panel-title"><a role="button" data-toggle="collapse" href="#collapseTwo"
                                                        aria-expanded="true" aria-controls="collapseTwo"
                                                        class="trigger collapsed date-btn"> View Alternate Dates </a>
                            </div>
                        </div>
                        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel"
                             aria-labelledby="headingTwo">
                            <div class="panel-body">
                                <div class="small-slider">
                                    <div class="carousel carousel-showsixmoveone slide" id="carousel123">
                                        <div class="carousel-inner">

                                            <!-- loop for dates ------------------------------------------->
                                            @php
                                                $idate = 0;
                                                $dots = 0;
                                            @endphp
                                            @foreach($alternatedates as $datesKey => $alternatedate)

                                                @if((($idate%6) == 0) )
                                                    @php $cloneditem = 0; @endphp
                                                    <div class="item {{ ($dots == 0)?'active' : '' }} ">
                                                        @php
                                                            $dots++;
                                                        @endphp
                                                @endif
                                                        <div class="col-xs-12 col-sm-4 col-md-2  {{ ($cloneditem != 0)? 'cloneditem-'.$cloneditem : '' }}">
                                                            <a href="javascript: void(0)">
                                                                <div class="sl-cotner"  data-dates="{{ $datesKey }}">
                                                                    <h4>{{ $alternatedate }}</h4>
                                                                    <p>{{ $night }} Nights holidays from</p> <span>€499pp</span></div>
                                                            </a>
                                                        </div>
                                                        @php
                                                            $idate++;
                                                            $cloneditem++;
                                                        @endphp
                                                @if((($idate%6) == 0))
                                                    </div>
                                                @endif


                                            @endforeach
                                        <!-- End loop --------------------------------------------------------->

                                        </div>
                                        <a class="left carousel-control" href="#carousel123" data-slide="prev"><i
                                                class=""><img src="{{asset('images/small-slider/sl-left.png')}}" alt=""
                                                              class=""></i></a>
                                        <a class="right carousel-control" href="#carousel123" data-slide="next"><i
                                                class=""><img src="{{asset('images/small-slider/sl-right.png')}}" alt=""
                                                              class=""></i></a>
                                        <div class="clearfix"></div>
                                        <br>
                                        <br>
                                        <br>
                                        <div class="">
                                            <ol class="carousel-indicators carousel-indicators-numbers">
                                                <li data-target="#carousel123" data-slide-to="0" class="active"></li>
                                                <li data-target="#carousel123" data-slide-to="1" class=""></li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
            <!--  View Alternate Dates end -->
            <div class="row">
                <!--  left Filter bar start -->
                <div class="sda col-md-3 slideInLeft animated" data-wow-delay="0s">
                    <div class="sidebar-nav">
                        <div class="navbar navbar-default" role="navigation">
                            <div class="navbar-header navbg-color">
                                <button type="button" id="sbtn" class="navbar-toggle tgbtn" data-toggle="collapse"
                                        data-target=".sbar"><span class="sr-only">Toggle navigation</span> <span
                                        class="icon-bar"></span> <span class="icon-bar"></span> <span
                                        class="icon-bar"></span></button>
                                <span class="visible-xs navbar-brand">Filter Result</span></div>
                            <div class="sbar navbar-collapse collapse sidebar-navbar-collapse">
                                <div class="active smenutitle ">Filter Result</div>
                                <!-- filters form start -->
                                <form id="filtersform" name="filtersform" type="POST">

                                <div class="collapse-group">
                                    
                                    @foreach($filters as $filters=>$filter)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingThree">
                                            <div class="panel-title"><a role="button" data-toggle="collapse"
                                                                        href="#{{ $filters }}" aria-expanded="true"
                                                                        aria-controls="{{ $filters }}" class="trigger">
                                                    @lang('listing.'.$filters)</a></div>
                                        </div>
                                        @if($filters == 'order_by')
                                        <div id="{{ $filters }}" class="panel-collapse collapse in" role="tabpanel"
                                             aria-labelledby="headingThree">
                                            <div class="panel-body">
                                            @foreach($filter as $filter=>$filter_value)
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" name="order_by" value="{{ $filter_value }}" class="filterapply" > <span
                                                            class="cr"><i class="cr-icon fa fa-circle"></i></span>
                                                        {{ $filter_value }} </label>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                        @elseif($filters == 'propertystars')
                                        <div id="{{ $filters }}" class="panel-collapse collapse in" role="tabpanel"
                                             aria-labelledby="headingThree">
                                            <div class="panel-body">
                                            @php  rsort($filter) @endphp
                                            @foreach($filter as $filter=>$filter_value)
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="propertystars[]" value="{{ $filter_value }}" class="filterapply" > <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                                                        @for($i = 1; $i <= $filter_value; $i++)
                                                            <i class="fa fa-star yi"></i>
                                                        @endfor
                                                        
                                                    </label>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                        @else
                                        @php sort($filter); @endphp
                                        <div class="panel panel-default">
                                            <div id="{{ $filters }}" class="panel-collapse collapse in" role="tabpanel"
                                                aria-labelledby="headingFour">
                                                <div class="panel-body">
                                            @foreach($filter as $filter=>$filter_value)
                                                <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="{{ $filters }}[]"  value="{{ $filter_value }}" class="filterapply" > <span class="cr"><i
                                                                    class="cr-icon fa fa-check"></i></span> {{ $filter_value }} </label>
                                                    </div>
                                            @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                    </div>
                                    @endforeach
                                    <div class="panel panel-default">
                                        <div class="panel-heading" role="tab" id="headingFiv">
                                            <div class="panel-title"><a role="button" data-toggle="collapse"
                                                                        href="#collapseFiv" aria-expanded="true"
                                                                        aria-controls="collapseFiv" class="trigger">
                                                    Search</a></div>
                                        </div>
                                        <div id="collapseFiv" class="panel-collapse collapse in" role="tabpanel"
                                             aria-labelledby="headingFiv">
                                            <div class="panel-body">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="hotelname" name="hotelname"
                                                           placeholder="Hotel Name">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form><!-- filters form ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  left Filter bar end -->

                <div class="col-md-9 pdl" id="table_data">
                
                    <!-- loop start for image list with details -->
                    @include('pages.pagination_data')
                    <!-- End loop for image list with details -->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('pagespecificscripts')
    <script>
        document.body.setAttribute('id', 'ibd');
        $('#sbar').addClass('vbar');


        $(document).on('click', '.pagination li a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetch_data(page);
        });

        $(document).on('click', '.filterapply', function(event){
            //event.preventDefault();
            fetch_data(1);
        });

        $('#hotelname').keypress(function(e) {
            //alert(e.which);
            // Enter pressed?
            if(e.which == 10 || e.which == 13) {
                e.preventDefault();
                fetch_data(1);
                //return false;
            }

        });
        $(document).on('change', 'input[type=radio][name=order_by]', function(event){
            //event.preventDefault();
            fetch_data(1);
        });
        function fetch_data(page)
        {
            $.ajax({
                url:"/fetch_data?page="+page,
                data: $( '#filtersform' ).serialize(),
                success:function(data)
                {
                    $('#table_data').html(data);
                }
            });
        }


        $('.sl-cotner').on('click', function () {
            $('.datepickerinput').val($(this).attr('data-dates'));
            $('.search-property-button').trigger('click');
        });
    </script>

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

@stop
