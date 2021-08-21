<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('Home') }}">
          <img class="img-responsive" src="{{ asset('assets/images/logo-color-small.png') }}"/>
        </a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <div class="row">
          <ul class="nav navbar-nav navbar-form navbar-right hidden-xs" style="margin-right:0px;">
            <li>
              <a href="{{ route('Home') }}">Home</a>
            </li>

            <li class="dropdown" >
 <div class="dropdown-menu" aria-labelledby="about-dropdown">
                <p class="dropdown-item">
                  <a href="/p/about-the-founders">The Founders</a>
                </p>
                <p class="dropdown-item">
                  <a href="/p/about-spotzcity">What We Do</a>
                </p>
              </div>
              <a href="#" data-toggle="dropdown" id="about-dropdown">About <i class="fa fa-chevron-down"></i>
              </a>
            
            </li>
            @foreach( \SpotzCity\Page::where([
              [ 'active', '=', true ],
              [ 'show_in_nav', '=', true ]
            ])->get()
            as $page )
              <li>
                <a href="/p/{{ $page->slug }}">{{ $page->title }}</a>
              </li>
            @endforeach
            <li>
              <a href="/search?for_sale=true">For Sale</a>
            </li>
            <li>
              <a href="/conferences">Events</a>
            </li>
            <li>
              <a href="{{ route('Resources') }}">Resources</a>
            </li>
            <li>
              <a href="{{ route('Blog') }}">Blog</a>
            </li>
			<?php
             if(isset(Auth::user()->id) && !empty(Auth::user()->id)){
            $user = DB::table('billing')->where('user_id', Auth::user()->id)
            // ->whereNotNull('stripe_id')
            ->first();
           
            //print_r($user);
            ?>
            @if (Auth::check() && $user)
            <li style="">
              <a href="{{ route('Partner') }}">Partners</a>
            </li>
            @endif
            <?php } ?>
            <li>
              <a href="https://twitter.com/SpotzCity" target="_blank" style="font-size: 24px; margin-right: -10px; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-twitter"></i></a>
            </li>
            <li>
              <a href="https://www.facebook.com/SpotzCity1/" target="_blank" style="font-size: 24px; margin-right: -10px; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-facebook-square"></i></a>
            </li>
            <li>
              <a href="https://www.instagram.com/spotzcity/" target="_blank" style="font-size: 24px; margin-right: -10px; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-instagram"></i></a>
            </li>
            <li>
              <a href="https://www.pinterest.com/spotzcity/boards/" target="_blank" style="font-size: 24px;margin-right: -10px; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-pinterest"></i></a>
            </li>
            <li>
              <a href="https://www.youtube.com/watch?v=G-kw5RYRd10" target="_blank" style="font-size: 24px; margin-top:-1px;margin-bottom:1px;"><i class="fa fa-youtube"></i></a>
            </li>
            <li class="right-button">
              <a href="{{ route('Search') }}" class="btn btn-default"><i class="icon-magnifier"></i></a>
            </li>
            @if (Auth::check())
              <li class="right-button dropdown">
                <a class="btn btn-default btn-user dropdown-toggle" data-toggle="dropdown" id="main-dropdown-1" onclick="dropdown()">
                  <i class="icon-user"></i> {{ Auth::user()->display_name }}
                </a>
                <div class="dropdown-menu" id="testid" aria-labelledby="main-dropdown-1" style="display: none;">
                  <p class="dropdown-item">
                    <a class="dropdown-item" href="{{ route('Dashboard') }}">Dashboard</a>
                  </p>
                  @if( auth()->user()->has_business )
                    <p class="dropdown-item">
                      <a class="dropdown-item" href="{{ route('Index Business') }}">My Businesses</a>
                    </p>
                  @endif
                  <p class="dropdown-item">
                    <a class="dropdown-item" href="{{ route('Edit User Info') }}">Edit My Info</a>
                  </p>
                  <p class="dropdown-item">
                    <a class="dropdown-item" href="{{ route('Logout') }}">Logout</a>
                  </p>
                </div>
              </li>
            @else
              <li class="right-button dropdown">
                <a class="btn btn-default btn-user dropdown-toggle" data-toggle="dropdown" id="main-dropdown">
                  <i class="icon-user"></i> Login/Sign Up</a>
                </a>
                <div class="dropdown-menu" aria-labelledby="main-dropdown">
                  <p class="dropdown-item">
                    <a href="/login">Login</a>
                  </p>
                  <p class="dropdown-item">
                    <a href="/register">Sign Up</a>
                  </p>
                </div>
              </li>
            @endif
          </ul>

          <ul class="nav navbar-nav navbar-form navbar-right visible-xs text-center" style="margin-right:-10px;">
            <li>
              <a href="/">
                Home
              </a>
            </li>
            @foreach( \SpotzCity\Page::where([
            [ 'active', '=', true ],
            [ 'show_in_nav', '=', true ]
            ])->get()
            as $page )
              <li>
                <a href="/p/{{ $page->slug }}">{{ $page->title }}</a>
              </li>
            @endforeach
            @if (!Auth::check())
              <li>
                <a href="/search?for_sale=true">
                  Businesses for Sale
                </a>
              </li>
              <li>
                <a>
                  Conferences
                </a>
              </li>
              <li>
                <a href="{{ route('Resources') }}">
                  Resources
                </a>
              </li>
              <li>
                <a href="/search">
                  <i class="icon-magnifier"></i> &nbsp;Search
                </a>
              </li>
              <li>
                <a href="/login">
                  <i class="icon-login"></i> &nbsp;Login/Signup
                </a>
              </li>
            @else
              <li>
                <a href="/dashboard">
                  <i class="icon-speedometer"></i> &nbsp;Dashboard
                </a>
              </li>
              @if(!Auth::user()->admin)
                @if (Auth::user()->has_business)
                  <li>
                    <a href="{{ route('Index Business') }}">
                      <i class="icon-briefcase"></i> Your Businesses
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('Edit Sale Info') }}">
                      <i class="icon-tag"></i> &nbsp;List Your Business for Sale
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('Events and Specials') }}">
                      <i class="icon-calendar"></i> &nbsp;Your Events and Specials
                    </a>
                  </li>
                @else
                  <li>
                    <a href="/edit-user-info">
                      <i class="icon-pencil"></i> &nbsp;Edit Your Info
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('Add Business') }}">
                      <i class="icon-plus"></i> &nbsp;Add Your Business
                    </a>
                  </li>
                @endif
                <li>
                  <a href="{{ route('Ads') }}">
                    <i class="icon-badge"></i> Advertise With Spotz
                  </a>
                </li>
                <li>
                  <a href="{{ route('Analytics') }}">
                    <i class="icon-pie-chart"></i> Your Analytics
                  </a>
                </li>
                <li>
                  <a href="{{ route('Manage Subscriptions') }}">
                    <i class="icon-credit-card"></i> Manage Subscriptions
                  </a>
                </li>
                <li>
                  <a href="/search?for_sale=true">
                    <i class="icon-star"></i> &nbsp;Businesses for Sale
                  </a>
                </li>
                <li>
                  <a href="/conferences">
                    <i class="icon-people"></i> &nbsp;Conferences
                  </a>
                </li>
                <li>
                  <a href="{{ route('Add Business') }}">
                    <i class="icon-plus"></i> &nbsp;Add Business
                  </a>
                </li>
                <li>
                  <a href="{{ route('Resources') }}">
                    <i class="icon-layers"></i> &nbsp;Resources
                  </a>
                </li>
                <li>
                  <a href="/search">
                    <i class="icon-magnifier"></i> &nbsp;Search
                  </a>
                </li>
              @else
                <li>
                  <a href="{{ route('Admin Search') }}">
                    <i class="icon-magnifier"></i> Search Spotz
                  </a>
                </li>
                <li>
                  <a href="/resources">
                    <i class="icon-layers"></i> Resources
                  </a>
                </li>
                <li>
                  <a href="{{ route('Create Admin') }}">
                    <i class="icon-plus"></i> Create Admin
                  </a>
                </li>
              @endif
              <li>
                <a href="{{ route('Logout') }}">
                  <i class="icon-logout"></i> &nbsp;Logout
                </a>
              </li>
            @endif
          </ul>
        </div>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
  {{-- <nav class="navbar underbar">
    <div class="container-fluid">
      <ul class="nav navbar-nav">
        <li>
          <a href="{{ route('Home') }}">Home</a>
        </li>
        <li>
          <a>Write a Review</a>
        </li>
        <li>
          <a href="{{ route('Add Business') }}">Add a Business</a>
        </li>
        <li>
          <a>Advertise with Spotz</a>
        </li>
        <li>
          <a>Conferences</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::check())
          <li class="text-center right-button"><a href="{{ route('Logout') }}" style="padding:0px 34px 0px 0px; font-size:12px;">Logout</a></li>
        @else
          <li class="text-center"><a href="/login" style="padding:0px 26px 0px 0px; font-size:12px;">Have an account? Log in <i class="icon-arrow-right"></i></a></li>
        @endif
      </ul>
    </div>
  </nav> --}}
</header>
