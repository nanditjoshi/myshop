@extends('admin.app')

@section('content')
    
@include('admin.includes.breadcumb', ['pageTitle' => 'Property Details', 'pageSubTitle' => ''])
<section class="content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Icons</h3>
          </div> <!-- /.card-body -->
          <div class="card-body">
          @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('message') }}
                </div>
                @endif
      @php //dd($property_details); @endphp
 <!-- title row -->
 <div class="row">
                <div class="col-6">
                  <h4>
                  <p class="lead">Property Code : {{$property_details->propertycode}}</p>
                  <p class="lead">Property Name : {{$property_details->propertyname}}</p> 
                  
                  </h4>
                </div>
                
                <div class="col-6">
                  <form method="POST" enctype ='multipart/form-data' action="{{ action('Admin\PropertyController@addimages') }}">
                  @csrf
                  <input type="hidden" name="_method" value="POST">
                    <h4>
                      <p class="lead">Upload Image</p>
                      <label for="File">File </label>
                      <input type="file" name="images[]" id="images" required autofocus class="form-control" multiple/>
                    </h4>
                    <input id="propertycode" type="hidden" class="form-control" name="propertycode" value="{{ $property_details->propertycode }}">
                    <input type="submit" value="Upload Image" class="btn btn-success"> <!-- float-right-->
                  </form>
                </div>
                
                <!-- /.col -->
              </div>

              

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                <p class="lead">Images List</p>
                 
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Property Image</th>
                      <th>Action</th>
                      
                      
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach($property_details->propertyImages as $value)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td> 
                      @php 
                      
                      preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', $value->main, $main); 
                      $foo = array_pop($main);
                      
                      @endphp
                      <a href="{{ $foo }}" target="_balnk">{!! $value->tiny !!}</a></td>
                      <td>
                        <!--<a href="../{{ $value->id }}/delimages" onclick="confFunction({{ $value->id }})">Delete</a>-->
                        <a href="#" data-action-url="../{{ $value->id }}/delimages" onclick="confFunction($(this))">Delete</a>
                        <!--<a href="#" data-action-url="../{{ $value->id }}/delimages" class="btn btn-danger"><i class="fa fa-trash"></i></a>-->
                      </td>
                    </tr>
                    @endforeach
                    
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->


          </div><!-- /.card-body -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
@endsection

