@extends('layout.default')

@section('pagespecificstyles')

    <!--carousel css-->
    <link href="{{asset('css/carousel.css')}}" rel="stylesheet">

@stop

@section('content')

@include('pages.slider')

<section>
        <div class="container ">
            <h1 class="text-center m_titl ">Popular Destinations</h1>
            <br>
            <br>
            <div class="row">
                <div class="col-md-4 wow flipInY" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: flipInY;">
                    <div class="course-item ">
                        <div class="course-hover"> <img src="{{asset('images/00s.jpg') }}" data-at2x="{{asset('images/00.jpg') }}" alt="">
                            <div class="hover-bg bg-color-1"></div>
                            <a href=""><img src="{{asset('images/top/play.png') }}" alt=""></a>
                        </div>
                        <div class="course-name text-center">
                            <h3>Florida</h3></div>
                    </div>
                    <br>
                </div>
                <div class="col-md-4 wow flipInY" data-wow-delay="0.7s" style="visibility: visible; animation-delay: 0.7s; animation-name: flipInY;">
                    <div class="course-item">
                        <div class="course-hover"> <img src="{{asset('images/01s.jpg') }}" data-at2x="{{asset('images/01.jpg') }}" alt="">
                            <div class="hover-bg bg-color-2"></div>
                            <a href=""><img src="{{asset('images/top/play.png') }}" alt=""></a>
                        </div>
                        <div class="course-name text-center">
                            <h3>Colorado</h3></div>
                    </div>
                    <br>
                </div>
                <div class="col-md-4 wow flipInY" data-wow-delay="0.9s" style="visibility: visible; animation-delay: 0.9s; animation-name: flipInY;">
                    <div class="course-item">
                        <div class="course-hover"> <img src="{{asset('images/02s.jpg') }}" data-at2x="{{asset('images/02.jpg') }}" alt="">
                            <div class="hover-bg bg-color-3"></div>
                            <a href=""><img src="{{asset('images/top/play.png') }}" alt=""></a>
                        </div>
                        <div class="course-name text-center">
                            <h3>Ayia Napa</h3></div>
                    </div>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 wow flipInY" data-wow-delay="0.9s" style="visibility: visible; animation-delay: 0.9s; animation-name: flipInY;">
                    <div class="course-item">
                        <div class="course-hover"> <img src="{{asset('images/03s.jpg') }}" data-at2x="{{asset('images/03.jpg') }}" alt="">
                            <div class="hover-bg bg-color-4"></div>
                            <a href=""><img src="{{asset('images/top/play.png') }}" alt=""></a>
                        </div>
                        <div class="course-name text-center">
                            <h3>Protaras</h3></div>
                    </div>
                    <br>
                </div>
                <div class="col-md-4 wow flipInY" data-wow-delay="1.0s" style="visibility: visible; animation-delay: 1.0s; animation-name: flipInY;">
                    <div class="course-item">
                        <div class="course-hover"> <img src="{{asset('images/04s.jpg') }}" data-at2x="{{asset('images/04.jpg') }}" alt="">
                            <div class="hover-bg bg-color-5"></div>
                            <a href=""><img src="{{asset('images/top/play.png') }}" alt=""></a>
                        </div>
                        <div class="course-name text-center">
                            <h3>Ayia Thekla</h3></div>
                    </div>
                </div>
                <div class="col-md-4 wow flipInY" data-wow-delay="1.1s" style="visibility: visible; animation-delay: 1.1s; animation-name: flipInY;">
                    <div class="course-item">
                        <div class="course-hover"> <img src="{{asset('images/05s.jpg') }}" data-at2x="{{asset('images/05.jpg') }}" alt="">
                            <div class="hover-bg bg-color-6"></div>
                            <a href=""><img src="{{asset('images/top/play.png') }}" alt=""></a>
                        </div>
                        <div class="course-name text-center">
                            <h3>Kapparis</h3></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container ">
            <div class="row">
                <div class="grid-row clear-fix">
                    <div class="grid-col-row">
                        <div class="col-md-12">
                            <br>
                            <h1 class="text-center m_titl">We Recommend</h1>
                            <hr class="line">
                            <br>
                            <h4>Need some inspiration to help choose your perfect villa? Looking for a pool with a view, a villa <br> in the centre of the action, or a property that sleeps a large group? We can recommend villas to suit you. <br> Browse through our villas that have that specific something you're looking for !</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="gallery">
                <div class="gallery-container"> 
				<a href="javascript: void(0)"><img class="gallery-item" src="{{asset('images/top/1.jpg') }}" alt="" /></a>
				<a href="javascript: void(0)"><img class="gallery-item" src="{{asset('images/top/2.jpg') }}" alt="" /></a>
				<a href="javascript: void(0)"><img class="gallery-item" src="{{asset('images/top/3.jpg') }}" alt="" /></a> 
				<a href="javascript: void(0)"><img class="gallery-item" src="{{asset('images/top/4.jpg') }}" alt="" /></a> 
				<a href="javascript: void(0)"><img class="gallery-item" src="{{asset('images/top/5.jpg') }}" alt="" /></a>
				</div>
                <div class="gallery-controls"></div>
            </div>  
        </div>
	</section>
    <section class="our-deal">
        <div class="deal">
            <h1 class="text-center m_titl">Our Deals</h1>
            <hr class="line">
            <h3>Offers Last Minute Villa Holidays</h3>
            <br>
            <br>
            <div class=" row mar-pad">
                <div class="col-sm-3 mr-pd">
                    <div class="thumbnail">
                        <a href="" target="_blank" class="rais"> <img src="{{asset('images/tom-zanetti.jpg') }}" alt="Fjords" style="width:100%">
                            <div class="caption">
                                <p>Cyprus In The Sun Celebrity Villa Tom Zanetti 605 Platinum</p>
                                <h5>€1,525 to €3,995 /week</h5></div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-3 mr-pd">
                    <div class="row mr-pd">
                        <div class="col-sm-12 mr-pd">
                            <div class="thumbnail">
                                <a href="" target="_blank" class="rais"> <img src="{{asset('images/agios.jpg') }}" alt="Fjords" style="width:100%" class="zoom">
                                    <div class="caption">
                                        <p>Cyprus In The Sun Villa Agios 98 Platinum</p>
                                        <h5>€2,139 to €4,695 /week</h5></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mr-pd">
                        <div class="col-sm-12 mr-pd">
                            <div class="thumbnail">
                                <a href="" target="_blank" class="rais"> <img src="{{asset('images/crystal.jpg') }}" alt="Fjords" style="width:100%">
                                    <div class="caption">
                                        <p>Cyprus In The Sun Villa Crystal Springs 1 Platinum</p>
                                        <h5>€3,294 to €4,706 /week</h5></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 mr-pd">
                    <div class="thumbnail">
                        <a href="" target="_blank" class="rais"> <img src="{{asset('images/melissa.jpg') }}" alt="Fjords" style="width:100%">
                            <div class="caption">
                                <p>Cyprus In The Sun Villa Melissa 16 Platinum</p>
                                <h5>€695 to €3,995 /week</h5></div>
                        </a>
                    </div>
                </div>
                <div class="col-sm-3 mr-pd">
                    <div class="row mr-pd">
                        <div class="col-sm-12 mr-pd">
                            <div class="thumbnail">
                                <a href="" target="_blank" class="rais"> <img src="{{asset('images/oliver.jpg') }}" alt="Fjords" style="width:100%">
                                    <div class="caption">
                                        <p>Cyprus In The Sun Celebrity Villa Oliver Proudlock 14 Platinum</p>
                                        <h5>€995 to €2,745 /week</h5></div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mr-pd">
                        <div class="col-sm-12 mr-pd">
                            <div class="thumbnail">
                                <a href="" target="_blank" class="rais"> <img src="{{asset('images/jordan.jpg') }}" alt="Fjords" style="width:100%">
                                    <div class="caption">
                                        <p>Cyprus In The Sun Celebrity Villa Jordan Weekender 9 Platinum</p>
                                        <h5>€995 to €2,555 /week</h5></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-sm-12 "> <a href="" class="dealbtn">View More Deals</a></div>
        </div>
        <div class="clearfix"></div>
    </section>
    <section class="our-villas">
        <div class="villas">
            <h1 class="text-center m_titl">Villas For Sale</h1>
            <hr class="line">
            <br>
            <br>
            <br>
            <div class="col-sm-12 text-right nv-pd">
                <div class=" mar-btm">
                    <div class="container nv-pd ">
					    <div class="col-sm-4">
                            <div class="blur pic"> <img src="{{asset('images/hollyoaks.jpg') }}" alt="" style="width:100%"></div>
                            <div class="top-right"><span>PINE CLIFFS RESORT - ALGARVE<br> UP TO 15% OFF SELECTED DATES</span></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="blur pic"> <img src="{{asset('images/esprit.jpg') }}" alt="" style="width:100%"></div>
                            <div class="top-right"><span>Cyprus In The Sun<br>Esprit Villa 21</span></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="blur pic"> <img src="{{asset('images/zanetti.jpg') }}" alt="" style="width:100%"></div>
                            <div class="top-right"><span>Cyprus In The Sun Celebrity<br>Villa Tom Zanetti 605 Platinum</span></div>
                        </div>
                    </div>
                </div>
                <div class=" mr-pd">
                    <div class="container nv-pd">
                        <div class="col-sm-4">
                            <div class="blur pic"> <img src="{{asset('images/silver-coast.jpg') }}" alt="" style="width:100%"></div>
                            <div class="top-right"><span>PRAIA D'EL REY GOLF & Offer as<br> BEACH RESORT - SILVER COAST<br> UP TO 25% OFF!</span></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="blur pic"> <img src="{{asset('images/aph.jpg') }}" alt="" style="width:100%"></div>
                            <div class="top-right"><span>APHRODITE HILLS - CYPRUS<br> UP TO 20% OFF 2020!</span></div>
                        </div>
                        <div class="col-sm-4">
                            <div class="blur pic"> <img src="{{asset('images/beach-resoart.jpg') }}" alt="" style="width:100%"></div>
                            <div class="top-right"><span>BEACH RESORT - SILVER COAST<br> UP TO 25% OFF!</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
        <br> 
		</section>
		<div class="clearfix"></div>
		<section>
		  <div class="seo">
		      <div class="container">
			     <h4>About Cyprus In The Sun</h4>
				 <p> <span>Cyprus In The Sun</span> is a part of the Hotels2villas Limited and Venture2 Ltd group. We are completely dedicated to offering our clients the very best in customer service and customer experience. In order to achieve this we have worked hard building a rental port folio where all of the properties that are featured on our web site are fully managed professionally.</p>
			  </div>
		  </div>
        </section>
        
        
@endsection


@section('pagespecificscripts')
<script src="{{asset('js/carousel.js')}}"></script>
<script>
        
        (function ($) {
            $("#owl-demo").owlCarousel({
                autoPlay: 3000,
                items: 6,
                itemsDesktop: [1199, 4],
                itemsDesktopSmall: [979, 3]
            });
        });
   
    (function ($) {
        $("#owl-demo").owlCarousel({
            autoPlay: 3000,
            items: 6,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [979, 3]
        });
    });
    $('#request-callback-form').on('submit', function (event) {
        event.preventDefault();
        $('.custom-loader').show();
        $.ajax({
            url:"/request-callback",
            type:'POST',
            data: $( '#request-callback-form' ).serialize(),
            success:function(data)
            {
                $('.custom-loader').hide();
                if(data.success == 'false' || data.success == false){
                    $('#myModal2 .modal-body').append('<br><div class="alert alert-danger alert-dismissible show" role="alert">' +
                        '                        <strong>'+data.error+'</strong>' +
                        '                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '                            <span aria-hidden="true">&times;</span>' +
                        '                        </button>' +
                        '                    </div>');

                }else{
                    $('#myModal2 .modal-body').append('<br><div class="alert alert-success alert-dismissible show" role="alert">' +
                        '                        <strong>'+data.message+'</strong>' +
                        '                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                        '                            <span aria-hidden="true">&times;</span>' +
                        '                        </button>' +
                        '                    </div>');
                }
            }
        });
    });
    
</script>
@stop
