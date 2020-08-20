@extends('admin.app')


@section('content')

@include('admin.includes.breadcumb', ['pageTitle' => 'Edit Property', 'pageSubTitle' => ''])

    
<!-- Main content -->
<section class="content">



      <div class="row">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
            @php //dd($data['houserules']); @endphp
              <h3 class="card-title">{{ $data['property']->propertyname }}</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
             
            </div>

            <div class="card-body">

            <form method="POST" enctype ='multipart/form-data' action="{{ action('Admin\PropertyController@update',[$data['property']->id]) }}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            
              <div class="row">                   
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="propertyname">Property Name</label>
                    <input type="text" name="propertyname" required autofocus class="form-control" value="{{ $data['property']->propertyname }}" />
                  </div>
                </div>
              </div>
              <div class="row">                   
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" required autofocus class="form-control" value="{{ $data['property']->title }}" />
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="metadescription">Meta Description</label>
                    <input type="text" name="metadescription" required autofocus class="form-control" value="{{ $data['property']->metadescription }}" />
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="metakeywords">Meta Keywords</label>
                    <input type="text" name="metakeywords" required autofocus class="form-control" value="{{ $data['property']->metakeywords }}" />
                  </div>
                </div>
              </div>
              <div class="row">                   
                <div class="col-sm-12">
                  <div class="form-group">
                  <label for="webdescription">Web Description</label>
                    <!--<textarea name="webdescription" required autofocus class="form-control" rows="3" placeholder="Web Description...">{{ $data['property']->webdescription }}</textarea>-->
                    <textarea name="webdescription" required autofocus class="textarea" placeholder="Web Description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $data['property']->webdescription }}</textarea>
                    
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="form-group">
                  <label for="cottageweblocation">Cottage Web Location</label>
                    <textarea name="cottageweblocation" required autofocus class="form-control" rows="3" placeholder="Cottage Web Location ...">{{ $data['property']->cottageweblocation }}</textarea>
              
                  </div>
                </div>
              </div>
              <div class="row">                   
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="propertystars">Property Star</label>
                    <input type="number" max="5" min="0" name="propertystars" required autofocus class="form-control" value="{{ $data['property']->propertystars }}" />
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="longitude">Longitude</label>
                    <input type="text" name="longitude" required autofocus class="form-control" value="{{ $data['property']->longitude }}" />
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="latitude">Latitude</label>
                    <input type="text" name="latitude" required autofocus class="form-control" value="{{ $data['property']->latitude }}" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                      <label for="checkin">Checkin</label>
                      <input type="text" name="checkin" required autofocus class="form-control" value="{{ $data['property']->checkin }}" />
                    </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="checkout">Checkout</label>
                    <input type="text" name="checkout" required autofocus class="form-control" value="{{ $data['property']->checkout }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="adults">Adults</label>
                    <input type="number" name="adults" required autofocus class="form-control" value="{{ $data['property']->adults }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="children">Children</label>
                    <input type="number" name="children" required autofocus class="form-control" value="{{ $data['property']->children }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="infants">Infants</label>
                    <input type="number" name="infants" required autofocus class="form-control" value="{{ $data['property']->infants }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="sleeps">Sleeps</label>
                    <input type="number" name="sleeps" required autofocus class="form-control" value="{{ $data['property']->sleeps }}" />
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                      <label for="propertyaddress">Property Address</label>
                      <input type="text" name="propertyaddress" required autofocus class="form-control" value="{{ $data['property']->propertyaddress }}" />
                    </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="regionname">Region Name</label>
                    <input type="text" name="regionname" required autofocus class="form-control" value="{{ $data['property']->regionname }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" name="country" required autofocus class="form-control" value="{{ $data['property']->country }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="countryiso">Country ISO</label>
                    <input type="text" name="countryiso" required autofocus class="form-control" value="{{ $data['property']->countryiso }}" />
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="propertypostcode">Property Post Code</label>
                    <input type="text" name="propertypostcode" required autofocus class="form-control" value="{{ $data['property']->propertypostcode }}" />
                  </div>
                </div>
              </div>
              <div class="row">                   
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="bedrooms_new">Bedrooms New</label>
                    <input type="number" name="bedrooms_new" required autofocus class="form-control" value="{{ $data['property']->bedrooms_new }}" />
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="bathrooms_new">Bathrooms New</label>
                    <input type="number" name="bathrooms_new" required autofocus class="form-control" value="{{ $data['property']->bathrooms_new }}" />
                  </div>
                </div>
                <!--<div class="col-sm-8">
                  <div class="form-group">
                    <label for="deposittype">Deposit Type</label>
                    <input type="text" name="deposittype" required autofocus class="form-control" value="{{ $data['property']->deposittype }}" />
                  </div>
                </div>-->
              </div>
              
              <div class="row">                   
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="siteID">SiteID</label>
                    <input type="text" name="siteID" required autofocus class="form-control" value="{{ $data['property']->siteID }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="ownerID">OwnerID</label>
                    <input type="text" name="ownerID" required autofocus class="form-control" value="{{ $data['property']->ownerID }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="propertyownerID">Property Owner ID</label>
                    <input type="text" name="propertyownerID" required autofocus class="form-control" value="{{ $data['property']->propertyownerID }}" />
                  </div>
                </div>
                <div class="col-sm-2">
                  <div class="form-group">
                    <label for="groupID">GroupID</label>
                    <input type="text" name="groupID" required autofocus class="form-control" value="{{ $data['property']->groupID }}" />
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="propertyminbookingdays">Property Min Booking Days</label>
                    <input type="text" name="propertyminbookingdays" required autofocus class="form-control" value="{{ $data['property']->propertyminbookingdays }}" />
                  </div>
                </div>
                
              </div>
              <div class="row">                   
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="managerID">ManagerID</label>
                    <input type="text" name="managerID" required autofocus class="form-control" value="{{ $data['property']->managerID }}" />
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="managername">Manager Name</label>
                    <input type="text" name="managername" required autofocus class="form-control" value="{{ $data['property']->managername }}" />
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="manageremail">Manager Email</label>
                    <input type="text" name="manageremail" required autofocus class="form-control" value="{{ $data['property']->manageremail }}" />
                  </div>
                </div>
              </div>
                            
              <div class="row">                   
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="first_name">How far is the nearest beach</label>
                    <textarea name="nearest_beach" required autofocus class="form-control" rows="3" placeholder="How far is the nearest beach ...">{{ $data['property']->nearest_beach }}</textarea>
                    <!--<textarea name="nearest_beach" required autofocus class="textarea" placeholder="How far is the nearest beach"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $data['property']->nearest_beach }}</textarea>-->
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="first_name">Distence from Airport</label>
                    <textarea name="airport_distence" required autofocus class="form-control" rows="3" placeholder="Distence from Airport ...">{{ $data['property']->airport_distence }}</textarea>
                    
                    <!--<textarea name="airport_distence" required autofocus class="textarea" placeholder="Distence from Airport"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $data['property']->airport_distence }}</textarea>-->
                
                  </div>
                </div>
              </div>

              <div class="row">                   
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="first_name">Cancellation Policy</label>
                    <textarea name="cancellation_policy" required autofocus class="form-control" rows="3" placeholder="Cancellation Policy ...">{{ $data['property']->cancellation_policy }}</textarea>
                    
                    <!--<textarea name="cancellation_policy" required autofocus class="textarea" placeholder="Cancellation Policy"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $data['property']->cancellation_policy }}</textarea>-->
                  
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="first_name">House Rules</label>
                    @php $hr = explode('_',$data['property']->house_rules); @endphp
                    <select multiple required autofocus class="custom-select" name="house_rules[]" id="house_rules">
                    @foreach($data['houserules'] as $key=>$value)
                      <option @if(in_array($value->rules,$hr)) selected="selected" @endif value="{{$value->rules}}">{{$value->rules}}</option>
                    @endforeach
                    </select>
                
                  </div>
                </div>
              </div>
              <!--<div class="row">                   
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="first_name">File </label>
                    <input type="file" name="images" id="images" required autofocus class="form-control" />
                  
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                   

                  </div>
                </div>
              </div>-->
              
            <div class="col-12">
            <input id="property_id" type="hidden" class="form-control" name="property_id" value="{{ $data['property']->id }}">
            <input id="propertycode" type="hidden" class="form-control" name="propertycode" value="{{ $data['property']->propertycode }}">
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