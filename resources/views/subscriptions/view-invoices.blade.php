@extends('app')
@section('content')
<div class="col-md-8 col-xs-12">
  <h2 class="section-header">
    <i class="icon-credit-card"></i> Invoices
  </h2>
  <div class="col-xs-12 no-pad">
    <table class="table table-striped">
      <tr>
        <th>Amt. Due</th>
        <th>Status</th>
        <th>Date</th>
      </tr>
      @forelse($invoices as $invoice)
      <tr>
        <td>${{$invoice->amount_due}}</td>
        <td>{!! $invoice->paid ? '<font style="color:green; font-weight:bold;">Paid</font>' : '<font style="color:red;font-weight:bold;">Unpaid</font>' !!}</td>
        <td>{{ $invoice->created_at->toFormattedDateString() }}</td>
      </tr>
      @empty
        <tr>
          <td>No invoices</td>
        </tr>
      @endforelse
    </table>
  </div>
</div>
@include('components/sidebar')
@endsection
