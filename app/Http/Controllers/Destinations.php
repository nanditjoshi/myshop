<?php
/**
 * User : Bhavin@avdevs
 * 
 * Provide the destination in dropdown from API response
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;


use App\Models\Destination;


class Destinations extends Controller
{
    function destinations(Request $request)
    {
        if($request->ajax())
        {
            try {
                $cachedDestinations = Cache::store('file')->get('destinations');

                if(empty($cachedDestinations)) {

                    //$apiURL = config('site-config.api-url') . 'town_40908.xml';
                    $apiURL = config('site-config.api-url') . 'town_'.config('site-config.siteID').'.xml';
                    $client = new Client();
                    $response = $client->request('GET', $apiURL);
                    $statusCode = $response->getStatusCode();
                    $body = $response->getBody()->getContents();

                    //$xml = simplexml_load_string($body);
                    $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
                    $json = json_encode($xml);
                    $array = json_decode($json, TRUE);
                    $townArray = [];
                    foreach ($array as $towns){
                        foreach ($towns as $town) {
                            $townArray = $town;
                        }
                    }
                    Cache::store('file')->put('destinations', $townArray, 86400);
                    $cachedDestinations = $townArray;
                }

                $destination = trim($request->get('searchText'));
                //$destinationList = Destination::where('name','LIKE', '%'.$destination.'%')->get()->toArray();
                if(!empty($destination)) {
                    $destinationList = array_filter($cachedDestinations, function ($value) use ($destination) {
                        if (!empty($value)) {
                            return strpos(strtolower($value), strtolower($destination)) !== false;
                        }
                    });
                }

                if(!empty($destinationList)) {
                    return response()->json(array('data' => 'full', 'destinations' => $destinationList), 200);
                }else{
                    return response()->json(array('data' => 'empty'), 200);
                }

            } catch (\Exception $ex){
                return response()->json([['success'=>false, "error"=>$ex->getMessage()]]);
            }
        }
    }
}
