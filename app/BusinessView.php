<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class BusinessView extends Model
{
    protected $casts = [
      'metadata' => 'array'
    ];

    // Relationships
    public function user(){
      return $this->belongsTo(User::class);
    }

    public function business(){
      return $this->belongsTo(Business::class);
    }
}
