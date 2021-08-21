<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class PaymentSource extends Model
{
  protected $fillable = [
    'card_id', 'type', 'last_four', 'exp_month', 'exp_year', 'name'
  ];
}
