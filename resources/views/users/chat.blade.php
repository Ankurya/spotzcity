@extends('app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.flex-sec i.fa.fa-cog {color: #3a89b7;font-size: 25px;}
.flex-sec {display: flex;justify-content: space-between;}
.online-select {width: 100%;max-width: 220px;height: 40px;padding: 0 10px;font-size: 14px;}
.select-bar label {font-size: 16px;font-weight: bold;color: gray;margin-top: 15px;}
.mr-3 {width: 42px;height: 42px;border-radius: 50px;object-fit: cover;background-position: center;margin-right: 10px;}
.left-chat .media {display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: start;-ms-flex-align: start;align-items: flex-start;align-items: center;padding: 10px;border-radius: 20px;}
.left-chat .media:hover{background: #f5f5f5;}
.mt-h5 {
	    margin: 0;
    font-size: 14px;
    font-weight: bold;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
    color: gray !important;
}
.mt-p {margin: 0;font-size: 12px;color: gray;}
.search-input {height: 30px;border-radius: 7px;border: 1px solid gray;margin: 0 0 15px 0;padding: 0 10px;}
.main-border {border: 1px solid #d0d0d0;padding: 15px;display: block;float: left;width: 100%;margin-top: 15px;border-radius: 15px;}
.row.row-3 {padding-left: 15px;padding-right: 15px;}
.top-s {
       display: flex;
    justify-content: space-between;
}

.top-s select {
    height: 25px;
}
.container{max-width:1170px; margin:auto;}
img{ max-width:100%;}
.inbox_people {
  background: #f8f8f8 none repeat scroll 0 0;
  float: left;
  overflow: hidden;
  width: 40%; border-right:1px solid #c4c4c4;
}
.inbox_msg {
  border: 1px solid #c4c4c4;
  clear: both;
  overflow: hidden;
}
.top_spac{ margin: 20px 0 0;}


.recent_heading {float: left; width:40%;}
.srch_bar {
  display: inline-block;
  text-align: right;
  width: 60%; padding:
}
.headind_srch{ padding:10px 29px 10px 20px; overflow:hidden; border-bottom:1px solid #c4c4c4;}

.recent_heading h4 {
  color: #05728f;
  font-size: 21px;
  margin: auto;
}
.srch_bar input{ border:1px solid #cdcdcd; border-width:0 0 1px 0; width:80%; padding:2px 0 4px 6px; background:none;}
.srch_bar .input-group-addon button {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  padding: 0;
  color: #707070;
  font-size: 18px;
}
.srch_bar .input-group-addon { margin: 0 0 0 -27px;}

.chat_ib h5{ font-size:15px; color:#464646; margin:0 0 8px 0;}
.chat_ib h5 span{ font-size:13px; float:right;}
.chat_ib p{ font-size:14px; color:#989898; margin:auto}
.chat_img {
  float: left;
  width: 11%;
}
.chat_ib {
  float: left;
  padding: 0 0 0 15px;
  width: 88%;
}

.chat_people{ overflow:hidden; clear:both;}
.chat_list {
  border-bottom: 1px solid #c4c4c4;
  margin: 0;
  padding: 18px 16px 10px;
}
.inbox_chat { height: 550px; overflow-y: scroll;}

.active_chat{ background:#ebebeb;}

.incoming_msg_img {
  display: inline-block;
  width: 6%;
}
.received_msg {
  display: inline-block;
  padding: 0 0 0 10px;
  vertical-align: top;
  width: 92%;
 }
 .received_withd_msg p {
        background: #666666;
    border-radius: 10px;
    color: #ffffff;
    font-size: 12px;
    margin: 0;
    padding: 7px 10px 7px 10px;
    width: 100%;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: 57%;}
.mesgs {
  float: left;
  padding: 0;
  width: 100%;
}
.top-s p {
    padding: 0 10px 0 15px;
    width: 70%;
    color: gray;
    position: relative;
}
 .sent_msg p {
    background: #3a89b7;
    border-radius: 10px;
    font-size: 12px;
    margin: 0;
    color: #fff;
    padding: 7px 10px 7px 10px;
    width: 100%;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: 46%;
}
.input_msg_write input {
  background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
  border: medium none;
  color: #4c4c4c;
  font-size: 15px;
  min-height: 55px;
  width: 85%;
}

.type_msg {border-top: 1px solid #c4c4c4;position: relative;}
.msg_send_btn {
  background: #05728f none repeat scroll 0 0;
  border: medium none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  font-size: 17px;
  height: 33px;
  position: absolute;
  right: 25px;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 400px;
  overflow-y: auto;
}
.rigt-0{padding-right: 0;}

.cusmedia {
    height: 447px;
}
 
.left-chat {
    overflow-y: auto;
}

input.write_msg.chat_input {
    padding-left: 35px;
    padding-right: 70px;
}

.attachment{
  float: right;
  width: 13px;
  position: absolute;
  right: 6px;
  top: 14px;
  font-size: 20px;
  margin: 0;
  }

.icon-rotate {
    transform: rotate(136deg);
}
label.attachment.icon-rotate i.fa.fa-paperclip {
	transform: rotateY(180deg);
    position: relative;
    right: 4px;
    top: 0px;
    color: #3a89b7;
    font-size: 23px !important;
}

img#blah {
    opacity: 0.7;
}

.view-file {
    width: 100%;
    padding-top: 5px;
    background: #eceaea;
    text-align: center;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.type_msg {
    background: #fff;
}
input.search-input {
        width: 100%;
    border: 1px solid #d0d0d0;
}
.col-lg-4.l-0l {
    padding-left: 0 !important;
}
.msg_history.chat-area {padding: 0 15px;}
.messages.sent_msg.text-right time {font-size: 10px;color: gray;position: relative;bottom: 3px;}
.col-lg-8.rigt-0 {padding-right: 0 !important;}
div#chat-overlay .panel.panel-default {margin-bottom: 0;}
select.form-controls.pull-right.text-right {
   border: none;
    border-radius: 28px;
    padding: 0px 0px;
    font-size: 12px;
    color: gray;
}
::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}
::-webkit-scrollbar-button {
    width: 5px;
    height: 5px;
}
::-webkit-scrollbar-thumb {
    background: gray;
    border: 0px none #ffffff;
    border-radius: 0px;
}
::-webkit-scrollbar-thumb:hover {
    background: gray;
}
::-webkit-scrollbar-thumb:active {
    background: gray;
}
::-webkit-scrollbar-track {
    background: transparent;
    border: 0px none #ffffff;
    border-radius: 50px;
}
::-webkit-scrollbar-track:hover {
    background: transparent;
}
::-webkit-scrollbar-track:active {
    background: transparent;
}
::-webkit-scrollbar-corner {
    background: transparent;
}
input.write_msg.chat_input {
    background: #fff !important;
}
h2.section-header {margin-bottom: 0px; !important}
.input_msg_write.form-controls svg {
    position: relative;
    top: 3px;
}
.cusmedia .media:first-child {
    background: #f5f5f5;
     margin-top: 0px;
}
.cusmedia .media {
    margin-top: 5px;
}
.messages.received_withd_msg time {
    font-size: 10px;
    color: gray;
    position: relative;bottom: 3px;
}
.incoming_msg {
    margin: 26px 0 26px;
}
a.chat-toggle.mt-h5 {
    text-decoration: none;
}
ul.nav.side-nav li a {
    font-weight: 600;
}
button.msg_send_btn.btn-chat {
    background: #3a89b7 !important;
}
.container-fluid.content-wrap {
    padding: 30px 0 !important;
}
span.green-dot {
display: inline-block;
    width: 10px;
    height: 10px;
    background: #7fca7f;
    border-radius: 10px;
    position: absolute;
    left: 0;
    top: 5px;
}
input.write_msg.chat_input:focus {
    outline: none;
}

button.msg_send_btn.btn-chat:focus {
    outline: none;
}

input.search-input:focus {
    outline: none;
}
div.sidebar {
    border-left: 1px solid #d0d0d0;
}
.panel.panel-default {
    border: 1px solid #d0d0d0;
}
section#banner-ad img.ad {
    max-width: 100%;
    border: 1px solid #ddd;
    width: 100%;
}
.container-fluid.ad-container.text-center a {
    display: block;
    width: 100%;
}
.container-fluid.ad-container.text-center {
    max-width: 1120px;
    width: 100%;
}
section#content div.container-fluid {
    max-width: 1120px;
}

@media(max-width: 767px){
	.col-lg-4.l-0l {
	    padding-right: 0 !important;
	}
	.col-lg-8.rigt-0 {
	    padding-right: 0 !important;
	}
	.received_withd_msg {
	    width: 100%;
	}
	.sent_msg {
	    width: 100%;
	}
	.right-chat {
	    margin-top: 20px;
	}
}
</style>
<div class="col-md-8 col-xs-12">
	<div class="row row-1">
		<div class="col-lg-12">
			<div class="flex-sec">
				 <h2 class="section-header"><i class="fa fa-comments-o" aria-hidden="true"></i> Chat & Message</h2>
			 	<i class="fa fa-cog" aria-hidden="true"></i>
			</div>
		</div>
	</div>
	<!-- <div class="row row-2">
		<div class="col-lg-12">
			<div class="select-bar">
				<label>Set Status</label>
				<select class="online-select">
					<option>Online</option>
					<option>Online 1</option>
					<option>Online 2</option>
					<option>Online 3</option>
				</select>
			</div>
		</div>
	</div> -->
	<div class="row row-3">
		<div class="main-border">
			<div class="col-lg-4 col-md-4 l-0l">
				<div class="left-chat">
					<div class="search-dix">
						<input type="search" class="search-input" placeholder="Search">
					</div>
					<div class="cusmedia" id="users">
            @if(count($users)>0)
              @foreach($users as $user)
    						<div class="media" id="{{$user->id}}">
    						  <img class="mr-3" src="/assets/storage/profiles/UkMpqJgthq0qXiTehKvtEIkvjNCw1YEsP569uHc0.png">
    						  <div class="media-body" >
    						    <!-- <h5 class="mt-h5"></h5> -->
                    <a href="javascript:void(0);" class="chat-toggle mt-h5" data-id="{{$user->id}}" data-user="{{$user->first_name}} {{ $user->last_name}}">{{$user->first_name}} {{ $user->last_name}}</a>


                    <p class="mt-p">Active Now</p>
    						  </div>
    						</div>
              @endforeach
            @endif
					</div>
				</div>
			</div>

			<div class="col-lg-8 col-md-8 rigt-0">
				
        <div class="right-chat">
					
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

          <div class="top-s">
            <p class="chat-user text-left"> <span class="green-dot"></span> @if(count($users)>0){{$users[0]->first_name}} {{ $user->last_name}}@endif ({{$business->name}})</p>
            <select class="form-controls pull-right text-right">
              <option>Active Now</option>
              <option>Offline</option>
            </select>
          </div>

      <div id="chat_box" class="chat_box" style="display: none">
        <div class="panel panel-default">
            <div class="msg_history chat-area">

            </div>
            <div class="view-file" style="display: none;"><img id="blah" src="#" alt="your image" width="150px" /></div>
            <div class="type_msg">
              <form method="post" enctype="multipart/form-data" id="myattach" class="myattach">
                <div class="input_msg_write form-controls">
                  <input type="text" data-emoji="true" class="write_msg chat_input" placeholder="Type a message">
                    <button class="msg_send_btn btn-chat" data-to-user="" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                      <label class="attachment icon-rotate"><input id="attach" type="file" name="attach" style="display: none;" ><i class="fa fa-paperclip" aria-hidden="true"></i></label>
                </div>
              </form>
            </div>
        </div>
      <input type="hidden" id="to_user_id" value="" />
      </div>

<div id="chat-overlay" class=""></div>

    <audio id="chat-alert-sound" style="display: none">
        <source src="{{ asset('sound/facebook_chat.mp3') }}" />
    </audio>


    <input type="hidden" id="current_user" value="{{ \Auth::user()->id }}" />
    <input type="hidden" id="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}" />
    <input type="hidden" id="pusher_cluster" value="{{ env('PUSHER_APP_CLUSTER') }}" />
          <!--div id="chat_box" class="chat_box mesgs panel-body" style="display: none">
                <div class="msg_history chat-area">

                </div>
            
                <div class="type_msg">
                  <div class="input_msg_write">
                    <input type="text" class="write_msg chat_input" placeholder="Type a message">
                    <button class="msg_send_btn btn-chat" data-to-user="" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                  </div>
                </div>
            <input type="hidden" id="to_user_id" value="" />
        </div-->

          
          <!--div class="mesgs panel-body chat-area">
          <div class="msg_history">

            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>Test which is a new approach to have all
                    solutions</p>
                  <span class="time_date"> 11:01 AM    |    June 9</span></div>
              </div>
            </div>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Test which is a new approach to have all
                  solutions</p>
                <span class="time_date"> 11:01 AM    |    June 9</span> </div>
            </div>
            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>Test, which is a new approach to have</p>
                  <span class="time_date"> 11:01 AM    |    Yesterday</span></div>
              </div>
            </div>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Apollo University, Delhi, India Test</p>
                <span class="time_date"> 11:01 AM    |    Today</span> </div>
            </div>
            <div class="incoming_msg">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>We work directly with our designers and suppliers,
                    and sell direct to you, which means quality, exclusive
                    products, at a price anyone can afford.</p>
                  <span class="time_date"> 11:01 AM    |    Today</span></div>
              </div>
            </div>

          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg chat_input" placeholder="Type a message">
              <button class="msg_send_btn btn-chat" data-to-user="" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
            </div>
          </div>
        </div-->
				</div>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
  setTimeout(function() {
      window.EmojiPicker.init()
  }, 2000)
$(window).load(function() {
  //alert($('#users .chat-toggle:first-child').length);
  //$("a.chat-toggle:first-child").attr("data","12");
  if($('#users a.chat-toggle').length ==1){
    $("#users a.chat-toggle:first-child").click();

  }
}); 
</script>
@include('components/sidebar')

@endsection


