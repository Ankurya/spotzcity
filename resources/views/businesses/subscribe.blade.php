@extends('app')
@section('content')
<div class="col-md-8 col-md-offset-2 col-xs-12 text-center claim-business">
  <h3>
    <i class="icon-check"></i>
    <br>
    Adding your business to SpotzCity?
  </h3>
  <p>
    Including your business in our national registry is easy and is very affordable. To list your business is <em>$2.99/month*</em>, with each additional location only being an additional <em>$1.00*</em>.
  </p>
  <p>
    <small><em>* Billed annually</em></small>
  </p>

  <div class="row">
    <div class="col-xs-12">
      <form id="card-form" action="/subscribe-add-card" method="POST">
        {{ csrf_field() }}
        <label>How many locations will you be adding?</label>
        <select name="amount" class="form-control">
          <option value="1">1 Location ($35.88/yr)</option>
          <option value="2">2 Locations ($47.88/yr)</option>
          <option value="3">3 Locations ($59.88/yr)</option>
          <option value="4">4 Locations ($71.88/yr)</option>
          <option value="5">5 Locations ($83.88/yr)</option>
          <option value="6">6 Locations ($95.88/yr)</option>
          <option value="7">7+ Locations ($107.88/yr)</option>
        </select>
        <label>
          <div id="stripe-form"></div>
        </label>
        <input id="card-token" name="token" type="hidden" />
        <button id="card-submit" class="btn btn-primary btn-lg">Subscribe</button>
        <p>
          <a href="/">No thanks, I'll do this later</a>
        </p>
    </div>
  </div>
</div>
@endsection
