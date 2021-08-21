@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-badge"></i> Advertise on SpotzCity
  </h2>
  <div class="current-ads clearfix">
    <h4>Your Current Ads</h4>
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
                <font style="color:green;">Active</font> | <a href="{{ route('Deactivate Ad', ['id' => $ad->id]) }}">Deactivate</a>
              @else
                <font style="color:#bbb;">Inactive</font> | <a href="/manage-subscriptions?activate={{ $ad->id }}">Activate!</a>
              @endif
            @else
              <font style="color:#bbb;">Awaiting Approval</font>
            @endif
          </h4>
        </span>
      </div>
    @empty
      <p class="text-center no-ads">No ads currently</p>
    @endforelse
  </div>
  <div class="ad-start">
    <h4>Create New Ad</h4>

    <div class="col-xs-6 no-pad-left text-center ad-types">
      <div class="col-xs-12 ad-type">
        <h3>Main Page Banner</h3>
        <h4>Big Business*</h4>
        <a class="btn btn-primary" href="{{ route('Create Ad', ['type' => 'main-banner-bb']) }}">Get Started</a>
      </div>
    </div>

    <div class="col-xs-6 no-pad-right text-center ad-types">
      <div class="col-xs-12 ad-type">
        <h3>Main Page Banner</h3>
        <h4>Small Business*</h4>
        <a class="btn btn-primary" href="{{ route('Create Ad', ['type' => 'main-banner-sb']) }}">Get Started</a>
      </div>
    </div>

    <div class="col-xs-6 no-pad-left text-center ad-types">
      <div class="col-xs-12 ad-type">
        <h3>Main Page Sidebar</h3>
        <h4>Big Business*</h4>
        <a class="btn btn-primary" href="{{ route('Create Ad', ['type' => 'main-sidebar-bb']) }}">Get Started</a>
      </div>
    </div>

    <div class="col-xs-6 no-pad-right text-center ad-types">
      <div class="col-xs-12 ad-type">
        <h3>Main Page Sidebar</h3>
        <h4>Small Business*</h4>
        <a class="btn btn-primary" href="{{ route('Create Ad', ['type' => 'main-sidebar-sb']) }}">Get Started</a>
      </div>
    </div>

    <div class="col-xs-6 no-pad-left text-center ad-types">
      <div class="col-xs-12 ad-type">
        <h3>Sub Page Banner</h3>
        <h4>Big Business*</h4>
        <a class="btn btn-primary" href="{{ route('Create Ad', ['type' => 'sub-banner-bb']) }}">Get Started</a>
      </div>
    </div>

    <div class="col-xs-6 no-pad-right text-center ad-types">
      <div class="col-xs-12 ad-type">
        <h3>Sub Page Banner</h3>
        <h4>Small Business*</h4>
        <a class="btn btn-primary" href="{{ route('Create Ad', ['type' => 'sub-banner-sb']) }}">Get Started</a>
      </div>
    </div>

    <div class="col-xs-6 no-pad-left text-center ad-types">
      <div class="col-xs-12 ad-type">
        <h3>Sub Page Sidebar</h3>
        <h4>Big Business*</h4>
        <a class="btn btn-primary" href="{{ route('Create Ad', ['type' => 'sub-sidebar-bb']) }}">Get Started</a>
      </div>
    </div>

    <div class="col-xs-6 no-pad-right text-center ad-types">
      <div class="col-xs-12 ad-type">
        <h3>Sub Page Sidebar</h3>
        <h4>Small Business*</h4>
        <a class="btn btn-primary" href="{{ route('Create Ad', ['type' => 'sub-sidebar-sb']) }}">Get Started</a>
      </div>
    </div>

  </div>
</div>
@include('components/sidebar')

@endsection
