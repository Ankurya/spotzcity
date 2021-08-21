<div class="form-group clearfix">
  <label for="logo-drop">Profile Picture</label>
  <!-- React Component: LogoDrop (used for Profile picture here) -->
    <div id="logo-drop" logo-url="{{ asset('assets/storage/'.\Auth::user()->picture) }}"></div>
  <!-- End Component -->
</div>

<div class="form-group clearfix">
  <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
    <label for="first_name">First Name</label>
    {!! Form::text('first_name', $user->first_name, ['class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="col-md-6 col-xs-12 no-pad-right no-pad-small">
    <label for="last_name">Last Name</label>
    {!! Form::text('last_name', $user->last_name, ['class' => 'form-control', 'required' => true]) !!}
  </div>
</div>

<div class="form-group clearfix">
  <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
    <label for="email">Email</label>
    {!! Form::text('email', $user->email, ['class' => 'form-control', 'required' => true]) !!}
  </div>
</div>

<hr>

@if(\Route::getCurrentRoute()->getName() == 'Create Admin' || Route::getCurrentRoute()->getName() == 'Add New User')
  <div class="form-group clearfix">
    <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
      <label for="password">Password</label>
      {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="col-md-6 col-xs-12 no-pad-right no-pad-small">
      <label for="password">Confirm Password</label>
      {!! Form::password('confirm_password', ['class' => 'form-control', 'required' => true]) !!}
    </div>
  </div>
@endif

<hr/>

<div class="button-group">
  <button class="btn btn-primary btn-lg" type="submit" style="margin-right: 20px">Save Info</button>
  <a href="{{ url()->previous() }}">Cancel</a>
</div>
