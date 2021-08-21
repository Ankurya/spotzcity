<?php

namespace SpotzCity;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'user_id', 'name', 'starts', 'ends', 'venue',
      'website', 'description'
    ];

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = [
      'starts', 'ends'
    ];

    protected $geofields = array('geolocation');
    protected $hidden = ['raw_location'];


    public function setGeolocationAttribute($value) {
        $this->attributes['geolocation'] = DB::raw("POINT($value)");
    }

    public function getGeolocationAttribute($value){

        $loc = substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);

        return substr($loc,0,-1);
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach($this->geofields as $column){
            //$raw .= $column.' as raw_'.$column.', astext('.$column.') as '.$column;
			 $raw .= $column.' as raw_'.$column.', '.$column.' as '.$column;
        }

        return parent::newQuery($excludeDeleted)->addSelect('*',DB::raw($raw));
    }

    public function geocodeLocation(){
      try{
        $geocode = app('geocoder')->geocode("$this->location")->get()->first();
      } catch(\Exception $e){
        return false;
      }
      $this->setGeolocationAttribute("{$geocode->getCoordinates()->getLongitude()}, {$geocode->getCoordinates()->getLatitude()}");
      return $geocode;
    }


    // Model Relationships
    public function user(){
      return $this->belongsTo(User::class);
    }
}
