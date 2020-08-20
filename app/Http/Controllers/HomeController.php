<?php
/**
 * User : Nandit@avdevs
 * 
 * Home controller for home page activity
 */
namespace App\Http\Controllers;

use App\Mail\RequestCallbackEmail;
use App\Models\RequestCallback;
use App\Models\Newsletter;
use App\Models\ContactUs;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /*
    * request callback email to admin 
    *
    *
    */
    
    public function requestCallback(Request $request){
        $requestname = $request->get('requestname','');
        $requesttelephone = $request->get('requesttelephone','');
        $requestemail = $request->get('requestemail','');
        $requestcomments = $request->get('requestcomments','');
        try {
            $variables = [
                'requestname' => $requestname,
                'requesttelephone' => $requesttelephone,
                'requestemail' => $requestemail,
                'requestcomments' => $requestcomments];
            $RequestCallback = new RequestCallback();
            $RequestCallback->create($variables);

            $objRequestCallback = new \stdClass();
            $objRequestCallback->requestname = $requestname;
            $objRequestCallback->requesttelephone = $requesttelephone;
            $objRequestCallback->requestemail = $requestemail;
            $objRequestCallback->requestcomments = $requestcomments;
            $objRequestCallback->sender = $requestname;
            $objRequestCallback->receiver = 'Admin User';

            Mail::to(config('site-config.toemail'))->send(new RequestCallbackEmail($objRequestCallback));
            return response()->json(['success' => 'true', 'message' => 'Email send']);
        }catch(\Exception $ex){
            return response()->json(['success'=>'false', 'error'=>$ex->getMessage()]);
        }

    }


    /*
    * register for news letter
    *
    *
    */
    
    public function requestNewsletter(Request $request){
        
        $user_email = $request->get('user_email');
        $user_name = $request->get('user_name');

        $newsletterdata  = Newsletter::where('user_email',$user_email)->get();
        
        if(count($newsletterdata)>0)
        {
            return response()->json(['success' => 'true', 'message' => 'Already Register For News Letter']);
        }
        try {
            $variables = [
                'user_email' => $user_email,
                'user_name' => $user_name
            ];
            $Newsletter = new Newsletter();
            $Newsletter->create($variables);
            
            return response()->json(['success' => 'true', 'message' => 'Succesfully Register For News Letter']);
        }catch(\Exception $ex){
            return response()->json(['success'=>'false', 'error'=>$ex->getMessage()]);
        }

    }

    /*
    * Contact us form
    *
    */
    
    public function addContactUs(Request $request){

        //dd('Contact-us');
        
        $name                       = $request->get('name');
        $surname                    = $request->get('surname');
        $email                      = $request->get('email');
        $phone                      = $request->get('phone');
        $classification             = $request->get('classification');
        $communication              = $request->get('communication');
        $property_code              = $request->get('property_code');
        $booking_reference          = $request->get('booking_reference');
        $preferred_contact_method   = $request->get('preferred_contact_method');
        $subject                    = $request->get('subject');
        $formmessage                = $request->get('message');
        
        try {
            $variables = [
                'name'                      => $name,
                'surname'                   => $surname,
                'email'                     => $email,
                'phone'                     => $phone,
                'classification'            => $classification,
                'communication'             => $communication,
                'property_code'             => $property_code,
                'booking_reference'         => $booking_reference,
                'preferred_contact_method'  => $preferred_contact_method,
                'subject'                   => $subject,
                'message'                   => $formmessage,

            ];
            $ContactUs = new ContactUs();
            $ContactUs->create($variables);
            
            //send mail
            //Mail::to(config('site-config.toemail'))->send(new RequestCallbackEmail($objRequestCallback));
            Mail::send('mails.contact-us',array(
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'phone' => $phone,
                'formmessage' => $formmessage,
            ), function($message) use ($request){
                $message->from(config('site-config.fromemail'));
                $message->to(config('site-config.toemail'));
                $message->subject('Contact Us Email');
            });
            
            //return response()->json(['success' => 'true', 'message' => 'Succesfully Register For News Letter']);
            return redirect()->to('/contact-us')->with('message','Enquiry Added !!');
        }catch(\Exception $ex){
            //return response()->json(['success'=>'false', 'error'=>$ex->getMessage()]);
            return redirect()->to('/contact-us')->with('message',$ex->getMessage());
        }

    }

    

}
