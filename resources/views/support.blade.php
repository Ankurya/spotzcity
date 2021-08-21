@extends('app')
@section('content')

<div class="col-md-8 col-xs-12 about">
  <h2 class="section-header">
    <i class="icon-info"></i> Support
  </h2>
  <!-- CONTACT FORM -->
  <h4 style="margin-top: 30px;">Contact Us Directly</h3>
  <p style="margin-bottom: 10px;">Feel free to explain the issue or concern in the form below. We will do our best to respond promptly to whatever you need.</p>
  {!! Form::model($contact_request, ['route' => 'Create Contact Request', 'name' => 'contact-request', 'id' => 'contact-request' ]) !!}
    <div class="row">
      <div class="col-xs-12 form-group">
        <label for="name">Name*</label>
        {!! Form::text('name', $contact_request->name, ['class' => 'form-control', 'required' => true, 'autofocus' => true]) !!}
      </div>
      <div class="col-xs-6 form-group">
        <label for="email">Email*</label>
        {!! Form::text('email', $contact_request->email, ['class' => 'form-control', 'required' => true]) !!}
      </div>
      <div class="col-xs-6 form-group">
        <label for="phone">Phone (Optional)</label>
        {!! Form::text('phone', $contact_request->phone, ['class' => 'form-control']) !!}
      </div>
      <div class="col-xs-12 form-group">
        <label for="subject">Subject*</label>
        {!! Form::text('subject', $contact_request->subject, ['class' => 'form-control', 'required' => true]) !!}
      </div>
      <div class="col-xs-12 form-group">
        <label for="message">Message*</label>
        {!! Form::textarea('message', $contact_request->message, ['class' => 'form-control', 'required' => true]) !!}
      </div>
    </div>
    <div class="row form-row" style="margin:30px -15px 20px;">
      <div class="col-xs-12">
        <button class="btn btn-primary btn-lg pull-left">Submit</button>
        <h5 class="pull-left" style="margin-left: 10px;">
          <a href="{{ url()->previous() }}">Go Back</a>
        </h5>
        <br/>
        <br/>
        <p class="text-center" style="clear: both;margin-top: 20px;">* Required Fields.</p>
      </div>
    </div>
  {!! Form::close() !!}
</div>

@include('components/sidebar')
@endsection
