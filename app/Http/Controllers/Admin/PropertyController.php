<?php
/**
 * User: Nandit Joshi
 * Date: 06/08/2020
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PropertyDetails;
use App\Models\PropertyImages;
use App\Models\PropertyOptions;
use App\Models\PropertyVariables;
use App\Models\HouseRules;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\URL;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;

class PropertyController extends Controller {

    public function index() {
        return view('admin.property.index');
    }

    public function create() {
        $user = Auth::user();
        $current_role = $user->role->id;

        if($current_role == User::SUPER_ADMIN){
            $companies = Company::all();
            $data = ['companies' => $companies, 'role' => $current_role];
        } else {
            $data = ['role' => $current_role];
        }
        return view('admin.users.form')->with($data);
    }

    public function browse(Request $request){
       
            $query = PropertyDetails::select('*');
            
            return Datatables::of($query)
            ->editColumn('id', function($query) {
                return '<input type="checkbox" name="row_id" id="checkbox_'.$query->id.'" value="'.$query->id.'">';
            })

            ->editColumn('updated_at', function($query) {
                //return Carbon::parse($query->updated_at)->format('d/m/Y');
                return Helpers::siteDateFormate($query->updated_at);
            })

            ->editColumn('webdescription', function($query) {
                return Str::limit($query->webdescription, 100);
            })
        

            ->editColumn('property_images', function($query) {
                return "<a href=property/$query->propertycode/images>View Images</a>";
                
            })
             
       
            ->editColumn('action', function($query) {
                return Helpers::getGeneralActions($query, 'property');
            })
       
            ->rawColumns(['action', 'id', 'property_images'])
            ->make(true);
    }

    public function show($id){
        
        $property_details = PropertyDetails::with('propertyImages','propertyVariables')->find($id);
        
        return view('admin.property.show',compact('property_details'));
    }

    public function imagesindex($propertycode){
        
        $property_details = PropertyDetails::with('propertyImages')->where('propertycode',$propertycode)->first();
        return view('admin.property.imagesindex',compact('property_details'));
    }

    public function delimages($id){
        
        $getPropertyImages = PropertyImages::find($id);
        $propertycode   =   $getPropertyImages->propertycode;
        
        
        //dd(is_file(storage_path('app/public/images/thumbnails/1597749934.png')));
        //dd(Storage::delete('app/public/images/thumbnails/1597749934.png'));

        preg_match('#([^/\'"=]*?[.](?:gif|jpeg|jpg|png))\b#i',$getPropertyImages->main, $main);
        preg_match('#([^/\'"=]*?[.](?:gif|jpeg|jpg|png))\b#i',$getPropertyImages->thumb, $thumb);
        preg_match('#([^/\'"=]*?[.](?:gif|jpeg|jpg|png))\b#i',$getPropertyImages->tiny, $tiny);
        if(is_file(public_path('storage/images/main/'.$main[0])))
            unlink(public_path('storage/images/main/'.$main[0]));
        
        if(is_file(public_path('storage/images/thumbnails/'.$thumb[0])))
            unlink(public_path('storage/images/thumbnails/'.$thumb[0]));
        
        if(is_file(public_path('storage/images/tiny/'.$tiny[0])))
            unlink(public_path('storage/images/tiny/'.$tiny[0]));

        
        $getPropertyImages->delete();

        return redirect()->to('property/'.$propertycode.'/images')->with('message','Image deleted succesfully!!');
        //return view('admin.propertys.imagesindex',compact('property_details'));
    }

    public function addimages(Request $request){

        $propertycode   =   $request->get('propertycode');
        
        //dd('<img src="'.URL::to('/').'/storage/images/thumbnail/1597746078.png" border="0" alt="" />');

        $images = $request->file('images');
        
        foreach ($images as $key => $value)
        {
            $input['imagename'] = $key.time().'.'.$value->getClientOriginalExtension();
            
            $destinationPath = public_path('storage/images/tiny');
            $img = Image::make($value->getRealPath())->resize(103, 102, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath.'/'.$input['imagename']);
            $tiny = '<img src="'.URL::to('/').'/storage/images/tiny/'.$input['imagename'].'" border="0" alt="" />';

            $destinationPath = public_path('storage/images/thumbnails');
            $img = Image::make($value->getRealPath())->resize(149, 74, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath.'/'.$input['imagename']);
            $thumbnails = '<img src="'.URL::to('/').'/storage/images/thumbnails/'.$input['imagename'].'" border="0" alt="" />';

            $destinationPath = public_path('storage/images/main');
            $img = Image::make($value->getRealPath())->resize(500, 334, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($destinationPath.'/'.$input['imagename']);
            $main = '<img src="'.URL::to('/').'/storage/images/main/'.$input['imagename'].'" border="0" alt="" />';

            $property_imagesModel = new PropertyImages();
            $property_images = array();
            $property_images = [
                'propertycode' => $propertycode,
                'tiny' => $tiny,
                'thumb' => $thumbnails,
                'main' => $main,
            ];
            $ImagesDetails = $property_imagesModel->create($property_images);
            unset($input);
            unset($property_images);
            
        }    
        
        return redirect()->to('property/'.$propertycode.'/images')->with('message','Image uploaded!!');
        
    }

    public function store(Request $request){
        $data = $request->all();
        $data['role_id'] = User::COMPANY_USER;

        if(Auth::user()->role->id != User::SUPER_ADMIN){
            $data['company_id'] = Auth::user()->company->id;
        }

        if(User::validator($data)->validate()){
            $user =  User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'role_id' => User::COMPANY_USER,
                'company_id' => $data['company_id'],
            ]);

            $user->password = Hash::make($data['password']);
            $user->save();

            $users = User::all();
            return view('admin.users.index', ['users' => $users]);
        }

    }

    public function edit($id){
        
        $property = PropertyDetails::find($id);
        $houserules = HouseRules::all();
        if($property instanceof PropertyDetails) {
            $data['property'] = $property;
            $data['houserules'] = $houserules;
            return view('admin.property.edit')->with('data',$data);
        } else {

        }
    }

    public function update(Request $request, $id){

        $property = PropertyDetails::find($id);
        if($request->get('house_rules')){
            $house_rules    =   implode('_',$request->get('house_rules'));
        }
        if($property instanceof PropertyDetails) {
            $property->update([
                'propertyname'          => $request->get('propertyname'),
                'title'                 => $request->get('title'),
                'metadescription'       => $request->get('metadescription'),
                'metakeywords'          => $request->get('metakeywords'),
                'cottageweblocation'    => $request->get('cottageweblocation'),
                'webdescription'        => $request->get('webdescription'),
                'propertystars'         => $request->get('propertystars'),
                'longitude'             => $request->get('longitude'),
                'latitude'              => $request->get('latitude'),
                'checkin'               => $request->get('checkin'),
                'checkout'              => $request->get('checkout'),
                'adults'                => $request->get('adults'),
                'children'              => $request->get('children'),
                'infants'               => $request->get('infants'),
                'sleeps'                => $request->get('sleeps'),
                'propertyaddress'       => $request->get('propertyaddress'),
                'regionname'            => $request->get('regionname'),
                'country'               => $request->get('country'),
                'countryiso'            => $request->get('countryiso'),
                'propertypostcode'      => $request->get('propertypostcode'),
                'bedrooms_new'          => $request->get('bedrooms_new'),
                'bathrooms_new'         => $request->get('bathrooms_new'),
                'siteID'                => $request->get('siteID'),
                'ownerID'               => $request->get('ownerID'),
                'propertyownerID'       => $request->get('propertyownerID'),
                'groupID'               => $request->get('groupID'),
                'propertyminbookingdays'=> $request->get('propertyminbookingdays'),
                'managerID'             => $request->get('managerID'),
                'managername'           => $request->get('managername'),
                'manageremail'          => $request->get('manageremail'),
                'nearest_beach'         => $request->get('nearest_beach'),
                'airport_distence'      => $request->get('airport_distence'),
                'cancellation_policy'   => $request->get('cancellation_policy'),
                'house_rules'           => $house_rules
            ]);

            return redirect()->to('/property')
                ->with('message','Record updated Successfully!!');
        } else {
            return redirect()->to('/property')
                ->with('message','Record not Found!!');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $user = User::find($id);
        if($user instanceof User) {
            $user->delete();
            $response = [
                'success' => false,
                'data' => 'Record Deleted successfully!!'
            ];
        } else {
            $response = [
                'success' => false,
                'data' => 'Record not found!!'
            ];
        }
        return response()->json($response);
    }
}