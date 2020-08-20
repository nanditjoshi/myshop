<script src="{{asset('js/jquery.js')}}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- <script src="{{asset('js/bootstrap.min.js')}}"></script> -->
<script src="{{asset('js/bootstrap.min2.js')}}"></script>
<script src="{{asset('js/wow.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>

<script>
        $(window).load(function() {
            $(".se-pre-con").fadeOut("slow");;
        });

    </script>

    <script>
        $(window).scroll(function() {
            var sticky = $('.mobile-menu'),
                scroll = $(window).scrollTop();
            if (scroll >= 40) {
                sticky.addClass('fixed');
            } else {
                sticky.removeClass('fixed');
            }
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $('#datetimepicker').datepicker();
        });
        $(document).ready(function() {
            $('#datetimepicker').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });
            $('#datetimepicker').datepicker({
                format: "dd/mm/yyyy"
            }).on('change', function() {
                $('.datepicker').hide();
            });
        });
    </script>

<script type="text/javascript">
    $('.date').datepicker({
       format: 'dd-mm-yyyy',
       startDate: '-0d',
     });
</script>

    <script>
        $('.btn-number').click(function(e) {
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }
                }
            } else {
                input.val(0);
            }
        });
        $('.input-number').focusin(function() {
            $(this).data('oldValue', $(this).val());
        });
        $('.input-number').change(function() {
            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());
            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                $(this).val($(this).data('oldValue'));
            }
        });
        $(".input-number").keydown(function(e) {
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 || (e.keyCode == 65 && e.ctrlKey === true) || (e.keyCode >= 35 && e.keyCode <= 39)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
        function getDestinationList(searchText) {
            $.ajax({
                type:'POST',
                url:'/destinations',
                data:{'_token' : '<?php echo csrf_token() ?>', 'searchText': searchText},
                success:function(data) {
                    var destinationsList = '';
                    if(data != '' && data.data != 'empty') {
                        destinationsList += '<ul class="dest" ><li class="pointer">All Destinations</li>';
                        $.each(data.destinations, function (index, destinations) {
                            destinationsList += '<li class="pointer">';
                            destinationsList += destinations;
                            destinationsList += '</li>';
                        });
                        destinationsList += '</ul>';
                        $('.destinations').html(destinationsList);
                    }else{
                        $('.destinations').html('No match found');
                    }

                    $('.destinations').fadeIn();
                }
            });
        }

        $(document).on('click', '.destinations ul li', function () {
            $('.destinationtext').val($(this).text());
            $('.destinations').fadeOut();
        });
 
        function IsEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

        $('#request-newsletter-form').on('click', function (event) {
            var user_name       =   $('#user_name').val();
            var user_email      =   $('#user_email').val();
            if(user_name == ''){
              alert('Please Enter Name');
              return false;
            }
            if(user_email== ''){
               alert('Please Enter Email');
               return false;
            }
            if (IsEmail(user_email)) {
                $.ajax({
                    type:'POST',
                    url:'/request-newsletter',
                    data:{'_token' : '<?php echo csrf_token() ?>', 'user_name': user_name, 'user_email': user_email},
                    success:function(data) {
                        alert(data.message);
                        $('#nlgModal').modal('toggle');
                    }
                });
            }
            else {
                alert('Please Enter Valid Email');
               return false;
            }
        });

    </script>
