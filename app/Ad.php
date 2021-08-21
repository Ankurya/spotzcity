<?php

namespace SpotzCity;

use \Stripe as Stripe;
use Carbon\Carbon;
use Lava\Lava;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public function user(){
      return $this->belongsTo(User::class);
    }

    public function clicks(){
      return $this->hasMany(AdClick::class);
    }

    public function sizeType(){
      return explode('-', $this->type)[1];
    }

    public function fetchPlanInfo(){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));
      return Stripe\Plan::retrieve($this->type);
    }


    public function generateClicksByMonthChart(){
      $table = \Lava::DataTable();

      $table->addStringColumn('Month');
      $table->addNumberColumn('Clicks');

      $intervals = [];

      $start = Carbon::now()->startOfMonth();
      $end = Carbon::now()->endOfMonth();
      $intervals[ $start->format('M y') ] = $this->clicks()->whereBetween('created_at', [$start, $end])->count();

      for($i=1;$i<12;$i++){
        $start = Carbon::now()->subMonths($i)->startOfMonth();
        $end = Carbon::now()->subMonths($i)->endOfMonth();
        $intervals[ $start->format('M y') ] = $this->clicks()->whereBetween('created_at', [$start, $end])->count();
      }

      foreach (array_reverse($intervals) as $label => $value) {
        $table->addRow([
          $label,
          $value
        ]);
      }

      $chart = \Lava::LineChart('Total Clicks - '.$this->id, $table, [
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


    public function generateClicksByPageChart(){
      $unique_pages = $this->clicks()->select('page')->distinct('page')->get();

      $table = \Lava::DataTable();

      $table->addStringColumn('Page');
      $table->addNumberColumn('Views');

      foreach ($unique_pages as $value) {
        $table->addRow([
          $value->page == '/' ? $value->page : "/$value->page",
          $this->clicks()->where('page', $value->page)->count()
        ]);
      }

      $chart = \Lava::PieChart('Page Ad Clicks - '.$this->id, $table, [
        'chartArea' => [
          'left' => 0,
          'top' => 20
        ],
        'height' => 300
      ]);

      return $table;
    }


    public function generateClicksByZipChart(){
      $unique_zips = $this->clicks()->select('zip')->distinct('zip')->get();

      $table = \Lava::DataTable();

      $table->addStringColumn('ZIP');
      $table->addNumberColumn('Views');

      foreach ($unique_zips as $value) {
        $table->addRow([
          $value->zip ? $value->zip : 'Unknown',
          $this->clicks()->where('zip', $value->zip)->count()
        ]);
      }

      $chart = \Lava::PieChart('Zip Ad Clicks - '.$this->id, $table, [
        'chartArea' => [
          'left' => 0,
          'top' => 20
        ],
        'height' => 300
      ]);

      return $table;
    }


    public function generateClicksByCityChart(){
      $unique_cities = $this->clicks()->select('city')->distinct('city')->get();

      $table = \Lava::DataTable();

      $table->addStringColumn('City');
      $table->addNumberColumn('Views');

      foreach ($unique_cities as $value) {
        $table->addRow([
          $value->city ? $value->city : 'Unknown',
          $this->clicks()->where('city', $value->city)->count()
        ]);
      }

      $chart = \Lava::PieChart('City Ad Clicks - '.$this->id, $table, [
        'chartArea' => [
          'left' => 0,
          'top' => 20
        ],
        'height' => 300
      ]);

      return $table;
    }


    public function generateClicksByStateChart(){
      $unique_states = $this->clicks()->select('state')->distinct('state')->get();

      $table = \Lava::DataTable();

      $table->addStringColumn('State');
      $table->addNumberColumn('Views');

      foreach ($unique_states as $value) {
        $table->addRow([
          $value->state ? $value->state : 'Unknown',
          $this->clicks()->where('state', $value->state)->count()
        ]);
      }

      $chart = \Lava::PieChart('State Ad Clicks - '.$this->id, $table, [
        'chartArea' => [
          'left' => 0,
          'top' => 20
        ],
        'height' => 300
      ]);

      return $table;
    }
}
