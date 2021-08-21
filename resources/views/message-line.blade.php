@if($message->from_user == \Auth::user()->id)

    <div class="outgoing_msg base_sent" data-message-id="{{ $message->id }}">
            <div class="messages sent_msg text-right">
                <p>{!! $message->content !!}</p>
                <time datetime="{{ date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString())) }}">{{ $message->fromUser->first_name }} {{ $message->fromUser->last_name }} • {{ $message->created_at->diffForHumans() }}</time>
            </div>
        <!--div class="col-md-2 col-xs-2 avatar">
            <img src="{{ url('assets/images/user-avatar.png') }}" width="50" height="50" class="img-responsive">
        </div-->
    </div>

@else

    <div class="incoming_msg base_receive" data-message-id="{{ $message->id }}">
        <div class="incoming_msg_img">
            <img src="{{ url('assets/images/user-avatar.png') }}" >
        </div>
        <div class="received_msg">
            <div class="messages received_withd_msg">
                <p>{!! $message->content !!}</p>
                <time datetime="{{ date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString())) }}">{{ $message->fromUser->first_name }} {{ $message->fromUser->last_name }}  • {{ $message->created_at->diffForHumans() }}</time>
            </div>
        </div>
    </div>

@endif