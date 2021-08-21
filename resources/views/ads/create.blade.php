@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-badge"></i>
    @if($edit)
      Update Your Ad
    @else
      Create an Ad
    @endif
  </h2>
  @if($edit && !$ad->edit_id)
    {!! Form::model($ad, ['route' => ['Update Ad', $ad->id], 'files' => true, 'name' => 'ad-info', 'id' => 'ad-info-form' ]) !!}
  @else
    {!! Form::model($ad, ['route' => ['Store Ad'], 'files' => true, 'name' => 'ad-info', 'id' => 'ad-info-form' ]) !!}
  @endif
    <div class="form-group clearfix">
      @if($ad->edit_id)
        <input type="hidden" name="edit_id" value="{{ $ad->edit_id }}"/>
      @endif

      <div class="col-xs-12 no-pad">
        <label for="type">Type</label>
        @if($edit)
          {!! Form::select('type', array(
              'main-banner-bb' => 'Main Page Banner - Big Business - $250/mo',
              'main-banner-sb' => 'Main Page Banner - Small Business - $100/mo',
              'main-sidebar-bb' => 'Main Page Sidebar - Big Business - $225/mo',
              'main-sidebar-sb' => 'Main Page Sidebar - Small Business - $80/mo',
              'sub-banner-bb' => 'Sub Page Banner - Big Business - $200/mo',
              'sub-banner-sb' => 'Sub Page Banner - Small Business - $70/mo',
              'sub-sidebar-bb' => 'Sub Page Sidebar - Big Business - $175/mo',
              'sub-sidebar-sb' => 'Sub Page Sidebar - Small Business - $60/mo'
            ),
            $ad->type,
            ['class' => 'form-control', 'required' => true, 'disabled' => $edit]) !!}
            <input type="hidden" name="type" value="{{ $ad->type }}"/>
        @else
          {!! Form::select('type', array(
            'main-banner-bb' => 'Main Page Banner - Big Business - $250/mo',
            'main-banner-sb' => 'Main Page Banner - Small Business - $100/mo',
            'main-sidebar-bb' => 'Main Page Sidebar - Big Business - $225/mo',
            'main-sidebar-sb' => 'Main Page Sidebar - Small Business - $80/mo',
            'sub-banner-bb' => 'Sub Page Banner - Big Business - $200/mo',
            'sub-banner-sb' => 'Sub Page Banner - Small Business - $70/mo',
            'sub-sidebar-bb' => 'Sub Page Sidebar - Big Business - $175/mo',
            'sub-sidebar-sb' => 'Sub Page Sidebar - Small Business - $60/mo'
          ),
          $ad->type,
          ['class' => 'form-control', 'required' => true]) !!}
        @endif
      </div>
    </div>

    <div class="form-group clearfix">

      <div class="col-xs-6 no-pad-left">
        <label for="ad_name">Name</label>
        {!! Form::text('ad_name', $ad->name, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
      </div>

      <div class="col-xs-6 no-pad-right">
        <label for="url">URL</label>
        {!! Form::text('url', $ad->url, ['class' => 'form-control', 'required' => true]) !!}
      </div>

    </div>

    <div class="form-group clearfix">

      <div class="col-xs-12 no-pad">
        <label for="ad">
          Ad Image
          <font id="ad-dimensions"></font>
        </label>
        <!-- React Component: AdDrop -->
          <div id="ad-drop"
            @if($edit)
              image={{ asset("assets/storage/$ad->image") }}
              @if($ad->sizeType() === "banner")
                banner-edit="true"
              @else
                sidebar-edit="true"
              @endif
            @endif
          ></div>
        <!-- End Component -->
      </div>

    </div>

    @if(!\Auth::user()->admin)
      <button type="submit" class="btn btn-primary btn-lg" style="margin-right:10px;">
        @if($edit)
          @if($ad->edit_id)
            Submit Edits for Approval
          @else
            Update Ad
          @endif
        @else
          Submit Ad for Approval
        @endif
      </button>
    @else
      <a href="{{ route('Approve Ad', ['id' => $ad->id]) }}" class="btn btn-primary btn-lg" style="margin-right:10px;">Approve Ad</a>
    @endif
    <a href="{{ url()->previous() }}">Cancel</a>
    <br/>
    <hr/>
    @if($edit)
      @if($ad->edit_id)
        <p class="text-center" style="padding: 0px 20px;">* Edits to activated ads must be approved before appearing. Your ad will automatically update on the site after approval.</p>
      @else
        <p class="text-center" style="padding: 0px 20px;">* Ads must be approved before they can be activated. You will not be charged until you activate your ad.</p>
      @endif
    @else
      <p class="text-center" style="padding: 0px 20px;">* Ads must be approved before they can be activated. You will not be charged until you activate your ad.</p>
    @endif

  {!! Form::close() !!}
</div>
@include('components/sidebar')

@endsection
