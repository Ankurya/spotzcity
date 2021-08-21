<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function subscription(){
      return $this->belongsTo(Subscription::class);
    }
}
