<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
  /**
   * Follow Business (AJAX)
   *
   * @param int $business_id
   * @return \Illuminate\Http\Response
   */
  public function create($business_id)
  {
    $follow = new Follow;
    $follow->user()->associate(\Auth::user());
    $follow->business_id = $business_id;
    return [
      'success' => $follow->save()
    ];
  }


  /**
   * Un-Follow Business (AJAX)
   *
   * @param int $business_id
   * @return \Illuminate\Http\Response
   */
  public function delete($business_id)
  {
    $follow = \Auth::user()->following()->where('business_id', $business_id);
    return [
      'success' => $follow->delete()
    ];

  }
}
