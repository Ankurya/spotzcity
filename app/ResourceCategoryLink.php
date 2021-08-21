<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class ResourceCategoryLink extends Model
{

    public $timestamps = false;

    // Model relationships
    public function category(){
      return $this->hasOne(ResourceCategory::class);
    }
}
