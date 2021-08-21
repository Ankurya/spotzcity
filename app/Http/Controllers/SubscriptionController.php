<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Ad;
use SpotzCity\PaymentSource;
use SpotzCity\Invoice;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display form to add/update payment method and show user existing subscriptions (can also activate ad if query string var is present)
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // Check for activate (will be an ad_id)
      $activate = $request->query('activate') !== null;
      if($request->query('flash') !== null){
        switch ($request->query('flash')) {
          case 'updatePayment':
            flash('Please update your payment method to continue with your subscription.', 'info');
            break;

          default:
            # code...
            break;
        }
      }


      if($activate){
        $ad = Ad::find($request->query('activate'));
        // Handle ad not found
        if(!$ad){
          flash('Could not find ad to activate.', 'error');
          return redirect()->to( route('Manage Subscriptions') );
        }
      } else{
        $ad = null;
      }

      // Check for resources (will be flag, present when user is attempting to sub to resources)
      $resources = $request->query('resources') !== null;

      // If both activate ad and resources present, error+redirect
      if($activate && $resources){
        flash('An error has occurred.', 'error');
        return redirect()->to( route('Manage Subscriptions') );
      }

      if($resources){
        // Do things for this.
      }

      // Check for existing subscription
      $has_existing = \Auth::user()->billing !== null;

      // CC Exp Years
      $years = [];
      $curr = date('Y');
      $add = $curr;
      while ($add - $curr <= 10) {
        $years[$add] = $add;
        $add++;
      }

      return view('subscriptions/index', [
        'ad' => $ad,
        'resources' => $resources,
        'has_existing' => $has_existing,
        'edit_card' => new PaymentSource,
        'years' => $years
      ]);

    }


    /**
     * Show invoices for a specific subscription
     *
     * @param \Illuminate\Http\Request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function viewInvoices(Request $request, $id)
    {
      $invoices = Invoice::where('subscription_id', $id)->get();
      return view('subscriptions/view-invoices', [
        'invoices' => $invoices
      ]);

    }


    /**
     * Store CC (can also create initial customer record in Stripe as well as activate ad)
     *
     * @param \Illuminate\Http\Request $request, {int $ad_id}, {bool $make_default}
     * @return \Illuminate\Http\Response
     */
    public function addCard(Request $request, $ad_id = null)
    {
      // Check for billing record, if not present, create
      try {
        if(!\Auth::user()->billing){
          $card = \Auth::user()->createStripeRecord($request->input('card_token'));
        } else {
          $card = \Auth::user()->billing->addCard($request->input('card_token'), $ad_id ? true : false);
        }

        \Auth::user()->load('billing');

        if($ad_id == 'resources'){
          $subscription = \Auth::user()->billing->createSubscription('resources');
        } else if($ad_id){
          $ad = Ad::find($ad_id);
          $subscription = \Auth::user()->billing->createSubscription('ad', ['ad' => $ad]);
          if($subscription){
            $ad->active = $subscription->id;
            $ad->save();
          } else{
            throw new Exception('Ad could not be updated.');
          }
        }
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

      if($ad_id == 'resources'){
        flash('Thank you for your business. Your subscription has been activated!', 'success');
        return redirect()->route('Resources');
      } else if($ad_id){
        flash('Thank you for your business. Your ad has been activated!', 'success');
        return redirect()->route('Ads');
      } else{
        flash('Your card has been added!', 'success');
        return redirect()->route('Manage Subscriptions');
      }
    }


    /**
     * Activate Ad, card id passed only if not using default card
     *
     * @param \Illuminate\Http\Request $request, {int $card_id}
     * @return \Illuminate\Http\Response
     */
    public function activateAd(Request $request, $ad_id, $card_id = null)
    {
      $ad = Ad::find($ad_id);

      if(!$ad){
        flash('Ad not found.', 'danger');
        return redirect()->to(route('Ads'));
      }

      if($ad->active){
        flash('Ad already active.', 'warning');
        return redirect()->to(route('Ads'));
      }

      if($ad->user_id != \Auth::user()->id){
        flash('Not authorized to activate this ad.', 'danger');
        return redirect()->to(route('Ads'));
      }else{
			 flash('Not authorized to activate this ad.', 'danger');
			return redirect()->to(route('Manage Subscriptions'));
       
		}

      $payment_source = $card_id ? PaymentSource::find($card_id) : PaymentSource::find(\Auth::user()->billing->default_card);

      try {
        if($card_id){
          \Auth::user()->billing->setDefaultCard($payment_source);
          \Auth::user()->billing->save();
        }else{
			 flash('Not authorized to activate this ad.', 'danger');
			return redirect()->to(route('Manage Subscriptions'));
       
		}
        $sub = \Auth::user()->billing->createSubscription('ad', ['ad' => $ad]);
        if($sub){
          $ad->active = $sub->id;
          $ad->save();
          flash('Thank you, your ad has been activated!', 'success');
          return redirect()->to(route('Ads'));
        }else{
			 flash('Not authorized to activate this ad.', 'danger');
			return redirect()->to(route('Manage Subscriptions'));
       
		}
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
    }


    // /** NOTE THAT RESOURCES DO NOT HAVE A SUBSCRIPTION
    //  * Activate Resource Subscription, card id passed only if not using default card
    //  *
    //  * @param \Illuminate\Http\Request $request, {int $card_id}
    //  * @return \Illuminate\Http\Response
    //  */
    // public function activateResources(Request $request, $card_id = null)
    // {

    //   // Check that requesting user does not have existing resource subscription
    //   if(\Auth::user()->hasResourcesAccess()){
    //     flash('You already have access to resources.', 'warning');
    //     return redirect()->to(route('Resources'));
    //   }

    //   $payment_source = $card_id ? PaymentSource::find($card_id) : PaymentSource::find(\Auth::user()->billing->default_card);

    //   try {
    //     if($card_id){
    //       \Auth::user()->billing->setDefaultCard($payment_source);
    //       \Auth::user()->billing->save();
    //     }
    //     $sub = \Auth::user()->billing->createSubscription('resources');
    //     if($sub){
    //       flash('Thank you, your subscription has been activated!', 'success');
    //       return redirect()->to(route('Resources'));
    //     }
    //   } catch(Stripe_CardError $e) {
    //     // Since it's a decline, Stripe_CardError will be caught
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_InvalidRequestError $e) {
    //     // Invalid parameters were supplied to Stripe's API
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_AuthenticationError $e) {
    //     // Authentication with Stripe's API failed
    //     // (maybe you changed API keys recently)
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_ApiConnectionError $e) {
    //     // Network communication with Stripe failed
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_Error $e) {
    //     // Display a very generic error to the user, and maybe send
    //     // yourself an email
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Exception $e) {
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   }
    // }


    // /**
    //  * Deactivate Resources Subscription
    //  *
    //  * @param  int $id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function deactivateResources()
    // {

    //   if(!\Auth::user()->hasResourcesAccess()){
    //     flash('An error occurred.', 'warning');
    //     return redirect()->to(route('Dashboard'));
    //   }

    //   try {
    //     $subscription = \Auth::user()->billing->subscriptions()->where('type', 'resources')->first();
    //     $subscription->cancel();
    //   } catch(Stripe_CardError $e) {
    //     // Since it's a decline, Stripe_CardError will be caught
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_InvalidRequestError $e) {
    //     // Invalid parameters were supplied to Stripe's API
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_AuthenticationError $e) {
    //     // Authentication with Stripe's API failed
    //     // (maybe you changed API keys recently)
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_ApiConnectionError $e) {
    //     // Network communication with Stripe failed
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_Error $e) {
    //     // Display a very generic error to the user, and maybe send
    //     // yourself an email
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Exception $e) {
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   }

    //   flash('Resources subscription cancelled.', 'success');
    //   return redirect()->to(route('Manage Subscriptions'));
    // }


    // /**
    //  * Set default card
    //  *
    //  * @param \Illuminate\Http\Request $request, int $card_id
    //  * @return \Illuminate\Http\Response
    //  */
    // public function setDefaultCard(Request $request, $card_id)
    // {
    //   $payment_source = PaymentSource::find($card_id);
    //   try {
    //     \Auth::user()->billing->setDefaultCard($payment_source);
    //     \Auth::user()->billing->save();
    //     flash('Default card set!', 'success');
    //     return redirect()->to(route('Manage Subscriptions'));
    //   } catch(Stripe_CardError $e) {
    //     // Since it's a decline, Stripe_CardError will be caught
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_InvalidRequestError $e) {
    //     // Invalid parameters were supplied to Stripe's API
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_AuthenticationError $e) {
    //     // Authentication with Stripe's API failed
    //     // (maybe you changed API keys recently)
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_ApiConnectionError $e) {
    //     // Network communication with Stripe failed
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Stripe_Error $e) {
    //     // Display a very generic error to the user, and maybe send
    //     // yourself an email
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   } catch (Exception $e) {
    //     flash($e->getMessage(), 'danger');
    //     return redirect()->back();
    //   }
    // }


    /**
     * Delete card
     *
     * @param \Illuminate\Http\Request $request, int $card_id
     * @return \Illuminate\Http\Response
     */
    public function deleteCard(Request $request, $card_id)
    {
      $payment_source = PaymentSource::find($card_id);
      try {
        \Auth::user()->billing->deleteCard($payment_source);
        flash('Card deleted successfully.', 'success');
        return redirect()->to(route('Manage Subscriptions'));
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
    }

}
