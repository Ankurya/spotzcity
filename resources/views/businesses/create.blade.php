@extends('app')
@section('content')
<div class="col-xs-12">
  <h1 class="section-header">
    <i class="icon-pencil"></i> Add {{ auth()->user()->has_business ? 'Location' : 'Business' }}
  </h1>
  {!! Form::model(null, ['route' => ['Create Business'], 'files' => true, 'name' => 'business-info', 'id' => 'business-info-form' ]) !!}
    @include('businesses/forms/info')
  {!! Form::close() !!}
</div>
@endsection
