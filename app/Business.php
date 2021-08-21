<?php

namespace SpotzCity;

use Carbon\Carbon;
use Lava\Lava;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{

    protected $geofields = array('location');
    protected $hidden = ['raw_location'];


    public function setLocationAttribute($value) {
        $this->attributes['location'] = DB::raw("POINT($value)");
    }

    public function getLocationAttribute($value){

        $loc = substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);

        return substr($loc,0,-1);
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach($this->geofields as $column){
            $raw .= $column.' as raw_'.$column.', ST_AsWKT('.$column.') as '.$column;
        }

        return parent::newQuery($excludeDeleted)->addSelect('*',DB::raw($raw));
    }

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function reviews(){
      return $this->hasMany(Review::class);
    }

    public function sale_info(){
      return $this->hasOne(SaleInfo::class);
    }

    public function eventsAndSpecials(){
      return $this->hasMany(BusinessEvent::class);
    }

    public function e_categories(){
      return $this->hasMany(ECategoryLink::class);
    }

    public function commodities(){
      return $this->hasMany(CommodityLink::class);
    }

    public function hours(){
      return $this->hasOne(BusinessHours::class);
    }

    public function views(){
      return $this->hasMany(BusinessView::class);
    }

    public function follows(){
      return $this->hasMany(Follow::class)->with('user');
    }

    public function activity(){
      return $this->hasMany(Activity::class);
    }

    // Refactor this eventually
    public function parsedHours(){
      $hours = [
        'Monday' => [],
        'Tuesday' => [],
        'Wednesday' => [],
        'Thursday' => [],
        'Friday' => [],
        'Saturday' => [],
        'Sunday' => []
      ];

      if(!$this->hours){
        return $hours;
      }

      $unparsed = $this->hours->toArray();

      foreach ($unparsed as $key => $time) {
        if($key == "id" || $key == "business_id" || !$time){
          continue;
        }

        switch($key){
          case "mon_open":
            $hours["Monday"]["opens"] = $time;
            $hours["Monday"]["opens_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "mon_close":
            $hours["Monday"]["closes"] = $time;
            $hours["Monday"]["closes_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "tue_open":
            $hours["Tuesday"]["opens"] = $time;
            $hours["Tuesday"]["opens_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "tue_close":
            $hours["Tuesday"]["closes"] = $time;
            $hours["Tuesday"]["closes_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "wed_open":
            $hours["Wednesday"]["opens"] = $time;
            $hours["Wednesday"]["opens_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "wed_close":
            $hours["Wednesday"]["closes"] = $time;
            $hours["Wednesday"]["closes_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "thu_open":
            $hours["Thursday"]["opens"] = $time;
            $hours["Thursday"]["opens_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "thu_close":
            $hours["Thursday"]["closes"] = $time;
            $hours["Thursday"]["closes_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "fri_open":
            $hours["Friday"]["opens"] = $time;
            $hours["Friday"]["opens_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "fri_close":
            $hours["Friday"]["closes"] = $time;
            $hours["Friday"]["closes_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "sat_open":
            $hours["Saturday"]["opens"] = $time;
            $hours["Saturday"]["opens_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "sat_close":
            $hours["Saturday"]["closes"] = $time;
            $hours["Saturday"]["closes_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "sun_open":
            $hours["Sunday"]["opens"] = $time;
            $hours["Sunday"]["opens_formatted"] = Carbon::parse($time)->format('h:i A');
            break;

          case "sun_close":
            $hours["Sunday"]["closes"] = $time;
            $hours["Sunday"]["closes_formatted"] = Carbon::parse($time)->format('h:i A');
            break;
        }
      }
      return $hours;
    }

    public function e_categories_concat(){
      $links = $this->hasMany(ECategoryLink::class)->get();
      $categories = [];
      foreach ($links as $key => $link) {
        $categories[] = $link->category->name;
      }
      return $categories;
    }

    public function commodities_concat(){
      $links = $this->hasMany(CommodityLink::class)->get();
      $commodities = [];
      foreach ($links as $key => $link) {
        $commodities[] = $link->commodity->name;
      }
      return $commodities;
    }

    public function featured_photos(){
      if(!$this->feature_photos) return [];
      return unserialize($this->feature_photos);
    }

    public function parsed_featured_photos(){
      if(!$this->feature_photos) return;
      $parsed = [];
      foreach (unserialize($this->feature_photos) as $photo) {
        $parsed[] = asset("storage/$photo");
      }
      return json_encode($parsed);
    }

    public function generateSlug(){
      $this->slug = str_replace([" ", "/", "'", '"', '\\', "#"], "-", "$this->name $this->city $this->state $this->zip");
      $exists = Business::where('slug', $this->slug)->first();
      if($exists){
        $this->slug = "-$this->slug";
      }
      return $this->slug;
    }

    public function geocodeAddress(){
      try {
        $geocode = app('geocoder')->geocode("$this->address $this->address2, $this->city, $this->state $this->zip")->get()->first();
		if(isset($geocode)){
			$this->lat = $geocode->getCoordinates()->getLatitude();
			$this->lng = $geocode->getCoordinates()->getLongitude();
			$this->setLocationAttribute("$this->lng, $this->lat");
			return $geocode;
		}
      } catch( \Exception $e ) {
        Bugsnag::notifyException( $e );
      }
    }

    public function calcRating(){
      $rating = DB::table('reviews')
        ->where('business_id', $this->id)
        ->avg('rating');

      $count = DB::table('reviews')
        ->where('business_id', $this->id)
        ->count();

      $this->review_count = $count;
      $this->rating = $rating ? $rating : null;
      return $this->rating;
    }

    public function generateScorecardChart(){
      $table = \Lava::DataTable();

      $table->addStringColumn('Spotz');
      $table->addNumberColumn('Total');

      for($i=5;$i>0;$i--){
        $table->addRow([
          ($i).' Spotz',
          $this->reviews->where('rating', $i)->count()
        ]);
      }

      $chart = \Lava::BarChart('Scorecard'.$this->id, $table, [
        'isStacked' => true,
        'height' => 300,
        'width'=> 500
      ]);
    }

    public function generateTotalPageViewsChart(){
      $table = \Lava::DataTable();

      $table->addStringColumn('Month');
      $table->addNumberColumn('Views');

      $intervals = [];

      $start = Carbon::now()->startOfMonth();
      $end = Carbon::now()->endOfMonth();
      $intervals[ $start->format('M y') ] = $this->views()->whereBetween('created_at', [$start, $end])->count();

      for($i=1;$i<12;$i++){
        $start = Carbon::now()->subMonths($i)->startOfMonth();
        $end = Carbon::now()->subMonths($i)->endOfMonth();
        $intervals[ $start->format('M y') ] = $this->views()->whereBetween('created_at', [$start, $end])->count();
      }

      foreach (array_reverse($intervals) as $label => $value) {
        $table->addRow([
          $label,
          $value
        ]);
      }

      $chart = \Lava::LineChart('Total Views - '.$this->id, $table, [
        'chartArea' => [
          'left' => 30,
          'right' => 0,
          'top' => 20
        ],
        'hAxis' => [
          'textStyle' => [
            'fontSize' => 15
          ]
        ],
        'legend' => [
          'position' => 'in'
        ],
        'height' => 350
      ]);
    }


    public function generatePageViewsByRegisteredChart(){
      $table = \Lava::DataTable();

      $table->addStringColumn('Status');
      $table->addNumberColumn('Views');

      $table->addRow([
        'Registered',
        $this->views()->where('user_id', '!=', null)->count()
      ]);

      $table->addRow([
        'Unregistered',
        $this->views()->where('user_id', '=', null)->count()
      ]);

      $pie_chart = \Lava::PieChart('Status Pie - '.$this->id, $table, [
        'chartArea' => [
          'left' => 0,
          'top' => 20
        ],
        'height' => 300
      ]);

      return $table;
    }


    public function generatePageViewsByZipChart(){
      $unique_zips = $this->views()->select('zip')->distinct('zip')->get();

      $table = \Lava::DataTable();

      $table->addStringColumn('ZIP');
      $table->addNumberColumn('Views');

      foreach ($unique_zips as $value) {
        $table->addRow([
          $value->zip ? $value->zip : 'Unknown',
          $this->views()->where('zip', $value->zip)->count()
        ]);
      }

      $chart = \Lava::PieChart('Zip Pie - '.$this->id, $table, [
        'chartArea' => [
          'left' => 0,
          'top' => 20
        ],
        'height' => 300
      ]);

      return $table;
    }


    public function generatePageViewsByCityChart(){
      $unique_cities = $this->views()->select('city')->distinct('city')->get();

      $table = \Lava::DataTable();

      $table->addStringColumn('City');
      $table->addNumberColumn('Views');

      foreach ($unique_cities as $value) {
        $table->addRow([
          $value->city ? $value->city : 'Unknown',
          $this->views()->where('city', $value->city)->count()
        ]);
      }

      $chart = \Lava::PieChart('City Pie - '.$this->id, $table, [
        'chartArea' => [
          'left' => 0,
          'top' => 20
        ],
        'height' => 300
      ]);

      return $table;
    }


    public function generatePageViewsByStateChart(){
      $unique_states = $this->views()->select('state')->distinct('state')->get();

      $table = \Lava::DataTable();

      $table->addStringColumn('State');
      $table->addNumberColumn('Views');

      foreach ($unique_states as $value) {
        $table->addRow([
          $value->state ? $value->state : 'Unknown',
          $this->views()->where('state', $value->state)->count()
        ]);
      }

      $chart = \Lava::PieChart('State Pie - '.$this->id, $table, [
        'chartArea' => [
          'left' => 0,
          'top' => 20
        ],
        'height' => 300
      ]);

      return $table;
    }


    public function scopeSearch($query){
      // Might not need this
      // return $query->select()
    }

}

