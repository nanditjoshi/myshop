@extends('layout.default')

@section('content')

    @include('layout.partials.searchbar')
<section  id="contact">
 <div class="container">
    <div class="row">
	<div class=" col-sm-12 col-sm-12 wow fadeInLeftBig animated shdborder-l term-condition ">
	<h4>Page not found - 404</h4>

	<P style="margin:0px;">Looks like this page is missing. Don't worry though, our best man is on the case.</p>
	</div>
	</div>
 </div>
</section>
@endsection
@section('pagespecificscripts')
    <script>
        document.body.setAttribute('id', 'ibd');
        $('#sbar').addClass('vbar');

    </script>

@stop
