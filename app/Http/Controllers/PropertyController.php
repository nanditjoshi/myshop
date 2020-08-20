<?php
/**
 * User : Nandit@avdevs
 * 
 * Property controller for property listing, property search, property details
 */
namespace App\Http\Controllers;

use App\Models\PropertyDetails;
use App\Models\PropertyImages;
use App\Models\PropertyOptions;
use App\Models\PropertyVariables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;



class PropertyController extends Controller
{
    /*
    * property search  
    *
    *
    */
    public function searchProperties(Request $request)
    {
        $destination = $request->get('destination');
        $date = Carbon::parse($request->get('date'))->format('Y-m-d');
        $night = $request->get('night');
        $quantity = $request->get('quant');
        $adult = $quantity[1]; //For Adult
        $children = $quantity[2]; //For Children

        $request->session()->put('destination', $request->get('destination'));
        $request->session()->put('date', $date);
        $request->session()->put('night', $request->get('night'));
        $request->session()->put('quantity', $request->get('quant'));
        $request->session()->put('adult', $quantity[1]);//For Adult
        $request->session()->put('children', $quantity[2]);//For Children
        
        
        //call getPropertyPriceFromAPI for get property prices from API
        $propertyprices =   $this->getPropertyPriceFromAPI($request);
        
        if(is_array($propertyprices) == false){

            $request->is_group = 1;
            return $this->searchGroupPropertys($request);
        }
        
        $propertycode = array();
        foreach($propertyprices as $key => $value)
        {
            $propertycode[] = $key;
        }
        $request->session()->put('propertyprices', $propertyprices);//For search property in DB from API

        //$property_list_query = PropertyDetails::with('propertyImages','propertyVariables')->where('regionname', 'like','%'. $destination.'%')->where('adults','>=',$adult)->where('children','>=',$children);
        
        //$property_list_query = PropertyDetails::with('propertyImages','propertyVariables')->whereIn('propertycode',$propertycode)->where('adults','>=',$adult)->where('children','>=',$children);
        
        $property_list_query = PropertyDetails::with('propertyImages','propertyVariables')->whereIn('propertycode',$propertycode)->orderByRaw('ABS(ABS(`latitude`-53.63) + ABS(`longitude`-9.9))', 'ASC');
       
       

        /* Filter Result Code */
        $propertystars = $facilities = $variables = $propertycodePrice = [];

        foreach($property_list_query->get() as $key => $value)
        {
            if(isset($propertyprices[$value->propertycode])){
                // $filters[$property->propertycode] = $propertyprices[$property->propertycode]['price'];
                $propertycodePrice[$value->id] = $propertyprices[$value->propertycode]['price']['rate'];
            }

           // dd(json_decode($value->json_data)->property);
            $property = json_decode($value->json_data)->property;
            
            // Star array
            if($property->propertystars > 5) {$property->propertystars = 5;}
            array_push($propertystars,$property->propertystars);         
            
            if(isset($property->options->option_db)){
                // Facility (options) array
                $facilitiesArr = $property->options->option_db;   
                
                foreach($facilitiesArr as $fkey => $fvalue)
                {   
                   if(isset($fvalue->name))
                        array_push($facilities,$fvalue->name);
                } 
            }

            if(isset($property->variables->varcat)){
                // Variables array
                $variablesArr = $property->variables->varcat;   
                foreach($variablesArr as $fkey => $fvalue)
                {   
                   if(isset($fvalue->varcatname))
                        array_push($variables,$fvalue->varcatname);
                } 
            }
            
        }

        $request->session()->put('propertycodePrice', $propertycodePrice);

        $filters['order_by'] = ['Star Rating','Price High - Low','Price Low - High'];
        $filters['propertystars'] = array_unique($propertystars);
        $filters['facilities'] = array_unique($facilities);
        $filters['variables'] = array_unique($variables);
        //dd($filters[357188]['rate']);

        //checking for alternate dates

        $startdate = new Carbon($date);
        $now = Carbon::today();
        $daysDiff =  $startdate->diff($now)->days;

        $addDate = new Carbon($date);
        $addDays = $addDate->addDays(5);
        //$addDays = Carbon::parse($addDays)->format('Y-m-d H:i:s');

        $subDate = new Carbon($date);
        if($daysDiff > 5) {
            $subDays = $subDate->subDay(5);
        }else{
            $subDays = $subDate->subDay($daysDiff);
        }

        $alternatedates = $this->generateDateRange($subDate, $addDays);

        //$property_list = PropertyDetails::with('propertyImages','propertyVariables')->paginate(10);
        $property_list = $property_list_query->paginate(10);
        
        return view('pages.listing',compact('property_list','filters','propertyprices','alternatedates','night'));
        
    }
    /*
    * property list ajax call for pagination and apply filters 
    *
    *
    */
    function fetch_data(Request $request)
    {
        $sessiondata = $request->session()->all();
        if($request->ajax())
        {
            $propertyprices =   $request->session()->get('propertyprices');        

            $propertycode = array();
            foreach($propertyprices as $key => $value)
            {
                $propertycode[] = $key;
            }
            
            $property_list_query = PropertyDetails::with('propertyImages','propertyVariables')->whereIn('propertycode',$propertycode);
            
            
            if($request)
            {
                if($request->has('propertystars')){
                    $propertystar   =   $request->get('propertystars'); //in array
                    $property_list_query->whereIn('propertystars',$propertystar);
                }
                if($request->has('facilities')){
                    $facilities   =   $request->get('facilities'); //in array
                    $propertycode = PropertyOptions::select('propertycode')->whereIn('name',$facilities)->get();
                    foreach($propertycode as $k => $v) {
                        $pcode[] = $v['propertycode'];
                    }
                    $property_list_query->whereIn('propertycode',$pcode);
                }  
                if($request->has('variables')){
                    $variables   =   $request->get('variables'); //in array
                    $propertycode = PropertyVariables::select('propertycode')->whereIn('varcatname',$variables)->get();
                    foreach($propertycode as $k => $v) {
                        $pcode[] = $v['propertycode'];
                    }
                    $property_list_query->whereIn('propertycode',$pcode);
                }    
                if($request->has('hotelname') && $request->hotelname != '' ){
                    $hotelname   =   $request->get('hotelname');
                    //$property_list_query->where('propertyname',$hotelname);
                    $property_list_query->Where('propertyname', 'like', '%' . $hotelname . '%');
                }
                if($request->has('order_by')){
                    $order_by   =   $request->get('order_by');
                    if($order_by == 'Star Rating') {
                        $property_list_query->orderby('propertystars', 'DESC');
                    }if($order_by == 'Price High - Low') {
                        $propertycodePrice = $request->session()->get('propertycodePrice');
                        arsort($propertycodePrice);
                        $propertycodePriceSort = implode(',',array_keys($propertycodePrice));
                        $property_list_query->orderByRaw('FIELD(id,'.$propertycodePriceSort.')');
                    }if($order_by == 'Price Low - High') {
                        $propertycodePrice = $request->session()->get('propertycodePrice');
                        asort($propertycodePrice);
                        $propertycodePriceSort = implode(',',array_keys($propertycodePrice));

                        $property_list_query->orderByRaw('FIELD(id,'.$propertycodePriceSort.')');
                    }
                }  
            }
            $property_list_query->orderByRaw('ABS(ABS(`latitude`-53.63) + ABS(`longitude`-9.9))', 'ASC');
            $property_list = $property_list_query->paginate(10);
            return view('pages.pagination_data', compact('property_list','propertyprices'))->render();
        }
        
    }


    private function searchGroupPropertys(Request $request)
    {
        $sessiondata    = $request->session()->all();
        $date           = $sessiondata['date'];
        $night          = $sessiondata['night'];
        $destination    = $sessiondata['destination'];
        $sleeps         = $sessiondata['adult']+$sessiondata['children'];

        $propertyprices =   $this->getPropertyPriceFromAPI($request);    
        $request->session()->put('propertyprices', $propertyprices);//For search property in DB from API
        
        $propertycode = array();
        foreach($propertyprices as $key => $value)
        {
            $propertycode[] = $key;
        }   
        /// Query for two property
        $query_for  =   2; 
        $property_list_query = DB::table(DB::raw('property_details as a'),DB::raw('property_details as b'))
        ->select(
                    DB::raw('a.*'),
                    DB::raw('b.propertycode as bpropertycode'),
                    DB::raw('b.propertyname as bpropertyname'),
                    DB::raw('111.111 *
                    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.latitude))
                        * COS(RADIANS(b.latitude))
                        * COS(RADIANS(a.longitude - b.longitude))
                        + SIN(RADIANS(a.latitude))
                        * SIN(RADIANS(b.latitude))))) AS distance_in_km')
                )
        ->join(DB::raw('property_details as b'), DB::raw('a.propertycode'),'<>', DB::raw('b.propertycode'));
        if($destination != 'All Destinations'){
            $property_list_query->where(function($q)use ($destination)  {
                $q->where((DB::raw('a.regionname')),'like', '%'.$destination.'%')
                ->where((DB::raw('b.regionname')),'like', '%'.$destination.'%');
            });
        }
        $property_list_query->where((DB::raw('a.sleeps + b.sleeps')), '>=' , $sleeps);
        $property_list_query->where(function($q)use ($propertycode)  {
            $q->whereIn((DB::raw('a.propertycode')),$propertycode)
            ->whereIn((DB::raw('b.propertycode')),$propertycode);
        });        
        $property_list_query->orderByRaw('distance_in_km', 'ASC');
        $property_list_query->orderByRaw('a.propertycode', 'ASC');
        $property_list_query->orderByRaw('b.propertycode', 'ASC');
        $property_list  =   $property_list_query->paginate(10);
        //dd($property_list->tosql());
        
        
        
        /* Filter Result Code */
        $propertystars = $facilities = $variables = $propertycodePrice = [];
        
        foreach($property_list as $key => $value)
        {

            if(isset($propertyprices[$value->propertycode]) && isset($propertyprices[$value->bpropertycode])){
                // $filters[$property->propertycode] = $propertyprices[$property->propertycode]['price'];
                if(is_int($propertyprices[$value->propertycode]['price']['rate']) && is_int($propertyprices[$value->bpropertycode]['price']['rate']))
                    $propertycodePrice[$value->id] = ($propertyprices[$value->propertycode]['price']['rate']+$propertyprices[$value->bpropertycode]['price']['rate'])/$query_for;
            }
            
           // dd(json_decode($value->json_data)->property);
            $property = json_decode($value->json_data)->property;
            
            // Star array
            if($property->propertystars > 5) {$property->propertystars = 5;}
            array_push($propertystars,$property->propertystars);         
            
            if(isset($property->options->option_db)){
                // Facility (options) array
                $facilitiesArr = $property->options->option_db;   
                
                foreach($facilitiesArr as $fkey => $fvalue)
                {   
                   if(isset($fvalue->name))
                        array_push($facilities,$fvalue->name);
                } 
            }

            if(isset($property->variables->varcat)){
                // Variables array
                $variablesArr = $property->variables->varcat;   
                foreach($variablesArr as $fkey => $fvalue)
                {   
                   if(isset($fvalue->varcatname))
                        array_push($variables,$fvalue->varcatname);
                } 
            }
            
        }

        $request->session()->put('propertycodePrice', $propertycodePrice);
        
        $filters['order_by'] = ['Star Rating','Price High - Low','Price Low - High'];
        $filters['propertystars'] = array_unique($propertystars);
        $filters['facilities'] = array_unique($facilities);
        $filters['variables'] = array_unique($variables);

        

        return view('pages.listing_group',compact('property_list','filters','query_for'));

    }
    /*
    * property list ajax call for pagination and apply filters for group property
    *
    *
    */
    function fetch_data_group(Request $request)
    {
        $sessiondata = $request->session()->all();
        $date           = $sessiondata['date'];
        $night          = $sessiondata['night'];
        $destination    = $sessiondata['destination'];
        $sleeps         = $sessiondata['adult']+$sessiondata['children'];
        if($request->ajax())
        {
            $propertyprices =   $request->session()->get('propertyprices');        

            $propertycode = array();
            foreach($propertyprices as $key => $value)
            {
                $propertycode[] = $key;
            }
            
            
            $property_list_query = DB::table(DB::raw('property_details as a'),DB::raw('property_details as b'))
            ->select(
                        DB::raw('a.*'),
                        DB::raw('b.propertycode as bpropertycode'),
                        DB::raw('b.propertyname as bpropertyname'),
                        DB::raw('111.111 *
                        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.latitude))
                            * COS(RADIANS(b.latitude))
                            * COS(RADIANS(a.longitude - b.longitude))
                            + SIN(RADIANS(a.latitude))
                            * SIN(RADIANS(b.latitude))))) AS distance_in_km')
                    )
            ->join(DB::raw('property_details as b'), DB::raw('a.propertycode'),'<>', DB::raw('b.propertycode'));
            
            if($destination != 'All Destinations'){
                $property_list_query->where(function($q)use ($destination)  {
                    $q->where((DB::raw('a.regionname')),'like', '%'.$destination.'%')
                    ->where((DB::raw('b.regionname')),'like', '%'.$destination.'%');
                });
            }
            $property_list_query->where((DB::raw('a.sleeps + b.sleeps')), '>=' , $sleeps)
            ->where(function($q)use ($propertycode)  {
                $q->whereIn((DB::raw('a.propertycode')),$propertycode)
                ->whereIn((DB::raw('b.propertycode')),$propertycode);
            });
            

            if($request)
            {
                if($request->has('propertystars')){
                    $propertystar   =   $request->get('propertystars'); //in array
                    
                    $property_list_query->where(function($q)use ($propertystar)  {
                                            $q->whereIn((DB::raw('a.propertystars')),$propertystar)
                                            ->orWhereIn((DB::raw('b.propertystars')),$propertystar);
                                        });
                }
                if($request->has('facilities')){
                    $facilities   =   $request->get('facilities'); //in array
                    $propertycode = PropertyOptions::select('propertycode')->whereIn('name',$facilities)->get();
                    foreach($propertycode as $k => $v) {
                        $pcode[] = $v['propertycode'];
                    }
                    
                    $property_list_query->where(function($q)use ($pcode)  {
                                            $q->whereIn((DB::raw('a.propertycode')),$pcode)
                                            ->orWhereIn((DB::raw('b.propertycode')),$pcode);
                                        });
                }  
                if($request->has('variables')){
                    $variables   =   $request->get('variables'); //in array
                    $propertycode = PropertyVariables::select('propertycode')->whereIn('varcatname',$variables)->get();
                    foreach($propertycode as $k => $v) {
                        $pcode_variables[] = $v['propertycode'];
                    }
                    
                    $property_list_query->where(function($q)use ($pcode_variables)  {
                                            $q->whereIn((DB::raw('a.propertycode')),$pcode_variables)
                                            ->orWhereIn((DB::raw('b.propertycode')),$pcode_variables);
                                        });
                }    
                if($request->has('hotelname') && $request->hotelname != '' ){
                    $hotelname   =   $request->get('hotelname');
                   // $property_list_query->Where('propertyname', 'like', '%' . $hotelname . '%');
                    $property_list_query->where(function($q)use ($hotelname)  {
                                            $q->where((DB::raw('a.propertyname')), 'like', '%' . $hotelname . '%')
                                            ->orWhere((DB::raw('b.propertyname')), 'like', '%' . $hotelname . '%');
                                        });
                }
                
            }
            if($request && $request->has('order_by')){                
                    $order_by   =   $request->get('order_by');
                    if($order_by == 'Star Rating') {
                        $property_list_query->orderByRaw('a.propertystars', 'DESC')
                                            ->orderByRaw('b.propertystars', 'DESC');

                    }if($order_by == 'Price High - Low') {
                        $propertycodePrice = $request->session()->get('propertycodePrice');
                        arsort($propertycodePrice);
                        $propertycodePriceSort = implode(',',array_keys($propertycodePrice));
                        $property_list_query->orderByRaw('FIELD(a.id,'.$propertycodePriceSort.')')
                                            ->orderByRaw('FIELD(b.id,'.$propertycodePriceSort.')');
                    }if($order_by == 'Price Low - High') {
                        $propertycodePrice = $request->session()->get('propertycodePrice');
                        asort($propertycodePrice);
                        $propertycodePriceSort = implode(',',array_keys($propertycodePrice));

                        $property_list_query->orderByRaw('FIELD(a.id,'.$propertycodePriceSort.')')
                        ->orderByRaw('FIELD(b.id,'.$propertycodePriceSort.')');
                    }                
            }else{
                $property_list_query->orderByRaw('distance_in_km', 'ASC');
                $property_list_query->orderByRaw('a.propertycode', 'ASC');
                $property_list_query->orderByRaw('b.propertycode', 'ASC');
            }
            /*$property_list = $property_list_query->tosql();
            dd($property_list);*/
            $property_list = $property_list_query->paginate(10);
            $query_for  =   $request->get('query_for');
       
                       
            return view('pages.pagination_data_group', compact('property_list','query_for'))->render();
        }
        
    }
    /*
    * get the property price based on search
    *
    *
    */
    public function getPropertyPriceFromAPI(Request $request)
    {
        // Call API for price and other live data
        //https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-06-20&numbernights=7&regionname=Paphos&basic_details=1
        //"https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-10-20&numbernights=7&regionname=Ayia Napa&sleeps=3&basic_details=1"

        $sessiondata = $request->session()->all();
       
        $date           = $sessiondata['date'];
        $night          = $sessiondata['night'];
        $destination    = $sessiondata['destination'];
        $sleeps         = $sessiondata['adult']+$sessiondata['children'];  
        
        if($request->is_group == 1)
        {
            if($destination != 'All Destinations'){
                //$apiURL = config('site-config.api-url').'filter3.asp?siteID='.config('site-config.siteID').'&startdate='.$date.'&numbernights='.$night.'&regionname='.$destination.'&basic_details=1';
                $apiURL = config('site-config.api-url').'filter3.asp?siteID='.config('site-config.siteID').'&startdate='.$date.'&numbernights='.$night.'&townname='.$destination.'&basic_details=1';
                
            }else{
                $apiURL = config('site-config.api-url').'filter3.asp?siteID='.config('site-config.siteID').'&startdate='.$date.'&numbernights='.$night.'&basic_details=1';
            }
        }else{
            if($destination != 'All Destinations'){
                //$apiURL = config('site-config.api-url').'filter3.asp?siteID='.config('site-config.siteID').'&startdate='.$date.'&numbernights='.$night.'&regionname='.$destination.'&sleeps='.$sleeps.'&basic_details=1';
                $apiURL = config('site-config.api-url').'filter3.asp?siteID='.config('site-config.siteID').'&startdate='.$date.'&numbernights='.$night.'&townname='.$destination.'&sleeps='.$sleeps.'&basic_details=1';
            }else{
                $apiURL = config('site-config.api-url').'filter3.asp?siteID='.config('site-config.siteID').'&startdate='.$date.'&numbernights='.$night.'&sleeps='.$sleeps.'&basic_details=1';
            }
        }
               
        try{
            $client = new Client();
            $response = $client->request('GET', $apiURL);
            $statusCode = $response->getStatusCode();
         
            $body = $response->getBody()->getContents();
            //$xml = simplexml_load_string($body);
            $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml); //API result in json
            $array = json_decode($json,TRUE); //API result in array
            
            $pricesArr  =   array();
            foreach($array['property'] as $key => $value)
            {
                $pricesArr[$value['propertycode']] =   $value['prices'];
            }
           
            if($statusCode == '200'){
                return $pricesArr;
                return response()->json(["success" => true, 'data' => $pricesArr ]);    
            }else{
                return response()->json(["success"=>false, 'data' => 'API is not alive..']);
            }
        
        } catch (\Exception $ex){
            return response()->json([['success'=>false, "error"=>$ex->getMessage()]]);
        }
    }

    /*
    * get the property details for single property
    *
    *
    */

    public function propertyDetails($propertycode,Request $request){

        $propertyprices =   $request->session()->get('propertyprices');
        
        if(array_key_exists($propertycode, $propertyprices) == false)
        {
            return abort(404);
        }
        $property_details = PropertyDetails::with('propertyImages','propertyVariables')->where('propertycode',$propertycode)->first();

        $propertyArray =   json_decode($property_details->json_data, true);
        $cp = $hr = $dfa = $nb = [];
        if(isset($propertyArray['property']['customfields'])){
            foreach($propertyArray['property']['customfields'] as $k => $v)
            {
                foreach($v as $a => $b)
                {
                    if($b['title'] == 'Cancellation Policy')
                    {
                        $cp['title'] = $b['title'];
                        $cp['text'] = $b['text'];
                    }
                    if($b['title'] == 'House Rules')
                    {
                        $hr['title'] = $b['title'];
                        $hr['text'] = $b['text'];
                    }
                    if($b['title'] == 'Distance from Airport')
                    {
                        $dfa['title'] = $b['title'];
                        $dfa['text'] = $b['text'];
                    }
                    if($b['title'] == 'Nearest Beach')
                    {
                        $nb['title'] = $b['title'];
                        $nb['text'] = $b['text'];
                    }
                }
            }
        }
        //print_r($hr);
        //dd($propertyprices);
        $request->session()->forget('vp_name');
        return view('pages.listing-details',compact('property_details','propertyprices','cp','hr','dfa','nb'));
    }

    /*
    * get the property details for group property
    *
    *
    */

    public function propertyDetailsGroup($propertycode,Request $request){

        $propertycodes = explode("_",$propertycode);
        
        $property_details_query = PropertyDetails::with('propertyImages','propertyVariables')->whereIn('propertycode',$propertycodes);
        
        if($propertycodes[0] > $propertycodes[1]){
            $property_details = $property_details_query->orderBy('propertycode', 'DESC')->get();
        }else{
            $property_details = $property_details_query->orderBy('propertycode', 'ASC')->get();
        }    
           
        $propertyArray =   json_decode($property_details[0]->json_data, true);
        
        $cp = $hr = $dfa = $nb = [];
        if(isset($propertyArray['property']['customfields'])){
            foreach($propertyArray['property']['customfields'] as $k => $v)
            {
                foreach($v as $a => $b)
                {
                    if($b['title'] == 'Cancellation Policy')
                    {
                        $cp['title'] = $b['title'];
                        $cp['text'] = $b['text'];
                    }
                    if($b['title'] == 'House Rules')
                    {
                        $hr['title'] = $b['title'];
                        $hr['text'] = $b['text'];
                    }
                    if($b['title'] == 'Distance from Airport')
                    {
                        $dfa['title'] = $b['title'];
                        $dfa['text'] = $b['text'];
                    }
                    if($b['title'] == 'Nearest Beach')
                    {
                        $nb['title'] = $b['title'];
                        $nb['text'] = $b['text'];
                    }
                }
            }
        }
        //print_r($hr);
        //dd($propertyprices);
        $request->session()->forget('vp_name');
        return view('pages.listing-details_group',compact('property_details','cp','hr','dfa','nb'));
    }


    public function bookProperty($propertycode,Request $request){

        $propertyprices =   $request->session()->get('propertyprices');
        
        $property_details = PropertyDetails::with('propertyImages','propertyVariables')->where('propertycode',$propertycode)->first();
        return view('pages.step1',compact('property_details','propertyprices'));
    }
    /*
    * view alternate dates on listing page
    *
    *
    */
    private function generateDateRange(Carbon $start_date, Carbon $end_date)
    {

        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[$date->format('d-m-Y')] = $date->format('D d M');
        }
        return $dates;

    }

    /*
    * get property price
    *
    *
    */
    public static function getPropertyPrice($date,$night,$pgroupcode)
    {
        if(isset($date) && isset($night) && isset($pgroupcode))
        {
            $pricesArr  =   array();
            
            $propertycode = explode('_',$pgroupcode);
            
            foreach($propertycode as $val)
            {
                $apiURL = config('site-config.api-url').'get_price.asp?siteID='.config('site-config.siteID').'&id='.$val.'&startdate='.$date.'&numbernights='.$night;
                //http://api.supercontrol.co.uk/xml/get_price.asp?siteid=40908&id=545278&startdate=2020-07-24&numbernights=7
                      
                try{
                    $client = new Client();
                    $response = $client->request('GET', $apiURL);
                    $statusCode = $response->getStatusCode();
                
                    $body = $response->getBody()->getContents();
                    //$xml = simplexml_load_string($body);
                    $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
                    $json = json_encode($xml); //API result in json
                    $array = json_decode($json,TRUE); //API result in array
                    foreach($array as $value)
                    {
                        $pricesArr[$array['propertyID']] =   $array;
                    }
                } catch (\Exception $ex){
                    return response()->json([['success'=>false, "error"=>$ex->getMessage()]]);
                }
                 
            }
            return $pricesArr;
        }
    }

    /*
    * get property price
    *
    *
    */
    public static function getPrice($date,$night,$pgroupcode)
    {
        if(isset($date) && isset($night) && isset($pgroupcode))
        {
            $pricesArr  =   array();
            
            foreach($pgroupcode as $val)
            {
                $apiURL = config('site-config.api-url').'get_price.asp?siteID='.config('site-config.siteID').'&id='.$val.'&startdate='.$date.'&numbernights='.$night;
                //http://api.supercontrol.co.uk/xml/get_price.asp?siteid=40908&id=545278&startdate=2020-07-24&numbernights=7
                      
                try{
                    $client = new Client();
                    $response = $client->request('GET', $apiURL);
                    $statusCode = $response->getStatusCode();
                
                    $body = $response->getBody()->getContents();
                    //$xml = simplexml_load_string($body);
                    $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
                    $json = json_encode($xml); //API result in json
                    $array = json_decode($json,TRUE); //API result in array
                    foreach($array as $value)
                    {
                        $pricesArr[$array['propertyID']] =   $array;
                    }
                } catch (\Exception $ex){
                    return response()->json([['success'=>false, "error"=>$ex->getMessage()]]);
                }
                 
            }
            $price = $discount =0;
            foreach($pricesArr as $k =>$v)
            {
                $price += $v['price'];
                $discount += $v['discount'];
            }
            return $price/count($pricesArr);
        }
    }


}
