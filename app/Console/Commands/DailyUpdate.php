<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use GuzzleHttp\Client;

use App\Models\PropertyUpdate;
use App\Models\PropertyDetails;
use App\Models\PropertyImages;
use App\Models\PropertyOptions;
use App\Models\PropertyVariables;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Daily update property';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $apiURL = config('site-config.api-url').'filter3.asp?siteID='.config('site-config.siteID').'&propertycode_only=1';

        try{
            $client = new Client([
                'verify' => false
            ]);
            $response = $client->request('GET', $apiURL);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            //$xml = simplexml_load_string($body);
            $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            //dd($array['property']);
            $property_updateModel = new PropertyUpdate();
            foreach($array['property'] as $key => $value)
            {
                $crval = array();
                $getPropertyUpdate = PropertyUpdate::where('propertycode',$value['propertycode'])->get()->toArray();

                $crval = [
                    'propertycode' => $value['propertycode'],
                    'enabled' => $value['enabled'],
                    //'lastupdate' => $lastupdate,
                    //'photolastupdate' => $photolastupdate,
                    //'specialoffers' => $propertycode,
                ];

                if(!empty($value['lastupdate'])){
                    $crval['lastupdate'] = $this->changeDateFormate($value['lastupdate']);
                }

                if(!empty($value['photolastupdate'])){
                    $crval['photolastupdate'] = $this->changeDateFormate($value['photolastupdate']);
                }

                if(!empty($value['specialoffers'])){
                    $crval['specialoffers'] = $value['specialoffers'];
                }

                $lastupdate = $crval['lastupdate'];
                $photolastupdate = $crval['photolastupdate'];
                $getPropertyUpdateByDate = PropertyUpdate::where('propertycode',$value['propertycode'])
                    ->where(function($query) use($lastupdate, $photolastupdate){
                        $query->where('lastupdate', "!=", $lastupdate)
                            ->orWhere('photolastupdate', "!=", $photolastupdate);
                    })
                    ->get()->toArray();

                if(isset($getPropertyUpdate) && empty($getPropertyUpdate)){
                    $PropertyUpdate = $property_updateModel->create($crval);
                    $this->updateProperty($value['propertycode']);
                }


                if(!empty($getPropertyUpdateByDate)) {
                    $PropertyUpdate = $property_updateModel->where('id',$getPropertyUpdate[0]['id'])->update($crval);
                    $this->updateProperty($value['propertycode']);
                }

                //$PropertyUpdate->save();
            }
            return response()->json(["success"=>true, 'data' => 'All records inserted in property_update table and property_details table']);

        } catch (\Exception $ex){
            return response()->json([['success'=>false, "error"=>$ex->getMessage()]]);
        }
    }

    /*

    This link provide details for the property
    https://api.supercontrol.co.uk/xml/property_xml.asp?id=86666&siteID=68

    */
    public function updateProperty($id)
    {
        $apiURL = config('site-config.api-url').'property_xml.asp?id='.$id.'&siteID='.config('site-config.siteID');

        try{
            $client = new Client([
                'verify' => false
            ]);
            $response = $client->request('GET', $apiURL);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody()->getContents();

            $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);

            //$arr = $this->xml2array($xml);



            $property_detailModel = new PropertyDetails();
            $crval = array();
            $crval = [
                'propertycode' => $array['property']['propertycode'],
            ];

            if(!empty($array['property']['propertyname'])){
                $crval['propertyname'] = $array['property']['propertyname'];
            }
            if(!empty($array['property']['propertystars'])){
                $crval['propertystars'] = $array['property']['propertystars'];
            }
            if(!empty($array['property']['propertypostcode'])){
                $crval['propertypostcode'] = $array['property']['propertypostcode'];
            }

            if(!empty($array['property']['longitude'])){
                $crval['longitude'] = $array['property']['longitude'];
            }

            if(!empty($array['property']['latitude'])){
                $crval['latitude'] = $array['property']['latitude'];
            }

            if(!empty($array['property']['country'])){
                $crval['country'] = $array['property']['country'];
            }

            if(!empty($array['property']['countryiso'])){
                $crval['countryiso'] = $array['property']['countryiso'];
            }
            
            if(!empty($array['property']['sleeps'])){
                $crval['sleeps'] = $array['property']['sleeps'];
            }

            if(!empty($array['property']['balance'])){
                $crval['balance'] = $array['property']['balance'];
            }

            if(!empty($array['property']['deposit'])){
                $crval['deposit'] = $array['property']['deposit'];
            }

            if(!empty($array['property']['deposittype'])){
                $crval['deposittype'] = $array['property']['deposittype'];
            }

            if(!empty($array['property']['typename'])){
                $crval['typename'] = $array['property']['typename'];
            }
            if(!empty($array['property']['regionname'])){
                $crval['regionname'] = $array['property']['regionname'];
            }

            if(!empty($array['property']['capacity']['adults'])){
                $crval['adults'] = $array['property']['capacity']['adults'];
            }
            if(!empty($array['property']['capacity']['children'])){
                $crval['children'] = $array['property']['capacity']['children'];
            }
            if(!empty($array['property']['capacity']['infants'])){
                $crval['infants'] = $array['property']['capacity']['infants'];
            }

            if(!empty($array['property']['bedrooms_new'])){
                $crval['bedrooms_new'] = $array['property']['bedrooms_new'];
            }

            if(!empty($array['property']['bathrooms_new'])){
                $crval['bathrooms_new'] = $array['property']['bathrooms_new'];
            }

            if(!empty($array['property']['deposittype'])){
                $crval['deposittype'] = $array['property']['deposittype'];
            }

            if(!empty($array['property']['checkin'])){
                $crval['checkin'] = $array['property']['checkin'];
            }

            if(!empty($array['property']['checkout'])){
                $crval['checkout'] = $array['property']['checkout'];
            }

            if(!empty($array['property']['title'])){
                $crval['title'] = $array['property']['title'];
            }

            if(!empty($array['property']['metadescription'])){
                $crval['metadescription'] = $array['property']['metadescription'];
            }

            if(!empty($array['property']['metakeywords'])){
                $crval['metakeywords'] = $array['property']['metakeywords'];
            }


            if(!empty($array['property']['siteID'])){
                $crval['siteID'] = $array['property']['siteID'];
            }

            if(!empty($array['property']['ownerID'])){
                $crval['ownerID'] = $array['property']['ownerID'];
            }

            if(!empty($array['property']['propertyownerID'])){
                $crval['propertyownerID'] = $array['property']['propertyownerID'];
            }

            if(!empty($array['property']['groupID'])){
                $crval['groupID'] = $array['property']['groupID'];
            }

            if(!empty($array['property']['managerID'])){
                $crval['managerID'] = $array['property']['managerID'];
            }

            if(!empty($array['property']['managername'])){
                $crval['managername'] = $array['property']['managername'];
            }

            if(!empty($array['property']['manageremail'])){
                $crval['manageremail'] = $array['property']['manageremail'];
            }

            if(!empty($array['property']['propertyminbookingdays'])){
                $crval['propertyminbookingdays'] = $array['property']['propertyminbookingdays'];
            }

            if(!empty($array['property']['propertyaddress'])){
                $crval['propertyaddress'] = $array['property']['propertyaddress'];
            }

            if(!empty($array['property']['availabilitylink'])){
                $crval['availabilitylink'] = $array['property']['availabilitylink'];
            }

            if(!empty($array['property']['webdescription'])){
                $crval['webdescription'] = $array['property']['webdescription'];
            }

            if(!empty($array['property']['cottageweblocation'])){
                $crval['cottageweblocation'] = $array['property']['cottageweblocation'];
            }

            if(!empty($array['property']['lastupdate'])){
                $crval['lastupdate'] = $this->changeDateFormate($array['property']['lastupdate']);
            }

            if(!empty($array['property']['photolastupdate'])){
                $crval['photolastupdate'] = $this->changeDateFormate($array['property']['photolastupdate']);
            }

            $crval['json_data'] = $json;
            $getPropertyDetails = PropertyDetails::where('propertycode',$id)->get()->toArray();

            if(isset($getPropertyDetails) && !empty($getPropertyDetails)){

                //$PropertyDetails = $property_detailModel->where('id',$getPropertyDetails[0]['id'])->update($crval);

            }else{
                
                $PropertyDetails = $property_detailModel->create($crval);

                /*$getPropertyImages = PropertyImages::where('propertycode',$id)->get();
                foreach ($getPropertyImages as $getPropertyImage){
                    $getPropertyImage->delete();
                }*/

                $property_imagesModel = new PropertyImages();
                foreach($array['property']['photos']['img'] as $key => $value){
                    $images = array();
                    $images = [
                        'propertycode' => $array['property']['propertycode'],
                        'main' => $value['main'],
                        'thumb' => $value['thumb'],
                        'tiny' => $value['tiny'],
                    ];
                    $ImagesDetails = $property_imagesModel->create($images);
                }

                /*$getPropertyVariables = PropertyVariables::where('propertycode',$id)->get();
                foreach ($getPropertyVariables as $getPropertyVariable){
                    $getPropertyVariable->delete();
                }*/

                $property_variablesModel = new PropertyVariables();
                foreach($array['property']['variables']['varcat'] as $key => $value){
                    $variables = array();
                    $variables = [
                        'propertycode' => $array['property']['propertycode'],
                        'varcatname' => $value['varcatname'],
                        'varcatcombined' => $value['varcatcombined'],
                    ];
                    $VariablessDetails = $property_variablesModel->create($variables);
                }

                /*$getPropertyOptions = PropertyOptions::where('propertycode',$id)->get();
                foreach ($getPropertyOptions as $getPropertyOption){
                    $getPropertyOption->delete();
                }*/

                $property_optionsModel = new PropertyOptions();
                foreach($array['property']['options']['option_db'] as $key => $value){
                    $options = array();
                    $options = [
                        'propertycode' => $array['property']['propertycode'],
                        'name' => $value['name'],
                        'price' => $value['price'],
                        //'pricetype' => $value['pricetype'],
                        'maxQty' => $value['maxQty'],
                        //'allowedDates' => $value['allowedDates'],
                        'defaultQty' => $value['defaultQty'],
                        //'img' => $value['img'],
                        'optionPayment' => $value['optionPayment'],
                    ];
                    if(!empty($value['description'])){
                        $options['description'] = $value['description'];
                    }
                    $OptionsDetails = $property_optionsModel->create($options);

                }
            }


            

        } catch (\Exception $ex){
            return response()->json([['success'=>false, "error"=>$ex->getMessage()]]);
        }

    }

    public function changeDateFormate($dateValue){
        return Carbon::parse(str_replace('/','-', $dateValue))->format('Y-m-d H:i:s');
    }
}
