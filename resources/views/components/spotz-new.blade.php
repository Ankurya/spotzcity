<h3 class="sub-header">
  New on <img src="{{ asset('assets/images/logo-color-small.png') }}" style="margin-left:5px;width:136px;"/>
</h3>
<!-- Pull 3 businesses -->
@foreach(\SpotzCity\Http\Controllers\ComponentController::newOnSpotzCity() as $business)
  <div class="business-row">
    <div class="business-pic pull-left">
      <img src="{{ $business->logo ? asset("assets/storage/$business->logo") : asset('assets/images/placeholder.png') }}" class="img-responsive" />
    </div>
    <div class="business-info pull-left">
      <h4>
        <a href="{{ route('View Business', ['slug' => $business->slug]) }}">{{ $business->name }}</a>
      </h4>
      <p>{{ implode(', ', array_merge($business->e_categories_concat(), $business->commodities_concat())) }}</p>
    </div>
  </div>
@endforeach

