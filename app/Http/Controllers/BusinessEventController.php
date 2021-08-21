<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Business;
use SpotzCity\BusinessEvent;

use Carbon\Carbon;
use \Lob\Lob;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BusinessEventController extends Controller
{
  /**
   * Return business's events and specials
   *
   * @return \Illuminate\Http\Response
   */
  public function index($id)
  {
    if(!is_integer((int) $id)){
      return response()->json(['message' => 'Invalid id given.'], 400);
    }
    $events_specials = BusinessEvent::where('business_id', $id)
      ->orderBy('created_at')
      ->get();
    return $events_specials;
  }


  /**
   * Display form to create/update/delete events and specials
   *
   * @return \Illuminate\Http\Response
   */
  public function edit($id = null)
  {
    return view('businesses/events',[
      'id' => $id ? $id : \Auth::user()->business->id
    ]);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request, $id)
  {
    $event_special = new BusinessEvent;
    $event_special->type = $request->input('type');
    $event_special->name = $request->input('name');
    $event_special->description = $request->input('description');
    $event_special->start = $request->input('start');
    $event_special->end = $request->input('end');

    $business = Business::find($id); // Need to lock down route for owner or admin

    if($business->eventsAndSpecials()->save($event_special)){
      return $this->index($id);
    } else{
      return response()->json(['error' => 'Error saving'], 400);
    }
  }


  /**
   * Update resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $business_id, $id)
  {
    $business = Business::find($business_id); // Need to lock down route for owner or admin
    $event_special = $business->eventsAndSpecials->find($id);
    $event_special->type = $request->input('type');
    $event_special->name = $request->input('name');
    $event_special->description = $request->input('description');
    $event_special->start = $request->input('start');
    $event_special->end = $request->input('end');

    if($event_special->save()){
      return $this->index($business_id);
    } else{
      return response()->json(['error' => 'Error saving'], 400);
    }
  }


  /**
   * Delete resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function delete(Request $request, $business_id, $id)
  {
    $business = Business::find($business_id); // Need to lock down route for owner or admin
    $event_special = $business->eventsAndSpecials->find($id);

    if($event_special->delete()){
      return $this->index($business_id);
    } else{
      return response()->json(['error' => 'Error saving'], 400);
    }
  }


  /**
   * Download event ical file
   *
   * @param int id
   * @return \Illuminate\Http\Response
   */
  public function downloadEvent($id)
  {
    $event = BusinessEvent::find($id);
    header('Content-type: text/calendar; charset=utf-8');
    header('Content-Disposition: attachment; filename='. $event->name .'.ics');
    echo $event->outputCalendarFile();
    return;
  }

}
