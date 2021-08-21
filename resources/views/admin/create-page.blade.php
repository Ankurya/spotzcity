@extends('app')
@section('content')
<div class="col-xs-12">
  <h2 class="section-header">
    @if(!$blog)
      <i class="icon-note"></i> Create Page
    @else
      <i class="icon-note"></i> Create Blog
    @endif
  </h2>
  <form id="page-form" action="{{ route( 'Store Page' ) }}" method="POST">
    {{ csrf_field() }}

    @if($blog)
      <input type="hidden" name="blog" value="yes" />
    @endif

    <button type="submit" class="btn btn-lg btn-primary pull-right" style="margin-top: -55px;">Create</button>

    <div class="row">

      <div class="form-group col-sm-6">
        <label for="title">Title</label>
        <input id="title" type="text" name="title" class="form-control" placeholder="Ex. About" />
      </div>

      <div class="form-group col-sm-6">
        <label for="slug">Slug</label>
        <input id="slug" type="text" name="slug" class="form-control" readonly/>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="active">
        <input type="checkbox" name="active" @if($blog) checked @endif /> &nbsp;&nbsp;Active</label>
        <p>* Is this page accessible?</p>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="show_in_nav">
        <input type="checkbox" name="show_in_nav" /> &nbsp;&nbsp;Show in Nav?</label>
        <p>* If this is checked this page will show up in the top navigation area.</p>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="show_in_footer">
        <input type="checkbox" name="show_in_footer" /> &nbsp;&nbsp;Show in Footer?</label>
        <p>* If this is checked this page will show up in the footer area.</p>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="sidebar">
        <input type="checkbox" name="sidebar" @if($blog) checked @endif /> &nbsp;&nbsp;Sidebar</label>
        <p>* Does the sidebar show alongside the content?</p>
      </div>

      <div class="form-group col-sm-4 @if($blog) hidden @endif">
        <label for="public">
        <input type="checkbox" name="public" @if($blog) checked @endif /> &nbsp;&nbsp;Public</label>
        <p>* Is this page accessible for non-logged in users?</p>
      </div>

      <div class="form-group col-xs-12">
        <label for="content">Content</label>
        <input id="content-holder" type="hidden" name="content"/>
        <div id="editor" style="min-height:200px;"></div>
      </div>

      <div class="form-group col-xs-12">
        <button type="submit" class="btn btn-lg btn-primary">Create</button>
      </div>

    </div>
  </form>
</div>

@endsection
