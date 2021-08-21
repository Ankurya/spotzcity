<footer>
  <div class="container-fluid">
    <div class="pull-left col-md-3 col-xs-12 no-pad-small">
      <h3 class="sub-header">Helpful Links</h3>
      <ul class="nav nav-footer">
        @foreach( \SpotzCity\Page::where([
          [ 'active', '=', true ],
          [ 'show_in_footer', '=', true ]
        ])->get()
        as $page )
          <li>
            <a href="/p/{{ $page->slug }}">
              <i class="icon-arrow-right-circle"></i> {{ $page->title }}
            </a>
          </li>
        @endforeach
        <li>
          <a href="/support">
            <i class="icon-arrow-right-circle"></i> Support
          </a>
        </li>
      </ul>
    </div>
    <div class="right-logo pull-right col-md-4 col-xs-12 no-pad text-right">
      <img src="{{ asset('assets/images/logo-white-small.png') }}" />
      <ul class="list-inline">
        <li>
          <a href="https://twitter.com/SpotzCity" target="_blank" style="font-size: 24px; color:white; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-twitter"></i></a>
        </li>
        <li>
          <a href="https://www.facebook.com/SpotzCity1/" target="_blank" style="font-size: 24px; color:white; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-facebook-square"></i></a>
        </li>
        <li>
          <a href="https://www.instagram.com/spotzcity/" target="_blank" style="font-size: 24px; color:white; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-instagram"></i></a>
        </li>
        <li>
          <a href="https://www.pinterest.com/spotzcity/boards/" target="_blank" style="font-size: 24px; color:white; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-pinterest"></i></a>
        </li>
        <li>
          <a href="https://www.youtube.com/watch?v=G-kw5RYRd10" target="_blank" style="font-size: 24px;color:white; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-youtube"></i></a>
        </li>
      </ul>
      <p>
        Copyright &copy;{{ Carbon\Carbon::now()->year }} SpotzCity.
        <br>
        All rights reserved.
      </p>
    </div>
  </div>
</footer>

<script type="text/javascript">
  function dropdown(){
   $("#testid").toggle(); 
}
</script>
