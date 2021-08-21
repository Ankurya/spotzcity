<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class AdClick extends Model
{
    protected $casts = [
      'metadata' => 'array'
    ];

    public function user(){
      return $this->belongsTo(User::class);
    }
}
