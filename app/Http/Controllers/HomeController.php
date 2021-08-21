<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Ad;
use SpotzCity\Business;
use SpotzCity\Activity;
use SpotzCity\Conference;
use SpotzCity\Resource;
use SpotzCity\ContactRequest;
use SpotzCity\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
        //$this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if( \Auth::check() ) return redirect( route('Dashboard') );
      return view('home');
    }


    public function dashboard(){
      if(\Auth::user()->admin){
        $ads = Ad::where('approved', 0)->get();
        $conferences = Conference::where('approved', 0)->get();
        $resources = Resource::where('approved', 0)->get();
        return view('dashboard', [
          'ads' => $ads,
          'conferences' => $conferences,
          'resources' => $resources
        ]);
      } else{
        $user = User::find(\Auth::user()->id);
        $user->last_seen = now();
        $user->user_status = "Online";
        $user->save();
        return view('dashboard');
      }
    }


    public function about(){
      return view('about');
    }


    public function faq(){
      return view('faq');
    }


    public function support(){
      $contact_request = new ContactRequest;
      // Autopopulate fields if logged in
      if(\Auth::check()){
        $contact_request->name = \Auth::user()->display_name;
        $contact_request->email = \Auth::user()->email;
      }
      return view('support', [
        'contact_request' => $contact_request
      ]);
    }


    public function createContactRequest(Request $request){
      $contact_request = new ContactRequest;
      $contact_request->name = $request->input('name');
      $contact_request->email = $request->input('email');
      $contact_request->phone = $request->input('phone');
      $contact_request->subject = $request->input('subject');
      $contact_request->message = $request->input('message');
      if(\Auth::check()){
        $contact_request->user_id = \Auth::user()->id;
      }
      $contact_request->save();
      flash('Your request has been sent!', 'success');
      return redirect()->to( route('Support') );
    }


    public function activityNearMe(Request $request, $page = 1){
      $location = \GeoIP::getLocation();

      $data = Activity::whereHas('business', function($q) use ($location){

        $q->whereRaw('st_distance(`location`, POINT('.$location['lon'].','.$location['lat'].')) < 150');

      })->orderBy('created_at', 'desc')->forPage($page, 10)->get();

      // Load appropriate relational data based on activity type
      $data->each(function($activity){
        switch($activity->type){
          case 'business.created':
            $activity->load('business');
            break;

          case 'event.created':
            $activity->load('business');
            $activity->load('business_event');
            break;

          case 'review.created':
            $activity->load('review');
            $activity->load('business');
            $activity->load('user');
            break;

          case 'review_response.created':
            $activity->load('review_response');
            $activity->load('business');
            $activity->load('user');
            break;
        }
      });


      // Eventually fix this to provide a proper paginator (count is wrong, need accurate count of query)
      $paginator = new LengthAwarePaginator($data, count($data), 10, $page, ['path' => $request->path()]);

      return $paginator;
    }


    public function activityFollowing(Request $request, $page = 1){

      // Pull business ids from user follows
      $follows = array_map(function($entry){
        return $entry['business_id'];
      }, \Auth::user()->followingEntries()->get()->toArray());

      $data = Activity::whereIn('business_id', $follows)->orderBy('created_at', 'desc')->forPage($page, 10)->get();

      $data->each(function($activity){
        switch($activity->type){
          case 'business.created':
            $activity->load('business');
            break;

          case 'event.created':
            $activity->load('business');
            $activity->load('business_event');
            break;

          case 'review.created':
            $activity->load('review');
            $activity->load('business');
            $activity->load('user');
            break;

          case 'review_response.created':
            $activity->load('review_response');
            $activity->load('business');
            $activity->load('user');
            break;
        }
      });

      // Eventually fix this to provide a proper paginator (count is wrong, need accurate count of query)
      $paginator = new LengthAwarePaginator($data, count($data), 10, $page, ['path' => $request->path()]);

      return $paginator;
    }


    public function getHotSpotz(Request $request, $ids = null){
      // Pull Location
      $location = \GeoIP::getLocation();

      // Create array from ids
      $ids = explode(',', $ids);

      // For each id, create a query for 5 businesses per category, union each request
      $querySet = [];
      foreach ($ids as $key => $id) {
        if($key == 0){
          $query = Business::whereHas('e_categories', function($q) use ($id){
            return $q->where('e_category_id', $id);
          })
          ->orderBy('rating', 'desc')->limit(5)->with('e_categories')
          ->orderByRaw('st_distance(`raw_location`, POINT('.$location['lon'].', '.$location['lat'].')) asc');
        } else{
          $query = Business::whereHas('e_categories', function($q) use ($id){
            return $q->where('e_category_id', $id);
          })
          ->orderBy('rating', 'desc')->limit(5)->with('e_categories')
          ->orderByRaw('st_distance(`raw_location`, POINT('.$location['lon'].', '.$location['lat'].')) asc');

          $querySet[0]->unionAll($query);
        }
        array_push($querySet, $query);
      }

      // Execute query
      $businesses = $querySet[0]->get();

      foreach ($businesses as $business) {
        $business->categories_list = $business->e_categories_concat();
        $business->commodities_list = $business->commodities_concat();
      }

      return $businesses;
    }


    public function logout(){
      \Auth::logout();
      return \Redirect::to('login');
    }
/* 	 public function dev()
    {
      if( \Auth::check() ) return redirect( route('Dashboard') );
      return view('home_dev');
    } */
  }

