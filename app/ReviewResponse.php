<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class ReviewResponse extends Model
{

    protected $fillable = [
      'body'
    ];

    public function review(){
      return $this->belongsTo(Review::class);
    }
}
