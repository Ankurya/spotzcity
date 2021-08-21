<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    // Mass assignment
    protected $fillable = [
      'name', 'user_id', 'website', 'city', 'state', 'phone',
      'type'
    ];


    // Model relationships
    public function categories(){
      return $this->hasMany(ResourceCategoryLink::class);
    }

    public function user(){
      return $this->belongsTo(User::class);
    }
}
