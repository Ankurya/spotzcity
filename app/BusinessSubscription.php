<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

use \Stripe as Stripe;

class BusinessSubscription extends Model
{
  protected $fillable = [
    'billing_id'
  ];

  public function billing(){
    return $this->belongsTo(Billing::class);
  }
}
