<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

use \Stripe as Stripe;

class Subscription extends Model
{
  protected $fillable = [
    'subscription_id', 'type', 'monthly_cost'
  ];

  public function billing(){
    return $this->belongsTo(Billing::class);
  }

  public function invoices(){
    return $this->hasMany(Invoice::class);
  }

  public function ad(){
    if($this->type == 'resources'){
      return false;
    }
    $ad = Ad::where('active', $this->id)->first();
    return $ad;
  }

  public function parsedType(){
    if($this->type == 'resources'){
      return 'Resources';
    }
    $words = explode('-', $this->type);
    $parsed = ucfirst($words[0])." ".ucfirst($words[1])." ";
    $parsed .= $words[2] == 'bb' ? 'Big Business' : 'Small Business';

    return $parsed;
  }

  public function cancel($cancel_remote = true){
    Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));

    if($cancel_remote){
      $stripe_sub = Stripe\Subscription::retrieve($this->subscription_id);
      $res = $stripe_sub->cancel();

      if(!$res){
        throw new Exception('Could not cancel subscription');
      }
    }

    return $this->delete();
  }
}
