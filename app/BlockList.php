<?php

namespace SpotzCity;

use Illuminate\Database\Eloquent\Model;

class BlockList extends Model
{
    
        protected $table = 'block_list';
      

          protected $fillable = [
          	'from_user_id', 
          	'block_user_id',
          	'type',
          	'message'
          ];

}
