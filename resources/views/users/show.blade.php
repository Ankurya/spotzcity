@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-user"></i> User Profile
  </h2>
  <div class="pull-left business-pic" style="width: auto; height: auto; max-width: 100px;">
    <img src="{{ $user->picture ? asset('assets/storage/'.$user->picture) : '/assets/images/placeholder.png' }}" class="img-responsive" />
  </div>
  <div class="pull-left business-info">
    <h4>{{ $user->display_name }}</h4>
    @if($user->business)
      Owner of: <a href="{{ route('View Business', ['slug' => $user->business->slug]) }}">{{ $user->business->name }}</a>
    @endif
    <p>User since: {{ $user->created_at->toFormattedDateString() }}</p>
    @if(\Auth::user()->admin)
      <span>
        <a href="{{ route('Edit User Info', ['id' => $user->id]) }}">Edit</a>
      </span>
    @endif
  </div>
  @if(\Auth::user()->admin && $user->billing)
    <div class="col-xs-12 no-pad">
      <hr/>
      <h4>Subscriptions</h4>
      @forelse($user->billing->subscriptions as $subscription)
        <a href="/create-ad/{{ $subscription->ad()->type }}?edit={{ $subscription->ad()->id }}"><p>{{ $subscription->parsedType() }}</p></a>
      @empty
        <p>No subscriptions</p>
      @endforelse
    </div>
  @endif
  <div class="col-xs-12 no-pad">
    <hr/>
    <h4>Reviews</h4>
    @forelse($user->reviews as $review)
      <div class="col-xs-12 no-pad" style="margin-bottom: 25px;">
        <div class="pull-left business-pic" style="width:auto;max-width: 60px;margin-bottom:10px;">
          <img src="{{ $review->business->logo ? asset('storage/'.$review->business->logo) : '/assets/images/placeholder.png' }}" class="img-responsive" />
        </div>
        <div class="pull-left business-info" style="margin-bottom:10px;">
          <h5 style="margin-bottom: 5px; margin-top: 0px;">
            <a href="{{ route('User Profile', ['id' => $review->user->id]) }}">{{ $review->user->display_name }}</a> reviewed
            <a href="{{ route('View Business', ['slug' => $review->business->slug]) }}">{{ $review->business->name }}</a>.
          </h5>
          <ul class="rating-icons sm">
            @for($i = 0; $i < 5; $i++)
              <li>
                <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon {{ $review->rating >= $i + 1 ? 'active' : 'inactive' }}" rating-level="{{$i + 1}}"></i>
              </li>
              @if($i == 4)
              <li>
                <small>
                  &nbsp;| {{ $review->created_at->toFormattedDateString() }}
                </small>
              </li>
              @endif
            @endfor
          </ul>
        </div>
        <br/>
        <p style="clear:both;margin-top:20px;">{{$review->body}}</p>
      </div>
    @empty
      <p class="text-center">No reviews Yet</p>
    @endforelse
  </div>
</div>
@include('components/sidebar')

@endsection
