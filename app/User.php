<?php

namespace SpotzCity;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use \Stripe as Stripe;
use Postmark\PostmarkClient;
use Postmark\Models\PostmarkException;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'display_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function business(){
      return $this->hasOne(Business::class);
    }

    public function businesses(){
      return $this->hasMany(Business::class);
    }

    public function activeBusinesses(){
      return $this->hasMany(Business::class)->where('active', true);
    }

    public function businessSlotsRemaining() {
      return $this->business_subscription()->quantity !== 7 ? $this->business_subscription()->quantity - $this->activeBusinesses()->count() : 9999;
    }

    public function inactiveBusinesses(){
      return $this->hasMany(Business::class)->where('active', false);
    }

    public function business_subscription(){
      return $this->billing ? $this->billing->business_subscription : null;
    }

    public function business_verifications(){
      return $this->hasMany(BusinessVerification::class);
    }

    public function reviews(){
      return $this->hasMany(Review::class);
    }

    public function ads(){
      return $this->hasMany(Ad::class);
    }

    public function billing(){
      return $this->hasOne(Billing::class);
    }

    public function following(){
      return $this->hasMany(Follow::class)->with('business');
    }

    public function followingEntries(){
      return $this->hasMany(Follow::class);
    }

    public function resources(){
      return $this->hasMany(Resource::class);
    }

    public function hasSubscriptions(){
      if($this->billing){
        if($this->billing->subscriptions){
          return true;
        } else{
          return false;
        }
      } else{
        return false;
      }
    }

    public function hasPaymentSources(){
      if($this->billing){
        if($this->billing->payment_sources){
          return true;
        } else{
          return false;
        }
      } else{
        return false;
      }
    }

    public function hasResourcesAccess(){
      if($this->hasSubscriptions()){
        return (bool) $this->billing->subscriptions()->where('type', 'resources')->first();
      } else{
        return false;
      }
    }

    public function createStripeRecord($card_token = null){
      if($this->billing) return $this->billing;

      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));

      $data = [
        "email" => $this->email,
        "description" => "Customer record for $this->email",
        "metadata" => [
          "name" => "$this->first_name $this->last_name",
          "spotz_id" => $this->id
        ]
      ];

      if($card_token){
        $data["source"] = $card_token;
      }

      $stripe_record = Stripe\Customer::create($data);

      $this->billing()->create([
        'stripe_id' => $stripe_record->id
      ]);

      if($card_token){
        $thisUser = $this->fresh();
        $source = $stripe_record->sources->data[0];
        $saved_card = $thisUser->billing->payment_sources()->create([
          'card_id' => $source->id,
          'type' => $source->brand,
          'last_four' => $source->{'last4'},
          'exp_month' => $source->exp_month,
          'exp_year' => $source->exp_year,
          'name' => $source->name
        ]);
        $thisUser->billing->update(['default_card' => $saved_card->id]);
      }


      if($saved_card){
        return $saved_card;
      } else{
        return true;
      }
    }


    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    /*public function sendPasswordResetNotification($token)
    { 

      // dd($this->email);
      // dd(env('POSTMARK_API_KEY'));
      try{
        $client = new PostmarkClient(env('POSTMARK_API_KEY'));
        //dd($client);
        $sendResult = $client->sendEmailWithTemplate(
          "noreply@spotzcity.com",
          $this->email,
          23289489,
          [
            'name' => $this->first_name,
            'url' => env('APP_URL')."/dashboard",
            'reset_link' => env('APP_URL')."/password/reset/".$token
          ]
        );

        dd($sendResult);

      }catch(PostmarkException $ex){
          // If client is able to communicate with the API in a timely fashion,
          // but the message data is invalid, or there's a server error,
          // a PostmarkException can be thrown.
        dd($ex);

      }catch(Exception $generalException){
          // A general exception is thrown if the API
          // was unreachable or times out.
        dd($generalException);
      }
      return true;
    }*/


public function user()
{
  return $this->belongsTo('App\User','id','user_id');
}

}
