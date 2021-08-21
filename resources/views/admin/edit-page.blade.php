@extends('app')
@section('content')
<div class="col-xs-12">
  <h2 class="section-header">
    @if(!$blog)
      <i class="icon-note"></i> Edit Page
    @else
      <i class="icon-note"></i> Edit Blog
    @endif
  </h2>
  <form id="page-form" action="{{ route( 'Update Page', ['id' => $page->id] ) }}" method="POST">
    {{ csrf_field() }}

    @if($blog)
      <input type="hidden" name="blog" value="yes" />
    @endif

    <button type="submit" class="btn btn-lg btn-primary pull-right" style="margin-top: -55px;">Update</button>

    <div class="row">

      <div class="form-group col-sm-6">
        <label for="title">Title</label>
        <input id="title" type="text" name="title" class="form-control" placeholder="Ex. About" value="{{ $page->title }}" />
      </div>

      <div class="form-group col-sm-6">
        <label for="slug">Slug</label>
        <input id="slug" type="text" name="slug" class="form-control" value="{{ $page->slug }}" readonly/>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="active">
        <input type="checkbox" name="active" {{ $page->active ? 'checked' : '' }} /> &nbsp;&nbsp;Active</label>
        <p>* Is this page accessible?</p>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="show_in_nav">
        <input type="checkbox" name="show_in_nav" {{ $page->show_in_nav ? 'checked' : '' }} /> &nbsp;&nbsp;Show in Nav?</label>
        <p>* If this is checked this page will show up in the top navigation area.</p>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="show_in_footer">
        <input type="checkbox" name="show_in_footer" {{ $page->show_in_footer ? 'checked' : '' }} /> &nbsp;&nbsp;Show in Footer?</label>
        <p>* If this is checked this page will show up in the footer area.</p>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="sidebar">
        <input type="checkbox" name="sidebar" {{ $page->sidebar ? 'checked' : '' }} /> &nbsp;&nbsp;Sidebar</label>
        <p>* Does the sidebar show alongside the content?</p>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="public">
        <input type="checkbox" name="public" {{ $page->public ? 'checked' : '' }} /> &nbsp;&nbsp;Public</label>
        <p>* Is this page accessible for non-logged in users?</p>
      </div>

      <div class="form-group col-xs-12">
        <label for="content">Content</label>
        <input id="content-holder" type="hidden" name="content" value="{{ $page->content }}"/>
        <div id="editor" style="min-height:200px;">{!! $page->content !!}</div>
      </div>

      <div class="form-group col-xs-12">
        <button type="submit" class="btn btn-lg btn-primary">Update</button>
      </div>

    </div>
  </form>
</div>

@endsection
