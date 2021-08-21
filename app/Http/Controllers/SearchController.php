<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\ECategory;
use SpotzCity\Commodity;
use SpotzCity\Business;
use SpotzCity\Ad;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories = ECategory::orderBy('name', 'asc')->get();
      $commodities = Commodity::orderBy('name', 'asc')->get();
      return view('search/index', [
        'categories' => $categories,
        'commodities' => $commodities
      ]);
    }


    /**
     * Search function. (AJAX)
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {

      // Build query
      /* $results = Business::when($request->has('categories'), function($q) use ($request){

        return $q->whereHas('e_categories', function($q) use ($request) {
          foreach( $request->input('categories') as $category ) {
            $q->where('e_category_id', $category);
          }
          // $q->whereIn('e_category_id', $request->input('categories'));
        });

      })->when($request->has('commodities'), function($q) use ($request){

        return $q->whereHas('commodities', function($q) use ($request){
          $q->whereIn('commodity_id', $request->input('commodities'));
        });

      })->when($request->has('sale') && $request->input('sale.sale_only'), function($q) use ($request){

        $min = $request->has('sale.min') ? $request->input('sale.min') : 0;
        $max = $request->has('sale.max') ? $request->input('sale.max') : 9999999999999;
        return $q->whereHas('sale_info', function($q) use ($request, $min, $max){

          $q->where('sale_price', '>=', $min)
            ->where('sale_price', '<=', $max);

        })->with('sale_info');

      })->when($request->has('location'), function($q) use ($request){
        // Geocode ZIP
        try{
          $geocode = app('geocoder')->geocode($request->input('location'))->get()->first();
        } catch(\Exception $e){
          // TODO: Throw error or exclude ZIP input?
          throw $e;
          return false;
        }

        return $q->orderByRaw('st_distance(`raw_location`, POINT('.$geocode->getCoordinates()->getLongitude().', '.$geocode->getCoordinates()->getLatitude().')) asc');

      })->when($request->input('sort') == 'highest_rated', function($q) use ($request){

        return $q->orderByRaw('`rating` desc, `review_count` desc');

      })->when($request->input('sort') == 'most_reviews', function($q) use ($request){

        return $q->orderBy('review_count', 'desc');

      })->paginate(10); */
	//$results = Business::where('active',1)->paginate(10);
	
	$results = Business::where('active',1)->when($request->has('categories'), function($q) use ($request){

        return $q->whereHas('e_categories', function($q) use ($request) {
          foreach( $request->input('categories') as $category ) {
            $q->where('e_category_id', $category);
          }
          // $q->whereIn('e_category_id', $request->input('categories'));
        });

      })->when($request->has('commodities'), function($q) use ($request){

        return $q->whereHas('commodities', function($q) use ($request){
          $q->whereIn('commodity_id', $request->input('commodities'));
        });

      })->when($request->has('sale') && $request->input('sale.sale_only'), function($q) use ($request){

        $min = $request->has('sale.min') ? $request->input('sale.min') : 0;
        $max = $request->has('sale.max') ? $request->input('sale.max') : 9999999999999;
        return $q->whereHas('sale_info', function($q) use ($request, $min, $max){

          $q->where('sale_price', '>=', $min)
            ->where('sale_price', '<=', $max);

        })->with('sale_info');

      })->when($request->has('location'), function($q) use ($request){
        // Geocode ZIP
        try{
          $geocode = app('geocoder')->geocode($request->input('location'))->get()->first();
        } catch(\Exception $e){
          // TODO: Throw error or exclude ZIP input?
          throw $e;
          return false;
        }

        return $q->orderByRaw('st_distance(`raw_location`, POINT('.$geocode->getCoordinates()->getLongitude().', '.$geocode->getCoordinates()->getLatitude().')) asc');

      })->when($request->input('sort') == 'highest_rated', function($q) use ($request){

        return $q->orderByRaw('`rating` desc, `review_count` desc');

      })->paginate(10);

      foreach ($results as $business) {
        $business->categories_list = $business->e_categories_concat();
        $business->commodities_list = $business->commodities_concat();
      }


      // Return
      return $results;
    }



    /**
     * Return random main page sidebar ad
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function getAd(Request $request)
    {
      $ad = Ad::where([['active', '>', 0], 'type' => 'main-sidebar-bb'])
        ->orWhere([['active', '>', 0], 'type' => 'main-sidebar-sb'])
        ->inRandomOrder()
        ->first();

      return $ad;
    }
}
