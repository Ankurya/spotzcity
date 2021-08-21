@extends('app')
@section('content')
<div class="col-md-8 col-xs-12" id="categories-admin-form">
  <h2 class="section-header" style="margin-bottom: 40px;">
    <i class="icon-directions"></i> Categories
  </h2>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#diversity" aria-controls="diversity" role="tab" data-toggle="tab">Diversity</a></li>
    <li role="presentation"><a href="#business" aria-controls="business" role="tab" data-toggle="tab">Business</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="diversity">
      @foreach ($e_categories as $e_category)
        <div class="row" style="margin-top:10px;margin-bottom:10px;">
          <div class="col-xs-5">
            <input class="form-control" name="ecat-{{ $e_category->id }}" value="{{ $e_category->name }}" />
          </div>
          <div class="col-xs-2">
            <button data-type="ecat" data-id="{{ $e_category->id }}" class="btn btn-primary update-category">Update</button>
          </div>
          <div class="col-xs-3">
            <a class="text-danger removal" data-name="{{ $e_category->name }}" href="/admin/categories/delete/{{ $e_category->id }}">Remove</a>
          </div>
        </div>
      @endforeach
      <div class="row" style="margin-top: 30px;">
        <div class="col-xs-5">
          <label>Add New Diversity Category</label>
          <input name="ecat-new" class="form-control" placeholder="New Diversity" />
        </div>
        <div class="col-xs-3">
          <button data-type="ecat" class="btn btn-primary create-category" style="margin-top:25px;">Update</button>
        </div>
      </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="business">
      @foreach ($commodities as $commodity)
        <div class="row" style="margin-top:10px;margin-bottom:10px;">
          <div class="col-xs-5">
            <input class="form-control" name="comm-{{ $commodity->id }}" value="{{ $commodity->name }}" />
          </div>
          <div class="col-xs-2">
            <button data-type="comm" data-id="{{ $commodity->id }}" class="btn btn-primary update-category">Update</button>
          </div>
          <div class="col-xs-3">
            <a class="text-danger removal" data-name="{{ $commodity->name }}" href="/admin/commodities/delete/{{ $commodity->id }}">Remove</a>
          </div>
        </div>
      @endforeach
      <div class="row" style="margin-top: 40px;">
        <div class="col-xs-5">
          <label>Add New Business Category</label>
          <input class="form-control" name="comm-new" placeholder="New Category" />
        </div>
        <div class="col-xs-3">
          <button data-type="comm" class="btn btn-primary create-category" style="margin-top:25px;">Update</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const removalLinks = Array.prototype.slice.call(document.querySelectorAll('a.removal'));
  removalLinks.forEach(link => {
    link.addEventListener("click", event => {
      console.log(event)
      event.preventDefault()
      let c = confirm(`Are you sure you want to delete ${event.target.getAttribute('data-name')}?`);
      if(c) {
        window.location.href = event.target.href
      }
    });
  });
</script>
@include('components/sidebar')
@endsection
