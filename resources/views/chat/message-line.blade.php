@if(isset($msg))
<div>{!!$msg!!}</div>
@endif
@if($message->from_user == \Auth::user()->id)

    <div class="outgoing_msg base_sent" data-message-id="{{ $message->id }}">
            <div class="messages sent_msg text-right">
                <p class="{{$message->type}}">{!! $message->content !!}</p>
                <time datetime="{{ date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString())) }}">{{ $message->created_at->diffForHumans() }}</time>
            </div>
    </div>

@else

    <div class="incoming_msg base_receive" data-message-id="{{ $message->id }}">
        <!--div class="incoming_msg_img">
            <img src="{{ url('assets/images/user-avatar.png') }}" >
        </div-->
        <div class="received_msg">
            <div class="messages received_withd_msg">
                <p class="{{$message->type}}">{!! $message->content !!}</p>
                <time datetime="{{ date("Y-m-dTH:i", strtotime($message->created_at->toDateTimeString())) }}">{{ $message->created_at->diffForHumans() }}</time>
            </div>
        </div>
    </div>

@endif