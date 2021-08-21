<?php

namespace SpotzCity\Http\Controllers;

use Carbon\Carbon;

use SpotzCity\Conference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;

class ConferencesController extends Controller
{
    /**
     * Display upcoming conferences.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
      // Pull args
      $location = $request->query( 'location' );
      $minDate = $request->query( 'min-date' );
      $maxDate = $request->query( 'max-date' );
      $industry = $request->query( 'industry' );

      $conferences = Conference::where('approved', true)
        ->when($location, function($q) use ($location) {
          return $q->where('location', 'LIKE', '%'.$location.'%');
        })
        ->when($minDate, function($q) use ($minDate) {
          return $q->where('starts', '>=', new Carbon($minDate));
        })
        ->when(!$minDate, function($q) {
          return $q->where('ends', '>=', Carbon::now());
        })
        ->when($maxDate, function($q) use ($maxDate) {
          return $q->where('starts', '<=', new Carbon($maxDate));
        })
        ->when($industry, function($q) use ($industry) {
          return $q->where('industry', 'LIKE', '%'.$industry.'%');
        })
        ->orderBy('starts', 'asc')
        ->paginate(15);

      return view('conferences/index', [
        'conferences' => $conferences,
        'location' => $location,
        'minDate' => $minDate,
        'maxDate' => $maxDate,
        'industry' => $industry
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('conferences/create', [
        'conference' => new Conference
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
      $conference = new Conference;
      $conference->name = $request->input('conference_name');
      $conference->website = $request->input('website');
      $conference->starts = Carbon::parse($request->input('starts'));
      $conference->ends = Carbon::parse($request->input('ends'));
      $conference->venue = $request->input('venue');
      $conference->industry = $request->input('industry');
      $conference->location = $request->input('location');
      $conference->description = $request->input('description');
      $conference->user_id = \Auth::user()->id;
      $conference->approved = \Auth::user()->admin;

      if($request->hasFile('logo')){
        $path = $request->file('logo')->store('conferences', 'public');
        $conference->image = $path;
      }

      $conference->geocodeLocation();

      $conference->save();
      flash('Conference submitted!', 'success');
      return redirect()->to(route('Conferences'));
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
      $conference = Conference::find($id);
      if(!$conference){
        flash('Conference not found', 'error');
        return redirect()->to(route('Conferences'));
      }

      if(!\Auth::user()->admin){
        flash('Not allowed to edit', 'warning');
        return redirect()->to(route('Conferences'));
      }

      return view('conferences/edit', [
        'conference' => $conference
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
      if(!\Auth::user()->admin){
        flash('Not allowed to edit', 'warning');
        return redirect()->to(route('Conferences'));
      }

      $conference = Conference::find($id);
      $conference->name = $request->input('conference_name');
      $conference->website = $request->input('website');
      $conference->starts = Carbon::parse($request->input('starts'));
      $conference->ends = Carbon::parse($request->input('ends'));
      $conference->venue = $request->input('venue');
      $conference->location = $request->input('location');
      $conference->description = $request->input('description');
      $conference->approved = \Auth::user()->admin;

      $conference->save();
      flash('Conference submitted!', 'success');
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
     * Batch import conferences (via scraper).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function batch(Request $request)
    {
        Log::debug( $request->all() );
        try{
          if( !$request->conferences ) throw new \Exception( 'Conferences empty or not detected.' );

          $toImport = $request->conferences;

          // Iterate and create/update
          foreach( $toImport as $data ) {
            $conference = Conference::firstOrNew([ 'name' => $data['name'] ]);
            $conference->fill( $data );
            $conference->approved = true;
            $conference->save();
          }
        } catch( \Exception $e ) {
          Bugsnag::notifyException( $e );
          return response()->json( ['error' => $e->getMessage()], 400 );
        }

        return [ 'success' => 1 ];
    }
}
