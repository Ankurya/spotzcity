<?php

namespace SpotzCity\Http\Controllers;

use SpotzCity\Lib\PusherFactory;
use SpotzCity\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SpotzCity\User;
use SpotzCity\Business;
use DB;
use Mail;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * getLoadLatestMessages
     *
     *
     * @param Request $request
     */

    public function addList(string $user_id ){
        // 2623 test business
        //2620 mohit
        $business = Business::where('user_id', $user_id)->first();
        // if(empty($business)){
        //     //echo ("This is not a business Account. Please <a href='/search'>click here</a> search.");
        //     return redirect()->to('search');
        // }
        $message = new Message();
        $message->from_user = Auth::user()->id;
        $message->to_user = $user_id;
        $message->content = "Hey ".$business->name;
        $message->save();
        return redirect()->to('chat');
    }

    public function chatRoom(){

        $current_user_Id = \Auth::user()->id;

        $messages = Message::orWhere('to_user', $current_user_Id)->orWhere('from_user', $current_user_Id)->orderBy('created_at', 'DESC')->get()->toArray();

        //dd($current_user_Id);

     //    $user_Id = \Auth::user()->id;

     // $business = Business::where('user_id', $user_Id)->first();
        // $user_id = base64_decode($request->id);

        

        // dd($business_id);


        $users_id = array();
        $block_lists = array();
        $unread_id = array();
        if(count($messages) >=0){

            foreach ($messages as $key => $value) {
                if($current_user_Id != $value['to_user']){
                    $users_id[$value['to_user']] = $value['to_user'];
                }
                if($current_user_Id != $value['from_user']){
                    $users_id[$value['from_user']] = $value['from_user'];
                }
              
            }
	        $users_id = array_values($users_id);
            if(isset($_GET['business_id'])) {
                $users_id[] = $_GET['business_id'];
            }
            $users_ids = '0';
            if(!empty($users_id)) {
                $users_ids = implode(",",$users_id);
            }

            //dd($users_id);
	        

            $business_id= (isset($_GET['business_id']) && !empty($_GET['business_id'])) ? $_GET['business_id'] : $users_ids;


	        $block_list = DB::table('block_list')->select('from_user_id','block_user_id')->where(['from_user_id'=>$current_user_Id,"type"=>"Block"])->orWhere(['block_user_id'=>$current_user_Id,"type"=>"Block"])->whereIn('block_user_id' , $users_id)->groupBy('block_user_id')->get()->toArray();

             /*if(isset($_GET['dev']) && $_GET['dev']=="1"){
                 echo "<pre>";print_r($messages);die;
             }*/
        	
        	foreach ($block_list as $key1 => $value1) {
                if($value1->from_user_id == $current_user_Id) {
                    $block_lists[] =  $value1->block_user_id;
                } else {
        		    $block_lists[] =  $value1->from_user_id;
        	    }
            }


        DB::enableQueryLog();
        $users = User::leftJoin('businesses', function($join) {
            $join->on('users.id', '=', 'businesses.user_id');
            })
            ->where('users.id' , '!=', $current_user_Id)
            ->whereIn('users.id' , $users_id)
            ->orderByRaw('FIELD(users.id,'.$business_id.') DESC')
            ->orderByRaw('FIELD(users.id,3,735,2617) DESC')

            
            ->get([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.display_name',
                'users.email',
                'users.has_business',
                'users.user_status',
                'users.picture',
                'users.created_at',
                'users.last_seen',
                'users.admin',
                'businesses.id as business_id',
                'businesses.name as business_name'
            ]);

        // $query = DB::getQueryLog();
        // dd($query);

        $unread = DB::table('messages')->where("isRead", 0)->whereIn('from_user' , $users_id)->orderBy('created_at', "DESC")->get()->toArray();

        foreach ($unread as $key => $value) {
            $unread_id[] = $value->from_user;
        }

        if(isset($_GET['dev']) && $_GET['dev']=="1"){
            // $unread1 = DB::table('messages')->where("isRead", 0)->whereIn('from_user' , $users_id)->orderBy('created_at', "DESC")->get(['id AS msg_id', 'from_user AS unread_user', 'content', 'type', 'created_at']);

            // echo "<pre>";print_r($unread);die;
            

            
        }

        return view('chat/chat',['users'=> $users, 'message_users' => $users_id , 'current_user_Id'=> $current_user_Id,'block_lists'=>$block_lists,'unread_id'=>$unread_id]);
        }else{
            return redirect()->to('search');
        }

    

    }


    public function changeUserStatus(Request $request){
        
        if(!\Auth::user()->id){
            return response()->json(['status' => 0, 'messages' => "unauthorized user!"]);
        }

        $user = User::find(\Auth::user()->id);
        
        $user->user_status = $request->status;
        $user->last_seen = now();
        $user->save();
        return response()->json(['status' => 1, 'messages' => "Status has been updated!"]);
    }


    public function blockuser(Request $request){
        
        if(!\Auth::user()->id){
            return response()->json(['status' => 0, 'messages' => "unauthorized user!"]);
        }

        $data['from_user_id'] = \Auth::user()->id;
        $data['block_user_id'] = $request->blocker_id;
        $data['type'] = $request->status;
        if($request->status=="Report"){
        	$data['message'] = $request->message;
        	/*
            $user = User::findOrFail(\Auth::user()->id);
            $user->block_user = User::findOrFail($request->blocker_id);
            $user->report_message = $request->message;
            //echo ($user);
           	Mail::send('emails.report', ['user' => $user], function ($m) use ($user) {
                $m->from($user->email, $user->display_name);
                $m->to("happysingh.singh007@gmail.com", "Spotz City")->subject('Spotzcity chat report user');
            });
			*/
        }
        $data['created_at'] = date("Y-m-d H:s:i");

        DB::table('block_list')->insert($data);

        return response()->json(['status' => 1, 'messages' => "User has been ".$request->status."!"]);
    }

    public function unblock($block_user_id){
        
        if(!\Auth::user()->id){
            return response()->json(['status' => 0, 'messages' => "unauthorized user!"]);
        }

        $data['from_user_id'] = \Auth::user()->id;
        $data['block_user_id'] = $block_user_id;
        DB::table('block_list')->where($data)->delete();

        return redirect()->to(route('Chats Settings'));
    }
    

    public function chatSetting(){
    	$current_user_Id = \Auth::user()->id;
        
        $block_list = DB::table('block_list')->where(['from_user_id'=>$current_user_Id,"type"=>"Block"])->groupBy('block_user_id')->get('block_user_id')->toArray();
            
        foreach ($block_list as $key1 => $value1) {
            $block_lists[] =  $value1->block_user_id;
        }
        $users = User::leftJoin('block_list', function($join) {
            $join->on('users.id', '=', 'block_list.block_user_id');
            })
            ->where(['block_list.from_user_id' => $current_user_Id,"type"=>"Block"])
            ->orderBy('block_list.block_user_id',"DESC")
            ->get([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.display_name',
                'users.email',
                'users.has_business',
                'users.user_status',
                'users.picture',
                'users.created_at',
                'users.last_seen',
                'users.admin',
                'block_list.id as block_list_id',
                'block_list.block_user_id',
                'block_list.type',
                'block_list.created_at'
            ]);

    	return view('chat/setting',['current_user_Id'=> $current_user_Id,'users'=> $users]);
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
            
          $users = User::where('id' , '!=', \Auth::user()->id)->whereIn('id' , $users_id)->limit(5)->get();
        
      // print_r($users);die;
        //return view('chat/home',['users'=> $users]);
        return view('chat/chat',['users'=> $users, 'business'=>$business]);
      }


    public function getLoadLatestMessages(Request $request)
    {
    	
        if(!$request->user_id) {
            return;
        }

        $messages = Message::where(function($query) use ($request) {
            $query->where('from_user', Auth::user()->id)->where('to_user', $request->user_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('from_user', $request->user_id)->where('to_user', Auth::user()->id);
        })->orderBy('created_at', 'ASC')->limit(10000)->get();

        $return = [];
        
        // dd($messages);
        $today = date("d-m-Y");
        $yesterday = date("d-m-Y", strtotime("yesterday"));
        $count = 0;
        $count1 = 0;
        //echo $messages;
        foreach ($messages as $message) {
            $msg = "";
            if(date("d-m-Y", strtotime($message->created_at))==$yesterday && $count==0){
                $msg = '<p class="test-pera"><span></span><span>Yesterday</span><span></span></p>';
                $count++;
            }elseif(date("d-m-Y", strtotime($message->created_at))==$today && $count1==0){
                $msg = '<p class="test-pera"><span></span><span>Today</span><span></span></p>';
                $count1++;
            }

            //echo $msg;
            //$return[] = view('chat/message-line')->with('message', $message)->render();
            $return[] = view('chat/message-line')->with(['msg'=>$msg,'message'=> $message])->render();
        }

        DB::table('messages')->where(["from_user"=>$request->user_id, "to_user" => \Auth::user()->id])->update(['isRead' => 1]);
        

        return response()->json(['state' => 1, 'messages' => $return]);
    }


    /**
     * postSendMessage
     *
     * @param Request $request
     */
    public function postSendMessage(Request $request)
    {
        define('CHARSET', 'ISO-8859-1');
        define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);
        if(!$request->to_user || ((!$request->message) && !$request->hasFile('attach'))) {
            //echo "exit";
            return;
        }

        $message = new Message();
        $picture = "";

        if($request->hasFile('attach')){
            
            if(($_FILES['attach']['type']=="image/png") || ($_FILES['attach']['type']=="image/jpg") || ($_FILES['attach']['type']=="image/jpeg")){
                //echo "<pre>";print_r($_POST);print_r($_FILES['attach']);
                if($request->hasFile('attach')){
                    $pic_path = $request->file('attach')->store('profiles', 'public');
                    $picture = '<img src="'.asset('assets/storage/'.$pic_path).'" width="150px" height="auto" /><br/>';
                  }
            }else{
                return response()->json(['state' => 1, 'data' => "Only (jpg/png) image file can upload"]);
            }
            $message->type = "image";
        }else{
            $message->type = $this->has_emojis_old($request->message);
        }
        
        
        $message->from_user = Auth::user()->id;

        $message->to_user = $request->to_user;


        $message->content = $picture. htmlspecialchars($request->message, REPLACE_FLAGS, CHARSET);
        //print_r($message);
        $message->save();


        // prepare some data to send with the response
        $message->dateTimeStr = date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString()));

        $message->dateHumanReadable = $message->created_at->diffForHumans();

        $message->fromUserName = Auth::user()->first_name.' '.Auth::user()->last_name;

        $message->from_user_id = Auth::user()->id;

        $message->toUserName = Auth::user()->first_name.' '.Auth::user()->last_name;

        $message->to_user_id = $request->to_user;


        $result = PusherFactory::make()->trigger('Spotz-city-1204', 'send', ['data' => $message]);
        // dd($result);

        $user = User::find(\Auth::user()->id);
        $user->last_seen = now();
        $user->save();

        return response()->json(['state' => 1, 'data' => $message]);
    }


    function has_emojis_old( $string ) {

    preg_match( '/[\x{1F600}-\x{1F64F}]/u', $string, $matches_emo );

    return !empty( $matches_emo[0] ) ? "emoji" : "text";

}

    /**
     * getOldMessages
     *
     * we will fetch the old messages using the last sent id from the request
     * by querying the created at date
     *
     * @param Request $request
     */
    public function getOldMessages(Request $request)
    {
        if(!$request->old_message_id || !$request->to_user)
            return;

        $message = Message::find($request->old_message_id);

        $lastMessages = Message::where(function($query) use ($request, $message) {
            $query->where('from_user', Auth::user()->id)
                ->where('to_user', $request->to_user)
                ->where('created_at', '<', $message->created_at);
        })
            ->orWhere(function ($query) use ($request, $message) {
            $query->where('from_user', $request->to_user)
                ->where('to_user', Auth::user()->id)
                ->where('created_at', '<', $message->created_at);
        })
            ->orderBy('created_at', 'ASC')->limit(10)->get();

        $return = [];
        
             
        // dd($message);

        if($lastMessages->count() > 0) {

            foreach ($lastMessages as $message) {

                $return[] = view('chat/message-line')->with('message', $message)->render();
            }

            PusherFactory::make()->trigger('chat', 'oldMsgs', ['to_user' => $request->to_user, 'data' => $return]);
        }

        return response()->json(['state' => 1, 'data' => $return]);
    }
}
