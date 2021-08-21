<a href="{{ route('Ad Redirect', ['id' => $ad->id]).'?ref='.Request::path() }}" target="_blank" rel="nofollow">
  <img class="ad img-responsive" src="{{ asset('assets/storage/'.$ad->image) }}">
</a>
