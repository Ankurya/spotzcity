<?php

namespace SpotzCity\Http\Controllers;

use Illuminate\Http\Request;
use SpotzCity\Partner;
use SpotzCity\User;
use SpotzCity\ECategory;
use DB;
class PartnerController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      // return redirect()->to( route('Dashboard') );
    
      if(!\Auth::user()->admin) return redirect()->to( route('Dashboard') );

      $partner = new Partner;

      $business = \Auth::user()->business;

      $e_categories = ECategory::orderBy('name', 'asc')->get();

      return view('partner/create', [
        'partner' => $partner,
        'e_categories' => $e_categories,
        'business' => $business
      ]);
    }

    public function store(Request $request)
    {
        $partner = new Partner;

        // CHECK FOR ADMIN
        if(!\Auth::user()->admin){
          flash("Not allowed to update.", 'warning');
          return redirect()->to(route('Dashboard'));
        }
        
       
        $partner->partner_name = $request->input('partner_name');
        $partner->link = $request->input('link');
        $partner->description = $request->input('description');
  
        if($request->hasFile('logo')){
          $pic_path = $request->file('logo')->store('profiles', 'public');
          $partner->picture = $pic_path;
        }
  
        $partner->save();
  
        flash('Successfully created partner.', 'success');
        return redirect()->to(route('Dashboard'));
    } 

    public function showPartner(){

        // dd('showPartner');

        // dd(\Auth::user()->billing);
        if(!\Auth::user()){
          flash("Not allowed to access URL.", 'warning');
          return redirect()->to(route('Dashboard'));
        }


        if(!\Auth::user()->billing) {
          flash("Not allowed to access URL.", 'warning');
          return redirect()->to(route('Dashboard'));

        }

        $partner = DB::table('partners')
        ->select('*')
        ->get();
       //echo '<pre>'; print_r($partner); exit;
        return view('partner/show', [
            'partner' => $partner
          ]);
    }
}
