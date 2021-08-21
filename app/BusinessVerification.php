<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class BusinessVerification extends Model
{

  public function user(){
    return $this->belongsTo(User::class);
  }

  public function business(){
    return $this->belongsTo(Business::class);
  }

  public function generateVerificationCode($len = 10){
    $result = "";
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $charArray = str_split($chars);
    for($i = 0; $i < $len; $i++){
      $randItem = array_rand($charArray);
      $result .= "".$charArray[$randItem];
    }
    $this->verification_code = $result;
    return $result;
  }

}
