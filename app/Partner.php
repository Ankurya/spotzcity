<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';

    protected $primaryKey = 'id';

    protected $fillable = [
        'partner_name', 'link', 'description',
    ];
}
