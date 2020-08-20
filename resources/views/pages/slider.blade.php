    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-pause="true">
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="item active"> <img src="{{asset('images/top/banner-1.jpg') }}" alt="First slide"></div>
            <div class="item"> <img src="{{asset('images/top/banner-2.jpg') }}" alt="Second slide"></div>
            <div class="item"> <img src="{{asset('images/top/banner-3.jpg') }}" alt="Third slide"></div>
        </div> <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
        
        @include('layout.partials.searchbar')

    </div>
    <div class="clearfix"></div>
    <div class="mbt">
        <button type="button" class="btn btn-demo " data-toggle="modal" data-target="#myModal2"></button>
        <button type="button" class="btn btn-demo2" data-toggle="modal" data-target="#myModal2"></button>
    </div>
    <div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel2">Request form</h4>
                </div>
                <div class="modal-body">
                    <form id="request-callback-form">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <div class="form-group">
                            <label for="requestname">Customer Name</label>
                            <input type="text" class="form-control" id="requestname" name="requestname" required>
                        </div>
                        <div class="form-group">
                            <label for="requesttelephone">Telephone</label>
                            <input type="text" class="form-control" id="requesttelephone" name="requesttelephone" required>
                        </div>
                        <div class="form-group">
                            <label for="requestemail">Email</label>
                            <input type="email" class="form-control" id="requestemail" name="requestemail" required>
                        </div>
                        <div class="form-group">
                            <label for="requestcomments">Inquiry</label>
                            <textarea class="form-control" id="requestcomments" name="requestcomments" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-default request-callback">Submit</button>
                        <div class="custom-loader" role="status">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
<style>
    .custom-loader{
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url(../images/Preloader_2.gif) center no-repeat #fff;
        display: none;
    }
</style>
