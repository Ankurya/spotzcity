<?php

namespace SpotzCity;

use SpotzCity\ECategoryLink;

use Illuminate\Database\Eloquent\Model;

class ECategoryLink extends Model
{
  public $timestamps = false;

  public function category(){
    return $this->hasOne(ECategory::class, 'id', 'e_category_id');
  }

  public function business(){
    return $this->belongsTo(Business::class);
  }
}

