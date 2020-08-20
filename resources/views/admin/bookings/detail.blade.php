@extends('admin.app')

@section('content')
    
@include('admin.includes.breadcumb', ['pageTitle' => 'Booking Details', 'pageSubTitle' => ''])
<section class="content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
          <div class="card-header">
            <h3 class="card-title">Icons</h3>
          </div> <!-- /.card-body -->
          <div class="card-body">
            

 <!-- title row -->
 <div class="row">
                <div class="col-12">
                  <h4>
                  <p class="lead">Site Booking Confirmation: CITS{{$booking_details->id}}</p>
                  <p class="lead">Booking Confirmation: {{$booking_details->bookingID}}</p> 
                  <small class="float-right">Booking Date: {{ Helpers::siteDateFormate($booking_details->created_at) }} </small>
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
                                            
              $propertycode = explode("_",$booking_details->propertycode);
              $PropertyDetails = \App\Models\PropertyDetails::with(['propertyImages','propertyVariables'])->whereIn('propertycode', $propertycode)->get()->toArray();
              
              @endphp
              
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <b>Accommodation : </b>
                  @foreach($PropertyDetails as $key => $val)
                  <address>
                    {{$val['propertyname']}}<br>
                    {{$val['propertyaddress']}}<br>
                    {{$val['regionname']}}<br>
                    {{$val['country']}}
                  </address>
                  @endforeach
                </div>

                <div class="col-sm-4 invoice-col">
                <b>Holiday Details : </b>
                  <address>
                    Check-in : {{ Helpers::siteDateFormate($booking_details->startdate) }}<br>
                    Check-out : {{ Helpers::siteDateFormate($booking_details->enddate) }}<br>
                    Passengers : {{$booking_details->adults + $booking_details->children }}<br>
                    Duration : {{$booking_details->nofonights}} Nights
                  </address>
                </div>
                @if($booking_details->transfer == '1')
                <div class="col-sm-4 invoice-col">
                <b>Transfers Details: </b>
                  <address>
                    From : {{$booking_details->airport}}<br>
                    To   : {{$booking_details->destination}}<br>
                    {{$booking_details->number_of_taxi}} X {{$booking_details->taxi_type}} Returns transfer (€{{$booking_details->taxi_price}})<br>
                    Price : €{{$booking_details->number_of_taxi * $booking_details->taxi_price}}	<br>
                    Arrival Time : {{ Helpers::siteDateFormate($booking_details->startdate) }} {{$booking_details->arrival_time	}}<br>
                    Departure Time : {{ Helpers::siteDateFormate($booking_details->enddate) }} {{$booking_details->departure_time }}<br>
                  </address>
                </div>
                @else
                <div class="col-sm-4 invoice-col">
                <b>No Transfers Selected ! </b>
                </div>

                @endif
                

                
              </div>
              <!-- /.row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <p class="lead">Payment Summary</p>
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>Accommodation Price</th>
                      <th>€{{number_format($booking_details->price_per_persion * $booking_details->adults + $booking_details->children,0) }}</th>
                    </tr>
                    @if($booking_details->deposit_pay > 0)
                    <tr>
                      <th>Deposit Pay</th>
                      <th>€{{$booking_details->deposit_pay}}</th>
                    </tr>
                    @endif
                    @if($booking_details->remaning_pay > 0)
                    <tr>
                      <th>Remaning Pay Before {!! \Carbon\Carbon::parse($booking_details->remainbalpaydate)->format('d-m-Y') !!}</th>
                      <th>€{{$booking_details->remaning_pay}}</th>
                    </tr>
                    @endif
                    @if($booking_details->transfer == '1')
                    <tr>
                      <th>Transfers {{$booking_details->number_of_taxi}} X {{$booking_details->taxi_type}} Returns transfer (€{{$booking_details->taxi_price}})</th>
                      <th>€{{$booking_details->number_of_taxi * $booking_details->taxi_price}}</th>
                    </tr>
                    @endif
                    <tr>
                      <th>Total Price Pay </th>
                      <th>€{{$booking_details->total_price}}</th>
                    </tr>
                    
                    </thead>
                    
                  </table>
                 </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              
              @if(count($booking_details->orderPassangers) > 0)
              <div class="row">
                <div class="col-12 table-responsive">
                <p class="lead">Passenger Summary</p>
                  <div class="col-sm-4 invoice-col">
                    Lead Passenger Address : 
                    <address>
                      {{$booking_details->orderPassangers[0]->house_name}}, {{$booking_details->orderPassangers[0]->address1}} , {{$booking_details->orderPassangers[0]->city}}
                      {{$booking_details->orderPassangers[0]->country}}<br>
                      Phone: {{$booking_details->orderPassangers[0]->telephone_no}}<br>
                      Email: {{$booking_details->orderPassangers[0]->email}}
                    </address>
                    @if($booking_details->orderPassangers[0]->comment != '')
                    Special Comment : 
                    {{$booking_details->orderPassangers[0]->comment}}<br><br>
                    @endif
                      

                  </div>
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Telephone Number</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                    @php $i = 1; @endphp
                    @foreach($booking_details->orderPassangers as $key=>$value)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>{{$value->title}} {{$value->firstname}} {{$value->surname}}</td>
                      <td>{{$value->email}}</td>
                      <td>{{$value->telephone_no}}</td>                      
                    </tr>
                    
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              @endif
              <!-- /.row -->


          </div><!-- /.card-body -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    
@endsection

