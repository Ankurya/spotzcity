<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Business;
use SpotzCity\Review;

use Carbon\Carbon;
use \Lob\Lob;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReviewController extends Controller
{
  /**
   * Return business's reviews
   *
   * @return \Illuminate\Http\Response
   */
  public function index($id)
  {

  }


  /**
   * Display form to create review
   *
   * @return \Illuminate\Http\Response
   */
  public function create($business_id)
  {
    if(\Auth::user()->has_business){
      if(\Auth::user()->business->id == $business_id){
        flash('You cannot review your own business.', 'warning');
        return redirect()->to(route('Dashboard'));
      }
    }

    if(\Auth::user()->reviews->where('business_id', $business_id)->first()){
      flash('You cannot review a business more than once. Please edit your existing review.', 'warning');
      return redirect()->to(route('Edit Review', ['business_id' => $business_id]));
    }

    $business = Business::find($business_id);
    return view('businesses/forms/create-review',[
      'business' => $business,
      'review' => new Review
    ]);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $business_id)
  {
    try {
      $business = Business::find($business_id);
      $business->reviews()->create([
        'rating' => $request->input('rating'),
        'body' => $request->input('body')
      ]);
    } catch (Exception $e) {
      flash($e->getMessage(), 'error');
      return redirect()->to(route('View Business', ['slug' => $business->slug]));
    }

    flash('Review submitted!', 'success');
    return redirect()->to(route('View Business', ['slug' => $business->slug]));
  }


  /**
   * Display form to create review
   *
   * @return \Illuminate\Http\Response
   */
  public function edit($business_id)
  {
    $business = Business::find($business_id);
    $review = \Auth::user()->reviews->where('business_id', $business_id)->first();

    if(!$review){
      return redirect()->to(route('Create Review', ['business_id' => $business->id]));
    }

    return view('businesses/forms/edit-review', [
      'business' => $business,
      'review' => $review
    ]);
  }


 /**
   * Update resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $business_id)
  {
    $business = Business::find($business_id);
    try {
      $review = $business->reviews->where('user_id', \Auth::user()->id)->first();
      $review->rating = $request->input('rating');
      $review->body = $request->input('body');
      $review->save();
    } catch (Exception $e) {
      flash($e->getMessage(), 'error');
      return redirect()->to(route('View Business', ['slug' => $business->slug]));
    }
    flash('Review updated!', 'success');
    return redirect()->to(route('View Business', ['slug' => $business->slug]));
  }


  /**
   * Create response to review
   *
   * @param  \Illuminate\Http\Request  $request, $review_id
   * @return \Illuminate\Http\Response
   */
  public function createResponse(Request $request, $review_id)
  {
    $review = Review::find($review_id);
    try {
      $review->response()->create([
        'body' => $request->input('body')
      ]);
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['success' => true, 'data' => $review->response], 200);
  }


  /**
   * Update response to review
   *
   * @param  \Illuminate\Http\Request  $request, $review_id
   * @return \Illuminate\Http\Response
   */
  public function updateResponse(Request $request, $review_id)
  {
    $review = Review::find($review_id);
    try {
      $review->response->body = $request->input('body');
      $review->response->save();
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['success' => true, 'data' => $review->response], 200);
  }


  /**
   * Delete response to review
   *
   * @param  \Illuminate\Http\Request  $request, $review_id
   * @return \Illuminate\Http\Response
   */
  public function deleteResponse(Request $request, $review_id)
  {
    $review = Review::find($review_id);
    try {
      $review->response->delete();
    } catch (Exception $e) {
      return response()->json(['error' => $e->getMessage()], 400);
    }
    return response()->json(['success' => true], 200);
  }
}
