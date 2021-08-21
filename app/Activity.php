<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = "activity";

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function business(){
      return $this->belongsTo(Business::class);
    }

    public function review(){
      return $this->belongsTo(Review::class);
    }

    public function business_event(){
      return $this->belongsTo(BusinessEvent::class);
    }

    public function review_response(){
      return $this->belongsTo(ReviewResponse::class);
    }
}
