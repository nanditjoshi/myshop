<?php
/**
 * User : Nandit@avdevs
 * 
 * Payment controller for manage the payments activity 
 */
namespace App\Http\Controllers;

use App\Mail\RequestCallbackEmail;
use App\Models\PropertyDetails;
use App\Models\PropertyImages;
use App\Models\Orders;
use App\Models\OrderPassengers;
use App\Models\OrderProperty;
use App\Models\IpcPayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use App\IPC\loader;



class PaymentController extends Controller
{
    /*
    * review the booking details and go for payment
    *
    *
    */
    public static function citsPayment($order_details)
    {
        if(config('site-config.env') == 'dev'){
            $cnf = new \Mypos\IPC\Config(); 
            $cnf->setIpcURL(config('site-config.dev_payment_url')); 
            $cnf->setLang('en'); 
            $cnf->setPrivateKeyPath(dirname(__FILE__) . '/keys/dev_store_private_key.pem'); 
            $cnf->setAPIPublicKeyPath(dirname(__FILE__) . '/keys/dev_api_public_key.pem'); 
            $cnf->setKeyIndex(1); 
            $cnf->setSid(config('site-config.dev_sid')); 
            $cnf->setVersion('1.4'); 
            $cnf->setWallet(config('site-config.dev_Wallet'));
        }else{
            $cnf = new \Mypos\IPC\Config(); 
            $cnf->setIpcURL(config('site-config.prod_payment_url')); 
            $cnf->setLang('en'); 
            $cnf->setPrivateKeyPath(dirname(__FILE__) . '/keys/prod_store_private_key.pem'); 
            $cnf->setAPIPublicKeyPath(dirname(__FILE__) . '/keys/prod_api_public_key.pem'); 
            $cnf->setKeyIndex(1); 
            $cnf->setSid(config('site-config.prod_sid')); 
            $cnf->setVersion('1.4'); 
            $cnf->setWallet(config('site-config.prod_Wallet'));
        }
        
        $customer = new \Mypos\IPC\Customer(); 
        $customer->setFirstName($order_details->orderPassangers[0]->firstname); 
        $customer->setLastName($order_details->orderPassangers[0]->surname); 
        $customer->setEmail($order_details->orderPassangers[0]->email); 
        $customer->setPhone($order_details->orderPassangers[0]->telephone_no); 
        $customer->setCountry('BGR'); 
        $customer->setAddress($order_details->orderPassangers[0]->house_name); 
        $customer->setCity($order_details->orderPassangers[0]->city); 
        $customer->setZip($order_details->orderPassangers[0]->post_code_add);

        $cart = new \Mypos\IPC\Cart; 
        $property_details = PropertyDetails::with('propertyImages','propertyVariables')->where('propertycode',$order_details->propertycode)->first();
        
        if($order_details->deposit_pay > 0){
            $cart->add($property_details->propertyname.' Code - '.$property_details->propertycode, 1, $order_details->deposit_pay); //name, quantity, price 
        }else{
            $cart->add($property_details->propertyname.' Code - '.$property_details->propertycode, 1, $order_details->total_price); //name, quantity, price 
        }
        
        /* foreach($order_details->orderPropertys as $k => $v)
        {
            $cart->add($v->propertycode, 1, 9.99); //name, quantity, price 
        }*/
        
        
        $purchase = new \Mypos\IPC\Purchase($cnf); 
        $purchase->setUrlCancel('https://'.$_SERVER['HTTP_HOST'].'/Cancel'); //User comes here after purchase cancelation 
        $purchase->setUrlOk('https://'.$_SERVER['HTTP_HOST'].'/Ok'); //User comes here after purchase success 
        $purchase->setUrlNotify('https://'.$_SERVER['HTTP_HOST'].'/Notify'); //IPC sends POST reuquest to this address with purchase status
        //$purchase->setOrderID(uniqid()); //Some unique ID 
        $purchase->setOrderID(uniqid().'_'.$order_details->id); //Some unique ID 
        $purchase->setCurrency('EUR'); 
        $purchase->setNote('Some note'); //Not required 
        $purchase->setCustomer($customer); 
        $purchase->setCart($cart); 
        
        $purchase->setCardTokenRequest(\Mypos\IPC\Purchase::CARD_TOKEN_REQUEST_PAY_AND_STORE); 
        $purchase->setPaymentParametersRequired(\Mypos\IPC\Purchase::PURCHASE_TYPE_FULL);
        $purchase->setPaymentMethod(\Mypos\IPC\Purchase::PAYMENT_METHOD_BOTH);

        try{ 
            $result = $purchase->process(); 
            dd($result);
        }catch(\Mypos\IPC\IPC_Exception $ex){ 
            echo $ex->getMessage(); 
            //Invalid params. To see details use "echo $ex->getMessage();" 
        }

        dd('Redirecting for payment');

    }

    /*
    * View payment responce 
    *
    *
    */
    public function citsCancel(Request $request)
    {
        if(config('site-config.env') == 'dev'){
            $cnf = new \Mypos\IPC\Config(); 
            $cnf->setIpcURL(config('site-config.dev_payment_url')); 
            $cnf->setLang('en'); 
            $cnf->setPrivateKeyPath(dirname(__FILE__) . '/keys/dev_store_private_key.pem'); 
            $cnf->setAPIPublicKeyPath(dirname(__FILE__) . '/keys/dev_api_public_key.pem'); 
            $cnf->setKeyIndex(1); 
            $cnf->setSid(config('site-config.dev_sid')); 
            $cnf->setVersion('1.3'); 
            $cnf->setWallet(config('site-config.dev_Wallet'));
        }else{
            $cnf = new \Mypos\IPC\Config(); 
            $cnf->setIpcURL(config('site-config.prod_payment_url')); 
            $cnf->setLang('en'); 
            $cnf->setPrivateKeyPath(dirname(__FILE__) . '/keys/prod_store_private_key.pem'); 
            $cnf->setAPIPublicKeyPath(dirname(__FILE__) . '/keys/prod_api_public_key.pem'); 
            $cnf->setKeyIndex(1); 
            $cnf->setSid(config('site-config.prod_sid')); 
            $cnf->setVersion('1.3'); 
            $cnf->setWallet(config('site-config.prod_Wallet'));
        }
        
        // unset current booking from session here
        $request->session()->forget('currentBookingId');

        try{ 
            $responce = \Mypos\IPC\Response::getInstance($cnf, $_POST, \Mypos\IPC\Defines::COMMUNICATION_FORMAT_POST); 
            $data = $responce->getData(CASE_LOWER); 
            //print_r($data['orderid']);
            $orderid = explode("_",$data['orderid']);
            $orderid = $orderid[1];

            $OrderRecord  = Orders::where('id',$orderid)->first();
            $OrderRecord->payment_status    =  'Cancel';
            $OrderRecord->order_status      =  'Cancel';
            $OrderRecord->save();
            $msg = 'Your Booking Canceled !';

            // unset current booking from session here
            $request->session()->forget('currentBookingId');
            $request->session()->forget('destination');
            $request->session()->forget('date');
            $request->session()->forget('night');
            $request->session()->forget('adult');
            $request->session()->forget('children');

            return view('pages.step4',compact('msg'));


        }catch(\Mypos\IPC\IPC_Exception $e){ 
            echo $ex->getMessage(); 
            //Display Some general error or redirect to merchant store home page 
        }
        

        

    }

    /*
    * View payment responce 
    *
    *
    */
    public function citsOk(Request $request)
    {
        if(config('site-config.env') == 'dev'){
            $cnf = new \Mypos\IPC\Config(); 
            $cnf->setIpcURL(config('site-config.dev_payment_url')); 
            $cnf->setLang('en'); 
            $cnf->setPrivateKeyPath(dirname(__FILE__) . '/keys/dev_store_private_key.pem'); 
            $cnf->setAPIPublicKeyPath(dirname(__FILE__) . '/keys/dev_api_public_key.pem'); 
            $cnf->setKeyIndex(1); 
            $cnf->setSid(config('site-config.dev_sid')); 
            $cnf->setVersion('1.3'); 
            $cnf->setWallet(config('site-config.dev_Wallet'));
        }else{
            $cnf = new \Mypos\IPC\Config(); 
            $cnf->setIpcURL(config('site-config.prod_payment_url')); 
            $cnf->setLang('en'); 
            $cnf->setPrivateKeyPath(dirname(__FILE__) . '/keys/prod_store_private_key.pem'); 
            $cnf->setAPIPublicKeyPath(dirname(__FILE__) . '/keys/prod_api_public_key.pem'); 
            $cnf->setKeyIndex(1); 
            $cnf->setSid(config('site-config.prod_sid')); 
            $cnf->setVersion('1.3'); 
            $cnf->setWallet(config('site-config.prod_Wallet'));
        }

        
        try{ 
            $responce = \Mypos\IPC\Response::getInstance($cnf, $_POST, \Mypos\IPC\Defines::COMMUNICATION_FORMAT_POST); 
            $data = $responce->getData(CASE_LOWER); 
            //print_r($data);

            $orderid = explode("_",$data['orderid']);
            $orderid = $orderid[1];

            
            $ipc_payment = new IpcPayments();
                $ipc_payment->ipcmethod         =  $data['ipcmethod'];
                $ipc_payment->amount            =  $data['amount'];
                $ipc_payment->currency          =  $data['currency'];
                $ipc_payment->orders_id         =  $orderid;
                $ipc_payment->ipc_trnref        =  $data['ipc_trnref'];
                $ipc_payment->requeststan       =  $data['requeststan'];
                $ipc_payment->requestdatetime   =  $data['requestdatetime'];
                $ipc_payment->customerphone     =  $data['customerphone'];
                $ipc_payment->cardtoken         =  $data['cardtoken'];
            $ipc_payment->save();

            $OrderRecord  = Orders::with('orderPropertys','orderPassangers')->where('id',$orderid)->first();
            $OrderRecord->payment_status    =  'Success';
            $OrderRecord->save();

            if($OrderRecord->deposit_pay > 0){
                $payment_value      =   $OrderRecord->deposit_pay;
                $payment_caption    =   'Deposit Paid';
            }else{
                $payment_value      =   $OrderRecord->total_price;
                $payment_caption    =   'Full Payment Paid';
            }
            $url = 'https://secure.supercontrol.co.uk/api/avail.asp';
            $xml = '<?xml version="1.0" encoding="utf-8"?>
            <scAPI>
                <client>
                    <ID>'.config('site-config.book_ID').'</ID>
                    <key>'.config('site-config.book_key').'</key>
                    <ref>'.$OrderRecord->userid.'</ref>
                    <prop>
                        <propID>'.$OrderRecord->propertycode.'</propID>
                        <reset>false</reset>
                        <dates>
                            <date status="b" start="'.Carbon::parse($OrderRecord->startdate)->format('Y-m-d').'" nights="'.$OrderRecord->nofonights.'" closed="0">
                                    <BookingType>API</BookingType>
                                    <yourRef>'.$OrderRecord->userid.'</yourRef>
                                    <affiliate></affiliate>
                                    <siteID>'.config('site-config.siteID').'</siteID>
                                <PaymentRedirect>
                                    <success></success>
                                    <fail></fail>
                                </PaymentRedirect>
                                <guest>
                                    <title>'.$OrderRecord->orderPassangers[0]->title.'</title>
                                    <firstname><![CDATA['.$OrderRecord->orderPassangers[0]->firstname.']]></firstname>
                                    <lastname><![CDATA['.$OrderRecord->orderPassangers[0]->surname.']]></lastname>
                                    <company></company>
                                    <address1><![CDATA['.$OrderRecord->orderPassangers[0]->house_name .']]></address1>
                                    <address2><![CDATA['.$OrderRecord->orderPassangers[0]->address1.']]></address2>
                                    <town><![CDATA['.$OrderRecord->orderPassangers[0]->city.']]></town>
                                    <county></county>
                                    <postcode><![CDATA['.$OrderRecord->orderPassangers[0]->post_code_add.']]></postcode>
                                    <country><![CDATA['.$OrderRecord->orderPassangers[0]->country.']]></country>
                                    <email><![CDATA['.$OrderRecord->orderPassangers[0]->email.']]></email>
                                    <telephone><![CDATA['.$OrderRecord->orderPassangers[0]->telephone_no.']]></telephone>
                                    <mobile><![CDATA['.$OrderRecord->orderPassangers[0]->telephone_no.']]></mobile>
                                </guest>
                                <notes>
                                    <note><![CDATA['.$OrderRecord->orderPassangers[0]->comment.']]></note>
                                </notes>
                                <booking>
                                    <value>'.$OrderRecord->total_price.'</value>
                                    <vatPercentage>0</vatPercentage>
                                    <pax adults="'.$OrderRecord->adults.'" children="'.$OrderRecord->children.'" infants="0" />
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
            
            $OrderRecord  = Orders::where('id',$orderid)->first();
            $OrderRecord->booking_xml       =  $data;
            $OrderRecord->save();
    
            //$str = $OrderRecord->booking_xml;
            //$xml = simplexml_load_string($str);
            $xml = simplexml_load_string($data);
            
            if($xml->status == 'OK' && $xml->msg == 'The data was saved')
            {
                $OrderRecord  = Orders::where('id',$order_id)->first();
                foreach($xml->bookingRef[0]->yourRef->attributes() as $key => $val)
                {
                    //echo $key."--". $val;
                    $OrderRecord->$key          =  $val;
                }
                $OrderRecord->order_status      =  'Success';
                $OrderRecord->save();
                
            }else{
                // unset current booking from session here
                $request->session()->forget('currentBookingId');
                $request->session()->forget('destination');
                $request->session()->forget('date');
                $request->session()->forget('night');
                $request->session()->forget('adult');
                $request->session()->forget('children');
                dd($xml);
                
            }

            //Mail::to(config('site-config.toemail'))->send(new RequestCallbackEmail($OrderRecord));

            // unset current booking from session here
            $request->session()->forget('currentBookingId');
            $request->session()->forget('destination');
            $request->session()->forget('date');
            $request->session()->forget('night');
            $request->session()->forget('adult');
            $request->session()->forget('children');
        

            $msg = true;
            
            $order_details      = Orders::with('orderPropertys','orderPassangers')->where('id',$orderid)->first();
            $property_details   = PropertyDetails::with('propertyImages','propertyVariables')->where('propertycode',$order_details->propertycode)->first();
            
            return view('pages.step4',compact('msg','order_details','property_details'));

        }catch(\Mypos\IPC\IPC_Exception $e){ 
            echo $ex->getMessage(); 
            //Display Some general error or redirect to merchant store home page 
        }
        
    }

    /*
    * View payment responce 
    *
    *
    */
    public function citsNotify(Request $request)
    {
        if(config('site-config.env') == 'dev'){
            $cnf = new \Mypos\IPC\Config(); 
            $cnf->setIpcURL(config('site-config.dev_payment_url')); 
            $cnf->setLang('en'); 
            $cnf->setPrivateKeyPath(dirname(__FILE__) . '/keys/dev_store_private_key.pem'); 
            $cnf->setAPIPublicKeyPath(dirname(__FILE__) . '/keys/dev_api_public_key.pem'); 
            $cnf->setKeyIndex(1); 
            $cnf->setSid(config('site-config.dev_sid')); 
            $cnf->setVersion('1.3'); 
            $cnf->setWallet(config('site-config.dev_Wallet'));
        }else{
            $cnf = new \Mypos\IPC\Config(); 
            $cnf->setIpcURL(config('site-config.prod_payment_url')); 
            $cnf->setLang('en'); 
            $cnf->setPrivateKeyPath(dirname(__FILE__) . '/keys/prod_store_private_key.pem'); 
            $cnf->setAPIPublicKeyPath(dirname(__FILE__) . '/keys/prod_api_public_key.pem'); 
            $cnf->setKeyIndex(1); 
            $cnf->setSid(config('site-config.prod_sid')); 
            $cnf->setVersion('1.3'); 
            $cnf->setWallet(config('site-config.prod_Wallet'));
        }

        // unset current booking from session here
       /* $request->session()->forget('currentBookingId');

        try{ 
            $responce = \Mypos\IPC\Response::getInstance($cnf, $_POST, \Mypos\IPC\Defines::COMMUNICATION_FORMAT_POST); 
            $data = $responce->getData(CASE_LOWER); 
            print_r($data);
        }catch(\Mypos\IPC\IPC_Exception $e){ 
            echo $ex->getMessage(); 
            //Display Some general error or redirect to merchant store home page 
        }
        
        dd('ipc_notify');*/

        echo "OK";


    }

}
