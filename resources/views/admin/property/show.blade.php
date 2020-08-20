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
            
      @php //dd($property_details); @endphp
 <!-- title row -->
 <div class="row">
                <div class="col-12">
                  <h4>
                  <p class="lead">Property Code : {{$property_details->propertycode}}</p>
                  <p class="lead">Property Name : {{$property_details->propertyname}}</p> 
                  
                  </h4>
                </div>
                
                <!-- /.col -->
              </div>

              <div class="row">
                <div class="col-12">
                <p class="lead"></p>
                </div>
                <!-- /.col -->
              </div>
              
              <!-- info row -->
              @php
                                            
              //$propertycode = explode("_",$booking_details->propertycode);
              //$PropertyDetails = \App\Models\PropertyDetails::with(['propertyImages','propertyVariables'])->whereIn('propertycode', //$propertycode)->get()->toArray();
              
              @endphp
              
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Property Address : 
                  
                  <address>
                    {{$property_details->propertyaddress}}<br>
                    {{$property_details->regionname}}<br>
                    {{$property_details->country}} - {{$property_details->countryiso}}<br>
                    {{$property_details->propertypostcode}}
                  </address>
                  
                </div>

                <div class="col-sm-4 invoice-col">
                  Property Capacity : 
                  <address>
                    Adults : {{$property_details->adults}}<br>
                    Children : {{$property_details->children}}<br>
                    Sleeps : {{$property_details->sleeps}}<br>
                    Bedrooms : {{$property_details->bedrooms_new }}<br>
                    Bathrooms : {{$property_details->bathrooms_new}}<br>
                    Check-In : {{$property_details->checkin}}<br>
                    Check-Out : {{$property_details->checkout}}<br>
                  </address>
                </div>

                <div class="col-sm-4 invoice-col">
                  Manager Details : 
                  <address>
                    Name : {{$property_details->managername}}<br>
                    Emiail : {{$property_details->manageremail}}<br>
                    
                  </address>
                </div>
                

                
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                <p class="lead">Web Description</p>
                  <div class="col-sm-4 invoice-col">
                    Title : 
                    <address>
                    {!! $property_details->title !!}
                    </address>
                  </div>
                  <div class="col-sm-4 invoice-col">
                    Description : 
                    <address>
                    {!! $property_details->metadescription !!}
                    </address>
                  </div>
                  <div class="col-sm-4 invoice-col">
                    Keywords : 
                    <address>
                    {!! $property_details->metakeywords !!}
                    </address>
                  </div>
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Nearest Beach</th>
                      <th>Airport Distence</th>
                      <th>Cancellation Policy</th>
                      <th>House Rules</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td>{!! $property_details->nearest_beach !!}</td>
                      <td>{!! $property_details->airport_distence !!}</td>
                      <td>{!! $property_details->cancellation_policy !!}</td>
                      @php $hr = explode('_',$property_details->house_rules); @endphp
                      <td>
                      @foreach($hr as $value)
                      <p>{{$value}}</p>
                      @endforeach
                      </td>                      
                    </tr>
                    
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

