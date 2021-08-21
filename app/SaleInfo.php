<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class SaleInfo extends Model
{
    protected $table = 'sale_info';

    protected $fillable = [
      'ein', 'sale_price', 'established', 'gross_income', 'reason'
    ];

    // Relationships
    public function business(){
      return $this->belongsTo(Business::class);
    }
}
