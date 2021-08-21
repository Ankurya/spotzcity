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
    padding: 0px 0px;
    font-size: 12px;
    color: #636b6f;
    background: url(assets/arroe_black.png);
    appearance: none;
    -moz-appearance: none;
    -webkit-appearance: none;
    background-size: 12px;
    background-repeat: no-repeat;
    background-position: right;
    padding-right: 20px;
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
    background: #d0d0d0;
    border: 0px none #ffffff;
    border-radius: 0px;
}
::-webkit-scrollbar-thumb:hover {
    background: #d0d0d0;
}
::-webkit-scrollbar-thumb:active {
    background: #d0d0d0;
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
.extra-chat select.form-controls.pull-right.text-right {
    float: left !important;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 0 10px;
    width: 100%;
    background-position: 150px 7px;
    max-width: 170px;
    height: 25px;
}

.col-lg-4.col-md-4.l-0l.br-right {
    border-right: none;
}

.left-chat.extra-chat label {
    margin-top: 15px;
}
span.Offline.green-dot {
    background: gray;
}
.flashmsg{
  color: green;
}
.icon-right-fa i.fa.fa-arrow-right {
    color: #3a89b7;
    font-size: 25px;
    margin-right: 10px;
}
.icon-right-fa i.fa.fa-chevron-left {
    font-size: 22px;
    line-height: 20px;
    margin-right: 10px;
}

.flex-dropdown {
    display: flex;
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
ul.drop-content-under {
    margin: 0;
    padding: 0;
    list-style: none;
}
ul.drop-content-under li p {
    margin: 0;
    padding: 0;
    color: #3a89b7;
    line-height: 23px;
    cursor: pointer;
}
.full-drop button {
    background: transparent;
    border: none;
    padding: 0;
    height: auto;
}
.full-drop {
    position: relative;
}
img.drop-image {
    max-width: 13px;
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


</style>
<div class="col-md-8 col-xs-12">
	<div class="row row-1">
		<div class="col-lg-12">
			<div class="flex-sec">
				 <h2 class="section-header"><i class="fa fa-comments-o" aria-hidden="true"></i> Chats Settings</h2>
			 <div class="icon-right-fa">
        <a href="/chat"><i class="fa fa-chevron-left"></i></a>
        <i class="fa fa-cog" aria-hidden="true"></i>   
       </div>
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
		<div class="">
			<div class="col-lg-4 col-md-4 l-0l br-right">
				<div class="left-chat extra-chat">
          <label>Set Status</label>
					<select class="form-controls pull-right text-right" onchange="changeUserStatus(<?php echo $current_user_Id ?>,this.value);">
              <option value="" selected="" disabled="">Select</option>
              <option value="Online" @if(\Auth::user()->user_status=="Online") selected=1 @endif >Active</option>
              <option value="Offline" @if(\Auth::user()->user_status=="Offline") selected=1 @endif >Offline</option>
            </select>
				</div>
        <span class="flashmsg"></span>

        <!--div class="flex-dropdown">
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
            </div-->

			</div>

      <div class="col-lg-12 col-md-12" style="padding: 0;">
     
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Block Status</th>
            </tr>
          </thead>
          <tbody>
            @if(count($users)>0)
            @foreach($users as $value)
            <tr>
              <td><a href="javascript:;">{{$value->display_name}}</a></td>
              <td>{{$value->email}}</td>
              <td><button class="btn btn-primary" onclick="unblock({{$value->block_user_id}});" type="button">Unblock</button></td>
            </tr>
            @endforeach
            @endif
          </tbody>

        </table>
      </div>
			
		</div>
	</div>
</div>


<script type="text/javascript">
function unblock(block_user_id){
  if (confirm("Are you sure you want to Un-Block this user ?")) {
        window.location.href = "/unblock/"+block_user_id;
    } else {
        
    }
}

function opendrop(){
  $(".drop-open").toggle(); 
}

</script>
@include('components/sidebar')

@endsection


