@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header pull-left">
    <i class="icon-people"></i> Edit Event
  </h2>
  {!! Form::model($conference, ['route' => ['Update Conference', $conference->id], 'name' => 'conference', 'id' => 'conference-form' ]) !!}
    @include('conferences/forms/conference')
  {!! Form::close() !!}
</div>
@include('components/sidebar')
@endsection
