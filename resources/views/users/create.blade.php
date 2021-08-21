@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-user"></i> Create Admin
  </h2>
  {!! Form::model($user, ['route' => ['Store Admin', $user->id], 'files' => true, 'name' => 'user-info', 'id' => 'user-info-form' ]) !!}
    @include('users/forms/info')
  {!! Form::close() !!}
</div>
@include('components/sidebar')

@endsection
