<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

use \Stripe as Stripe;


class Billing extends Model
{
    protected $table = 'billing';

    protected $fillable = ['stripe_id', 'default_card'];

    public function user(){
      return $this->belongsTo(User::class);
    }

    public function subscriptions(){
      return $this->hasMany(Subscription::class);
    }

    public function business_subscription() {
      return $this->hasOne(BusinessSubscription::class);
    }

    public function payment_sources(){
      return $this->hasMany(PaymentSource::class);
    }

    public function defaultCard(){
      return $this->payment_sources()->find($this->default_card);
    }


    public function setDefaultCard($card){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));
      $customer = Stripe\Customer::retrieve($this->stripe_id);
      $customer->default_source = $card->card_id;
      $customer->save();
      $this->default_card = $card->id;
      $this->save();
    }


    public function createSubscription($type, $data = null){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));

      switch ($type) {
        case 'ad':
          $data = [
            'customer' => $this->stripe_id,
            'plan' => $data['ad']->type,
            'metadata' => [
              'ad' => $data['ad']->id,
              'ad_name' => $data['ad']->name
            ]
          ];
          break;

        case 'resources':
          $data = [
            'customer' => $this->stripe_id,
            'plan' => 'resources'
          ];
          break;
      }

      $stripe_sub = Stripe\Subscription::create($data);
      $subscription = new Subscription;
      $subscription->type = $stripe_sub->plan->id;
      $subscription->subscription_id = $stripe_sub->id;
      $subscription->monthly_cost = $stripe_sub->plan->amount / 100;

      if($this->subscriptions()->save($subscription)){
        return $subscription;
      } else{
        throw new Exception('Could not create subscription');
        return false;
      }
    }

    public function createBusinessSubscription($amount){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));

      // Set price id by amount (dirty, yuck)
      switch( $amount ) {
        case 1:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1caZHRou1HY7BEMU65S6tJ' : 'price_1GxhMuHRou1HY7BErviHfTR8';
          break;

        case 2:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cbuHRou1HY7BE8tc6FiHx' : 'price_1H0qo2HRou1HY7BEAKt71cxH';
          break;

        case 3:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cdxHRou1HY7BE8PSkFmz3' : 'price_1H0qqHHRou1HY7BE3xsUrnmD';
          break;

        case 4:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1ceGHRou1HY7BEoM9dcX5t' : 'price_1H0qr2HRou1HY7BENWr7hioo';
          break;

        case 5:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cfNHRou1HY7BElYhjNdn2' : 'price_1H0rqwHRou1HY7BEbGB3UeN1';
          break;

        case 6:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cfdHRou1HY7BEcz7eHz91' : 'price_1H0rsqHRou1HY7BE0XOfFLJb';
          break;

        case 7:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cg3HRou1HY7BEwSni0S3S' : 'price_1H0slFHRou1HY7BEzEiZhMDx';
          break;
      }

      $data = [
        'customer' => $this->stripe_id,
        'items' => [
          [ 'price' => $priceId ]
        ]
      ];

      $stripe_sub = Stripe\Subscription::create($data);
      $businessSubscription = new BusinessSubscription;
      $businessSubscription->billing_id = $this->id;
      $businessSubscription->quantity = $amount;
      $businessSubscription->subscription_id = $stripe_sub['id'];
      $businessSubscription->save();
    }


    public function updateBusinessSubscription($amount){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));

      // Set price id by amount (dirty, yuck)
      $priceId = $this->determinePriceId( $amount );

      $stripe_sub = Stripe\Subscription::retrieve($this->business_subscription->subscription_id);
      $data = [
        'cancel_at_period_end' => false,
        'proration_behavior' => 'always_invoice',
        'items' => [
          [
            'id' => $stripe_sub->items->data[0]->id,
            'price' => $priceId
          ]
        ]
      ];

      Stripe\Subscription::update($this->business_subscription->subscription_id, $data);
      $businessSubscription = $this->business_subscription;
      $businessSubscription->quantity = $amount;
      $businessSubscription->subscription_id = $stripe_sub['id'];
      $businessSubscription->save();
    }

    public function cancelBusinessSubscription(){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));

      $freeTier = env('APP_ENV') === 'production' ? 'price_1H1gFEHRou1HY7BEwwQogdlJ' : 'price_1H1gEbHRou1HY7BEeZmaivLF';

      $stripe_sub = Stripe\Subscription::retrieve($this->business_subscription->subscription_id);
      $data = [
        'cancel_at_period_end' => false,
        'proration_behavior' => 'always_invoice',
        'items' => [
          [
            'id' => $stripe_sub->items->data[0]->id,
            'price' => $freeTier
          ]
        ]
      ];

      Stripe\Subscription::update($this->business_subscription->subscription_id, $data);

      $businessSubscription = $this->business_subscription;
      $businessSubscription->quantity = 0;
      $businessSubscription->subscription_id = $stripe_sub['id'];
      $businessSubscription->save();
    }

    public function addCard($card, $make_default = false){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));

      $customer = Stripe\Customer::retrieve($this->stripe_id);
      $source = $customer->sources->create(["source" => $card]);

      $saved_card = $this->payment_sources()->create([
        'card_id' => $source->id,
        'type' => $source->brand,
        'last_four' => $source->{'last4'},
        'exp_month' => $source->exp_month,
        'exp_year' => $source->exp_year,
        'name' => $source->name
      ]);

      if($make_default){
        $this->setDefaultCard($saved_card);
      }

      return $saved_card;
    }


    public function deleteCard($card){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));
      $customer = Stripe\Customer::retrieve($this->stripe_id);
      $resp = $customer->sources->retrieve($card->card_id)->delete();
      if($resp->deleted){
        $card->delete();
        return true;
      } else{
        throw new Exception('Could not delete card.');
      }
    }


    private function determinePriceId($amount) {
      switch( $amount ) {
        case 1:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1caZHRou1HY7BEMU65S6tJ' : 'price_1GxhMuHRou1HY7BErviHfTR8';
          break;

        case 2:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cbuHRou1HY7BE8tc6FiHx' : 'price_1H0qo2HRou1HY7BEAKt71cxH';
          break;

        case 3:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cdxHRou1HY7BE8PSkFmz3' : 'price_1H0qqHHRou1HY7BE3xsUrnmD';
          break;

        case 4:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1ceGHRou1HY7BEoM9dcX5t' : 'price_1H0qr2HRou1HY7BENWr7hioo';
          break;

        case 5:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cfNHRou1HY7BElYhjNdn2' : 'price_1H0rqwHRou1HY7BEbGB3UeN1';
          break;

        case 6:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cfdHRou1HY7BEcz7eHz91' : 'price_1H0rsqHRou1HY7BE0XOfFLJb';
          break;

        case 7:
          $priceId = env('APP_ENV') === 'production' ? 'price_1H1cg3HRou1HY7BEwSni0S3S' : 'price_1H0slFHRou1HY7BEzEiZhMDx';
          break;
      }

      return $priceId;
    }


    // Static Methods
    public static function fetchResourceSubscriptionPrice(){
      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));
      return Stripe\Plan::retrieve('resources');
    }
}
