@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-user"></i> Add A Partner
  </h2>
  {!! Form::model($partner, ['route' => ['Store Partner', $partner->id], 'files' => true, 'name' => 'partner-info', 'id' => 'partner-info-form' ]) !!}
    @include('partner/forms/info')
  {!! Form::close() !!}
</div>
@include('components/sidebar')

@endsection
