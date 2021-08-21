@extends('app')

@section('content')

@if(\Auth::user()->admin)
  <div class="col-md-8 col-xs-12 current-ads">
    <h2 class="section-header">
      <i class="icon-check"></i> Approve Ads
    </h2>
    @forelse($ads as $ad)
      <div class="ad col-xs-12 no-pad">
        <span class="pull-left">
          <h4><a href="/create-ad/{{ $ad->type }}?edit={{ $ad->id }}">{{ $ad->name }}</a> <small>({{ ucfirst($ad->sizeType()) }})</small></h4>
        </span>
        <span class="pull-right">
          <h4>
            Status:
            @if($ad->approved)
              @if($ad->active)
                <font style="color:green;">Active</font>
              @else
                <font style="color:#bbb;">Inactive</font>
              @endif
            @else
              <font style="color:#bbb;">Awaiting Approval</font>
            @endif
          </h4>
        </span>
      </div>
    @empty
      <p>No ads to be approved.</p>
    @endforelse
    <br/>
    <br/>
    <h2 class="section-header" style="margin-top: 45px;clear:both;display: inline-block;">
      <i class="icon-check"></i> Approve Conferences
    </h2>
    @forelse($conferences as $conference)
      <div class="conference col-xs-12 no-pad">
        <h4>
        {{ $conference->name }}
        @if(\Auth::user()->admin)
          <small>&nbsp;-&nbsp;<a href="{{ route('Edit Conference', ['id' => $conference->id]) }}">Approve</a></small>
        @endif
        </h4>
        <p><strong>Venue:</strong> {{ $conference->venue }} - {{ $conference->location }}</p>
        <p><strong>Dates:</strong> {{ Carbon\Carbon::parse($conference->starts)->toFormattedDateString() }} - {{ Carbon\Carbon::parse($conference->ends)->toFormattedDateString() }}</p>
        @if($conference->website)
          <p><strong>Website: </strong> <a href="{{$conference->website}}" target="_blank">{{$conference->website}}</a></p>
        @endif
        @if($conference->description)
          <p>{{ $conference->description }}</p>
        @endif
      </div>
    @empty
      <p>No conferences to be approved.</p>
    @endforelse
    <br/>
    <br/>
    <h2 class="section-header" style="margin-top: 45px;clear:both;display: inline-block;">
      <i class="icon-check"></i> Approve Resources
    </h2>
    @forelse($resources as $resource)
      <div class="conference col-xs-12 no-pad">
        <h4>
        {{ $resource->name }}
        @if(\Auth::user()->admin)
          <small>&nbsp;-&nbsp;<a href="{{ route('Edit Resource', ['id' => $resource->id]) }}">Approve</a></small>
        @endif
        </h4>
        <p><strong>City:</strong> {{$resource->city}}</p>
        <p><strong>State:</strong> {{$resource->state}}</p>
        <p><strong>Type:</strong> {{$resource->type}}</p>
        @if($resource->website)
          <p><strong>Website: </strong> <a href="{{$resource->website}}" target="_blank">{{$resource->website}}</a></p>
        @endif
        @if($resource->phone)
          <p><strong>Phone: </strong> <a href="tel:{{$resource->phone}}" target="_blank">{{$resource->phone}}</a></p>
        @endif
      </div>
    @empty
      <p>No resources to be approved.</p>
    @endforelse
  </div>
@else
  <div class="col-md-8 col-xs-12">
    <h2 class="section-header">
      <i class="icon-feed"></i> Recent Activity
    </h2>
    <!-- React Component -->
    <div id="activity-feed" loggedIn="true"></div>
    <!-- End React Component -->
  </div>
@endif

@include('components/sidebar')

@endsection
