@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-credit-card"></i> Manage Subscriptions
  </h2>
  <div class="col-xs-12 no-pad">
    @if($ad || $resources)
      <h3 style="margin-top: 0px;margin-bottom: 15px;">
        Activate
        @if($ad)
          {{ $ad->name }} &nbsp;<small>({{ ucfirst($ad->sizeType()) }})</small>
        @elseif($resources)
          Resources Subscription
        @endif
      </h3>
      <div class="col-xs-12 due-today">
        <h4 class="pull-left">
          @if($ad)
            <i>Total Today: ${{ $ad->fetchPlanInfo()->amount / 100 }}</i>
          @elseif($resources)
            <i>Total Today: ${{ SpotzCity\Billing::fetchResourceSubscriptionPrice()->amount / 100 }}</i>
          @endif
        </h4>
        @if(\Auth::user()->hasPaymentSources())
          @if($ad)
            <a href="{{ route('Activate Ad', ['ad_id' => $ad->id]) }}" class="btn btn-primary pull-right">Use Current Card</a>
          @elseif($resources)
            <a href="{{ route('Activate Resources') }}" class="btn btn-primary pull-right">Use Current Card</a>
          @endif
        @endif
      </div>
      @if(\Auth::user()->hasPaymentSources())
        <div class="cards-list clearfix">
          @foreach(\Auth::user()->billing->payment_sources as $card)
            <div class="col-xs-12 card no-pad">
              <div class="pull-left">
                <p>
                  <strong>{{ $card->type }}</strong> ending in {{ $card->last_four }} (Expires {{ $card->exp_month }}/{{ $card->exp_year }})&nbsp;
                  @if($card->id == \Auth::user()->billing->default_card)
                    <strong>Current*</strong>
                  @endif
                </p>
              </div>
              <div class="pull-right">
                <div class="btn-group">
                  @if($ad)
                    <a class="btn btn-primary btn-sm" href="{{ route('Activate Ad', ['ad_id' => $ad->id, 'card_id' => $card->id]) }}"
                      @if($card->id != \Auth::user()->billing->default_card)
                        onclick="return confirm('Selecting this card will switch all existing subscriptions to use this card. Continue?');"
                      @endif
                    >Use Card</a>
                  @elseif($resources)
                    <a class="btn btn-primary btn-sm" href="{{ route('Activate Resources', ['card_id' => $card->id]) }}"
                      @if($card->id != \Auth::user()->billing->default_card)
                        onclick="return confirm('Selecting this card will switch all existing subscriptions to use this card. Continue?');"
                      @endif
                    >Use Card</a>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
      <h4 style="clear:both;">Add New Card</h4>
      @if($ad)
        {!! Form::model($edit_card, ['route' => ['Add Card', $ad->id], 'name' => 'card', 'id' => 'card-form' ]) !!}
          @include('subscriptions/forms/card')
          @if(!\Auth::user()->hasPaymentSources())
            <button type="submit" class="btn btn-primary btn-lg">Activate Ad</button>
          @else
            <button type="submit" onclick="return confirm('Activating with a new card will switch all existing subscriptions to use the new card. Continue?');" class="btn btn-primary btn-lg">Activate with New Card</button>
          @endif
        {!! Form::close() !!}
      @elseif($resources)
        {!! Form::model($edit_card, ['route' => ['Add Card', 'resources'], 'name' => 'card', 'id' => 'card-form' ]) !!}
          @include('subscriptions/forms/card')
          @if(!\Auth::user()->hasPaymentSources())
            <button type="submit" class="btn btn-primary btn-lg">Activate Subscription</button>
          @else
            <button type="submit" onclick="return confirm('Activating with a new card will switch all existing subscriptions to use the new card. Continue?');" class="btn btn-primary btn-lg">Activate with New Card</button>
          @endif
      @endif
    @else
      @if(\Auth::user()->hasSubscriptions())
        <h4 style="clear:both;">Current Subscriptions</h4>
        <div class="cards-list clearfix">
          @foreach(\Auth::user()->billing->subscriptions as $subscription)
            <div class="col-xs-12 card no-pad">
              <div class="pull-left">
                @if($subscription->type !== 'resources')
                  <p><strong>{{ $subscription->ad()->name }}</strong> - {{ $subscription->parsedType() }} - ${{ $subscription->monthly_cost }}/mo</p>
                @else
                  <p><strong>Resources</strong> - ${{ $subscription->monthly_cost }}/mo
                @endif
              </div>
              <div class="pull-right">
                <div class="btn-toolbar">
                  <a class="btn btn-primary btn-sm" href="{{ route('View Invoices', ['id' => $subscription->id]) }}">Invoices</a>
                  @if($subscription->type !== 'resources')
                    <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this subscription? Your ad will be immediately deactivated.');" href="{{ route('Deactivate Ad', ['id' => $subscription->ad()->id]) }}">Cancel</a>
                  @else
                    <a class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to cancel this subscription?');" href="{{ route('Deactivate Resources') }}">Cancel</a>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
      @if(\Auth::user()->hasPaymentSources())
        <h4 style="clear:both;">Cards on File</h4>
        <div class="cards-list clearfix">
          @foreach(\Auth::user()->billing->payment_sources as $card)
            <div class="col-xs-12 card no-pad">
              <div class="pull-left">
                <p>
                  <strong>{{ $card->type }}</strong> ending in {{ $card->last_four }} (Expires {{ $card->exp_month }}/{{ $card->exp_year }})&nbsp;
                  @if($card->id == \Auth::user()->billing->default_card)
                    <strong>Current*</strong>
                  @endif
                </p>
              </div>
              <div class="pull-right">
                <div class="btn-toolbar">
                  <a class="btn btn-primary btn-sm" href="{{ route('Set Default Card', ['card_id' => $card->id]) }}"
                    @if($card->id != \Auth::user()->billing->default_card)
                      onclick="return confirm('Selecting this card will switch all existing subscriptions to use this card. Continue?');"
                    @else
                      onclick="return false;"
                      disabled
                    @endif
                  >Use Card</a>
                  <a class="btn btn-danger btn-sm" href="{{ route('Delete Card', ['card_id' => $card->id]) }}"
                    @if($card->id != \Auth::user()->billing->default_card)
                      onclick="return confirm('Are you sure you want to delete this card?');"
                    @else
                      onclick="return false;"
                      disabled
                    @endif
                  >Delete</a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
      @if(\Auth::user()->hasSubscriptions())
        <h4 style="clear:both;">Add New Card</h4>
        {!! Form::model($edit_card, ['route' => ['Add Card'], 'name' => 'card', 'id' => 'card-form' ]) !!}
          @include('subscriptions/forms/card')
          <button type="submit" class="btn btn-primary btn-lg">Add Card</button>
        {!! Form::close() !!}
      @else
        <h4>No current subscriptions</h4>
      @endif
    @endif
  </div>
</div>
@include('components/sidebar')
@endsection
