@extends('app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.flex-sec i.fa.fa-cog {color: #3a89b7;font-size: 25px;}
.flex-sec {display: flex;justify-content: space-between;}
.online-select {width: 100%;max-width: 220px;height: 40px;padding: 0 10px;font-size: 14px;}
.select-bar label {font-size: 16px;font-weight: bold;color: gray;margin-top: 15px;}
.mr-3 {width: 42px;height: 42px;border-radius: 50px;object-fit: cover;background-position: center;margin-right: 10px;}
.left-chat .media {margin-bottom: 5px;display: -webkit-box;display: -ms-flexbox;-webkit-box-align: start;-ms-flex-align: start;align-items: flex-start;align-items: center;padding: 10px;border-radius: 7px;}
.left-chat .media:hover,.left-chat .media.active{background: #f5f5f5;}
.mt-h5 {
      margin: 0;
    font-size: 14px;
    font-weight: bold;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: block;
    color: gray !important;
    margin-top: 4px;
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
        width: fit-content;
}
.time_date {
  color: #747474;
  display: block;
  font-size: 12px;
  margin: 8px 0 0;
}
.received_withd_msg { width: auto;}
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
    width: fit-content;
    float: right;
    display: block;
}
.outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
.sent_msg {
  float: right;
  width: auto;
}
.input_msg_write input {
  border: 1px solid #ccc;
    color: #4c4c4c;
    font-size: 15px;
    min-height: 37px;
    width: 83% !important;
    margin-top: 20px;
    border-radius: 10px;
    margin-left: 10px;
}

.type_msg {border-top: 0px solid #c4c4c4;position: relative;}
.msg_send_btn {
     border: medium none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 17px;
    height: 33px;
    position: absolute;
    right: 30px;
    top: 20px;
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
    padding-right: 35px;
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
    right: -7px;
    top: -1px;
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
    border-right: 1px solid #d0d0d0;
}
.msg_history.chat-area {padding: 0 15px;}
.messages.sent_msg.text-right time {
  font-size: 10px;
    color: gray;
    position: relative;
    bottom: 0px;
    display: block;
    width: 100%;
    float: right;
}
.col-lg-8.rigt-0 {padding-right: 0 !important;}
div#chat-overlay .panel.panel-default {margin-bottom: 0;}
select.form-controls.pull-right.text-right {
  border: none;
    border-radius: 28px;
    padding: 6px;
    font-size: 12px;
    color: #ccc;
    background: url(assets/arroe.png);
    appearance: none;
    -moz-appearance: none;
    -webkit-appearance: none;
    background-size: 12px;
    background-repeat: no-repeat;
    background-position: right;
    padding-right: 20px;
}



.left-chat::-webkit-scrollbar,
.msg_history::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}
.left-chat::-webkit-scrollbar-button,
.msg_history::-webkit-scrollbar-button {
    width: 5px;
    height: 5px;
}
.left-chat::-webkit-scrollbar-thumb,
.msg_history::-webkit-scrollbar-thumb {
    background: #d0d0d0;
    border: 0px none #ffffff;
    border-radius: 0px;
}
.left-chat::-webkit-scrollbar-thumb:hover,
.msg_history::-webkit-scrollbar-thumb:hover {
    background: #d0d0d0;
}
.left-chat::-webkit-scrollbar-thumb:active,
.msg_history::-webkit-scrollbar-thumb:active {
    background: #d0d0d0;
}
.left-chat::-webkit-scrollbar-track,
.msg_history::-webkit-scrollbar-track {
    background: transparent;
    border: 0px none #ffffff;
    border-radius: 50px;
}
.left-chat::-webkit-scrollbar-track:hover,
.msg_history::-webkit-scrollbar-track:hover {
    background: transparent;
}
.left-chat::-webkit-scrollbar-track:active,
.msg_history::-webkit-scrollbar-track:active {
    background: transparent;
}
.left-chat::-webkit-scrollbar-corner,
.msg_history::-webkit-scrollbar-corner {
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
   cursor: pointer;
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
/*ul.nav.side-nav li a {
    font-weight: 600;
}*/
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
    border: 0px solid #d0d0d0;
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
.cusmedia table tr td {
    border: none !important;
    padding: 0 !important;
}
.left-chat {
    padding-right: 5px;
}
.panel.panel-default {
    box-shadow: none !important;
}
input.write_msg.chat_input::-webkit-input-placeholder { text-align:right; }
input.write_msg.chat_input:-moz-placeholder { text-align:right; }
p.test-pera {
    display: flex;
    justify-content: space-between;
}

p.test-pera span {
    font-size: 10px;
    /* width: 160px; */
    text-align: center;
    color: #ccc;
    margin: 0 5px;
}

p.test-pera span:nth-child(1),p.test-pera span:nth-child(3) {
    height: 1px;
    background: #ccc;
    width: 100%;
    position: relative;
    top: 7px;
}
p.image {
    background: transparent;
    padding-right: 0;
}
.navbar-default .navbar-nav>li>a, .navbar-default .navbar-text {
    font-size: 12px !important;
}



@media(max-width: 991px){
ul.nav.side-nav {
    margin-top: 15px;
}
.col-lg-4.l-0l {
    border-right: 0px solid #ccc;
}
.input_msg_write input {
    width: 89% !important;
}
.right-chat {
    margin-top: 30px;
}
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
  .input_msg_write input {
    width: 80% !important;
    margin-left: 0px;
}
}


@media(max-width: 370px){
.input_msg_write input {
    width: 75% !important;
}
}

span.Offline.green-dot {
    background: gray;
}

	/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

.main-modal {
background: white;
    padding: 20px 20px 20px 20px;
    border-radius: 10px;
    max-width: 800px;
    margin: auto;
    position: absolute;
    left: 0;
    right: 0;
    margin: auto;
    top: 50%;
    -webkit-transform: translateY(-50%);
    -moz-transform: translateY(-50%);
    -ms-transform: translateY(-50%);
    -o-transform: translateY(-50%);
    transform: translateY(-50%);
}
h5.rep-h5 {
font-size: 20px;
font-weight: 400;
color: #847d7d;
border-bottom: 1px solid #80808030;
padding: 0px 0px 12px 0px;
margin: 0px 0px 0px 0px;
}
p.plea-p {
font-size: 16px;
color: #847d7d;
padding: 10px 0px 10px 0px;
margin: 0px 0px 0px 0px;
font-weight: 400;
}
textarea.texrta-st {
width: 100%;
border: 1px solid #80808030;
height: 200px;
border-radius: 10px;
resize: none;
padding: 15px;
margin: 20px 0;
}
textarea.texrta-st:focus {
outline: none;
box-shadow: none;
}
button.Can-btn {
background: transparent;
font-weight: 600;
font-size: 18px;
height: 47px;
padding: 0 20px;
border: none;
color: #3a89b7;
}
button.sub-btn {
background: #3a89b7;
font-weight: 600;
font-size: 18px;
height: 47px;
padding: 0 20px;
border: none;
color: white;
border-radius: 10px;
}
.main-button {
float: right;
}
.clear-float{
clear: both;
}
tr.blocked-cntcts {
    font-size: 14px;
    font-weight: 600;
    color: red;
    text-align: center;
    border-top: 1px solid #ccc;
    text-align: left;
}
.blocked-cntcts td {
    padding-top: 5px !important;
}
img.drop-image {
    max-width: 13px;
}

.full-drop button {
    background: transparent;
    border: none;
    padding: 0;
    height: auto;
}

ul.drop-content-under {
    margin: 0;
    padding: 0;
    list-style: none;
}

.drop-open {
    position: absolute;
    right: 0;
    top: 45px;
    max-width: 180px;
    border: 1px solid #d0d0d0;
    padding: 10px 15px;
    width: 180px;
    background: #fff;
    z-index: 99;
}

.full-drop {
    position: relative;
}

ul.drop-content-under li p {
    margin: 0;
    padding: 0;
    color: #3a89b7;
    line-height: 23px;
    cursor: pointer;
}

span.text-right.user_status {
    font-size: 12px;
    color: #d0d0d0;
    line-height: 25px;
    margin-right: 10px;
}
.top-s {
    border-bottom: 1px solid #d0d0d0;
    padding-bottom: 5px;
}
.flex-dropdown {
    display: flex;
}
div.sidebar ul.nav.side-nav {
    font-size: 14px;
}
section#banner-ad img.ad {
    max-width: 1000px;
}




</style>



<div class="col-md-8 col-xs-12">
	<div class="row row-1">
		<div class="col-lg-12">
			<div class="flex-sec">
				 <h2 class="section-header"><i class="fa fa-comments-o" aria-hidden="true"></i> Chat & Message</h2>
			 	<a href="/chat-setting"><i class="fa fa-cog" aria-hidden="true"></i></a>
			</div>
		</div>
	</div>
	<!--div class="row row-2">
		<div class="col-lg-12">
			<div class="select-bar">
				<label>Set Status 234234</label>
				<select class="online-select">
					<option>Online</option>
					<option>Online 1</option>
					<option>Online 2</option>
					<option>Online 3</option>
				</select>
			</div>
		</div>
	</div-->
	<div class="row row-3">
		<div class="main-border">
			<div class="col-lg-4 col-md-4 l-0l">
				<div class="left-chat">
					<div class="search-dix">
						<input type="search" placeholder="Search..." class="search-input" id="FilterTextBox" name="FilterTextBox">
					</div>
          <div class="cusmedia">
  					<table class="table filterable" id="users">
              @if(count($users)>0)
                @foreach($users as $user)
                @if(!in_array($user->id, $block_lists))
                <tr>
                  <td style="display: none;">{{$user->first_name}}</td>
      						<td><div class="media" id="{{$user->id}}">
      						  <img class="mr-3" src="@if($user->picture!=''){{ asset('assets/storage/'.$user->picture) }} @else {{ asset('assets/user-icon.png') }} @endif">
      						  <div class="media-body" >
                      <a href="javascript:void(0);" class="chat-toggle mt-h5" data-id="{{$user->id}}" data-user="{{$user->first_name}} {{ $user->last_name}}" data-business="{{$user->has_business}}" data-user_status="{{$user->user_status}}" data-business_name="{{$user->business_name}}"> @if($user->has_business==1){{str_limit($user->first_name.' '.$user->last_name.' ('.$user->business_name.')',15)}}@else {{$user->first_name.' '.$user->last_name}} @endif</a>
                      <p class="unread mt-p" @if(!in_array($user->id, $unread_id)) style="display: none;" @endif ><strong style="color:#3a89b7">New Message</strong></p>

                      <p class="time mt-p" @if(in_array($user->id, $unread_id)) style="display: none;" @endif > @if($user->user_status=="Online")Active Now @else Last Seen {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }} @endif</p>
      						  </div>
      						</div></td>
                  </tr>
                @endif
                @endforeach
              @endif

              @if(count($block_lists)>0)
                <tr class="blocked-cntcts"><td>Blocked Contacts</td></tr>
                <?php  $n = 0; ?>
                @foreach($users as $user)
                @if(in_array($user->id, $block_lists))
                <tr>
                  <td style="display: none;">{{$user->first_name}}</td>
                  <td><div class="media" id="{{$user->id}}">
                    <img class="mr-3" src="@if($user->picture!=''){{ asset('assets/storage/'.$user->picture) }} @else {{ asset('assets/user-icon.png') }} @endif">
                    <div class="media-body" >
                      <a href="javascript:void(0);" class="chat-toggle mt-h5 block-user" data-id="{{$user->id}}" data-user="{{$user->first_name}} {{ $user->last_name}}" data-business="{{$user->has_business}}" data-user_status="{{$user->user_status}}" data-business_name="{{$user->business_name}}">@if($user->has_business==1){{str_limit($user->first_name.' '.$user->last_name.' ('.$user->business_name.')',15)}}@else {{$user->first_name.' '.$user->last_name}} @endif</a>
                      <p class="mt-p">@if($user->user_status=="Online")Active Now @else Last Seen {{ \Carbon\Carbon::parse($user->last_seen)->diffForHumans() }} @endif</p>
                    </div>
                  </div></td>
                </tr>
                @endif
                <?php $n++; ?>
                @endforeach
              @endif


  					</table>
          </div>
				</div>
			</div>

			<div class="col-lg-8 col-md-8 rigt-0">
				
        <div class="right-chat">
					
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

          <div class="top-s">
            <p class="chat-user text-left"></p>
            <div class="flex-dropdown">
              <span class="text-right user_status"></span>
            <div class="full-drop">
              <button onclick="opendrop()"><img class="drop-image" src="/assets/arroe.png"></button>
              <div class="drop-open" style="display: none;">
                <ul class="drop-content-under blockuser" data-id="">
                  <li onclick="blockuser('Block');">
                    <p>Block User</p>
                  </li>
                  <li onclick="blockuser('Report');">
                    <p>Report User</p>
                  </li>
                </ul>
              </div>
            </div>
            </div>
            <!--select class="form-controls pull-right text-right blockuser" data-id="" onchange="blockuser(this.value);">
              <option value="" selected="">Select</option>
              <option value="Block">Block User</option>
              <option value="Report">Report User</option>
            </select-->
          </div>
        

          	<!-- The Modal -->
			<div id="myModal" class="modal">
				<div class="main-modal">
					<div class="main-text">
					<h5 class="rep-h5">Report User</h5>
					<p class="plea-p">Please describe why you're reporting this user</p>
					</div>
					<div class="main-textra">
					<textarea class="texrta-st reportbox" name="mesage" ></textarea>
					</div>
					<div class="main-button">
					<button class="Can-btn close-btn">Cancel</button>
					<button class="sub-btn report-btn" onclick="sendReport();">Submit</button>

					</div>
					<div class="clear-float"></div>
				</div>
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

      <div id="chat-overlay" class="row"></div>

    <audio id="chat-alert-sound" style="display: none">
        <source src="{{ asset('sound/facebook_chat.mp3') }}" />
    </audio>

				</div>

			</div>
		</div>
	</div>
</div>

<input type="hidden" id="current_user" value="{{ \Auth::user()->id }}" />
<input type="hidden" id="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}" />
<input type="hidden" id="pusher_cluster" value="{{ env('PUSHER_APP_CLUSTER') }}" />

<script type="text/javascript">
	// Get the modal
var modal = document.getElementById("myModal");
// Get the button that opens the modal
//var btn = document.getElementById("myBtn");
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close-btn")[0];
// When the user clicks on the button, open the modal
/*btn.onclick = function() {
  modal.style.display = "block";
}*/
// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

<script type="text/javascript">

  setTimeout(function() {
      $(".media:eq(0)").click();
  }, 2000)

$(document).ready(function() {

  /*if($('#users a.chat-toggle').length ==1){
    $("#users a.chat-toggle:first-child").click();

  }*/
}); 

 $(document).ready(function () { 
        //add index column with all content. 
        $(".filterable tr:has(td)").each(function () { 
            var t = $(this).text().toLowerCase(); //all row text 
            $("<td class='indexColumn'></td>").hide().text(t).appendTo(this); 
        }); //each tr 
        $("#FilterTextBox").keyup(function () { 
            var s = $(this).val().toLowerCase().split(" "); 
          
            $(".filterable tr:hidden").show(); 
            $.each(s, function () { 
                $(".filterable tr:visible .indexColumn:not(:contains('"+ this + "'))").parent().hide(); 
            }); //each 
        }); //key up. 
    }); //document.ready 


function opendrop(){
  $(".drop-open").toggle(); 
}

function dropdown(){
   $("#testid").toggle(); 
}


</script>



@include('components/sidebar')


@endsection


