@extends('app')
@section('content')

<div class="{{ $page->sidebar ? 'col-md-8 col-xs-12' : 'col-xs-12' }} cms-content">
  <h2 class="section-header">{{ $page->title }}</h2>
  {!! $page->content !!}
</div>

@if($page->sidebar)
  @include('components/sidebar')
@endif
@endsection
