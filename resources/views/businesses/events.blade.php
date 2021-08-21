@extends('app')
@section('content')

<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-calendar"></i> Your Events and Specials
  </h2>
  <!-- React Component: EventsSpecialsContainer -->
    <div id="events-specials-container" businessid="{{ $id }}"></div>
  <!-- End Component -->
</div>
@include('components/sidebar')

@endsection
