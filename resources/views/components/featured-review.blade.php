<div id="featured-review clearfix" style="margin-bottom: 10px;">
  <div class="business-pic pull-left" style="margin-bottom: 10px;">
    <img src="{{ $review->user->picture ? $review->user->picture : '/assets/images/placeholder.png' }}" class="img-responsive" />
  </div>
  <div class="business-info pull-left" style="margin-bottom: 10px;">
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
  <p style="clear:both;margin-top:10px;">{{$review->body}}</p>
</div>
