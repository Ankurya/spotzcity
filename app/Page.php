<?php

namespace SpotzCity;

use Stevebauman\Purify\Facades\Purify;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
      'title', 'active', 'sidebar',
      'public', 'content', 'blog'
    ];

    /**
     * Sanitize HTML before delivering
     *
     * @param string $value
     * @return void
     */
    public function getContentAttribute( $value )
    {
      return Purify::clean( $value );
    }

    public function scopeBlogs( $query ) {
      return $query->where( 'blog', true )->orderBy('created_at', 'desc');
    }

    public function scopeSitePages( $query ) {
      return $query->where( 'blog', false );
    }
}
