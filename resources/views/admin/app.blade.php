<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ asset("/admin/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css") }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("/admin/bower_components/admin-lte/dist/css/adminlte.min.css") }}">

  <link href="{{ asset('/admin/bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ asset('/admin/bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('/admin/bower_components/admin-lte/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  @include('admin.includes.header')

  

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    
    <a href="#" class="brand-link">
      <img src="{{asset('images/top/logo.png') }}" class="brand-image img-circle elevation-3" alt="{{ config('app.name') }}" style="opacity: .8">
      <br><span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="https://via.placeholder.com/150" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <!-- Left side column. contains the logo and sidebar -->
          @if(auth()->user()->name == 'Nandit')
          <li class="nav-item">
            <a href="{{ url('/dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>{{ __('Dashboard') }}</p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="{{ url('/users') }}" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>{{ __('Users') }}</p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{ url('/bookings') }}" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>{{ __('Booking List') }}</p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{ url('/property') }}" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>{{ __('Property List') }}</p>
            </a>
          </li>                  

                    
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('admin.includes.delete-modal')
  @include('admin.includes.footer')
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset("/admin/bower_components/admin-lte/plugins/jquery/jquery.min.js") }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset("/admin/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

<!-- DataTables -->
<script src="{{ asset('/admin/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin/bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/admin/bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/admin/bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset("/admin/bower_components/admin-lte/dist/js/adminlte.min.js") }}"></script>

<script type="text/javascript">
    function confFunction(ele) {
      if (confirm("Are you sure you want to delete!")) {
        window.location.href = ele.attr('data-action-url');
      } else {
        return false;
      }
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        }
    });
    function cciInitComplete($columns, $id) {
        var colCount = $columns[0].length;
        $columns.every(function () {
            var column = this;
            if (column.index() != 0 && column.index() != colCount-1)  {
                if(column.dataSrc() == 'role_id'){
                    var input = drawSelect('Role', $roles);
                } else {
                    var input = '<input type="text" class="form-control">';
                }

                $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        column.search($(this).val()).draw();
                });
            }
        });
        $('.paginate_button').addClass("btn btn-primary");
        $(`#${$id} thead`).append($(`#${$id}  tfoot tr`));
        $(`#${$id} tfoot`).hide();

    }

    function drawSelect($title, $options) {
        $select = '<select class="form-control">';
        $select += '<option value="">'+$title+'</option>';
        $.each($.parseJSON($options), function(key,value) {
            $select += '<option value="'+key+'">'+value+'</option>';
        });
        $select += '</select>';
        return $select;
    }

    $(document).ready( function () {
        $(document).on('click', '.action-delete', function(e){
            $('#modalDanger #deleteUrl').val($(this).data('action-url'));
            $('#modalDanger').modal('show');
        });

        $(document).on('click', '.btn-confirm-delete', function () {
            /*console.log($('#deleteUrl').val())*/
            $.ajax({
                url: $('#deleteUrl').val(),
                type: 'delete',
                success: function (data) {
                    alert(data.data);
                    $('#modalDanger').modal('hide');
                    window.location.reload();
                },
                error: function (data) {
                    alert('Something went wrong, please try again!!');
                    $('#modalDanger').modal('hide');
                }
            });
        });

        $('#modalDanger').on('hidden.bs.modal', function () {
            $('#modalDanger #deleteUrl').val('');
        })
    });

</script>
    <!-- Summernote -->
    <script src="{{ asset('/admin/bower_components/admin-lte/plugins/summernote/summernote-bs4.min.js') }}"></script>

<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
<!-- page script -->
@yield('footer-script')

</body>
</html>
