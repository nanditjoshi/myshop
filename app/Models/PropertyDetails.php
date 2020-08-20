<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyImages;
use App\Models\PropertyVariables;

class PropertyDetails extends Model
{
    protected $fillable = [
        'propertycode',
        'propertyname',
        'propertystars',
        'propertypostcode',
        'longitude',
        'latitude',
        'country',
        'countryiso',
        'regionname',
        'adults',
        'children',
        'infants',
        'bedrooms_new',
        'bathrooms_new',
        'deposittype',
        'checkin',
        'checkout',
        'title',
        'metadescription',
        'metakeywords',
        'json_data',
        'siteID',
        'ownerID',
        'propertyownerID',
        'groupID',
        'managerID',
        'managername,',
        'manageremail',
        'propertyminbookingdays',
        'propertyaddress',
        'availabilitylink',
        'lastupdate',
        'photolastupdate',
        'cottageweblocation',
        'webdescription',
        'nearest_beach',
        'airport_distence',
        'cancellation_policy',
        'house_rules',
        'sleeps',
        /*
        Relation tabel

        translated
        interim
        photos
        variables
        prices
        testimonials
        options

        */

    ];

    public function propertyImages(){
        return $this->hasMany('App\Models\PropertyImages','propertycode','propertycode');
    }

    public function propertyVariables(){
        return $this->hasMany('App\Models\PropertyVariables','propertycode','propertycode');
    }

}
