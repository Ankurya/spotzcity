<?php

namespace SpotzCity\Http\Controllers;

use Illuminate\Http\Request;

use SpotzCity\Ad;
use SpotzCity\AdClick;
use SpotzCity\Subscription;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $ads = \Auth::user()->ads()->where('edit_id', null)->get();
      return view('ads/index', [
        'ads' => $ads
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $type = null)
    {

      $ad = new Ad;
      $ad->type = $type;

      $edit = $request->query('edit') !== null;

      // If user is editing an ad that is active, they will actually be creating a new record
      // that will have to be approved by an admin. The old record will remain the same and active
      // so as to not interrupt their ad broadcast (mainly a billing concern).
      if($edit){
        $edit_ad = Ad::find($request->query('edit'));

        // Edit ad not found, redirect w/ error message
        if(!$edit_ad){
          flash('Ad was not found.', 'danger');
          return redirect()->route('Ads');
        }

        // If not owner or admin, redirect w/ error message
        if($edit_ad->user_id != \Auth::user()->id && !\Auth::user()->admin){
          flash('You are not authorized to edit this ad.', 'danger');
          return redirect()->route('Ads');
        }

        if($edit_ad->active){
          $ad->edit_id = $request->query('edit');
          $ad->image = $edit_ad->image;
          $ad->name = $edit_ad->name;
          $ad->url = $edit_ad->url;
          $ad->type = $edit_ad->type;
        } else{
          $ad = $edit_ad;
        }
      }

      return view('ads/create', [
        'ad' => $ad,
        'edit' => $edit
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
      $ad = new Ad;
      $ad->type = $request->input('type');
      $ad->name = $request->input('ad_name');
      $ad->url = $request->input('url');
      $ad->image = $request->file('ad')->store('ads', 'public');
      if($request->input('edit_id')) $ad->edit_id = $request->input('edit_id');

      if(\Auth::user()->ads()->save($ad)){
        flash("Ad submitted! We will review it ASAP.", 'success');
        return redirect()->to(route('Ads'));
      } else{
        flash("Not able to save ad. Please try again.", 'danger');
        return redirect()->to(route('Create Ad'));
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
      $ad = Ad::find($id);

      if(!$ad){
        flash("Ad not found. Please try again.", 'danger');
        return redirect()->to(route('Ads'));
      }

      if(\Auth::user()->id != $ad->user_id){
        flash('You are not authorized to edit this ad.', 'danger');
        return redirect()->to(route('Ads'));
      }

      $ad->name = $request->input('ad_name');
      $ad->url = $request->input('url');
      $ad->approved = false;

      if($request->hasFile('ad')){
        $ad->image = $request->file('ad')->store('ads', 'public');
      }

      if($ad->save()){
        flash("Ad updated! We will review it ASAP.", 'success');
        return redirect()->to(route('Dashboard'));
      }
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
     * Approve ad (admin-only)
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
      if(!\Auth::user()->admin){
        flash('Not authorized to approve ads.', 'danger');
        return redirect()->to(route('Dashboard'));
      }

      $ad = Ad::find($id);

      // If edit_id is present, we'll want to update the original ad
      // with the edits present on this ad, and then delete it.
      if($ad->edit_id){
        $original_ad = Ad::find($ad->edit_id);
        $original_ad->name = $ad->name;
        $original_ad->url = $ad->url;
        $original_ad->image = $ad->image;
        $ad->delete();
        $ad = $original_ad;
      }

      $ad->approved = true;

      if($ad->save()){
        // TO DO: Add email notification for user

        flash('Ad approved!', 'success');
        return redirect()->to(route('Dashboard'));
      } else{
        flash('Unable to approve ad.', 'danger');
        return redirect()->to(route('Dashboard'));
      }
    }


    /**
     * Ad Redirect Handling
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function handleRedirect(Request $request, $id)
    {
      $ad = Ad::find($id);

      // TRACK CLICK HERE
      $ad_click = new AdClick;
      $ad_click->page = $request->query('ref');

      if(\Auth::user()){
        $ad_click->user()->associate(\Auth::user());
      }

      $location = \GeoIP::getLocation();

      if(!$location['default']){
        $ad_click->city = $location['city'];
        $ad_click->state = $location['state'];
        $ad_click->zip = $location['postal_code'];
        $ad_click->metadata = [
          'country' => $location['country'],
          'ip' => $location['ip'],
          'lat' => $location['lat'],
          'lng' => $location['lon']
        ];
      }

      $ad->clicks()->save($ad_click);

      if(strpos($ad->url, 'http://') === false && strpos($ad->url, 'https://') === false){
        $url = "http://$ad->url";
      } else{
        $url = $ad->url;
      }

      return redirect()->to($url);
    }


    /**
     * Deactivate Ad
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
      $ad = Ad::find($id);

      if(!$ad){
        flash('Ad not found.', 'warning');
        return redirect()->to(route('Ads'));
      }

      if($ad->user_id != \Auth::user()->id && !\Auth::user()->admin){
        flash('Not authorized to edit ad.', 'danger');
        return redirect()->to(route('Ads'));
      }

      $ad_subscription = Subscription::find($ad->active);
      try {
        $ad_subscription->cancel();
        $ad->active = 0;
        $ad->save();
      } catch(Stripe_CardError $e) {
        // Since it's a decline, Stripe_CardError will be caught
        flash($e->getMessage(), 'danger');
        return redirect()->back();
      } catch (Stripe_InvalidRequestError $e) {
        // Invalid parameters were supplied to Stripe's API
        flash($e->getMessage(), 'danger');
        return redirect()->back();
      } catch (Stripe_AuthenticationError $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
        flash($e->getMessage(), 'danger');
        return redirect()->back();
      } catch (Stripe_ApiConnectionError $e) {
        // Network communication with Stripe failed
        flash($e->getMessage(), 'danger');
        return redirect()->back();
      } catch (Stripe_Error $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
        flash($e->getMessage(), 'danger');
        return redirect()->back();
      } catch (Exception $e) {
        flash($e->getMessage(), 'danger');
        return redirect()->back();
      }

      flash('Ad deactivated.', 'success');
      return redirect()->to(route('Ads'));
    }


  }
