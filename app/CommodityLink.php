<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class CommodityLink extends Model
{
  public $timestamps = false;

  public function commodity(){
    return $this->hasOne(Commodity::class, 'id', 'commodity_id');
  }

  public function business(){
    return $this->belongsTo(Business::class);
  }
}
