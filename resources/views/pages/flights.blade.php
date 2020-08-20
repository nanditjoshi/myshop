@extends('layout.default')

@section('content')

    @include('layout.partials.searchbar')

    <div class="clearfix"></div>
    <section id="contact">

  <div class="container  ">
    <div class="date-colps">

    <div class="row">
     <div class="col-md-12 pdl">
        <div class="shdborder" >
			<div class="col-sm-12">
				<h4>Flights</h4>
				<p>Search flights</p>
				<div
  data-skyscanner-widget="SearchWidget"
  data-locale="en-GB"
  data-market="GB"
  data-currency="GBP"
  data-button-colour="#fecc00"
></div>
<script src="https://widgets.skyscanner.net/widget-server/js/loader.js" async></script>
			</div>
      </div>


  </div>
  <!-- end of col-md-9 pdl-->
  
  </div>

    </section>
@endsection
@section('pagespecificscripts')
    <script>
        document.body.setAttribute('id', 'ibd');
        $('#sbar').addClass('vbar');

    </script>
    <script src="js/jquery.js"></script> 

<!-- Bootstrap Core JavaScript --> 
<script src="js/bootstrap.min.js"></script> 
<script src="js/wow.min.js"></script> 
<script>//paste this code under the head tag or in a separate js file.
				// Wait for window load
				$(window).load(function() {
					// Animate loader off screen
					$(".se-pre-con").fadeOut("slow");;
				});

				$(document).ready(function() {

			  $("#owl-demo").owlCarousel({

				  autoPlay: 3000, //Set AutoPlay to 3 seconds

				  items : 6,
				  itemsDesktop : [1199,4],
				  itemsDesktopSmall : [979,3]

			  });

			});


				</script> 
<!-- Script --> 

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
<script>
				$(window).scroll(function() {
			  var sticky = $('.mobile-menu'),
				scroll = $(window).scrollTop();

			  if (scroll >= 40) { 
				sticky.addClass('fixed'); }
			  else { 
			   sticky.removeClass('fixed');

			}
			});
			</script> 
<script src="js/carousel.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script> 
<script type="text/javascript">
				$(function () {
					$('#datetimepicker').datepicker();
				});
		
		$(document).ready(function () {
		$('#datetimepicker').datepicker({
			format: "dd/mm/yyyy",
			autoclose: true
		});

		//Alternativ way
		$('#datetimepicker').datepicker({
		  format: "dd/mm/yyyy"
		}).on('change', function(){
			$('.datepicker').hide();
		});

	});
	</script> 
	<script type="text/javascript">
    $('.date').datepicker({
       format: 'dd-mm-yyyy'
     });
</script>
<script>
	$(".open-button").on("click", function() {
	  $(this).closest('.collapse-group').find('.collapse').collapse('show');
	});

	$(".close-button").on("click", function() {
	  $(this).closest('.collapse-group').find('.collapse').collapse('hide');
	});
	</script> 

<!--small carousal--> 
<!-- increase decrease -->
<script>
//plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
</script>

@stop
