<div class="col-md-4 col-sm-12 sidebar">
  @if (Auth::check())
    <ul class="nav side-nav">
      <li>
        <a href="/dashboard">
          <i class="icon-speedometer"></i> Dashboard
        </a>
      </li>
	  <?php $arrUserId = array(2581,2582,2583,2584,2585); ?>
          @if(in_array(Auth::user()->id, $arrUserId))
          <li style="display:none;">
          <a href="{{ route('Add New User') }}">
              <i class="icon-speedometer"></i> Add New User
            </a>
          </li>
          @endif
      @if(!\Auth::user()->admin)
        @if (\Auth::user()->has_business)
          <li>
            <a href="{{ route('Index Business') }}">
              <i class="icon-briefcase"></i> Your Businesses
            </a>
          </li>
          <li>
            <a href="{{ route('Edit Sale Info') }}">
              <i class="icon-tag"></i> List Your Business for Sale
            </a>
          </li>
          <li>
            <a href="{{ route('User Profile', ['id' => \Auth::user()->id]) }}">
              <i class="icon-eye"></i> Your Profile
            </a>
          </li>
          <li>
            <a href="{{ route('Edit User Info') }}">
              <i class="icon-pencil"></i> Edit Your Info
            </a>
          </li>
        @else
          <li>
            <a href="{{ route('User Profile', ['id' => \Auth::user()->id]) }}">
              <i class="icon-eye"></i> Your Profile
            </a>
          </li>
          <li>
            <a href="{{ route('Edit User Info') }}">
              <i class="icon-pencil"></i> Edit Your Info
            </a>
          </li>
          <li>
            <a href="{{ route('Add Business') }}">
              <i class="icon-plus"></i> Add a Business
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
            <i class="icon-pie-chart"></i> Ad Analytics
          </a>
        </li>
        <li>
          <a href="{{ route('Manage Subscriptions') }}">
            <i class="icon-credit-card"></i> Ad Subscriptions
          </a>
        </li>
        <li>
          <a href="/search?for_sale=true">
            <i class="icon-star"></i> Businesses for Sale
          </a>
        </li>
        <li>
          <a href="/resources">
            <i class="icon-layers"></i> Resources
          </a>
        </li>
       @if(\Auth::check())
          @if(\Auth::user()->hasSubscriptions())
        <li>
          <a href="{{ route('Chat & Message') }}">
            <i class="fa fa-comments-o" ></i> Chat & Messages
          </a>
        </li>
        @endif 
          @endif

      @else
        <li>
          <a href="{{ route('Admin Search') }}">
            <i class="icon-magnifier"></i> Search Spotz
          </a>
        </li>
        <li>
          <a href="{{ route('Pages') }}">
            <i class="icon-note"></i> Pages
          </a>
        </li>
        <li>
          <a href="{{ route('Blogs') }}">
            <i class="icon-note"></i> Blog Posts
          </a>
        </li>
        <li>
          <a href="{{ route('Admin Categories') }}">
            <i class="icon-directions"></i> Categories
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
        <!-- <li>
          <a href="{{ route('Create Partner') }}">
            <i class="icon-plus"></i> Add A Partner
          </a>
        </li> -->
        <li>
          <a href="{{ route('Users Reports') }}">
            <i class="icon-plus"></i> Reported Users List
          </a>
        </li>
      @endif
    </ul>
    
  @endif

  @if (Request::url() === route('Home') && !Auth::check())
    <h2 class="section-header">Featured Review</h2>
    @include('components/featured-review', ['review' => \SpotzCity\Http\Controllers\ComponentController::getFeaturedReview()])
  @endif

  <hr>

  <?php $ads = \SpotzCity\Http\Controllers\ComponentController::getSidebarAds(); ?>

  @include('components/sidebar-ad', ['ad' => $ads[0]])

  <hr>

  @include('components/spotz-new')

  <hr>

  @include('components/sidebar-ad', ['ad' => $ads[1]])
</div>
