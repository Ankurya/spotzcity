<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Business;
use SpotzCity\BusinessVerification;
use SpotzCity\ECategory;
use SpotzCity\ECategoryLink;
use SpotzCity\Commodity;
use SpotzCity\CommodityLink;
use SpotzCity\BusinessHours;
use SpotzCity\Ad;
use SpotzCity\Review;
use \Mapper;

use Carbon\Carbon;

use Illuminate\Http\Request;

use SpotzCity\Http\Requests;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class ComponentController extends Controller
{

    /**
     * Display 3 new(ish) businesses.
     *
     * @return Collection of businesses
     */
    public static function newOnSpotzCity()
    {
      $new_businesses = Business::where([
          [ 'verified', '=', true ],
          [ 'active', '=', true ]
        ])
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->inRandomOrder()
        ->get();

      if( $new_businesses->count() > 3 ) {

        return $new_businesses->random( 3 );

      } else if( $new_businesses->count() <= 3 && $new_businesses->count() > 1 ) {

        return $new_businesses;

      } else {

        return collect( $new_businesses );

      }
    }


    /**
     * Display random review.
     *
     * @return Review
     */
    public static function getFeaturedReview()
    {
      $review = Review::inRandomOrder()
        ->first();
      return $review;
    }


    /**
     * Display banner ad.
     *
     * @return \SpotzCity\Ad
     */
    public static function getBannerAd()
    {
      $main_pages = [
        'View Business', 'Home', 'Dashboard', 'Edit Business', 'Login', 'Register'
      ];

      if(in_array(Route::currentRouteName(), $main_pages)){
        // $ad = Ad::where([['active', '>', 0], 'type' => 'main-banner-bb'])
        //   ->orWhere([['active', '>', 0], 'type' => 'main-banner-sb'])
        //   ->inRandomOrder()
        //   ->first();

        $ad = Ad::where([
            ['active', '>', 0],
            ['type', '=', 'main-banner-sb']
          ])
          ->orWhere([
            ['active', '>', 0],
            ['type', '=', 'main-banner-bb']
          ])
          ->inRandomOrder()
          ->first();

        return $ad ? $ad : Ad::where('type', 'default-banner')->first();
      } else{
        $ad = Ad::where([
            ['active', '>', 0],
            ['type', '=', 'sub-banner-sb']
          ])
          ->orWhere([
            ['active', '>', 0],
            ['type', '=', 'sub-banner-bb']
          ])
          ->inRandomOrder()
          ->first();

        return $ad ? $ad : Ad::where('type', 'default-banner')->first();
      }
    }

    /**
     * Display sidebar ads.
     *
     * @return Collection of Ads
     */
    public static function getSidebarAds()
    {
      $main_pages = [
        'View Business', 'Home', 'Dashboard', 'Edit Business'
      ];

      if(in_array(Route::currentRouteName(), $main_pages)){
        $ads = Ad::where([
            [ 'active', '>', 0 ],
            [ 'type', '=', 'main-sidebar-sb' ],
          ])
          ->orWhere([
            [ 'active', '>', 0 ],
            [ 'type', '=', 'main-sidebar-bb' ],
          ])
          ->inRandomOrder()
          ->limit(2)
          ->get();
      } else{
        $ads = Ad::where([
            [ 'active', '>', 0 ],
            [ 'type', '=', 'sub-sidebar-bb' ]
          ])
          ->orWhere([
            ['active', '>', 0],
            [ 'type', '=', 'sub-sidebar-sb' ]
          ])
          ->inRandomOrder()
          ->limit(2)
          ->get();
      }

      switch(count($ads)){
        case 0:
          return Ad::where('type', 'default-sidebar-1')
            ->orWhere('type', 'default-sidebar-2')
            ->inRandomOrder()
            ->get();
          break;

        case 1:
          $default = Ad::where('type', 'default-sidebar-1')
            ->orWhere('type', 'default-sidebar-2')
            ->inRandomOrder()
            ->limit(1)
            ->get();
          return $ads->merge($default);
          break;

        case 2:
          return $ads;
          break;
      }
    }

}
