<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rating', 'body'
    ];

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function business(){
      return $this->belongsTo(Business::class);
    }

    public function response(){
      return $this->hasOne(ReviewResponse::class);
    }
}
