<?php
/**
 * User: Nandit Joshi
 * Date: 06/08/2020
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HouseRules;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class HouseRulesController extends Controller {

    public function index() {
        return view('admin.houserules.index');
    }

    public function create() {
        return view('admin.houserules.form');
    }

    public function store(Request $request){
    
        $data = $request->all();
        
        $query = HouseRules::where('rules',$data['rules'])->get();   
        if(count($query) > 0)
        {
            return redirect()->to('/propertys')->with('message','House Rule Already Exixt!!');    
        }else{
            $houserules =  HouseRules::create([
                'rules' => $data['rules'],
            ]);
            $houserules->save();
            $houserules = HouseRules::all();
            //return view('admin.propertys.index', ['HouseRules' => $houserules]);
            return redirect()->to('/propertys')->with('message','House Rule Added!!');
        } 
    }

    public function browse(Request $request){
       
            $query = HouseRules::select('*');
       
        return Datatables::of($query)
            ->editColumn('id', function($query) {
                return '<input type="checkbox" name="row_id" id="checkbox_'.$query->id.'" value="'.$query->id.'">';
            })
       
            ->editColumn('action', function($query) {
                return Helpers::getGeneralActions($query, 'houserules');
            })
       
            ->rawColumns(['action', 'id'])
            ->make(true);
    }

    

    public function edit($id){
        $user = User::find($id);
        if($user instanceof User) {
            $data['user'] = $user;
            return view('admin.houserules.edit')->with('data',$data);
        } else {

        }
    }

    public function update(Request $request, $id){

        $user = User::find($id);
        if($user instanceof User) {
            $user->update([
                'name' => $request->get('first_name'),
            ]);
            return redirect()->to('/users')
                ->with('message','Record updated Successfully!!');
        } else {
            return redirect()->to('/users')
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