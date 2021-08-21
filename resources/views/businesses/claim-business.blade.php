@extends('app')
@section('content')
<div class="col-xs-12 claim-business">
  <div class="col-md-8 col-md-offset-2 col-xs-12 text-center">
    <h3>
      <i class="icon-exclamation"></i>
      <br>
      Is this your business?
    </h3>
    <p>
      In order to verify that you own <strong>{{ $business->name }}</strong>, we'll be sending a postcard with instructions and a verification code to the address listed for the business. Don't worry, the code will be linked to your account so that only <i>you</i> can claim the business. The postcard will be sent to:
    </p>
    <p>
      Attn: {{ \Auth::user()->display_name }}
      <br>
      {{ $business->name }}
      <br>
      {{ $business->address }}
      @if($business->address2)
        <br>
        {{ $business->address2 }}
      @endif
      <br>
      {{ $business->city }}, {{ $business->state }} {{ $business->zip }}
      <br>
    </p>
    <hr>
    {!! Form::open(['url' => "claim-business/$business->id/send-card", 'method' => 'post']) !!}
      <button class="btn btn-primary btn-lg" type="submit">Yes, send me a verification card</button>
    {!! Form::close() !!}
    <p>
      <a href="{{ route('Dashboard') }}">No, this is not my business.</a>
    </p>
  </div>
</div>
@endsection
