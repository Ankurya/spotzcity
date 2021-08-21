@extends('app')
@section('content')
<!-- React Component: SearchContainer -->
  <div
    id="search"
    data-categories='{!! json_encode($categories) !!}'
    data-commodities='{!! json_encode($commodities) !!}'
  ></div>
<!-- End React Component -->
<style type="text/css">
	.side-map.stick {
    position: absolute !important;
}
</style>
@endsection
