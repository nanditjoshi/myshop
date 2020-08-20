@extends('admin.app')

@section('content')

@include('admin.includes.breadcumb', ['pageTitle' => 'Edit User', 'pageSubTitle' => ''])

    
<!-- Main content -->
<section class="content">



      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">{{ $data['user']->name }}</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>

            <div class="card-body">

            <form method="POST" action="{{ action('Admin\UserController@update',[$data['user']->id]) }}">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
              <div class="form-group col-md-6">
                <label for="first_name">First Name</label>
                <input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                        placeholder="{{ __('First Name') }}" name="first_name" value="{{ $data['user']->name }}" required autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('first_name'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('first_name') }}</strong></span>
                @endif
              </div>

              
            <div class="col-12">
                <input id="user_id" type="hidden" class="form-control" name="user_id" value="{{ $data['user']->id }}">
                <input type="submit" value="Update" class="btn btn-success"> <!-- float-right-->
            </div>
        

                </form>
              
            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->
        </div>
      </div>
      

     
    </section>
    <!-- /.content -->
@endsection



