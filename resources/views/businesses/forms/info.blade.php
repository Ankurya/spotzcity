<div class="row">
  <div class="col-md-8 col-xs-12 left-business-section">
    <div class="form-group">
      <label for="business_name">Company Name</label>
      {!! Form::text('business_name', auth()->user()->has_business ? auth()->user()->business->name : $business->name, [
        'class' => 'form-control',
        'required' => true,
        'autofocus' => true,
        'disabled' => !!auth()->user()->has_business
      ]) !!}

      <label for="url">Company Website <font style="font-weight:300;">(URL)</font></label>
      {!! Form::text('url', $business->url, ['class' => 'form-control']) !!}

    </div>

    <div class="form-group">
	 <div class="col-sm-12 no-pad">
        <label for="address">Company Video<font style="font-weight:300;">(Please Add YouTube Link Here)</font></label>
		{!! Form::text('youtube_video', $business->youtube_video, ['class' => 'form-control']) !!}
      </div>
	  
      <div class="col-sm-12 no-pad">
        <label for="address">Address</label>
        {!! Form::text('address', $business->address, ['class' => 'form-control', 'required' => true]) !!}
      </div>
	 

      <div class="col-sm-12 no-pad">
        <label for="address_two">Address 2 <font style="font-weight:300;">(Suite, Building No., Etc.)</font></label>
        {!! Form::text('address_two', $business->address_two, ['class' => 'form-control']) !!}
      </div>

      <div class="col-sm-7 no-pad-left">
        <label for="city">City</label>
        {!! Form::text('city', $business->city, ['class' => 'form-control', 'required' => true]) !!}
      </div>

      <div class="col-sm-2 no-pad">
        <label for="state">State</label>
        {!! Form::select('state', array(
            'AL'=>'AL',
            'AK'=>'AK',
            'AZ'=>'AZ',
            'AR'=>'AR',
            'CA'=>'CA',
            'CO'=>'CO',
            'CT'=>'CT',
            'DE'=>'DE',
            'DC'=>'DC',
            'FL'=>'FL',
            'GA'=>'GA',
            'HI'=>'HI',
            'ID'=>'ID',
            'IL'=>'IL',
            'IN'=>'IN',
            'IA'=>'IA',
            'KS'=>'KS',
            'KY'=>'KY',
            'LA'=>'LA',
            'ME'=>'ME',
            'MD'=>'MD',
            'MA'=>'MA',
            'MI'=>'MI',
            'MN'=>'MN',
            'MS'=>'MS',
            'MO'=>'MO',
            'MT'=>'MT',
            'NE'=>'NE',
            'NV'=>'NV',
            'NH'=>'NH',
            'NJ'=>'NJ',
            'NM'=>'NM',
            'NY'=>'NY',
            'NC'=>'NC',
            'ND'=>'ND',
            'OH'=>'OH',
            'OK'=>'OK',
            'OR'=>'OR',
            'PA'=>'PA',
            'RI'=>'RI',
            'SC'=>'SC',
            'SD'=>'SD',
            'TN'=>'TN',
            'TX'=>'TX',
            'UT'=>'UT',
            'VT'=>'VT',
            'VA'=>'VA',
            'WA'=>'WA',
            'WV'=>'WV',
            'WI'=>'WI',
            'WY'=>'WY'
          ),
          $business->state,
          ['class' => 'form-control', 'required' => true]) !!}
      </div>

      <div class="col-sm-3 no-pad-right">
        <label for="zip">ZIP</label>
        {!! Form::number('zip', $business->zip, ['class' => 'form-control', 'required' => true]) !!}
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-7 no-pad-left">
        <label for="phone">Phone No.</label>
        {!! Form::tel('phone', $business->phone, ['class' => 'form-control', 'data-inputmask' => '"mask": "(999) 999-9999"']) !!}
      </div>

    </div>

    <div class="form-group">
      <div class="col-xs-12 no-pad">
        <label for="b_description">Description</label>
        {!! Form::textarea('b_description', $business->description, ['class' => 'form-control']) !!}
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
              {!! Form::checkbox('e_categories_buffer[]', "$category->id", in_array($category->name, $business->e_categories_concat())) !!} &nbsp;{{ $category->name }}
            </label>
          </div>
        @endforeach
      </div>
    </div>

    <div class="form-group big-checklist">
      <div class="col-xs-12 no-pad sub-header">
        <h2 class="section-header" for="commodities_buffer">
          <i class="icon-briefcase"></i> Commodity of Business
        </h2>
        @foreach($commodities as $key => $commodity)
          <div class="col-xs-6 no-pad-left">
            <label>
              {!! Form::checkbox('commodities_buffer[]', "$commodity->id", in_array($commodity->name, $business->commodities_concat())) !!} &nbsp;{{ $commodity->name }}
            </label>
          </div>
        @endforeach
      </div>
    </div>

  </div>

  <div class="col-md-4 col-xs-12 right-business-section">

    <div class="form-group clearfix">
      <div class="col-xs-12 no-pad">
        <label for="logo">Company Logo</label>
        <!-- React Component: LogoDrop -->
          <div id="logo-drop" logo-url="{{ asset('assets/storage/'.$business->logo) }}"></div>
        <!-- End Component -->
      </div>
    </div>

    <div class="form-group clearfix">
      <div class="col-xs-12 no-pad">
        <label for="featured">Featured Photos (Max 3)</label>
        <!-- React Component: FeaturedDrop -->
          <div id="featured-drop" images="{{ $business->parsed_featured_photos() }}" businessid="{{ $business->id }}"></div>
        <!-- End Component -->
      </div>
    </div>

    <div class="form-group clearfix" style="margin-top: 0px;">
      <div class="col-xs-12 no-pad sub-header">
        <h2 class="section-header">
          <i class="icon-clock"></i> Business Hours
        </h2>
        <div class="row">
          <div class="col-xs-4">
            <label>Days</label>
          </div>
          <div class="col-xs-8">
            <div class="col-xs-6 no-pad-left">
              <label>Opens</label>
            </div>
            <div class="col-xs-6 no-pad-right">
              <label>Closes</label>
            </div>
          </div>
        </div>
        @foreach($business->parsedHours() as $day => $time)
          <div class="row">
            <div class="col-xs-4">
              <label class="day-label">
                {!! Form::checkbox($day, $day, count($time), ['class' => 'day_checkbox']) !!} &nbsp;{{ $day }}
              </label>
            </div>
            <div class="col-xs-8">
              <div class="col-xs-6 no-pad-left time-selector">
                {!! Form::text("{$day}_opens", isset($time["opens"]) ? $time["opens"] : null, ['class' => 'form-control time-picker', 'disabled' => isset($time["opens"])]) !!}
              </div>
              <div class="col-xs-6 no-pad-right time-selector">
                {!! Form::text("{$day}_closes", isset($time["closes"]) ? $time["closes"] : null, ['class' => 'form-control time-picker', 'disabled' => isset($time["closes"])]) !!}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

  </div>

</div>

<div class="row form-row" style="margin:60px 0px 30px;">
  <div class="col-xs-12 text-center">
    <button class="btn btn-primary btn-lg">Save Company Information</button>
    <br>
    <br>
    <h5>
      @if( !$onboard )
        <a href="{{ url()->previous() }}">Go Back</a>
      @else
        <a href="{{ route( 'Dashboard' ) }}">Skip This Step</a>
      @endif
    </h5>
  </div>
</div>
