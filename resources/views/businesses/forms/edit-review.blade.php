@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-pencil"></i> Edit Review for {{ $business->name }}
  </h2>
  {!! Form::model($review, ['route' => ['Update Review', $business->id], 'name' => 'write-review', 'id' => 'write-review-form' ]) !!}
    <div class="form-group">
      <label for="business_name">Rating</label>
      <!-- RatingBar -->
      <div id="rating-bar" data-interactive="true">
        <ul class="rating-icons">
          <li>
            <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive icon-star" data-rating-level="1"></i>
          </li>
          <li>
            <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive icon-star" data-rating-level="2"></i>
          </li>
          <li>
            <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive icon-star" data-rating-level="3"></i>
          </li>
          <li>
            <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive icon-star" data-rating-level="4"></i>
          </li>
          <li>
            <img src="{{ asset('assets/images/logo-symbol-only.png') }}" class="rating-icon inactive icon-star" data-rating-level="5"></i>
          </li>
        </ul>
        {!! Form::text('rating', $review->rating, ['class' => 'form-control hidden', 'id' => 'rating-input', 'required' => true]) !!}
      </div>

      <label for="body">Review</label>
      {!! Form::textarea('body', $review->body, ['class' => 'form-control', 'required' => true]) !!}
    </div>
    <div class="button-group">
      <button class="btn btn-primary btn-lg" style="margin-right: 20px">Update Review</button>
      <a href="{{ url()->previous() }}">Go Back</a>
    </div>
  {!! Form::close() !!}
</div>
@include('components/sidebar')

@endsection
