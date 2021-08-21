@extends('app')
@section('content')

  <div class="col-md-8 col-xs-12">
    <h2 class="section-header">SpotzCity Blog</h2>

    @foreach ($blogs as $blog)
      <div class="row">
        <div class="col-xs-12">
          <a href="/p/{{ $blog->slug }}">
            <h3 class="blog-title">{{ $blog->title }}</h3>
            <small style="text-decoration:none;color: gray;">Posted {{ $blog->created_at->format('m-d-y') }}</small>
          </a>
          <hr/>
        </div>
      </div>
    @endforeach
  </div>

  @include('components/sidebar')

@endsection
