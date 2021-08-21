<div class="form-group clearfix">
  <label for="logo-drop">Profile Picture</label>
  <!-- React Component: LogoDrop (used for Profile picture here) -->
    <div id="logo-drop" logo-url="{{ asset('storage/'.\Auth::user()->picture) }}"></div>
  <!-- End Component -->
</div>

<div class="form-group clearfix">
  <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
    <label for="partner_name">First Name</label>
    {!! Form::text('first_name', $partner->partner_name, ['class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
    <label for="last_name">Last Name</label>
    {!! Form::text('last_name', $partner->partner_name, ['class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
    <label for="partner_name">Email</label>
    {!! Form::text('email', $partner->partner_name, ['class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
    <label for="partner_name">Name Of Company</label>
    {!! Form::text('email', $partner->partner_name, ['class' => 'form-control', 'required' => true]) !!}
  </div>
</div>
 <div class="form-group">
      <div class="col-xs-12 no-pad">
        <label for="description">Business Description</label>
        {!! Form::textarea('description', $partner->description, ['class' => 'form-control','required' => true]) !!}
      </div>
    </div>

 <div class="form-group">
      <div class="col-xs-12 no-pad">
    <label for="link">Website Link</label>
    {!! Form::text('link', $partner->link, ['class' => 'form-control', 'required' => true]) !!}
  </div>
</div>

  <div class="form-group big-checklist">
    <div class="col-xs-12 no-pad sub-header">
      <h2 class="section-header" for="e_categories_buffer">
        <i class="icon-people"></i> Entrepreneur Categories
      </h2>
      @foreach($e_categories as $key => $category)
        <div class="col-xs-6 no-pad-left">
          <label>
            {!! Form::checkbox('e_categories_buffer[]', "$category->id") !!} &nbsp;{{ $category->name }}
          </label>
        </div>
      @endforeach
    </div>
  </div>



<hr/>

<div class="button-group">
  <button class="btn btn-primary btn-lg" type="submit" style="margin-right: 20px">Save Info</button>
  <a href="{{ url()->previous() }}">Cancel</a>
</div>
