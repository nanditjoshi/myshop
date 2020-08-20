<?php
/**
 * User : Nandit@avdevs
 * 
 * Booking controller for manage the booking relate activity 
 */
namespace App\Http\Controllers;

use App\Models\PropertyDetails;
use App\Models\PropertyImages;
use App\Models\Orders;
use App\Models\OrderPassengers;
use App\Models\OrderProperty;
use App\Models\Transfer;

use App\IPC\loader;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;



class BookingController extends Controller
{
    /*
    * start booking process 
    *
    *
    */

    public function bookProperty(Request $request){

        //$apiURL = config('site-config.api-url').'filter3.asp?siteID='.config('site-config.siteID').'&startdate='.$date.'&numbernights='.$night.'&regionname='.$destination.'&sleeps='.$sleeps.'&propertycode='.$propertycode.'&bedrooms_min='.$bedrooms_min.'&basic_details=1';
        
        $propertyprices =   $request->session()->get('propertyprices');
        $propertycode = $request->get('propertycode');
        $propertycode = explode("_",$propertycode);
        
        $property_details = PropertyDetails::with('propertyImages','propertyVariables')->whereIn('propertycode',$propertycode)->get();
                
        return view('pages.step1',compact('property_details','propertyprices'));
    }

    /*
    * create the order 
    *
    *
    */
    public function addOrderdetails(Request $request){
        

        $propertyprices     = $request->session()->get('propertyprices');
        $propertycode       = $request->get('propertycode');
        $remainbalpaydate   = $request->get('remainbalpaydate');
        $price_per_persion  = $request->get('price_per_persion');
        $airport            = $request->get('airport');
        $taxi_type          = $request->get('taxi_type');
        $total_price        = $request->get('total_price');
        $number_of_taxi     = $request->get('number_of_taxi');
        $arrival_time       = $request->get('arrival_time');
        $departure_time     = $request->get('departure_time');
        $destination        = $request->session()->get('destination');
        
        
        $currentBookingId = $request->session()->get('currentBookingId');
        
        
        if($currentBookingId != null && $currentBookingId > 0){  
            //if record exists update it
            
            $OrderRecord  = Orders::where('id',$currentBookingId)->first();
            
            if(!empty($airport) && !empty($taxi_type))
            {
                $OrderRecord->transfer      =   true;
                $OrderRecord->airport       =   $airport;
                $taxi                       =   explode("_",$taxi_type);
                $OrderRecord->taxi_type     =   $taxi[0];
                $OrderRecord->taxi_price    =   $taxi[1];        
            }

            $OrderRecord->adults             =  $request->session()->get('adult');
            $OrderRecord->children           =  $request->session()->get('children');
            $OrderRecord->propertycode       =  $propertycode;
            $OrderRecord->price_per_persion  =  $price_per_persion;
            $OrderRecord->startdate          =  $request->session()->get('date');
            $enddate                         = \Carbon\Carbon::parse( $request->session()->get('date'))->addDay($request->session()->get('night'));
            $OrderRecord->enddate            =  $enddate;
            $OrderRecord->nofonights         =  $request->session()->get('night');
            $OrderRecord->remainbalpaydate   =  $remainbalpaydate;
            $OrderRecord->total_price        =  $total_price;
            $OrderRecord->number_of_taxi     =  $number_of_taxi;
            $OrderRecord->destination        =  $destination;
            $OrderRecord->arrival_time       =  $arrival_time;
            $OrderRecord->departure_time     =  $departure_time;
            $OrderRecord->save();

            
            $OrderPropertyRecord  = OrderProperty::where('orders_id',$currentBookingId)->first();
            $OrderPropertyRecord->orders_id   =  $OrderRecord->id;
            $OrderPropertyRecord->propertycode   =  $propertycode;
            $OrderPropertyRecord->save();            

        }else{
            //if record not exists add it
            $OrderRecord = new Orders();

            if(!empty($airport) && !empty($taxi_type))
            {
                $OrderRecord->transfer      =   true;
                $OrderRecord->airport       =   $airport;
                $taxi   =   explode("_",$taxi_type);
                $OrderRecord->taxi_type     =   $taxi[0];
                $OrderRecord->taxi_price    =   $taxi[1];        
            }

            $OrderRecord->userid            =  uniqid(rand(), true); //$request->session()->get('_token');
            $OrderRecord->adults            =  $request->session()->get('adult');
            $OrderRecord->children          =  $request->session()->get('children');
            $OrderRecord->propertycode      =  $propertycode;
            $OrderRecord->price_per_persion =  $price_per_persion;
            $OrderRecord->startdate         =  $request->session()->get('date');
            $enddate                        = \Carbon\Carbon::parse( $request->session()->get('date'))->addDay($request->session()->get('night'));
            $OrderRecord->enddate           =  $enddate;
            $OrderRecord->nofonights        =  $request->session()->get('night');
            $OrderRecord->remainbalpaydate  =  $remainbalpaydate;
            $OrderRecord->total_price       =  $total_price;
            $OrderRecord->number_of_taxi    =  $number_of_taxi;
            $OrderRecord->destination       =  $destination;
            $OrderRecord->arrival_time       =  $arrival_time;
            $OrderRecord->departure_time     =  $departure_time;
            $OrderRecord->save();
            
            $OrderPropertyRecord = new OrderProperty();
            $OrderPropertyRecord->orders_id     =  $OrderRecord->id;
            $OrderPropertyRecord->propertycode  =  $propertycode;
            $OrderPropertyRecord->save();

            $request->session()->put('currentBookingId', $OrderRecord->id);
        }
        
        $orders_id = $OrderRecord->id;
        $propertycode = explode("_",$propertycode);
            
        $property_details = PropertyDetails::with('propertyImages','propertyVariables')->whereIn('propertycode',$propertycode)->get();
        $order_details  = Orders::with('orderPropertys','orderPassangers')->where('id',$orders_id)->first();
        return view('pages.step2',compact('property_details','propertyprices','orders_id','order_details'));
    }
    
    /*
    * add passenger details in order
    *
    *
    */
    public function addPassengerdetails(Request $request){
        
        $propertyprices =   $request->session()->get('propertyprices');
        $propertycode = $request->get('propertycode');
        
        
        $passengerCount = count($request->get('type'));
        
        $currentBookingId = $request->session()->get('currentBookingId');
        $order_details  = OrderPassengers::where('orders_id',$currentBookingId)->delete();

        for($i=0;$i<=$passengerCount-1;$i++)
        {
            $PassengersRecord = new OrderPassengers();

                $PassengersRecord->orders_id  =  $request->get('orders_id');
                $PassengersRecord->type       =  $request->get('type')[$i];
                $PassengersRecord->is_lead    =  $request->get('is_lead')[$i];
                if($PassengersRecord->is_lead == '1'){
                    $PassengersRecord->house_name    =  $request->get('house_name');
                    $PassengersRecord->address1      =  $request->get('address1');
                    $PassengersRecord->address2      =  $request->get('address2');
                    $PassengersRecord->city          =  $request->get('city');
                    $PassengersRecord->country       =  $request->get('country');
                    $PassengersRecord->post_code_add =  $request->get('post_code_add');
                    $PassengersRecord->telephone_no  =  $request->get('telephone_no');  
                    $PassengersRecord->email         =  $request->get('email');
                    $PassengersRecord->comment       =  $request->get('comment');        
                }
                $PassengersRecord->title      =  $request->get('title')[$i];
                $PassengersRecord->firstname  =  $request->get('firstname')[$i];
                $PassengersRecord->surname    =  $request->get('surname')[$i];
                $PassengersRecord->age        =  $request->get('age')[$i];
                

            $PassengersRecord->save();
        }


        $order_id = $request->get('orders_id');
        $propertycode = explode("_",$propertycode);
        
        $property_details = PropertyDetails::with('propertyImages','propertyVariables')->whereIn('propertycode',$propertycode)->get();
        $order_details  = Orders::with('orderPropertys','orderPassangers')->where('id',$order_id)->first();
        return view('pages.step3',compact('property_details','propertyprices','order_details'));
    }
    /*
    * review the booking details and go for payment
    *
    *
    */
    public function reviewBookingDetails(Request $request)
    {
        $propertyprices =   $request->session()->get('propertyprices');
        $propertycode = $request->get('propertycode');
        $order_id = $request->get('orders_id');

        $order_details  = Orders::with('orderPropertys','orderPassangers')->where('id',$order_id)->first();
        
        if($request->get('payment') == "fullpay")
        {
            $order_details->deposit_pay    =  0;
            $order_details->remaning_pay   =  0;    
            
        }else{
            
            $order_details->deposit_pay   =  $request->get('amount');
            $order_details->remaning_pay  =  $request->get('totalprice') - $request->get('amount') ;
        }

        $order_details->total_price   =  $request->get('totalprice');
        $order_details->save();
       
        
        PaymentController::citsPayment($order_details);

        
        $msg = true;
        $order_details      = Orders::with('orderPropertys','orderPassangers')->where('id',$order_id)->first();
        $property_details   = PropertyDetails::with('propertyImages','propertyVariables')->where('propertycode',$order_details->propertycode)->first();
        
        if($order_details->deposit_pay > 0){
            $payment_value      =   $order_details->deposit_pay;
            $payment_caption    =   'Deposit Paid';
        }else{
            $payment_value      =   $order_details->total_price;
            $payment_caption    =   'Full Payment Paid';
        }
        $url = 'https://secure.supercontrol.co.uk/api/avail.asp';
        $xml = '<?xml version="1.0" encoding="utf-8"?>
        <scAPI>
            <client>
                <ID>'.config('site-config.payment_ID').'</ID>
                <key>'.config('site-config.payment_key').'</key>
                <ref>'.$order_details->userid.'</ref>
                <prop>
                    <propID>'.$order_details->propertycode.'</propID>
                    <reset>false</reset>
                    <dates>
                        <date status="b" start="'.Carbon::parse($order_details->startdate)->format('Y-m-d').'" nights="'.$order_details->nofonights.'" closed="0">
                                <BookingType>API</BookingType>
                                <yourRef>'.$order_details->userid.'</yourRef>
                                <affiliate></affiliate>
                                <siteID>'.config('site-config.siteID').'</siteID>
                            <PaymentRedirect>
                                <success></success>
                                <fail></fail>
                            </PaymentRedirect>
                            <guest>
                                <title>'.$order_details->orderPassangers[0]->title.'</title>
                                <firstname><![CDATA['.$order_details->orderPassangers[0]->firstname.']]></firstname>
                                <lastname><![CDATA['.$order_details->orderPassangers[0]->surname.']]></lastname>
                                <company></company>
                                <address1><![CDATA['.$order_details->orderPassangers[0]->house_name .']]></address1>
                                <address2><![CDATA['.$order_details->orderPassangers[0]->address1.']]></address2>
                                <town><![CDATA['.$order_details->orderPassangers[0]->city.']]></town>
                                <county></county>
                                <postcode><![CDATA['.$order_details->orderPassangers[0]->post_code_add.']]></postcode>
                                <country><![CDATA['.$order_details->orderPassangers[0]->country.']]></country>
                                <email><![CDATA['.$order_details->orderPassangers[0]->email.']]></email>
                                <telephone><![CDATA['.$order_details->orderPassangers[0]->telephone_no.']]></telephone>
                                <mobile><![CDATA['.$order_details->orderPassangers[0]->telephone_no.']]></mobile>
                            </guest>
                            <notes>
                                <note><![CDATA['.$order_details->orderPassangers[0]->comment.']]></note>
                            </notes>
                            <booking>
                                <value>'.$order_details->total_price.'</value>
                                <vatPercentage>0</vatPercentage>
                                <pax adults="'.$order_details->adults.'" children="'.$order_details->children.'" infants="0" />
                                <commission>0</commission>
                            </booking>
                            <payments>
                                <payment>
                                    <date>'.date('Y-m-d').'</date>
                                    <value>'.$payment_value.'</value>
                                    <caption>'.$payment_caption.'</caption>
                                    <method>Credit card</method>
                                </payment>
                            </payments>
                            <extras>
                                <extra>
                                    <id>0</id>
                                    <qty>0</qty>
                                    <value>0</value>
                                    <name>Custom option</name>
                                </extra>
                            </extras>
                        </date>
                    </dates>    
                </prop>
            </client>
        </scAPI>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: application/xml"));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $data = curl_exec($ch);
        curl_close($ch);
        
        $order_details  = Orders::where('id',$order_id)->first();
        $order_details->booking_xml       =  $data;
        $order_details->save();

        //$str = $OrderRecord->booking_xml;
        //$xml = simplexml_load_string($str);
        
        $xml = simplexml_load_string($data);
        if($xml->status == 'OK' && $xml->msg == 'The data was saved')
        {
            $order_details  = Orders::where('id',$order_id)->first();
            foreach($xml->bookingRef[0]->yourRef->attributes() as $key => $val)
            {
                //echo $key."--". $val;
                $order_details->$key          =  $val;
            }
            $order_details->save();
            $msg = true;
            
            return view('pages.step4',compact('msg','order_details','property_details'));

        }else{

            dd($xml);
            return $xml;

        }
        
        //dd('HERE...');
    }    

    /*
    * View booking details after succesfully book the property
    *
    *
    */
    public function viewBooking(Request $request)
    {
        $order_id = $request->get('orders_id');
        
        $order_details  = Orders::with('orderPropertys','orderPassangers')->where('id',$order_id)->first();
        if(!isset($order_details))
            return abort(404);
            
        $propertycode = $order_details->propertycode;
        $property_details = PropertyDetails::with('propertyImages','propertyVariables')->where('propertycode',$propertycode)->first();
        
        return view('pages.viewbooking',compact('order_details','property_details'));

    }

    /*
    * get the transfer details
    *
    *
    */
    public function getTransfers(Request $request)
    {
        if($request->ajax())
        {
            $airport        = $request->get('airport');
            $destination    = $request->get('destination');

            $transfers_details  = Transfer::where('airport',$airport)->where('destination',$destination)->get()->toArray();

            foreach($transfers_details as $key => $value)
            {
                $tArray[$value['taxi_type']]    =   $value;

            }
            
            if(!empty($tArray)) {
                return response()->json(array('data' => 'full', 'transfers_details' => $tArray), 200);
            }else{
                return response()->json(array('data' => 'empty'), 200);
            }
        }    

    }
}
