@extends('app')
@section('content')
    <div class="row">
        <div class="col-md-5">
            @if($users->count() > 0)
                <h3>Pick a user to chat with</h3>
                <ul id="users">
                    @foreach($users as $user)
                        <li><span class="label label-info">{{$user->first_name}} {{ $user->last_name}}</span> <a href="javascript:void(0);" class="chat-toggle" data-id="{{ $user->id }}" data-user="{{$user->first_name}} {{ $user->last_name}}">Open chat</a></li>
                    @endforeach
                </ul>
            @else
                <p>No users found! try to add a new user using another browser by going to <a href="{{ url('register') }}">Register page</a></p>
            @endif
        </div>
    </div>

    @include('chat/chat-box')

    <div id="chat-overlay" class="row"></div>

    <audio id="chat-alert-sound" style="display: none">
        <source src="{{ asset('sound/facebook_chat.mp3') }}" />
    </audio>


    <input type="hidden" id="current_user" value="{{ \Auth::user()->id }}" />
    <input type="hidden" id="pusher_app_key" value="{{ env('PUSHER_APP_KEY') }}" />
    <input type="hidden" id="pusher_cluster" value="{{ env('PUSHER_APP_CLUSTER') }}" />
@endsection
