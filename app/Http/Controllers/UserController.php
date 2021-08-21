<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\User;
use Illuminate\Http\Request;
use SpotzCity\Business;
use DB;
use SpotzCity\Message;
class UserController extends Controller
{

    /**
     * Display User with reviews
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
    {
      $user = User::find($id);

      if(\Auth::user()->admin) $user->with('billing');

      return view('users/show', [
        'user' => $user
      ]);
    }


    /**
     * Show form for creating an admin
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

      if(!\Auth::user()->admin) return redirect()->to( route('Dashboard') );

      $user = new User;

      return view('users/create', [
        'user' => $user
      ]);
    }


    /**
     * Store asset in storage.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $user = new User;

      // CHECK FOR ADMIN
      if(!\Auth::user()->admin){
        flash("Not allowed to update.", 'warning');
        return redirect()->to(route('Dashboard'));
      }
	  if (User::where('email', '=', $request->input('email'))->count() > 0) {
        flash("User email already exist.", 'warning');
        return redirect()->to(route('Dashboard'));
      }
      $user->first_name = $request->input('first_name');
      $user->last_name = $request->input('last_name');
      $user->display_name = $user->first_name." ".$user->last_name;
      $user->email = $request->input('email');

      if($request->hasFile('logo')){
        $pic_path = $request->file('logo')->store('profiles', 'public');
        $user->picture = $pic_path;
      }

      $user->admin = true;

      $user->password = bcrypt($request->input('password'));

      $user->save();

      flash('Successfully created admin.', 'success');
      return redirect()->to(route('Dashboard'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
      // If id specified, fetch user. Else current user.
      $user = $id ? User::find($id) : \Auth::user();

      return view('users/edit', [
        'user' => $user
      ]);
    }


    /**
     * Update specified asset in storage.
     *
     * @param  \Illuminate\Http\Request,  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {

      $user = $id ? User::find($id) : \Auth::user();

      // TO DO: ADD CHECK FOR ADMIN OR OWNERSHIP
      if($user->id !== \Auth::user()->id && !\Auth::user()->admin){
        flash("Not allowed to update.", 'warning');
        return redirect()->to(route('Dashboard'));
      }

      $user->first_name = $request->input('first_name');
      $user->last_name = $request->input('last_name');
      $user->display_name = $user->first_name." ".$user->last_name;
      $user->email = $request->input('email');

      if($request->hasFile('logo')){
        $pic_path = $request->file('logo')->store('profiles', 'public');
        $user->picture = $pic_path;
      }

      $user->save();

      flash('Successfully updated user info.', 'success');
      return redirect()->to(route('Dashboard'));
    }
	public function addNewUser(){


      // return redirect()->to( route('Dashboard') );

      $user = new User;

      return view('users/create-new-user', [
        'user' => $user
      ]);
    }
    public function storeNewUser(Request $request){
      $user = new User;

      // CHECK FOR ADMIN
     
      if (User::where('email', '=', $request->input('email'))->count() > 0) {
        flash("User email already exist.", 'warning');
        return redirect()->to(route('Dashboard'));
      }
     
      $user->first_name = $request->input('first_name');
      $user->last_name = $request->input('last_name');
      $user->display_name = $user->first_name." ".$user->last_name;
      $user->email = $request->input('email');

      if($request->hasFile('logo')){
        $pic_path = $request->file('logo')->store('profiles', 'public');
        $user->picture = $pic_path;
      }

      $user->admin = false;

      $user->password = bcrypt($request->input('password'));
     
      $id = DB::table('users')->insertGetId(
        ['first_name' => $user->first_name , 'last_name' =>  $user->last_name,'display_name'=> $user->display_name,'email'=> $user->email,'picture'=> $user->picture,'password'=> $user->password,'admin'=> false]
      );

      $billingId = DB::table('billing')->insertGetId(
        array(
               'user_id'     =>   $id,
        )
      );
      DB::table('business_subscriptions')->insertGetId(
        array(
               'billing_id'     =>   $billingId,
               'quantity'    => 1,
        )
      );

      flash('Successfully created new user.', 'success');
      return redirect()->to(route('Dashboard'));
    }
	
	public function chatFunc(string $slug ){
    $business = Business::where('slug', $slug)->first();
    //echo $business->user_id.' = '.$business->name;die;
    $users = User::where('id' , '!=', \Auth::user()->id)->where('id' , $business->user_id)->limit(5)->get();

    //return view('chat/home',['users'=> $users]);
    return view('users/chat',['users'=> $users, 'business'=>$business]);
	}

  public function businessChat(){
    $user_Id = \Auth::user()->id;
    $business = Business::where('user_id', $user_Id)->first();

    if(empty($business->id)){
      return redirect()->to(route('Dashboard'));
    }
    $users_id = array();

    $messages = Message::orWhere('to_user', $user_Id)->orWhere('from_user', $user_Id)->groupBy("to_user")->groupBy("from_user")->orderBy('created_at', 'ASC')->get();
        
        if(count($messages)>0){
            foreach ($messages as $key => $value) {
              $users_id[] = $value->to_user;
              $users_id[] = $value->from_user;
            }
        }
        
      $users = User::where('id' , '!=', \Auth::user()->id)->whereIn('id' , $users_id)->get();
    
  //print_r($users);die;
    //return view('chat/home',['users'=> $users]);
    return view('users/chat',['users'=> $users, 'business'=>$business]);
  }


	public function chatMsgSend(){
		print_r($_POST['to_user_id']);
		print_r($_POST['chat_message']);
		DB::table('chat_message')->insert(
			 array(
					'to_user_id'     =>   $_POST['to_user_id'], 
					'from_user_id'   =>   2,
					'chat_message'   =>   $_POST['chat_message'],
					'status'   =>   1,
			 )
		);
	}
}
