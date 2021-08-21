@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header pull-left">
    <i class="icon-people"></i> Add Event
  </h2>
  {!! Form::model(null, ['route' => ['Store Conference'], 'name' => 'conference', 'id' => 'conference-form', 'files' => true ]) !!}
    @include('conferences/forms/conference')
  {!! Form::close() !!}
</div>
@include('components/sidebar')
@endsection
