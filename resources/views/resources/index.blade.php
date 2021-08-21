@extends('app')
@section('content')
<div class="col-xs-12">
  <h2 class="section-header pull-left">
    <i class="icon-chart"></i> Resources
  </h2>
  <!-- React Component: Resources -->
    <div
      id="resources"
      class="col-xs-12"
      data-categories='{!! json_encode($categories) !!}'
    ></div>
  <!-- End React Component -->
</div>
@endsection
