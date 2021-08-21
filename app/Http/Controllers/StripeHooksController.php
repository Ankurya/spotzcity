<?php

namespace SpotzCity\Http\Controllers;

use Illuminate\Http\Request;
use \Stripe as Stripe;
use Illuminate\Support\Facades\Log;
use SpotzCity\Invoice;
use SpotzCity\Subscription;
use SpotzCity\Billing;

use Postmark\PostmarkClient;
use Postmark\Models\PostmarkException;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class StripeHooksController extends Controller
{

    public function receiveEvent(Request $request){
      // Log
      $log = new Logger('receiveEvent');
      $log->pushHandler(new StreamHandler(base_path().'/logs/webhooks.log', Logger::INFO));
      $log->info("Receiving event: ".$request->input('type'));

      Stripe\Stripe::setApiKey(env("STRIPE_API_KEY"));
      switch ($request->input('type')) {
        case 'invoice.created':
          try {
            $this->invoiceCreated($request->input('data.object'));
            return response('Good', 200);
          } catch (Exception $e) {
            return response($e->getMessage(), 400);
          }
          break;

        case 'invoice.payment_succeeded':
          try {
            $this->invoicePaymentSucceeded($request->input('data.object'));
            return response('Good', 200);
          } catch (Exception $e) {
            return response($e->getMessage(), 400);
          }
          break;

        case 'invoice.payment_failed':
          try {
            $log->info("Initiating invoicePaymentFailed...");
            $this->invoicePaymentFailed($request->input('data.object'));
            return response('Good', 200);
          } catch (Exception $e) {
            return response($e->getMessage(), 400);
          }
          break;

        case 'subscription.cancelled':
          // Take appropriate action to cancel ad
          // try {
          //   $this->invoicePaymentFailed($request->input('data.object'));
          //   return response('Good', 200);
          // } catch (Exception $e) {

          // }
          break;
      }
    }

    public function invoiceCreated($stripe_invoice){
      $sub = Subscription::where('subscription_id', $stripe_invoice['subscription'])->first();
      if(!$sub) return; // To avoid logging invoices across environments

      $invoice = new Invoice;
      $invoice->invoice_id = $stripe_invoice['id'];
      $invoice->customer_id = $stripe_invoice['customer'];
      $invoice->amount_due = $stripe_invoice['amount_due'] / 100;
      $invoice->attempted = $stripe_invoice['attempted'];
      $invoice->next_attempt = $stripe_invoice['next_payment_attempt'];
      $invoice->paid = $stripe_invoice['paid'];
      $invoice->receipt_number = $stripe_invoice['receipt_number'] ? $stripe_invoice['receipt_number'] : 'N/A';

      $sub->invoices()->save($invoice);
      return;
    }


    public function invoicePaymentSucceeded($stripe_invoice){
      $sub = Subscription::where('subscription_id', $stripe_invoice['subscription'])->first();
      if(!$sub) return; // To avoid logging invoices across environments

      $invoice = Invoice::where('invoice_id', $stripe_invoice['id'])->first();
      $invoice->customer_id = $stripe_invoice['customer'];
      $invoice->amount_due = $stripe_invoice['amount_due'] / 100;
      $invoice->attempted = $stripe_invoice['attempted'];
      $invoice->next_attempt = $stripe_invoice['next_payment_attempt'];
      $invoice->paid = $stripe_invoice['paid'];
      $invoice->receipt_number = $stripe_invoice['receipt_number'] ? $stripe_invoice['receipt_number'] : 'N/A';

      $sub->invoices()->save($invoice);
      return;
    }


    public function invoicePaymentFailed($stripe_invoice){
      // Log
      $log = new Logger('invoicePaymentFailed');
      $log->pushHandler(new StreamHandler(base_path().'/logs/webhooks.log', Logger::INFO));
      $log->info("Payment failure beginning to process...");

      $invoice = Invoice::where('invoice_id', $stripe_invoice['id'])->first();
      if(!$invoice) return;
      $sub = $invoice->subscription;
      $log->info("Invoice #$invoice->id successfully pulled...");

      $invoice->attempted += 1;
      $invoice->next_attempt = $stripe_invoice['next_payment_attempt'];
      $invoice->paid = $stripe_invoice['paid'];
      $invoice->save();
      $log->info("Invoice #$invoice->id successfully updated, sending email...");

      // Send Payment Failed email if tried less than 3 times
      if($invoice->attempted < 3){
        try {
          $client = new PostmarkClient(env('POSTMARK_API_KEY'));
          $sendResult = $client->sendEmailWithTemplate(
            "ej@sequential.tech",
            $sub->billing->user->email,
            2817682,
            [
              'name' => $sub->billing->user->first_name,
              'payment_url' => env('APP_URL')."/manage-subscriptions?flash=updatePayment",
              'ad_name' => $sub->ad()->name,
              'next_payment_attempt' => $invoice->next_attempt
            ]
          );
        } catch (Exception $e) {
          $log->info("Email error occurred: ".$e->getMessage());
        }
      }


      $log->info("Email sent successfully...");

      // If 3rd attempt to charge, subscription will be cancelled. Set ad to inactive and delete subscription.
      if($invoice->attempted == 3){
        try {
          $sub->ad()->active = 0;
          $sub->ad()->approved = 0;
          $sub->ad()->save();
          $sub->cancel(false);
        } catch (Exception $e) {
          $log->info("Error occurred: ".$e->getMessage());
        }
      }
      return;
    }
}
