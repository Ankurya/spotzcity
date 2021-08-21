<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";

    public function fromUser()
    {
        return $this->belongsTo('SpotzCity\User', 'from_user');
    }

    public function toUser()
    {
        return $this->belongsTo('SpotzCity\User', 'to_user');
    }
}
