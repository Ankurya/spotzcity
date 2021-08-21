@extends('app')
@section('content')
<div class="col-md-8 col-xs-12 col-xs-12">
  <h2 class="section-header">
    <i class="icon-chart"></i> Edit Resource
  </h2>
  {!! Form::model($resource, ['route' => ['Update Resource', $resource->id], 'name' => 'resource', 'id' => 'resource-form' ]) !!}
    @include('resources/forms/info')
  {!! Form::close() !!}
</div>
@include('components/sidebar')
@endsection
