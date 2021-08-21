<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public function user(){
      return $this->belongsTo(User::class);
    }

    public function business(){
      return $this->belongsTo(Business::class);
    }
}
