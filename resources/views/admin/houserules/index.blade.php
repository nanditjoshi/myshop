@extends('admin.app')

@section('content')

@include('admin.includes.breadcumb', ['pageTitle' => 'House Rules', 'pageSubTitle' => ''])


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
                <h3 class="card-title">{{ __('House Rules') }}</h3>
                <div class="box-tools">
                                <a href="{{ url('/houserules/create') }}" class="btn btn-default float-right"><i class="fa fa-add"></i>{{ __('Add House Rules') }}</a>
                            </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="houserulesTable" class="table table-bordered table-hover">
                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Rules</th>
                                    <th class="nosort">Actions</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th></th>
                                    <th>Rules</th>
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
            //alert(1)
            $('#houserulesTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('admin.houserules.browse') }}',
                    method: 'POST'
                },
                columnDefs: [ {"targets": 'nosort',"orderable": false}],
                columns: [
                    {"data":"id","name":"id","searchable":false,"orderable": false},
                    {"data":"rules","name":"rules","searchable":true},
                    {"data":"action","name":"action","searchable":false}
                ],
                initComplete: function () {
                    //cciInitComplete(this.api().columns(), 'houserulesTable');
                },
                fnDrawCallback: function () {

                }
            });
        });
    </script>
@endsection
