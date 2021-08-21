<section id="banner-ad" class="section">
  <div class="container-fluid ad-container text-center">
    <a href="{{ route('Ad Redirect', ['id' => $bannerAd->id]).'?ref='.Request::path() }}" target="_blank" rel="nofollow">
      <img class="ad" src="{{ asset('/assets/storage/'.$bannerAd->image) }}">
     
    </a>
  </div>
</section>
