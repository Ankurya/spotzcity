@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-pie-chart"></i> Analytics
  </h2>

  <ul id="analytics-tabs" role="tablist" class="nav nav-pills">
    @if($business)
      <li role="presentation" class="active">
        <a href="#business" aria-controls="business" role="tab" data-toggle="tab">Business Page</a>
      </li>
    @endif
    @foreach($ads as $ad)
      <li role="presentation">
        <a href="#ad-{{$ad->id}}" aria-controls="ad-{{$ad->id}}" role="tab" data-toggle="tab">Ad: {{$ad->name}}</a>
      </li>
    @endforeach
    @if(!count($ads) && !$business)
      <p>No stats to display. Please <a href="{{ route('Ads') }}">create an ad</a> to gain access to detailed analytics.</p>
    @endif
  </ul>

  <div class="tab-content">
    @if($business)
      <div id="business" role="tabpanel" class="tab-pane fade in active">
        <h4>Business Page Views by Month</h4>
        <div id="total-views-chart"></div>
        {!! \Lava::render('LineChart', 'Total Views - '.$business->id, 'total-views-chart') !!}

        <h4>Business Page Views by Registered/Unregistered Users</h4>
        <div id="registered-views-chart"></div>
        {!! \Lava::render('PieChart', 'Status Pie - '.$business->id, 'registered-views-chart') !!}

        <h4>Business Page Views by ZIP</h4>
        <div id="zip-views-chart"></div>
        {!! \Lava::render('PieChart', 'Zip Pie - '.$business->id, 'zip-views-chart') !!}

        <h4>Business Page Views by City</h4>
        <div id="city-views-chart"></div>
        {!! \Lava::render('PieChart', 'City Pie - '.$business->id, 'city-views-chart') !!}

        <h4>Business Page Views by State</h4>
        <div id="state-views-chart"></div>
        {!! \Lava::render('PieChart', 'State Pie - '.$business->id, 'state-views-chart') !!}
      </div>
    @endif

    @foreach($ads as $ad)
      <div id="ad-{{$ad->id}}" role="tabpanel" class="tab-pane fade">
        <h4>Ad Clicks by Month</h4>
        <div id="total-clicks-chart-{{$ad->id}}"></div>
        {!! \Lava::render('LineChart', 'Total Clicks - '.$ad->id, "total-clicks-chart-$ad->id") !!}

        <h4>Ad Clicks by Referring Page</h4>
        <div id="page-clicks-chart-{{$ad->id}}"></div>
        {!! \Lava::render('PieChart', 'Page Ad Clicks - '.$ad->id, "page-clicks-chart-$ad->id") !!}
        <h4>Ad Clicks by ZIP</h4>
        <div id="zip-clicks-chart-{{$ad->id}}"></div>
        {!! \Lava::render('PieChart', 'Zip Ad Clicks - '.$ad->id, "zip-clicks-chart-$ad->id") !!}

        <h4>Ad Clicks by City</h4>
        <div id="city-clicks-chart-{{$ad->id}}"></div>
        {!! \Lava::render('PieChart', 'City Ad Clicks - '.$ad->id, "city-clicks-chart-$ad->id") !!}

        <h4>Ad Clicks by State</h4>
        <div id="state-clicks-chart-{{$ad->id}}"></div>
        {!! \Lava::render('PieChart', 'State Ad Clicks - '.$ad->id, "state-clicks-chart-$ad->id") !!}
      </div>
    @endforeach
  </div>

</div>
@include('components/sidebar')

@endsection
