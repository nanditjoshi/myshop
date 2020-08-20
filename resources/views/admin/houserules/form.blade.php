
@extends('admin.app')


@section('content')

@include('admin.includes.breadcumb', ['pageTitle' => 'House Rules', 'pageSubTitle' => ''])

    
<!-- Main content -->
<section class="content">



      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add House Rules</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
             
            </div>

            <div class="card-body">

            <form method="POST" action="{{ action('Admin\HouseRulesController@store')}}">
              @csrf
              <input type="hidden" name="_method" value="POST">
              <div class="form-group col-md-6">
                <label for="Rule">Rule</label>
                <input id="rules" type="text" class="form-control{{ $errors->has('rules') ? ' is-invalid' : '' }}"
                        placeholder="{{ __('Rule') }}" name="rules" value="" required autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                @if ($errors->has('rule'))
                    <span class="invalid-feedback" role="alert"><strong>{{ $errors->first('rules') }}</strong></span>
                @endif
                
              </div>

              
            <div class="col-6">
                <input type="submit" value="{{ __('Create') }}" class="btn btn-success"> <!-- float-right-->
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