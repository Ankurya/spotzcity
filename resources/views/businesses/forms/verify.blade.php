@extends('app')
@section('content')
<div class="col-md-8 col-md-offset-2 col-xs-12 text-center claim-business">
  <h3>
    <i class="icon-check"></i>
    <br>
    Verify Your Business Ownership
  </h3>
  <p>
    Enter the 10-character verification code that was mailed to your business's listed address.
  </p>
  {!! Form::open(['url' => "verify", 'method' => 'post']) !!}
    <div class="col-md-8 col-md-offset-2 col-xs-12 text-center">
      {!! Form::text('verification_code', '', ['class' => 'form-control text-center large-input', 'required' => true, 'autofocus' => true, 'placeholder' => 'Verification Code']) !!}
    </div>
    <button class="btn btn-primary btn-lg" type="submit" style="margin-top:20px;">Claim Business</button>
  {!! Form::close() !!}
</div>
@endsection
