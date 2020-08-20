@extends('admin.app')


@section('content')

@include('admin.includes.breadcumb', ['pageTitle' => 'Booking List', 'pageSubTitle' => ''])


<!-- Main content -->
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

          @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('message') }}
                </div>
                @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">{{ __('Booking List') }}</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="bookingsTable" class="table table-bordered table-hover">
                <thead>
                                <tr>
                                    <!--<th>#</th>-->
                                    <th>Site Booking ID</th>
                                    <th>Booked Property Code</th>
                                    <th>Booking Date</th>
                                    <th>Check-in Date</th>
                                    <th>Nights</th>
                                    <th>View</th>
                                    <!--<th class="nosort">Actions</th>-->
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <!--<th></th>-->
                                    <th>Site Booking ID</th>
                                    <th>Booked Property Code</th>
                                    <th>Booking Date</th>
                                    <th>Check-in Date</th>
                                    <th>Nights</th>
                                    <th>View</th>
                                    <!--<th></th>-->
                                </tr>
                                </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    
@endsection


@section('footer-script')
    <script>
        $(document).ready( function () {
            
            $('#bookingsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('admin.bookings.browse') }}',
                    method: 'POST'
                },
                columnDefs: [ {"targets": 'nosort',"orderable": false,"searchable":false}],
                columns: [
                    //{"data":"id","name":"id","orderable": false},
                    {"data":"userid","name":"userid"},
                    {"data":"propertycode","name":"propertycode"},
                    {"data":"created_at","name":"created_at"},
                    {"data":"startdate","name":"startdate"},
                    {"data":"nofonights","name":"nofonights"},
                    {"data":"passenger","name":"passenger","orderable": false,"searchable":false},
                    //{"data":"action","name":"action"}
                ],
                initComplete: function () {
                    //cciInitComplete(this.api().columns(), 'bookingsTable');
                },
                fnDrawCallback: function () {

                }
            });
        });
    </script>
@endsection
