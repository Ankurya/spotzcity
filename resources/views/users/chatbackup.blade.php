@extends('app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.flex-sec i.fa.fa-cog {color: #3a89b7;font-size: 25px;}
.flex-sec {display: flex;justify-content: space-between;}
.online-select {width: 100%;max-width: 220px;height: 40px;padding: 0 10px;font-size: 14px;}
.select-bar label {font-size: 16px;font-weight: bold;color: gray;margin-top: 15px;}
.mr-3 {width: 50px;height: 49px;border-radius: 50px;object-fit: cover;background-position: center;margin-right: 10px;}
.left-chat .media {display: -webkit-box;display: -ms-flexbox;display: flex;-webkit-box-align: start;-ms-flex-align: start;align-items: flex-start;align-items: center;padding: 10px;border-radius: 20px;}
.left-chat .media:hover{background: #e6e6e6;}
.mt-h5 {margin: 0;font-size: 20px;font-weight: bold;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;}
.mt-p {margin: 0;font-size: 14px;}
.search-input {height: 30px;border-radius: 7px;border: 1px solid gray;margin: 15px 0;padding: 0 10px;}
.main-border {border: 1px solid gray;padding: 15px;display: block;float: left;width: 99%;margin-top: 10px;border-radius: 15px;}
.row.row-3 {padding-left: 15px;padding-right: 15px;}
.top-s {
    display: flex;
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
    border-radius: 3px;
    color: #ffffff;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
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
    padding-right: 15px;
}
 .sent_msg p {
  background: #3a89b7;
  border-radius: 3px;
  font-size: 14px;
  margin: 0; color:#fff;
  padding: 5px 10px 5px 12px;
  width:100%;
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
  min-height: 48px;
  width: 100%;
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
  right: 0;
  top: 11px;
  width: 33px;
}
.messaging { padding: 0 0 50px 0;}
.msg_history {
  height: 516px;
  overflow-y: auto;
}
.rigt-0{padding-right: 0;}
</style>
<div class="col-md-8 col-xs-12">
	<div class="row row-1">
		<div class="col-lg-12">
			<div class="flex-sec">
				 <h2 class="section-header"><i class="fa fa-comments-o" aria-hidden="true"></i> Chat & Message</h2>

          <input type="hidden" id="current_user" value="{{ \Auth::user()->id }}" />
          <input type="hidden" id="pusher_app_key" value="fbe429aabde8434fa8bd" />
          <input type="hidden" id="pusher_cluster" value="ap2" />



			 	<i class="fa fa-cog" aria-hidden="true"></i>
			</div>
		</div>
	</div>
	<div class="row row-2">
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
	</div>
	<div class="row row-3">
		<div class="main-border">
			<div class="col-lg-4">
				<div class="left-chat">
					<div class="search-dix">
						<input type="search" class="search-input">
					</div>
					<div class="cusmedia">
            @if(!empty($users))
              @foreach($users as $user)
    						<div class="media">
    						  <img class="mr-3" src="/assets/storage/profiles/UkMpqJgthq0qXiTehKvtEIkvjNCw1YEsP569uHc0.png">
    						  <div class="media-body">
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
			<div class="col-lg-8 rigt-0">
				
        <div class="right-chat">
					<div class="top-s">
						<p class="chat-user">John Doe (The Barbeque Company, Steel Works)</p>
						<select>
							<option>Active Now</option>
							<option>Offline</option>
						</select>
					</div>
					

          <div id="chat_box" class="chat_box mesgs panel-body" style="display: none">
                <!--div class="panel-heading">
                    <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat with <i class="chat-user"></i> </h3>
                    <span class="glyphicon glyphicon-remove pull-right close-chat"></span>
                </div-->
                <div class="msg_history chat-area">

                </div>
                
                <div class="type_msg">
                  <div class="input_msg_write">
                    <input type="text" class="write_msg chat_input" placeholder="Type a message">
                    <button class="msg_send_btn btn-chat" data-to-user="" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                  </div>
                </div>
                <!--div class="panel-footer">
                    <div class="input-group form-controls">
                        <textarea class="form-control input-sm chat_input" placeholder="Write your message here..."></textarea>
                        <span class="input-group-btn">
                                <button class="btn btn-primary btn-sm btn-chat" type="button" data-to-user="" disabled>
                                    <i class="glyphicon glyphicon-send"></i>
                                    Send</button>
                            </span>
                    </div>
                </div-->
            <input type="hidden" id="to_user_id" value="" />
        </div>

          <div id="chat-overlay" class="row"></div>
          <audio id="chat-alert-sound" style="display: none">
              <source src="{{ asset('sound/facebook_chat.mp3') }}" />
          </audio>
          
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
@include('components/sidebar')

@endsection


