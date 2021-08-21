@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header" style="margin-bottom: 40px;">
    @if(!$isBlog)
      <i class="icon-note"></i> Pages
      <a href="/pages/create" class="btn btn-primary btn-lg pull-right">Create New Page</a>
    @else
      <i class="icon-note"></i> Blog Posts
      <a href="/pages/create?blog=true" class="btn btn-primary btn-lg pull-right">Create New Blog</a>
    @endif
  </h2>
  @foreach( $pages as $page )
      <div class="row" style="margin-bottom: 20px;">
        <div class="col-sm-6">
          <h4>{{ $page->title }}</h4>
        </div>
        <div class="col-sm-6 text-right">
          <a class="btn btn-md btn-primary" href="{{ route( 'Show Page', [ 'slug' => $page->slug ] ) }}">View</a>
          @if(!$isBlog)
            <a class="btn btn-md btn-info" href="{{ route( 'Edit Page', [ 'id' => $page->id ] ) }}">Edit</a>
          @else
            <a class="btn btn-md btn-info" href="/pages/edit/{{ $page->id }}?blog=true">Edit</a>
          @endif
          <a class="btn btn-md btn-danger delete-page" href="{{ route( 'Delete Page', [ 'id' => $page->id ] ) }}">Delete</a>
        </div>
      </div>
  @endforeach
</div>
@include('components/sidebar')
@endsection
