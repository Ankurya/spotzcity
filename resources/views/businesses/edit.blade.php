@extends('app')
@section('content')
<div class="col-xs-12">
  <h1 class="section-header">
    <i class="icon-info"></i> Business Information
  </h1>
  {!! Form::model($business, ['route' => ['Update Business', $business->id], 'files' => true, 'name' => 'business-info', 'id' => 'business-info-form' ]) !!}
    @include('businesses/forms/info')
  {!! Form::close() !!}
</div>
@endsection
