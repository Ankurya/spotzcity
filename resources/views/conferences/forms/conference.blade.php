<div class="row">
  <div class="col-xs-12">
    <div class="form-group">
      <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
        <label for="business_name">Conference Name</label>
        {!! Form::text('conference_name', $conference->name, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
      </div>

      <div class="col-md-6 col-xs-12 no-pad-right no-pad-small">
        <label for="website">Conference Website <font style="font-weight:300;">(URL)</font></label>
        {!! Form::text('website', $conference->website, ['class' => 'form-control']) !!}
      </div>

      <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
        <label for="starts">Starts</label>
        <div class='input-group date' id='start-picker'>
          <input name="starts" type='text' value="{{ $conference->starts ? $conference->starts->format('m/d/Y') : '' }}" class="form-control" />
          <span class="input-group-addon">
              <span class="icon-calendar"></span>
          </span>
        </div>
      </div>

      <div class="col-md-6 col-xs-12 no-pad-right no-pad-small">
        <label for="ends">Ends</label>
        <div class='input-group date' id='end-picker'>
          <input name="ends" type='text' value="{{ $conference->ends ? $conference->ends->format('m/d/Y') : '' }}" class="form-control" />
          <span class="input-group-addon">
              <span class="icon-calendar"></span>
          </span>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-12 no-pad">
        <label for="venue">Venue</label>
        {!! Form::text('venue', $conference->venue, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Ex. The Event Arena']) !!}
      </div>

      <div class="col-sm-12 no-pad">
        <label for="industry">Industry</label>
        {!! Form::text('industry', $conference->industry, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Ex. Technology']) !!}
      </div>

      <div class="col-sm-12 no-pad">
        <label for="location">Location</label>
        {!! Form::text('location', $conference->location, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Ex. Chicago, IL']) !!}
      </div>
    </div>

    <div class="form-group">
      <div class="col-xs-12 no-pad">
        <label for="description">Description</label>
        {!! Form::textarea('description', $conference->description, ['class' => 'form-control']) !!}
      </div>
    </div>

    <div class="form-group">
      <div class="col-xs-12 no-pad">
        <label for="image">Image</label>
        <!-- React Component: LogoDrop -->
          <div id="logo-drop" logo-url="{{ asset('storage/'.$conference->image) }}"></div>
        <!-- End Component -->
      </div>
    </div>

  </div>

</div>

<div class="row form-row" style="margin:30px -15px 20px;">
  <div class="col-xs-12">
    <button class="btn btn-primary btn-lg pull-left">Submit Conference</button>
    <h5 class="pull-left" style="margin-left: 10px;">
      <a href="{{ url()->previous() }}">Go Back</a>
    </h5>
    <br/>
    <br/>
    <p class="text-center" style="clear: both;margin-top: 20px;">* Conferences must be approved by an admin before they display on SpotzCity.</p>
  </div>
</div>
