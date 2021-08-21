@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-tag"></i> Sale Info - {{ $business->name }}
  </h2>
  {!! Form::model($sale_info, ['route' => ['Update Sale Info'], 'name' => 'sale-info', 'id' => 'sale-info-form' ]) !!}
    <div class="form-group clearfix">
      <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
        <label for="ein">EIN or Business License #</label>
        {!! Form::text('ein', $sale_info->ein, ['class' => 'form-control', 'required' => true]) !!}
      </div>
      <div class="col-md-6 col-xs-12 no-pad-right no-pad-small">
        <label for="sale_price">Sale Price</label>
        {!! Form::text('sale_price', $sale_info->sale_price, ['class' => 'form-control', 'required' => true]) !!}
      </div>
    </div>

    <div class="form-group clearfix">
      <div class="col-md-6 col-xs-12 no-pad-left no-pad-small">
        <label for="established">Year Established</label>
        {!! Form::text('established', $sale_info->established, ['class' => 'form-control', 'required' => true]) !!}
      </div>
      <div class="col-md-6 col-xs-12 no-pad-right no-pad-small">
        <label for="gross_income">Income (Gross)</label>
        {!! Form::text('gross_income', $sale_info->gross_income, ['class' => 'form-control', 'required' => true]) !!}
      </div>
    </div>

    <div class="form-group clearfix">
      <div class="col-xs-12 no-pad">
        <label for="reason">Reason for Selling Business</label>
        {!! Form::textarea('reason', $sale_info->reason, ['class' => 'form-control', 'required' => true]) !!}
      </div>
    </div>

    <div class="form-group clearfix">
      <div class="col-sm-12 no-pad">
        <label for="for_sale">Currently For Sale? (If yes, your business will show up in for sale listings in search)</label>
        <div class="radio">
          <label class="pull-left" style="display: block;max-width: 70px;">
            {!! Form::radio('for_sale', 1, isset($sale_info->business) ? $sale_info->business->for_sale == 1 : true) !!} Yes
          </label>
          <label class="pull-left" style="display: block;max-width: 70px;">
            {!! Form::radio('for_sale', 0, isset($sale_info->business) ? $sale_info->business->for_sale == 0 : false) !!} No
          </label>
        </div>
      </div>
    </div>

    <hr/>

    <div class="button-group">
      <button class="btn btn-primary btn-lg" type="submit" style="margin-right: 20px">Save Sale Info</button>
      <a href="{{ url()->previous() }}">Cancel</a>
    </div>

  {!! Form::close() !!}
</div>
@include('components/sidebar')

@endsection
