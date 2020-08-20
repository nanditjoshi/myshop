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
use App\Models\Orders;
use App\Models\OrderPassengers;
use App\Models\OrderProperty;
use App\Models\Transfer;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\URL;


class BookingController extends Controller {

    public function index() {
        return view('admin.bookings.index');
    }

    public function browse(Request $request){
       
            //$query = Orders::select('*');
            $query = Orders::with('orderPassangers');
            
            return Datatables::of($query)
            ->editColumn('id', function($query) {
                return '<input type="checkbox" name="row_id" id="checkbox_'.$query->id.'" value="'.$query->id.'">';
            })

            ->editColumn('created_at', function($query) {
                return Helpers::siteDateFormate($query->created_at);
            })

            ->editColumn('startdate', function($query) {
                return Helpers::siteDateFormate($query->startdate);
            })

            ->editColumn('passenger', function($query) {
                $module = 'bookings';
                $href = URL::to('/'.$module.'/' . $query->id . '/details');

                return $strHtml = '<div class="btn-group"><a href="'.$href.' "class="btn btn-block bg-gradient-info" title="View Fill Booking Details"><i class="fa fa-eye"></i></a></div>';
                //return "<a href='$query->id'>View Fill Booking Details</a>";
            })
           /* ->editColumn('action', function($query) {
                return Helpers::getGeneralActions($query, 'users');
            })*/
       
            ->rawColumns(['id','created_at','startdate', 'passenger'])
            ->make(true);
    }

    
    public function details($id){
        
        $booking_details = Orders::with('orderPassangers','orderPropertys')->find($id);
        
        //dd($booking_details);
        
        return view('admin.bookings.detail',compact('booking_details'));
    }

    
}