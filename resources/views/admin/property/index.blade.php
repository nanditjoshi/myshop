@extends('admin.app')



@section('content')

@include('admin.includes.breadcumb', ['pageTitle' => 'Property List', 'pageSubTitle' => ''])


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
                <h3 class="card-title">{{ __('Property List') }}</h3>
                <!--<div class="box-tools">
                                <a href="{{ url('/houserules/create') }}" class="btn btn-default float-right"><i class="fa fa-add"></i>{{ __('Add House Rules') }}</a>
                            </div>-->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="propertysTable" class="table table-bordered table-hover">
                <thead>
                                <tr>
                                    <!--<th class="nosort">ID</th>-->
                                    <th>Property Code</th>
                                    <th>Property Name</th>
                                    <th>Description</th>
                                    <th>Region Name</th>
                                    <th>Property Address</th>
                                    <th>Sleeps</th>
                                    <th>Updated Date</th>
                                    <th>Property Images</th>
                                    <th class="nosort">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <!--<th>ID</th>-->
                                    <th>Property Code</th>
                                    <th>Property Name</th>
                                    <th>Description</th>
                                    <th>Region Name</th>
                                    <th>Property Address</th>
                                    <th>Sleeps</th>
                                    <th>Updated Date</th>
                                    <th>Property Images</th>
                                    <th></th>
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
            
            $('#propertysTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('admin.propertys.browse') }}',
                    method: 'POST'
                },
                columnDefs: [ {"targets": 'nosort',"orderable": false}],
                columns: [
                    //{"data":"id","name":"id","searchable":false},
                    {"data":"propertycode","name":"propertycode","searchable":true},
                    {"data":"propertyname","name":"propertyname","searchable":true},
                    {"data":"webdescription","name":"webdescription","searchable":false},
                    {"data":"regionname","name":"regionname","searchable":true},
                    {"data":"propertyaddress","name":"propertyaddress","searchable":true},
                    {"data":"sleeps","name":"sleeps","searchable":true},
                    {"data":"updated_at","name":"updated_at","searchable":true},
                    {"data":"property_images","name":"property_images","searchable":false,"orderable": false},
                    {"data":"action","name":"action","searchable":false}
                ],
                initComplete: function () {
                    //cciInitComplete(this.api().columns(), 'propertysTable');
                },
                fnDrawCallback: function () {

                }
            });
        });
    </script>
@endsection
