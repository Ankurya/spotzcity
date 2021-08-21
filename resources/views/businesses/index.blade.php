@extends('app')

@section('content')


<div class="col-md-8 col-xs-12 current-ads">
  <h2 class="section-header">
    <i class="icon-check"></i> Businesses
  </h2>

  <div class="row" style="margin-bottom: 40px;">
    <div class="col-xs-12">
      <form name="update-subscription" action="/update-business-subscription" method="POST" style="background: #ebebeb;border-radius:4px;padding: 10px;">
        <h4><i>Current Subscription</i>: {{ auth()->user()->business_subscription()->quantity === 7 ? '7+' : auth()->user()->business_subscription()->quantity }} locations</h4>
        <p>Note: If you upgrade your subscription, the prorated difference will automatically be charged to your card on file.</p>
        {{ csrf_field() }}
        <select name="amount" class="form-control">
          <option value="1" {{ auth()->user()->business_subscription()->quantity === 1 ? 'selected' : null }}>1 Location ($35.88/yr)</option>
          <option value="2" {{ auth()->user()->business_subscription()->quantity === 2 ? 'selected' : null }}>2 Locations ($47.88/yr)</option>
          <option value="3" {{ auth()->user()->business_subscription()->quantity === 3 ? 'selected' : null }}>3 Locations ($59.88/yr)</option>
          <option value="4" {{ auth()->user()->business_subscription()->quantity === 4 ? 'selected' : null }}>4 Locations ($71.88/yr)</option>
          <option value="5" {{ auth()->user()->business_subscription()->quantity === 5 ? 'selected' : null }}>5 Locations ($83.88/yr)</option>
          <option value="6" {{ auth()->user()->business_subscription()->quantity === 6 ? 'selected' : null }}>6 Locations ($95.88/yr)</option>
          <option value="7" {{ auth()->user()->business_subscription()->quantity === 7 ? 'selected' : null }}>7+ Locations ($107.88/yr)</option>
        </select>
        <br/>
        <button type="submit" class="btn btn-primary">Update Subscription</button> |
        <a href="/cancel-business-subscription">Cancel Subscription</a>
      </form>
    </div>
  </div>
  <hr/>

  @foreach (auth()->user()->activeBusinesses as $index => $business)
    <div class="row business">
      <div class="col-xs-6">
        @if( $index === 0 )
          <h3 style="margin-top:5px;">{{ $business->name }}</h3>
        @endif
        <p style="margin-top: 15px;">{{ $business->address }}</p>
        @if( $business->address_two )
          <p>{{ $business->address_two }}</p>
        @endif
        <p>{{ $business->city }}, {{ $business->state }} {{ $business->zip }}</p>
      </div>

      <div class="col-xs-6 text-right">
        <a class="btn btn-danger" href="{{ route('Deactivate Business', ['id' => $business->id]) }}" style="min-width:65px;margin-top:5px;">Set Inactive</a>
      </div>

      <div class="col-xs-12">
        <a class="btn btn-primary" href="{{ route('View Business', ['slug' => $business->slug]) }}" style="min-width:65px;margin-top:5px;">View</a>
        <a class="btn btn-info" href="{{ route('Business Analytics', ['id' => $business->id]) }}" style="min-width:65px;margin-top:5px;">Analytics</a>
        <a class="btn btn-warning" href="{{ route('Edit Business', ['id' => $business->id]) }}" style="min-width:65px;margin-top:5px;">Edit</a>
      </div>
    </div>
    @if( $index === 0 )
      <div class="row">
        <div class="col-sm-12" style="margin-top:25px;">
          <h4>Other Locations:</h4>
        </div>
      </div>
    @else
      <hr/>
    @endif
  @endforeach

  <div class="row">
    <div class="col-sm-12" style="margin-top:25px;">
      @if( auth()->user()->businessSlotsRemaining() >= 1 && auth()->user()->business_subscription()->quantity !== 7 )
        <a class="btn btn-primary btn-lg" href="{{ route('Add Business') }}">Add Another Location</a>
        <br/><br/>
        <p>You have {{ auth()->user()->businessSlotsRemaining() }} more locations you can add.</p>
      @elseif( auth()->user()->businessSlotsRemaining() >= 1 && auth()->user()->business_subscription()->quantity === 7 )
        <a class="btn btn-primary btn-lg" href="{{ route('Add Business') }}">Add Another Location</a>
      @else
        <strong>Upgrade your subscription to have more locations</strong>
      @endif
    </div>
  </div>

  <div class="row" style="margin-top:40px;">
    <div class="col-sm-12">
      <h4>Inactive Locations:</h4>
    </div>
  </div>

  @foreach (auth()->user()->inactiveBusinesses as $index => $business)
    <div class="row business" style="margin-top: 15px;">
      <div class="col-sm-5">
        <p>{{ $business->address }}</p>
        @if( $business->address_two )
          <p>{{ $business->address_two }}</p>
        @endif
        <p>{{ $business->city }}, {{ $business->state }} {{ $business->zip }}</p>
      </div>

      <div class="col-sm-7 text-right">
        @if( auth()->user()->businessSlotsRemaining() > 0 )
          <a class="btn btn-info" href="{{ route('Reactivate Business', ['id' => $business->id]) }}" style="min-width:70px;">Set Active</a>
        @endif
      </div>
    </div>
  @endforeach

</div>


@include('components/sidebar')
@endsection
