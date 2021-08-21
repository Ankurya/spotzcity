<!DOCTYPE html>

<html lang="en">

<head>
  @if(request()->route()->getName() === 'Show Page')
    <title>{{ $page->title }} - SpotzCity</title>
    <meta name="description" content="SpotzCity: Building Communities One Entrepreneur at a Time">
    <meta property="og:title" content="{{ $page->title }} - SpotzCity">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('assets/images/logo-color-small.png') }}">
  @elseif(request()->route()->getName() !== 'View Business')
    <title>{{ ucfirst((\Request::route()->getName())) }} - SpotzCity</title>
    <meta name="description" content="SpotzCity: Building Communities One Entrepreneur at a Time">
    <meta property="og:title" content="{{ ucfirst((\Request::route()->getName())) }} - SpotzCity">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ asset('assets/images/logo-color-small.png') }}">
  @else
    <title>{{ $business->name }} - SpotzCity</title>
    <meta name="description" content="{{ $business->description }}">
    <meta property="og:title" content="{{ $business->name }} - SpotzCity">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $business->logo ? asset("storage/$business->logo") : asset('assets/images/placeholder.png') }}">
  @endif

  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <meta name="author" content="Sequential Tech/Design">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('assets/images/logo-symbol-only.png') }}">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" type="image/x-icon" href="{{ asset('assets/images/logo-symbol-only.png') }}">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" type="image/x-icon" href="{{ asset('assets/images/logo-symbol-only.png') }}">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" type="image/x-icon" href="{{ asset('assets/images/logo-symbol-only.png') }}">
  <link rel="apple-touch-icon-precomposed" sizes="57x57" type="image/x-icon" href="{{ asset('assets/images/logo-symbol-only.png') }}">

  <!-- Stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Sintony|Source+Sans+Pro:200,300,400,600,700" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.3.2/css/simple-line-icons.css">
  <link rel="stylesheet" type="text/css" href="{{ elixir('assets/css/vendor.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ elixir('assets/css/app.css') }}">
  <meta name="stripe-pk" content="{!! env('STRIPE_PUBLISH_KEY') !!}">
  <!--<meta name="stripe-pk" content="pk_live_S6A6F6PE5ttX00NE5fxFaLnp">-->
  <style>

    section#content div.container-fluid {
        max-width: 1120px;
    }
    html body section#banner-ad img.ad {
        max-width: 1070px !important;
        width: 100%;
    }

    @media(max-width: 1500px){
    .navbar-default .navbar-nav>li>a, .navbar-default .navbar-text {
          font-size: 13px !important;
      }
    }

    @media(max-width: 1025px){
    header nav.navbar-default li a {
     padding-left: 7px !important;
    padding-right: 7px !important;
    }
    header nav.navbar-default li.right-button a.btn-user {
      min-width: 100px !important;
    }
    header nav.navbar-default img {
      max-height: 35px !important;
      margin-top: 5px !important;
    }
  }
    @media(max-width: 991px){
      header nav.navbar-default img {
      max-height: 50px !important;
      margin-top: 0px !important;
    }
    header nav.navbar-default li.right-button {
    padding: 0px 0 0px 5px;
}
    }

@media(max-width: 767px){
    html body div.sidebar ul.nav.side-nav {
        display: block !important;
        position: relative;
        top: 30px;
        margin-bottom: 50px !important;
    }
}


  </style>
  <script src="https://js.stripe.com/v3/"></script>
  
  <script>
    window.stripe = Stripe( document.querySelector('meta[name=stripe-pk]').content )
    var base_url = 'https://spotzcity.com';
  </script>
  <script src="https://use.fontawesome.com/bcb935a130.js"></script>
  <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>

<body>

  @include('components/header')
  @if(request()->route()->getName() !== 'Home' && request()->route()->getName() !== 'Search' && request()->route()->getName() !== 'Conferences')
    @include('components/banner-ad', ['bannerAd' => \SpotzCity\Http\Controllers\ComponentController::getBannerAd()])
    <section id="content">
      <div class="container-fluid content-wrap">
        <div class="col-xs-12 notification">
          @include('flash::message')
        </div>
        @yield('content')
      </div>
    </section>
  @else
    @yield('content')
  @endif

  @include('components/footer')

  <!-- Scripts -->
  @if(\Request::route()->getName() !== 'View Business')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDIuPIAMFJGc3WsfHur8Fe_VQcpqK0HCsE&libraries=places"></script>
  @endif
  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
  <script type="text/javascript">
    Stripe.setPublishableKey('{{ config("services.stripe.key") }}');
  </script>

  <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>

  <script src="{{ elixir('assets/js/vendor.js') }}"></script>
  <script src="{{ asset('js/share.js') }}"></script>
  <script src="{{ elixir('assets/js/app.js') }}"></script>
  <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
  <!-- <script src="{{ asset('assets/js/chats.js?'.time()) }}"></script> -->
  <script src="{{ asset('assets/js/push-chat.js?'.time()) }}"></script>
  <script src="https://spotzcity.com/emojiPicker.js?{{time() }}"></script>
</body>

</html>
