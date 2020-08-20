<?php
/**
 * User: Nandit Joshi
 * Date: 06/08/2020
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller {

    public function index() {
        return view('admin.users.index');
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
       
            $query = User::select('*');
       
        return Datatables::of($query)
            ->editColumn('id', function($query) {
                return '<input type="checkbox" name="row_id" id="checkbox_'.$query->id.'" value="'.$query->id.'">';
            })
       
            ->editColumn('action', function($query) {
                return Helpers::getGeneralActions($query, 'users');
            })
       
            ->rawColumns(['action', 'id'])
            ->make(true);
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
        $user = User::find($id);
        if($user instanceof User) {
            $data['user'] = $user;
            return view('admin.users.edit')->with('data',$data);
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