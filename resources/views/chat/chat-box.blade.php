    <style type="text/css">
    
p {
    font-size: 13px;
    padding: 5px;
    border-radius: 3px;
}

.base_receive p {
    background: #4bdbe6;
}

.base_sent p {
    background: #e674a8;
}

time {
    font-size: 11px;
    font-style: italic;
}

#login-box {
    margin-top: 20px
}

#chat_box {
    position: fixed;
    top: 10%;
    right: 5%;
    width: 27%;
}

.close-chat {
    margin-top: -17px;
    cursor: pointer;
}

.chat_box {
    margin-right: 25px;
    width: 310px;
}

.chat-area {
    height: 400px;
    overflow-y: scroll;
}

#users li {
    margin-bottom: 5px;
}

#chat-overlay {
    position: fixed;
    right: 0%;
    bottom: 0%;
}

.glyphicon-ok {
    color: #42b7dd;
}

.loader {
    -webkit-animation: spin 1000ms infinite linear;
    animation: spin 1000ms infinite linear;
}
@-webkit-keyframes spin {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(359deg);
        transform: rotate(359deg);
    }
}
</style>

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>


<div id="chat_box" class="chat_box pull-right" style="display: none">
    <div class="row">
        <div class="col-xs-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat with <i class="chat-user"></i> </h3>
                        <span class="glyphicon glyphicon-remove pull-right close-chat"></span>
                    </div>
                    <div class="panel-body chat-area">

                    </div>
                    <div class="panel-footer">
                        <div class="input-group form-controls">
                            <textarea class="form-control input-sm chat_input" placeholder="Write your message here..."></textarea>
                            <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm btn-chat" type="button" data-to-user="" disabled>
                                        <i class="glyphicon glyphicon-send"></i>
                                        Send</button>
                                </span>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <input type="hidden" id="to_user_id" value="" />
</div>