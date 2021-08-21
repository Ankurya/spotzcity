@extends('app')
@section('content')
<div id="search">
  <div id="search-parameters" class="conferences-search">
    <form id="conference-search" method="GET" action="/conferences">
      <div class="row">
        <div class="container">
          <div class="row">
            <div class="col-md-3 col-xs-12">
              <label class="big">Location:</label>
              <input type="text" name="location" class="form-control" placeholder="Ex. Chicago, IL" value="{{ $location }}" />
            </div>
            <div class="col-md-4 col-xs-12">
              <label class="big">Date Range:</label>
              <input id="start-picker" class="form-control" name="min-date" value="{{ $minDate }}" />
              <label class="big">to</label>
              <input id="end-picker" class="form-control" name="max-date" value="{{ $maxDate }}" />
            </div>
            <div class="col-md-3 col-xs-12">
              <label class="big">Industry Type:</label>
              <input name="industry" class="form-control" placeholder="Ex. Film" value="{{ $industry }}" />
            </div>
            <div class="col-md-2 col-xs-12">
              <label>&nbsp;</label>
              <button class="col-xs-12 btn btn-lg add-conference" type="submit">Search</button>
              <a href="/conferences/add-conference" class="col-xs-12 btn btn-lg add-conference">Add Event</a>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="row">
    <div class="container">
      @foreach($conferences as $conference)
        <div class="conference row">
          <div class="col-md-2 col-xs-12">
            <img class="img-responsive" src="{{ $conference->image ? asset("storage/$conference->image") : asset("assets/images/placeholder.png") }}" />
          </div>
          <div class="col-md-5 col-xs-12 b-right">
            <h4>
              {{ $conference->name }}
              @if(\Auth::user()->admin)
                <small>&nbsp;-&nbsp;<a href="{{ route('Edit Conference', ['id' => $conference->id]) }}">Edit</a></small>
              @endif
            </h4>
            <p><strong>Industry:</strong> {{ $conference->industry }}</p>
            <p><strong>Venue:</strong> {{ $conference->venue }} - {{ $conference->location }}</p>
            <p><strong>Dates:</strong> {{ Carbon\Carbon::parse($conference->starts)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($conference->ends)->toFormattedDateString() }}</p>
            @if($conference->website)
              <p><strong>Website: </strong> <a href="{{$conference->website}}" target="_blank">{{$conference->website}}</a></p>
            @endif
          </div>
          @if($conference->description)
            <div class="col-md-4 col-xs-12">
              <p><strong>About:</strong> {{ $conference->description }}</p>
            </div>
          @else
            <div class="col-md-5 col-xs-12">
              <p><strong>About:</strong> N/A</p>
            </div>
          @endif
        </div>
      @endforeach
      {{ $conferences->links() }}
    </div>
  </div>
</div>
@endsection
