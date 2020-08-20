
## About Project Setup

- Laravel Version 6+
- make .env file from .env.example
- Run `php artisan key:generate` in a Laravel project where the .env file does not contain an APP_KEY
- Run `composer update` to update the composer
- Change  permission of storage and booststrap folder
- Create data-base and configure it 
- run `php artisan migrate` and start server
- run `php artisan daily:update` to insert and updae the property in database.
- run `YOURLOCALHOST:PORT/curl-check` using this the data inserted in your databsse from API 
 
## Some Basic Rules
- controller and model name in first lattercapital like `PropertyUpdate`
- Under controller functions name in camelcase like `checkCurl`

## Some Commands
- `php artisan make:model property_update -m`  // to create migration and model 
- `php artisan make:migration add_paid_to_users_table --table=users`  // add fields in tabel after migration
-  Drop All Tables and run migration again `php artisan migrate:fresh`
- `php artisan clear:all` Clearing Cache,View,Route,Config



## Payment API
https://developers.mypos.eu/en/doc/getting_started/v1_0/321-payment-solutions
https://developers.mypos.eu/en/doc/online_payments/v1_4/226-test-data

## Postel Address API
https://getaddress.io/

## Search all property price
https://api.supercontrol.co.uk/xml/filter3.asp?siteID=16145&startdate=2020-08-22&numbernights=2&regionname=Ayia%20Napa&sleeps=1&basic_details=1

## Property Detail API
https://api.supercontrol.co.uk/xml/property_xml.asp?id=357188&siteID=40908
https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&regionname=Paphos&startdate=2020-06-20&numbernights=7
https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-06-23&numbernights=7&regionname=Paphos&basic_details=1
https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-06-23&numbernights=7&regionname=Paphos&propertycode=357188&basic_details=1
https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-06-20&numbernights=8&basic_details=1
&basic_details=1 shows basic detalis only
https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-06-20&numbernights=8

siteID  required - the relevant selection of properties for a website.
startdate: yyyy-mm-dd - only use if performing an availability search
numbernights: integer - must be specified if using the startdate (otherwise a default of 3 nights will be used)

no_price_err=1  this will only return properties with a price.
prices_only: integer - Use "prices_only=1" to return properties with a price only
regionname: string - Filter results by region name

town: string - specifying the town specified in the propertytown element of the property list or the town list

show_disabled: You can use it like "show_disabled=X to return live, archived and disabled properties only:
show_disabled=0 - to show only live properties
show_disabled=1 - to show only live and disabled properties
show_disabled:
show_disabled=2 - to show only disabled properties
show_disabled=3 - to show all properties
show_disabled=4 - to show all except live properties

propertycode_only=1 Use "propertycode_only=1" to display only property codes

https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-06-20&numbernights=7&basic_details=1

https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-06-20&numbernights=8

## For static IP
https://openvpn.net/openvpn-client-for-linux/
openvpn3 session-start --config /home/avdevs/Downloads/avdevs-vpn-user9.ovpn
openvpn3 sessions-list
openvpn3 session-manage --session-path /net/openvpn/v3/sessions/..... --disconnect

## For cron job
https://laravel.com/docs/5.4/scheduling
https://www.rumahweb.com/journal/running-php-artisan-laravel-menggunakan-cron-jobs-cpanel/
crontab -e
crontab -l
grep CRON /var/log/syslog
tail -f /var/log/syslog


## Admin Them
https://adminlte.io/docs/2.4/installation
https://github.com/akhileshdarjee/origin-cms
https://adminlte.io/themes/AdminLTE/pages/layout/fixed.html

login
https://auth0.com/blog/creating-your-first-laravel-app-and-adding-authentication/

# Icon missing Listing page
Services
Kitchen Facilities
Home Entertainment
FlipKey Specific
Category
Website
Resort
Business Amenities
Airbnb

# Icon missing Detail page
Kitchen Facilities
Home Entertainment
FlipKey Specific
Website
Bathrooms
Resort
Business Amenities
Airbnb
Meal Type
Onsite Facilities


# on json fiedl query
SELECT id,json_data, json_extract(json_data, '$.property.sleeps') AS POPL_MALE FROM `property_details` 
update property_details set capacity = ( SELECT json_extract(json_data, '$.property.sleeps') FROM `property_details` )

# Distance query
SELECT *  FROM (  SELECT *,  (    SELECT SUM(sleeps)      FROM property_details     WHERE sleeps >= 15  ) total    FROM property_details t) q WHERE total >= 15 ORDER BY  ABS(ABS(q.`latitude`-53.63) + ABS(q.`longitude`-9.9)) ASC

SELECT propertycode, SUM(sleeps) total_sleeps FROM property_details GROUP BY `propertypostcode` HAVING SUM(sleeps) >= 15 ORDER BY propertycode DESC;

select a.id,a.sleeps, b.id,b.sleeps, c.id,c.sleeps, d.id,d.sleeps from property_details a, property_details b, property_details c , property_details d where (a.sleeps+b.sleeps+c.sleeps+d.sleeps) >= 50 

select a.id,a.sleeps, b.id,b.sleeps from property_details a, property_details b where (a.sleeps+b.sleeps) >= 15 ORDER BY ABS(ABS(a.`latitude`-53.63) + ABS(a.`longitude`-9.9)) ASC 

https://api.supercontrol.co.uk/xml/filter3.asp?siteID=40908&startdate=2020-09-09&numbernights=3%20Nights&regionname=Latchi&sleeps=2&basic_details=1


###  query for virtual property ####
SELECT a.id AS from_property_details, b.id AS to_property_details, 
   111.111 *
    DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.latitude))
         * COS(RADIANS(b.latitude))
         * COS(RADIANS(a.longitude - b.longitude))
         + SIN(RADIANS(a.latitude))
         * SIN(RADIANS(b.latitude))))) AS distance_in_km
  FROM property_details AS a
  JOIN property_details AS b ON a.id <> b.id
 WHERE (a.sleeps+b.sleeps) >= 20 ORDER BY distance_in_km ASC

 $property_list = DB::table(DB::raw('property_details as a'),DB::raw('property_details as b'))
        ->select(
                    DB::raw('a.*'),
                    DB::raw('b.propertycode as bpropertycode'),
                    DB::raw('b.propertyname as bpropertyname')
                )
        ->join(DB::raw('property_details as b'), DB::raw('a.id'),'<>', DB::raw('b.id'))
        ->where(DB::raw('a.regionname'),'like', '%Ayia Napa%')
        ->where(((DB::raw('a.sleeps'))+(DB::raw('b.sleeps'))),'>=', 20)
        ->offset(0)->limit(5)->get();


/// Query for three property
        /*if($property_list->total() == 0){
            $query_for  =   3;
            $property_list = DB::table(DB::raw('property_details as a'),DB::raw('property_details as b'),DB::raw('property_details as c'))
            ->select(
                        DB::raw('a.*'),
                        DB::raw('b.propertycode as bpropertycode'),
                        DB::raw('b.propertyname as bpropertyname'),
                        DB::raw('c.propertycode as cpropertycode'),
                        DB::raw('c.propertyname as cpropertyname'),
                        DB::raw('(111.111 *
                        DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.latitude))
                            * COS(RADIANS(b.latitude))
                            * COS(RADIANS(a.longitude - b.longitude))
                            + SIN(RADIANS(a.latitude))
                            * SIN(RADIANS(b.latitude))))) + 111.111 *
                            DEGREES(ACOS(LEAST(1.0, COS(RADIANS(a.latitude))
                                * COS(RADIANS(c.latitude))
                                * COS(RADIANS(a.longitude - c.longitude))
                                + SIN(RADIANS(a.latitude))
                                * SIN(RADIANS(c.latitude))))) ) AS distance_in_km')
                    )
            ->join(DB::raw('property_details as b'), DB::raw('a.propertycode'),'<>', DB::raw('b.propertycode'))
            ->join(DB::raw('property_details as c'), DB::raw('a.propertycode'),'<>', DB::raw('c.propertycode'))
            ->where(DB::raw('b.propertycode'), '<>' , DB::raw('c.propertycode'))
            ->where(DB::raw('a.regionname'),'like', '%'.$destination.'%')
            ->where((DB::raw('a.sleeps + b.sleeps + c.sleeps')), '>=' , $sleeps)
            ->where(function($q)use ($propertycode)  {
                $q->whereIn((DB::raw('a.propertycode')),$propertycode)
                ->whereIn((DB::raw('b.propertycode')),$propertycode)
                ->whereIn((DB::raw('c.propertycode')),$propertycode);
            })       
            ->orderByRaw('distance_in_km', 'ASC')
            //dd($property_list->tosql());
            ->paginate(10);
        }*/