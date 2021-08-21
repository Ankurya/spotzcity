<?php

namespace SpotzCity\Http\Controllers;

use \Mapper;
use \Lob\Lob;
use Carbon\Carbon;
use SpotzCity\Business;
use SpotzCity\SaleInfo;
use SpotzCity\Commodity;
use SpotzCity\ECategory;
use SpotzCity\BusinessView;
use Illuminate\Http\Request;
use SpotzCity\User;
use SpotzCity\BusinessHours;
use SpotzCity\CommodityLink;
use SpotzCity\ECategoryLink;
use SpotzCity\Http\Requests;
use Illuminate\Support\Facades\Log;
use SpotzCity\BusinessVerification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;


class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view( 'businesses/index' );
    }

    /**
     * Display a subscribe form.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe()
    {
		//dd(env("POSTMARK_API_KEY"));
        return view( 'businesses/subscribe' );
    }

    /**
     * Create stripe record for user.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function createBillingRecord( Request $request )
    {
      try {
        $user = auth()->user();
        $card = $user->createStripeRecord( $request->token );

        // Subscribe
        $user->refresh();
        auth()->user()->billing->createBusinessSubscription( (int) $request->amount );
      } catch( \Exception $e ) {
        flash($e->getMessage(), 'danger');
        return redirect( route( 'Subscribe' ) );
      }

      flash('Thank you for your subscription!', 'success');
      return redirect( route( 'Add Business', ['onboard' => true] ) );
    }


    /**
     * Update subscription.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function updateBusinessSubscription( Request $request )
    {
      try {
        $user = auth()->user();
        $newAmount = (int) $request->amount;

        // Update
        auth()->user()->billing->updateBusinessSubscription( $newAmount );

        // If downgrading and active locations exceed new slots, set locations inactive
        if( $newAmount < $user->activeBusinesses()->count() ) {
          $diff = $user->activeBusinesses()->count() - $newAmount;
          $user->activeBusinesses()->limit( $diff )->orderBy( 'id', 'desc' )->update([
            'active' => false
          ]);
        }
      } catch( \Exception $e ) {
        flash($e->getMessage(), 'danger');
        return redirect( route( 'Index Business' ) );
      }

      flash('Subscription updated!', 'success');
      return redirect( route( 'Index Business' ) );
    }

    /**
     * Cancel subscription.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function cancelBusinessSubscription( Request $request )
    {
      $user = auth()->user();
      $newAmount = 0;

      // Cancel
      auth()->user()->billing->cancelBusinessSubscription( $newAmount );

      // Set businesses inactive
      $user->activeBusinesses()->update([
        'active' => false
      ]);

      flash('Subscription updated!', 'success');
      return redirect( route( 'Index Business' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create( Request $request )
    {
      $business = new Business;
      $e_categories = ECategory::orderBy('name', 'asc')->get();
      $commodities = Commodity::orderBy('name', 'asc')->get();

      if( !auth()->user()->billing ) {
        return redirect( route('Subscribe') );
      }

      if( auth()->user()->business ) {
        if( !auth()->user()->business->verified ) {
          flash('You cannot add another location until you\'ve verified your business ownership.', 'warning');
          return redirect( '/dashboard' );
        }
      }

      return view('businesses/create', [
        'business' => $business,
        'e_categories' => $e_categories,
        'commodities' => $commodities,
        'onboard' => strpos($request->fullUrl(), 'onboard') !== false
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $business = new Business;
      $user = \Auth::user();
      $error = null;
      $logo_path = null;

      $business->name = $user->has_business ? $user->business->name : $request->input('business_name');
      $business->url = $request->input('url');
      $business->user_id = $user->id;
      $business->address = $request->input('address');
      $business->address_two = $request->input('address_two');
      $business->city = $request->input('city');
      $business->state = $request->input('state');
      $business->zip = $request->input('zip');
      $business->phone = $request->input('phone');
      $business->description = $request->input('b_description');
      $business->youtube_video = $request->input('youtube_video');
      $business->generateSlug();
      $business->geocodeAddress();
      $business->active = true;

      // 07/03/2020 - Removed postcard validation requirement, business always verified
      $business->verified = true;

      if($business->save()){
        $hours = null;
        try {
          // Set hours
          if($request->input('Monday')
          || $request->input('Tuesday')
          || $request->input('Wednesday')
          || $request->input('Thursday')
          || $request->input('Friday')
          || $request->input('Saturday')
          || $request->input('Sunday')
          ) {
            $hours = new BusinessHours;

            if($request->input('Monday')){
              $hours->mon_open = Carbon::parse($request->input('Monday_opens'))->toTimeString();
              $hours->mon_close = Carbon::parse($request->input('Monday_closes'))->toTimeString();
              $hours->timezone = Carbon::parse($request->input('Monday_closes'))->format('O');
            }

            if($request->input('Tuesday')){
              $hours->tue_open = Carbon::parse($request->input('Tuesday_opens'))->toTimeString();
              $hours->tue_close = Carbon::parse($request->input('Tuesday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Tuesday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Wednesday')){
              $hours->wed_open = Carbon::parse($request->input('Wednesday_opens'))->toTimeString();
              $hours->wed_close = Carbon::parse($request->input('Wednesday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Wednesday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Thursday')){
              $hours->thu_open = Carbon::parse($request->input('Thursday_opens'))->toTimeString();
              $hours->thu_close = Carbon::parse($request->input('Thursday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Thursday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Friday')){
              $hours->fri_open = Carbon::parse($request->input('Friday_opens'))->toTimeString();
              $hours->fri_close = Carbon::parse($request->input('Friday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Friday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Saturday')){
              $hours->sat_open = Carbon::parse($request->input('Saturday_opens'))->toTimeString();
              $hours->sat_close = Carbon::parse($request->input('Saturday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Saturday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Sunday')){
              $hours->sun_open = Carbon::parse($request->input('Sunday_opens'))->toTimeString();
              $hours->sun_close = Carbon::parse($request->input('Sunday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Sunday_closes'))->format('O') : $hours->timezone;
            }

            if( $hours ) $business->hours()->save($hours);
          }

          foreach ($request->input('e_categories_buffer') as $key => $e_category) {
            $e_category_to_link = ECategory::find($e_category);

            // Not found, throw error (maybe make this a silent failure unless all categories submitted are not found)
            if(!$e_category_to_link) continue;

            $link = new ECategoryLink;

            $link->e_category_id = $e_category_to_link->id;
            $business->e_categories()->save($link);
          }

          foreach ($request->input('commodities_buffer') as $key => $commodity) {
            $commodity_to_link = Commodity::find($commodity);

            // Not found, throw error (maybe make this a silent failure unless all categories submitted are not found)
            if(!$commodity_to_link) continue;

            $link = new CommodityLink;

            $link->commodity_id = $commodity_to_link->id;
            $business->commodities()->save($link);
          }

          if($request->hasFile('logo')){
            $logo_path = $request->file('logo')->store('logos', 'public');
            $business->logo = $logo_path;
            $business->save();
          }

          if($request->hasFile('featured')){
            $paths = [];
            foreach ($request->file('featured') as $file) {
              if(count($paths) < 3) {
                $paths[] = $file->store("feature/$business->id", 'public');
              }
            }
            $business->feature_photos = serialize($paths);
            $business->save();
          }

          // Update user record to "have" business (since postcard verification is gone)
          $user->has_business = true;
          $user->save();

        } catch (Exception $e) {
          $error = $e->getMessage();
          dd($error);
        }


        flash('Business added!', 'success');
        return redirect()->to(route('View Business', ['slug' => $business->slug]));
      }

    }


    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show( string $slug )
    {

      // dd($slug);
      $business = Business::where('slug', $slug)->first();

      if( !$business ) {
        abort(404);
      }

      if( !$business->active ) {
        abort(404);
      }

      if( !$business->verified ) {
        flash('Cannot view business until it has been verified.', 'info');
        return redirect( '/dashboard' );
      }

      $skip = false;

      // Track page view (unless user that owns business is viewing)
      if(\Auth::user()){
        if(\Auth::user()->id == $business->user_id){
          $skip = true;
        }
      }

      if(!$skip){
        $view = new BusinessView;
        $location = \GeoIP::getLocation();
        if(!$location['default']){
          $view->city = $location['city'];
          $view->state = $location['state'];
          $view->zip = $location['postal_code'];
          $view->metadata = [
            'ip' => $location['ip'],
            'lat' => $location['lat'],
            'lng' => $location['lon']
          ];
        }
        $view->user()->associate(\Auth::user());
        $business->views()->save($view);
      }

      //echo "<pre>";print_r($business);die;

      $business->generateScorecardChart();
      $e_categories = ECategory::get();
      Mapper::map($business->lat, $business->lng, ['zoom' => 15]);
      return view('businesses/show', [
        'business' => $business,
        'hours' => $business->parsedHours()
      ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
      if(!$id){
        $business = \Auth::user()->business;
      } else{
        $business = Business::find($id);
      }

      if( !$business->verified ) {
        flash('Cannot edit business until it has been verified.', 'info');
        return redirect( '/dashboard' );
      }

      $e_categories = ECategory::orderBy('name', 'asc')->get();
      $commodities = Commodity::orderBy('name', 'asc')->get();

      return view('businesses/edit', [
        'business' => $business,
        'e_categories' => $e_categories,
        'commodities' => $commodities,
        'onboard' => false
      ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $business = Business::find($id);
      $user = \Auth::user();
      $error = null;
      $logo_path = null;

      // TO DO: ADD CHECK FOR ADMIN OR OWNERSHIP
      if(!$user->business && !\Auth::user()->admin){
        flash("Not allowed to update.", 'warning');
        return redirect()->to(route('Dashboard'));
      } else if($user->business){
        if($user->business->id !== $business->id){
          flash("Not allowed to update.", 'warning');
          return redirect()->to(route('Dashboard'));
        }
      }

      $business->name = $user->has_business ? $user->business->name : $request->input('business_name');
      $business->url = $request->input('url');
      $business->address = $request->input('address');
      $business->address_two = $request->input('address_two');
      $business->city = $request->input('city');
      $business->state = $request->input('state');
      $business->zip = $request->input('zip');
      $business->phone = $request->input('phone');
      $business->description = $request->input('b_description');
      $business->youtube_video = $request->input('youtube_video');
      $business->generateSlug();
      $business->geocodeAddress();

      // 07/03/2020 - Removed postcard validation requirement, business always verified
      $business->verified = true;

      if($business->save()){
        try {

          // Set hours
          if($request->input('Monday')
          || $request->input('Tuesday')
          || $request->input('Wednesday')
          || $request->input('Thursday')
          || $request->input('Friday')
          || $request->input('Saturday')
          || $request->input('Sunday')
          ) {
            $hours = $business->hours ? $business->hours : new BusinessHours;

            if($request->input('Monday')){
              $hours->mon_open = Carbon::parse($request->input('Monday_opens'))->toTimeString();
              $hours->mon_close = Carbon::parse($request->input('Monday_closes'))->toTimeString();
              $hours->timezone = Carbon::parse($request->input('Monday_closes'))->format('O');
            }

            if($request->input('Tuesday')){
              $hours->tue_open = Carbon::parse($request->input('Tuesday_opens'))->toTimeString();
              $hours->tue_close = Carbon::parse($request->input('Tuesday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Tuesday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Wednesday')){
              $hours->wed_open = Carbon::parse($request->input('Wednesday_opens'))->toTimeString();
              $hours->wed_close = Carbon::parse($request->input('Wednesday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Wednesday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Thursday')){
              $hours->thu_open = Carbon::parse($request->input('Thursday_opens'))->toTimeString();
              $hours->thu_close = Carbon::parse($request->input('Thursday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Thursday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Friday')){
              $hours->fri_open = Carbon::parse($request->input('Friday_opens'))->toTimeString();
              $hours->fri_close = Carbon::parse($request->input('Friday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Friday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Saturday')){
              $hours->sat_open = Carbon::parse($request->input('Saturday_opens'))->toTimeString();
              $hours->sat_close = Carbon::parse($request->input('Saturday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Saturday_closes'))->format('O') : $hours->timezone;
            }

            if($request->input('Sunday')){
              $hours->sun_open = Carbon::parse($request->input('Sunday_opens'))->toTimeString();
              $hours->sun_close = Carbon::parse($request->input('Sunday_closes'))->toTimeString();
              $hours->timezone = !$hours->timezone ? Carbon::parse($request->input('Sunday_closes'))->format('O') : $hours->timezone;
            }
            $business->hours()->save($hours);
          }

          $business->e_categories()->delete();
          $business->commodities()->delete();

          foreach ($request->input('e_categories_buffer') as $key => $e_category) {
            $e_category_to_link = ECategory::find($e_category);

            // Not found, throw error (maybe make this a silent failure unless all categories submitted are not found)
            if(!$e_category_to_link) continue;

            $link = new ECategoryLink;

            $link->e_category_id = $e_category_to_link->id;
            $business->e_categories()->save($link);
          }

          foreach ($request->input('commodities_buffer') as $key => $commodity) {
            $commodity_to_link = Commodity::find($commodity);

            // Not found, throw error (maybe make this a silent failure unless all categories submitted are not found)
            if(!$commodity_to_link) continue;

            $link = new CommodityLink;

            $link->commodity_id = $commodity_to_link->id;
            $business->commodities()->save($link);
          }

          if($request->hasFile('logo')){
            $logo_path = $request->file('logo')->store('logos', 'public');
            $business->logo = $logo_path;
            $business->save();
          }

          if($request->hasFile('featured')){
            $existing_paths = $business->featured_photos();
            foreach ($request->file('featured') as $file) {
              if( count($existing_paths) < 3 ) {
                array_push($existing_paths, $file->store("feature/$business->id", 'public'));
              }
            }
            $business->feature_photos = serialize($existing_paths);
            $business->save();
          }
        } catch (\Exception $e) {
          $error = $e->getMessage();
          dd($error);
        }

        // return [
        //   'request_body' => $request->all(),
        //   'error' => $error,
        //   'files' => [
        //     'logo' => $logo_path
        //     //'featured' => $paths
        //   ]
        // ];

        // TODO: Redirect logic
        flash("Business updated successfully!", 'success');
        return redirect()->to(route('Dashboard'));
      }
    }


    /**
     * Show the form for editing the sale info
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editSaleInfo($id = null)
    {
      if(!$id){
        $business = \Auth::user()->business;
      } else{
        $business = Business::find($id);
      }

      $sale_info = $business->sale_info ? $business->sale_info : new SaleInfo;

      return view('businesses/forms/sale-info', [
        'business' => $business,
        'sale_info' => $sale_info
      ]);
    }


    /**
     * Create or update business's sale info
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdateSaleInfo(Request $request)
    {
      $new = !isset(\Auth::user()->business->sale_info);

      if($new){
        \Auth::user()->business->sale_info()->create([
          'ein' => $request->input('ein'),
          'sale_price' => $request->input('sale_price'),
          'established' => $request->input('established'),
          'gross_income' => $request->input('gross_income'),
          'reason' => $request->input('reason')
        ]);
      } else{
        \Auth::user()->business->sale_info->ein = $request->input('ein');
        \Auth::user()->business->sale_info->sale_price = $request->input('sale_price');
        \Auth::user()->business->sale_info->established = $request->input('established');
        \Auth::user()->business->sale_info->gross_income = $request->input('gross_income');
        \Auth::user()->business->sale_info->reason = $request->input('reason');
        \Auth::user()->business->sale_info->save();
      }

      \Auth::user()->business->for_sale = $request->input('for_sale');
      \Auth::user()->business->save();
      flash('Your business\'s sale information has been updated.', 'success');
      return redirect()->to(route('Dashboard'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Page prompting verification postcard
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function claim($id)
    {
      $business = Business::find($id);

      if(\Auth::user()->has_business){
        flash('You cannot claim more than one business.', 'warning');
        return redirect()->to(route('View Business', ['slug' => $business->slug]));
      }

      return view('businesses/claim-business', [
        'business' => $business
      ]);
    }


    /**
     * Send verification postcard
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sendPostcard($id)
    {
      // TO DO: Generate BusinessVerification if user does not have pre-existing verification sent and send Lob postcard
      if(BusinessVerification::where('user_id', \Auth::user()->id)->first()){
        flash("You cannot claim more than one business. If you believe you are seeing this in error, please contact us.", 'danger');
        return redirect()->to(route('Dashboard'));
      };

      try {
        $business = Business::find($id);
        $verification = new BusinessVerification;
        $verification->user_id = \Auth::user()->id;
        $verification->business_id = $id;

        $lob = new Lob(env('LOB_API_KEY'));
        $postcard = $lob->postcards()->create([
          'description' => '',
          'to' => [
            'name' => \Auth::user()->display_name,
            'address_line1' => $business->address,
            'address_line2' => $business->address2,
            'address_city' => $business->city,
            'address_state' => $business->state,
            'address_zip' => $business->zip
          ],
          //'from' => Will add later
          'front' => (string) view('businesses/postcard-templates/front'),
          'back' => (string) view('businesses/postcard-templates/back', [
              'first_name' => \Auth::user()->first_name,
              'last_name' => \Auth::user()->last_name,
              'business_name' => $business->name,
              'app_url' => env('APP_URL'),
              'verification_code' => $verification->generateVerificationCode()
          ]),
        ]);

        if($postcard){
          $verification->postcard_id = $postcard['id'];
          $verification->expected_arrival = Carbon::createFromFormat('Y-m-d', $postcard['expected_delivery_date']);
          $verification->save();
        }
      } catch (Exception $e) {
        flash("Verification could not be sent. Please try again or contact us.", 'danger');
        return redirect()->to(route('Claim Business', ['id' => $id]));
      }

      $formatted_delivery = Carbon::createFromFormat('Y-m-d', $postcard['expected_delivery_date'])->toFormattedDateString();

      flash("Verification sent! Expected delivery: $formatted_delivery.", 'success');
      return redirect()->to(route('Dashboard'));
    }


    /**
     * Show form for business verification
     *
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function showVerifyBusinessForm(){
      return view('businesses/forms/verify');
    }


    /**
     * Reactivate Business
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function reactivate( Request $request ){
      $business = Business::find( $request->id );
      $business->active = true;
      $business->save();

      // To Do:
      // Actually increase monthly bill by 1 unit

      flash('Location activated!.', 'info');
      return redirect( route( 'Index Business' ) );
    }


    /**
     * Deactivate Business
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deactivate( Request $request ){
      $business = Business::find( $request->id );
      $business->active = false;
      $business->save();

      // To Do:
      // Actually decrease monthly bill by 1 unit

      flash('Location deactivated.', 'info');
      return redirect( route( 'Index Business' ) );
    }


    public function deactivate_admin( Request $request ){
  
   
      $business = Business::find( $request->id );
      $business->active = false;
      $business->save();

      // To Do:
      // Actually decrease monthly bill by 1 unit

      flash('Location deactivated.', 'info');
        return redirect( route( 'Dashboard' ) );
    }


    /**
     * Page to display business analytics
     *
     * @param  \Illumintate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function businessAnalytics( Request $request ){

      $business = Business::find( $request->id );
      $business->generateTotalPageViewsChart();
      $business->generatePageViewsByRegisteredChart();
      $business->generatePageViewsByZipChart();
      $business->generatePageViewsByCityChart();
      $business->generatePageViewsByStateChart();

      return view('analytics/index',[
        'business' => $business,
        'ads' => []
      ]);
    }


    /**
     * Page to display ad analytics
     *
     * @return \Illuminate\Http\Response
     */
    public function analytics(){
      $ads = \Auth::user()->ads()->where('active', '>', 0)->get();
      foreach ($ads as $ad) {
        $ad->generateClicksByMonthChart();
        $ad->generateClicksByPageChart();
        $ad->generateClicksByZipChart();
        $ad->generateClicksByCityChart();
        $ad->generateClicksByStateChart();
      }
      return view('analytics/index',[
        'business' => null,
        'ads' => $ads
      ]);
    }


    /**
     * Show form for business verification
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string code (in body)
     * @return \Illuminate\Http\Response
     */
    public function verifyCode(Request $request){
      $verification = BusinessVerification::where('user_id', \Auth::user()->id)->first();
      if(!$verification){
        flash('No pending verifications found on your account, perhaps you claimed it under another account.', 'danger');
        return redirect()->to(route('Verify Business'));
      }

      if($verification->verification_code !== $request->input('verification_code')){
        flash('Incorrect code.', 'danger');
        return redirect()->to(route('Verify Business'));
      } else{
        \Auth::user()->has_business = true;
        \Auth::user()->save();

        $business = $verification->business;
        $business->user()->associate(\Auth::user());
        $business->verified = true;

        $business->active = true;
        $business->save();

        $verification->delete();

        flash('Business ownership verified! Thank you!', 'success');
        return redirect()->to(route('Dashboard'));
      }
    }


    /**
     * Delete featured photo from storage (AJAX)
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id, string path (in request body)
     * @return \Illuminate\Http\Response
     */
    public function deleteFeaturedPhoto(Request $request, $id){
      $error = null;

      $path = $request->input('path');
      $business = Business::find($id);

      $photos = $business->featured_photos();

      try {
        Storage::delete($path);
      } catch (Exception $e) {
        $error = $e->getMessage();
        return response($error, 400);
      }

      $path_to_delete = array_search($path, $photos);
      unset($photos[$path_to_delete]);
      $new_array = array_values($photos);

      $business->feature_photos = serialize($new_array);
      $business->save();

      return response('success', 200);
    }
	public function homePageSignUp(Request $request){
      $userCount = User::where('email', $_POST['email']);
      if(isset($_POST['email']) && !empty($_POST['email'])){
        if ($userCount->count()) {
          return response('email exist');
        }
        elseif($_POST['password'] != $_POST['password_confirmation']){
          return response('password not match');
        }else{
          return response('match');
        }
      }
      
    }
}
