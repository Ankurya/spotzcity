<div class="form-group clearfix">
  <div class="col-xs-12 no-pad">
    <label for="card_number">Card Number</label>
    {!! Form::number('card_number', $edit_card->number, ['class' => 'form-control', 'required' => true]) !!}
  </div>
</div>
<div class="form-group clearfix">
  <div class="col-md-7 col-xs-12 no-pad-left no-pad-small">
    <label for="card_name">Name on Card</label>
    {!! Form::text('card_name', $edit_card->number, ['class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="col-md-5 col-xs-12 no-pad-right no-pad-small">
    <label for="zip">ZIP</label>
    {!! Form::number('zip', $edit_card->zip, ['class' => 'form-control', 'required' => true]) !!}
  </div>
</div>
<div class="form-group clearfix">
  <div class="col-md-5 col-xs-6 no-pad-left no-pad-small">
    <label for="exp_month">Exp. Month</label>
    {!! Form::select('exp_month', array(
      '01'=>'Jan - 01',
      '02'=>'Feb - 02',
      '03'=>'Mar - 03',
      '04'=>'Apr - 04',
      '05'=>'May - 05',
      '06'=>'Jun - 06',
      '07'=>'Jul - 07',
      '08'=>'Aug - 08',
      '09'=>'Sep - 09',
      '10'=>'Oct - 10',
      '11'=>'Nov - 11',
      '12'=>'Dec - 12'
    ),
    $edit_card->exp_month,
    ['class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="col-md-4 col-xs-12 no-pad-small">
    <label for="exp_year">Exp. Year</label>
    {!! Form::select('exp_year', $years, $edit_card->exp_month, ['class' => 'form-control', 'required' => true]) !!}
  </div>
  <div class="col-md-3 col-xs-12 no-pad-small no-pad-right">
    <label for="cvv">CVV</label>
    {!! Form::number('cvv', $edit_card->cvv, ['class' => 'form-control', 'required' => true]) !!}
  </div>
  <input type="hidden" name="card_token">
</div>
