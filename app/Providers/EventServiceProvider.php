<?php

namespace SpotzCity\Providers;

use SpotzCity\Business;
use SpotzCity\Ad;
use SpotzCity\Review;
use SpotzCity\ReviewResponse;
use SpotzCity\User;
use SpotzCity\BusinessEvent;
use SpotzCity\BusinessVerification;
use SpotzCity\Activity;
use SpotzCity\ContactRequest;
use SpotzCity\Conference;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Postmark\PostmarkClient;
use Postmark\Models\PostmarkException;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'SpotzCity\Events\SomeEvent' => [
            'SpotzCity\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     * TO DO (eventually): refactor these into observers
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Send welcome email after user is created
        User::created(function($user){
          if(!$user->admin){
            try{
              $client = new PostmarkClient(env('POSTMARK_API_KEY'));
              $sendResult = $client->sendEmailWithTemplate(
                "ej@sequential.tech",
                $user->email,
                1405461,
                [
                  'name' => $user->first_name,
                  'url' => env('APP_URL')."/dashboard"
                ]
              );

            }catch(PostmarkException $ex){
                // If client is able to communicate with the API in a timely fashion,
                // but the message data is invalid, or there's a server error,
                // a PostmarkException can be thrown.

            }catch(Exception $generalException){
                // A general exception is thrown if the API
                // was unreachable or times out.
            }
          } else{
            try{
              $client = new PostmarkClient(env('POSTMARK_API_KEY'));
              $sendResult = $client->sendEmail(
                "ej@sequential.tech",
                $user->email,
                "Added as Admin",
                "You've been added to SpotzCity as an admin. Please follow the following link, input your email, and reset your password to complete your signup. Click <a href='".env('APP_URL')."/password/reset'>here.</a>"
              );

            }catch(PostmarkException $ex){
                // If client is able to communicate with the API in a timely fashion,
                // but the message data is invalid, or there's a server error,
                // a PostmarkException can be thrown.
                Bugsnag::notifyException($ex);

            }catch(Exception $generalException){
                // A general exception is thrown if the API
                // was unreachable or times out.
                Bugsnag::notifyException($generalException);
            }
          }

        });


        // Send email after verification is requested
        BusinessVerification::created(function($verification){
          try{
            $client = new PostmarkClient(env('POSTMARK_API_KEY'));
            $sendResult = $client->sendEmailWithTemplate(
              "ej@sequential.tech",
              $verification->user->email,
              1450882,
              [
                'name' => $verification->user->first_name,
                'full_name' => $verification->user->display_name,
                'url' => env('APP_URL')."/dashboard",
                'business' => $verification->business->toArray(),
                'arrival' => $verification->expected_arrival->toFormattedDateString()
              ]
            );

          }catch(PostmarkException $ex){
            // If client is able to communicate with the API in a timely fashion,
            // but the message data is invalid, or there's a server error,
            // a PostmarkException can be thrown.
            Bugsnag::notifyException($ex);

          }catch(Exception $generalException){
              // A general exception is thrown if the API
              // was unreachable or times out.
              Bugsnag::notifyException($generalException);
          }

        });


        Ad::created(function($ad){
          // Send ad created email
          try{
            $client = new PostmarkClient(env('POSTMARK_API_KEY'));
            $sendResult = $client->sendEmailWithTemplate(
              "ej@sequential.tech",
              $ad->user->email,
              1473201,
              [
                'name' => $ad->user->first_name,
                'url' => env('APP_URL')."/dashboard"
              ]
            );

          }catch(PostmarkException $ex){
            // If client is able to communicate with the API in a timely fashion,
            // but the message data is invalid, or there's a server error,
            // a PostmarkException can be thrown.
            Bugsnag::notifyException($ex);

          }catch(Exception $generalException){
              // A general exception is thrown if the API
              // was unreachable or times out.
              Bugsnag::notifyException($generalException);
          }
        });

        Ad::updating(function($ad){
          // Send approved email if ad->approved goes from false to true
          $prev = $ad->getOriginal();
          if(!$prev['approved'] && $ad->approved){
            try{
              $client = new PostmarkClient(env('POSTMARK_API_KEY'));
              $sendResult = $client->sendEmailWithTemplate(
                "ej@sequential.tech",
                $ad->user->email,
                1473321,
                [
                  'name' => $ad->user->first_name,
                  'ad_name' => $ad->name,
                  'activate_url' => env('APP_URL')."/manage-subscriptions?activate=$ad->id",
                  'url' => env('APP_URL')."/dashboard"
                ]
              );

            }catch(PostmarkException $ex){
              // If client is able to communicate with the API in a timely fashion,
              // but the message data is invalid, or there's a server error,
              // a PostmarkException can be thrown.
              Bugsnag::notifyException($ex);

            }catch(Exception $generalException){
                // A general exception is thrown if the API
                // was unreachable or times out.
                Bugsnag::notifyException($generalException);
            }
          }
        });


        // Set user during review creation
        Review::creating(function($review){
          if(!$review->user_id){
            $review->user_id = \Auth::user()->id;
          }
        });

        // Update business rating and log activity upon review created/updated
        Review::created(function($review){
          // Send business owner 'Your business was reviewed...' email
          try{
            $client = new PostmarkClient(env('POSTMARK_API_KEY'));
            $sendResult = $client->sendEmailWithTemplate(
              "ej@sequential.tech",
              $review->business->user->email,
              1472901,
              [
                'name' => $review->business->user->first_name,
                'business_name' => $review->business->name,
                'reviewer_name' => $review->user->display_name,
                'business_url' => env('APP_URL')."/business/{$review->business->slug}",
                'url' => env('APP_URL')."/dashboard"
              ]
            );

          }catch(PostmarkException $ex){
            // If client is able to communicate with the API in a timely fashion,
            // but the message data is invalid, or there's a server error,
            // a PostmarkException can be thrown.
            Bugsnag::notifyException($ex);

          }catch(Exception $generalException){
              // A general exception is thrown if the API
              // was unreachable or times out.
              Bugsnag::notifyException($generalException);
          }


          $review->business->calcRating();

          // Log activity
          $entry = new Activity;
          $entry->type = 'review.created';
          $entry->user()->associate($review->user);
          $entry->business()->associate($review->business);
          $entry->review()->associate($review);
          $entry->save();

          return $review->business->save();
        });

        Review::updated(function($review){
          $review->business->calcRating();
          return $review->business->save();
        });


        // Log activity when review is responded to
        ReviewResponse::created(function($response){
          // Send review owner 'Your review has been responded to...' email
          try{
            $client = new PostmarkClient(env('POSTMARK_API_KEY'));
            $sendResult = $client->sendEmailWithTemplate(
              "ej@sequential.tech",
              $response->review->user->email,
              1472942,
              [
                'name' => $response->review->user->first_name,
                'business_name' => $response->review->business->name,
                'business_url' => env('APP_URL')."/business/{$response->review->business->slug}",
                'url' => env('APP_URL')."/dashboard"
              ]
            );

          }catch(PostmarkException $ex){
            // If client is able to communicate with the API in a timely fashion,
            // but the message data is invalid, or there's a server error,
            // a PostmarkException can be thrown.
            Bugsnag::notifyException($ex);

          }catch(Exception $generalException){
              // A general exception is thrown if the API
              // was unreachable or times out.
              Bugsnag::notifyException($generalException);
          }


          $entry = new Activity;
          $entry->type = 'review_response.created';
          $entry->user()->associate($response->review->user);
          $entry->business()->associate($response->review->business);
          $entry->review()->associate($response->review);
          $entry->review_response()->associate($response);
          return $entry->save();
        });


        // Log activity for business created
        // Business::created(function($business){
        //   $entry = new Activity;
        //   $entry->type = 'business.created';
        //   $entry->business()->associate($business);
        //   $entry->save();
        // });


        // Log activity for business event/special created
        BusinessEvent::created(function($business_event){
          $entry = new Activity;
          $entry->type = 'event.created';
          $entry->business()->associate($business_event->business);
          $entry->business_event()->associate($business_event);
          $entry->save();
        });


        // Send notification email to super admin user when contact request is created
        ContactRequest::created(function($contact_request){
          try{
            $super = User::find(env('APP_SUPERUSER'));
            $client = new PostmarkClient(env('POSTMARK_API_KEY'));
            $message = [
              'To' => 'customer_service@spotzcity.com',
              'From' => "ej@sequential.tech",
              'ReplyTo' => $contact_request->email,
              'Subject' => "Spotz CR: $contact_request->subject",
              "HtmlBody" => "Message: $contact_request->message <br/><br/> From: $contact_request->name, Phone (if provided): $contact_request->phone <br/><br/> <i>Simply hit reply to respond.</i>"
            ];

            $sendResult = $client->sendEmailBatch([$message]);

          }catch(PostmarkException $ex){
            // If client is able to communicate with the API in a timely fashion,
            // but the message data is invalid, or there's a server error,
            // a PostmarkException can be thrown.
            Bugsnag::notifyException($ex);

          }catch(Exception $generalException){
              // A general exception is thrown if the API
              // was unreachable or times out.
              Bugsnag::notifyException($generalException);
          }
        });


        // Geocode conference during creation
        Conference::creating(function($conference){
          $conference->geocodeLocation();
          return true;
        });
    }
}
