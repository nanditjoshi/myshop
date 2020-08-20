<?php
/**
 * Created by PhpStorm.
 * User: Jiten Patel
 * Date: 4/12/2019
 * Time: 6:10 PM
 */

namespace App\Helpers;

use App\Models\Company;
use App\Models\Role;
use Illuminate\Support\Facades\URL;
use Carbon\Carbon;


class Helpers {
    public static function getRoleList() {
        return Role::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public static function getCompanyList() {
        return Company::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public static function siteDateFormate($date) {
        //return Carbon::parse(str_replace('/','-', $dateValue))->format('Y-m-d H:i:s');
        return Carbon::parse($date)->format('d/m/Y');
    }
    
    public static function getGeneralActions($query, $module){
        $strHtml = '';
        foreach (self::getActions() as $action => $class) {
            if($action == 'edit') {
                $strHtml .= '<div class="btn-group btn-group-sm">';
                $href = URL::to('/'.$module.'/' . $query->id . '/edit');
                $strHtml .= '<a href="'.$href.'" class="btn btn btn-info action-'.$action.'" title="'.$action.'"><i class="fa '.$class.'"></i></a>';
            } elseif ($action == 'delete') {
                //$strHtml .= '';
                $href = URL::to('/'.$module.'/' . $query->id);
                $strHtml .= '<a href="#" data-action-url="'.$href.'" class="btn btn-danger action-'.$action.'" title="'.$action.'"><i class="fa '.$class.'"></i></a>';
                //$strHtml .= '</div>';
            }elseif ($action == 'show') {
                //$strHtml .= '';
                $href = URL::to('/'.$module.'/' . $query->id. '/show');
                $strHtml .= '<a href="'.$href.'" class="btn btn btn-info action-'.$action.'" title="'.$action.'"><i class="fa '.$class.'"></i></a>';
                $strHtml .= '</div>';
            }
        }
        
        return $strHtml;
    }

    public static function getActions(){
        return [
            'edit' => 'fas fa-edit',
            'show' => 'fas fa-eye',
           // 'delete' => 'fa-trash'
        ];
    }
}