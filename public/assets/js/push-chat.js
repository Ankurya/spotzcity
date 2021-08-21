var base_url = "chat";
$(function () {

    Pusher.logToConsole = true;

    var pusher = new Pusher('014371d78974ba1b9fee', {
        cluster: 'ap2',
        forceTLS: true,
        encrypted: false
    });

    let channel = pusher.subscribe('Spotz-city-1204');

    channel.bind('pusher:subscription_succeeded', function(members) {
        console.log('successfully subscribed!');
    });



    // on click on any chat btn render the chat box
   $(".media").on("click", function (e) {
       e.preventDefault();
       /*if($(".chat-opened").attr('id') != undefined){
        oldid = $(".chat-opened").attr('id');
        //alert(oldid);
       }*/
       
       $(".media").removeClass("active");
       let ele = $(this).find("a.chat-toggle");

       if(ele.hasClass('block-user')) {
        alert('Unable to send message. The user is blocked.');
        return;
       }

       //console.log($(this).find("a"));
       
       let user_id = ele.attr("data-id");
       let user_status = ele.attr("data-user_status");

       let username = ele.attr("data-user");
       let business_name = ele.attr("data-business_name");

       if(business_name != ""){
          var name = "<span class='"+user_status+" green-dot'></span><strong>" + username + "</strong> (" + business_name +")";
       }else{
          var name = "<span class='"+user_status+" green-dot'></span><strong>" + username + "</strong>";
       }
       $(".chat-user").html(name);
       if(user_status=="Online"){
          $(".user_status").html("Active Now");
       }else{
          $(".user_status").html("Offline");
       }
       
       $(this).addClass("active");
       $(".blockuser").attr("data-id",user_id);

       cloneChatBox(user_id, username, function () {

           let chatBox = $("#chat_box_" + user_id);

           if(!chatBox.hasClass("chat-opened")) {

               chatBox.addClass("chat-opened").slideDown("fast");

               loadLatestMessages(chatBox, user_id);

               chatBox.find(".chat-area").animate({scrollTop: chatBox.find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true)}, 800, 'swing');
                if(chatBox.length ==1){
                    //alert($('#chat_box').length +"="+chatBox.length);
                    //$("#chat_box").remove();
                  }
           }
       });
       window.EmojiPicker.init();
   });

   // on close chat close the chat box but don't remove it from the dom
   $(".close-chat").on("click", function (e) {

       $(this).parents("div.chat-opened").removeClass("chat-opened").slideUp("fast");
   });


   // on change chat input text toggle the chat btn disabled state
    $(".chat_input").on("change keyup", function (e) {
       if($(this).val() != "" || $("#attach")[0].files[0] != undefined) {
           //$(this).parents(".form-controls").find(".btn-chat").prop("disabled", false);
       } else {
           //$(this).parents(".form-controls").find(".btn-chat").prop("disabled", true);
       }
    });

    $("#attach").change(function() {
      readURL(this);
    });

    function readURL(input) {
      
      if (input.files && input.files[0]) {
        //$(".btn-chat").prop("disabled", false);

        var reader = new FileReader();
        reader.onload = function(e) {
          $('.chat-opened #blah').attr('src', e.target.result);
          $('.chat-opened .view-file').show();
        }
        reader.readAsDataURL(input.files[0]); // convert to base64 string
        
      }
    }



    $("#myattach").on("submit", function (e) {
      e.preventDefault();
      
      send($(this).find(".msg_send_btn").attr('data-to-user'), $("#chat_box_" + $(this).find(".msg_send_btn").attr('data-to-user')).find(".chat_input").val());
      //$(".btn-chat").click();
    });


    // on click the btn send the message
   $(".btn-chat").on("click", function (e) {
   	
       send($(this).attr('data-to-user'), $("#chat_box_" + $(this).attr('data-to-user')).find(".chat_input").val());
   });

   // listen for the send event, this event will be triggered on click the send btn




    channel.bind('send', function(data) {
        displayMessage(data.data);
    });


    // handle the scroll top of any chat box
    // the idea is to load the last messages by date depending of last message
    // that's already loaded on the chat box
    let lastScrollTop = 0;

   /*$(".chat-area").on("scroll", function (e) {
       let st = $(this).scrollTop();
       console.log(st,lastScrollTop);
       if(st < lastScrollTop) {
        //if(st < 2) {
          //fetchOldMessages($(this).parents(".chat-opened").find("#to_user_id").val(), $(this).find(".msg_container:first-child").attr("data-message-id"));
       }

       lastScrollTop = st;
   });*/

    // listen for the oldMsgs event, this event will be triggered on scroll top




    channel.bind('oldMsgs', function(data) {
        displayOldMessages(data);
    });
});

/**
 * loaderHtml
 *
 * @returns {string}
 */
function loaderHtml() {
    return '<i class="glyphicon glyphicon-refresh loader"></i>';
}

function cloneHTML(){
  return $('<div id="chat_box" class="chat_box" style="display: none">\
        <div class="panel panel-default">\
            <div class="msg_history chat-area">\
            </div>\
            <div class="view-file" style="display: none;"><img id="blah" src="#" alt="your image" width="150px" /></div>\
            <div class="type_msg">\
              <form method="post" enctype="multipart/form-data" id="myattach" class="myattach">\
                <div class="input_msg_write form-controls">\
                  <input type="text" data-emoji="true" class="write_msg chat_input" placeholder="Type a message">\
                    <button class="msg_send_btn btn-chat" data-to-user="" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>\
                      <label class="attachment icon-rotate"><input id="attach" type="file" name="attach" style="display: none;" ><i class="fa fa-paperclip" aria-hidden="true"></i></label>\
                </div>\
              </form>\
            </div>\
        </div>\
      <input type="hidden" id="to_user_id" value="" />\
      </div>');
}

function cloneChatBox(user_id, username, callback)
{
    if($("#chat_box_" + user_id).length == 0) {

        let cloned = $("#chat_box").clone(true);
        
        // change cloned box id
        cloned.attr("id", "chat_box_" + user_id);
        //console.log(username);
        //cloned.find(".chat-user").text(username);

        cloned.find(".btn-chat").attr("data-to-user", user_id);

        cloned.find("#to_user_id").val(user_id);
        if($(".emojis")[0]){
        //cloned.find(".input_msg_write").prepend('<input type="text" data-emoji="true" class="write_msg chat_input" placeholder="Type a message" style="width: 100%;">');
        cloned.find(".emoji-section").remove();
        }
        $("#chat-overlay").html(cloned);
        
    }

    callback();
}

/**
 * loadLatestMessages
 *
 * this function called on load to fetch the latest messages
 *
 * @param container
 * @param user_id
 */
function loadLatestMessages(container, user_id)
{
    let chat_area = container.find(".chat-area");

    chat_area.html("");

    $.ajax({
        url: "/load-latest-messages",
        data: {user_id: user_id, _token: $("meta[name='csrf-token']").attr("content")},
        method: "GET",
        dataType: "json",
        beforeSend: function () {
            if(chat_area.find(".loader").length  == 0) {
                chat_area.html(loaderHtml());
            }
        },
        success: function (response) {
            if(response.state == 1) {
                response.messages.map(function (val, index) {
                    $(val).appendTo(chat_area);
                });
            }
        },
        complete: function () {
            chat_area.find(".loader").remove();
            $(".filterable #"+user_id).find(".unread").hide();
            $(".filterable #"+user_id).find(".time").show();
            let st = chat_area.prop("scrollHeight");
            chat_area.animate({scrollTop:  st});
            //chat_area.animate({scrollTop: chat_area.offset().top + chat_area.outerHeight(true)}, 800, 'swing');
            
        }
    });
}





function changeUserStatus(current_user_id,value){
    $.ajax({
        url: "/changeUserStatus",
        data: {current_user_id:current_user_id, status:value},
        method: "POST",
        dataType: "json",
        beforeSend: function () {
        },
        success: function (response) {
        
        },
        complete: function () {
          if(value == "Online"){
            $(".flashmsg").text("Your profile is visible!");
          }else{
            $(".flashmsg").text("Your profile is invisible!");
          }
        }
    });
}

function sendReport(){

  let blocker_id = $(".blockuser").attr("data-id");
  let status = "Report";
  let message = $(".reportbox").val();
  if(message == ""){
    alert("Message field is required!");
    return false;
  }
  $(".report-btn").attr("disabled",1);
  
  $.ajax({
        url: "/blockuser",
        data: {blocker_id:blocker_id, status:status,message:message},
        method: "POST",
        dataType: "json",
        beforeSend: function () {
        },
        success: function (response) {
        
        },
        complete: function () {
            $(".reportbox").val("");
            $(".report-btn").removeAttr("disabled");
            $('#myModal').hide();
            //alert("Thank you for your feedback!");
        }
    });
  
}

function blockuser(value){
    if(value==""){
      return false;
    }
    if(value=="Block"){
      if (confirm('Are you sure you want to Block this user ?')) {
        
      
      } else {
        //$('.blockuser option:eq(0)').prop('selected', true);
        return false;
      }
    }
    let blocker_id = $(".blockuser").attr("data-id");
    if(value=="Report"){
      $('#myModal').show();
      return false;
    }
    $.ajax({
        url: "/blockuser",
        data: {blocker_id:blocker_id, status:value},
        method: "POST",
        dataType: "json",
        beforeSend: function () {
        },
        success: function (response) {
        
        },
        complete: function () {
          if(value=="Block"){
            window.location.href = "/chat";
          }
        }
    });
}

/**
 * send
 *
 * this function is the main function of chat as it send the message
 *
 * @param to_user
 * @param message
 */
function send(to_user, message)
{
    let chat_box = $("#chat_box_" + to_user);
    let chat_area = chat_box.find(".chat-area");
    
    if(typeof $(".chat-opened #attach")[0].files[0] != undefined){
      var datas = new FormData();
      datas.append('to_user', to_user);
      datas.append('message', message);
      datas.append('_token', $("meta[name='csrf-token']").attr("content"));
      datas.append('attach', $(".chat-opened #attach")[0].files[0]);
      

      $.ajax({
          url: "/send",
          data: datas,
          method: "POST",
          enctype: 'multipart/form-data',
          processData: false,  // tell jQuery not to process the data
          contentType: false,   // tell jQuery not to set contentType
          dataType: "json",
          beforeSend: function () {
              if(chat_area.find(".loader").length  == 0) {
                  chat_area.append(loaderHtml());
              }
          },
          success: function (response) {
          },
          complete: function () {
              chat_area.find(".loader").remove();
              //chat_box.find(".btn-chat").prop("disabled", true);
              chat_box.find(".chat_input").val("");
              chat_box.find("#attach").val("");
              $('.chat-opened .view-file').hide();
              $('.chat-opened #blah').attr('src', "#");
              	
              	let st = chat_area.prop("scrollHeight");
        		chat_area.animate({scrollTop:  st});
              /*console.log(chat_area.offset());
              	if(typeof chat_area.offset() != undefined){
              		console.log("if",chat_area.offset());
              		chat_area.animate({scrollTop: chat_area.offset().top + chat_area.outerHeight(true)}, 800, 'swing');
      			}*/
          }
      });
    
    }else{

      $.ajax({
          url: "/send",
          data: {to_user: to_user, message: message, _token: $("meta[name='csrf-token']").attr("content")},
          method: "POST",
          dataType: "json",
          beforeSend: function () {
              if(chat_area.find(".loader").length  == 0) {
                  chat_area.append(loaderHtml());
              }
          },
          success: function (response) {
          },
          complete: function () {
              chat_area.find(".loader").remove();
              //chat_box.find(".btn-chat").prop("disabled", true);
              chat_box.find(".chat_input").val("");
              chat_area.animate({scrollTop: chat_area.offset().top + chat_area.outerHeight(true)}, 800, 'swing');
          }
      });
    }
}

/**
 * fetchOldMessages
 *
 * this function load the old messages if scroll up triggerd
 *
 * @param to_user
 * @param old_message_id
 */
function fetchOldMessages(to_user, old_message_id)
{
    let chat_box = $("#chat_box_" + to_user);
    let chat_area = chat_box.find(".chat-area");

    $.ajax({
        url: "/fetch-old-messages",
        data: {to_user: to_user, old_message_id: old_message_id, _token: $("meta[name='csrf-token']").attr("content")},
        method: "GET",
        dataType: "json",
        beforeSend: function () {
            if(chat_area.find(".loader").length  == 0) {
                chat_area.prepend(loaderHtml());
            }
        },
        success: function (response) {
        },
        complete: function () {
            chat_area.find(".loader").remove();
        }
    });
}

/**
 * getMessageSenderHtml
 *
 * this is the message template for the sender
 *
 * @param message
 * @returns {string}
 */
function getMessageSenderHtml(message)
{
  

    return `
           <div class="outgoing_msg base_sent" data-message-id="${message.id}">
            <div class="messages sent_msg text-right">
                <p class="${message.type}">${message.content}</p>
                <time datetime="${message.dateTimeStr}">${message.dateHumanReadable} </time>
            </div>
    </div>
    `;
}

/**
 * getMessageReceiverHtml
 *
 * this is the message template for the receiver
 *
 * @param message
 * @returns {string}
 */
function getMessageReceiverHtml(message)
{
  
  $(".filterable #"+message.from_user).find(".unread").show();
	$(".filterable #"+message.from_user).find(".time").hide();
    return `
           <div class="incoming_msg base_receive" data-message-id="${message.id}">
           <!--div class="incoming_msg_img">
             <img src="` + base_url +  '/assets/images/user-avatar.png' + `">
           </div-->
        <div class="received_msg">
            <div class="messages received_withd_msg text-left">
                <p class="${message.type}">${message.content}</p>
                <time datetime="${message.dateTimeStr}">${message.dateHumanReadable} </time>
            </div>
        </div>
    </div>
    `;
}

/**
 * This function called by the send event triggered from pusher to display the message
 *
 * @param message
 */
function displayMessage(message)
{
    let alert_sound = document.getElementById("chat-alert-sound");
    
    if($("#current_user").val() == message.from_user_id) {

        let messageLine = getMessageSenderHtml(message);
        
        $("#chat_box_" + message.to_user_id).find(".chat-area").append(messageLine);

    } else if($("#current_user").val() == message.to_user_id) {
    	let chatBox = $("#chat_box_" + message.from_user_id);
        //alert_sound.play();
        if(!chatBox.hasClass("chat-opened")) {
        	$(".filterable #"+message.from_user).find(".unread").show();
			$(".filterable #"+message.from_user).find(".time").hide();
        }else{
        	
        	let messageLine = getMessageReceiverHtml(message);
			$("#chat_box_" + message.from_user_id).find(".chat-area").append(messageLine);
			let st = chatBox.find('.chat-area').prop("scrollHeight");
            chatBox.find('.chat-area').animate({scrollTop:  st});
            
            $(".filterable #"+message.from_user).find(".unread").hide();
			$(".filterable #"+message.from_user).find(".time").show();
			//loadLatestMessages(chatBox, message.from_user_id);
        }
        
        // for the receiver user check if the chat box is already opened otherwise open it
        /*cloneChatBox(message.from_user_id, message.fromUserName, function () {

            let chatBox = $("#chat_box_" + message.from_user_id);
            console.log("1",message.from_user_id);
            if(!chatBox.hasClass("chat-opened")) {

                chatBox.addClass("chat-opened").slideDown("fast");

                loadLatestMessages(chatBox, message.from_user_id);

                chatBox.find(".chat-area").animate({scrollTop: chatBox.find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true)}, 800, 'swing');
                console.log("2");
            } else {
              console.log("3");
                let messageLine = getMessageReceiverHtml(message);

                // append the message for the receiver user
                $("#chat_box_" + message.from_user_id).find(".chat-area").append(messageLine);
                chatBox.find(".chat-area").animate({scrollTop: chatBox.find(".chat-area").offset().top + chatBox.find(".chat-area").outerHeight(true)}, 800, 'swing');
            }
        });*/
    }
}

function displayOldMessages(data)
{
    if(data.data.length > 0) {

        data.data.map(function (val, index) {
            $("#chat_box_" + data.to_user).find(".chat-area").prepend(val);
        });
    }
}