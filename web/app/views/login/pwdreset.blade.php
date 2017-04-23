@extends('master/index')
@section('meta_title')
{{ strip_tags('Password Reset') }} - {{ siteSettings('siteName') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Password Reset') }}</h1>
</div>
<div class="row">
    {{ Form::open() }}
    <input type="hidden" name="token" value="{{ $token }}">
    <div class="form-group">

        <label for="email">{{ t('Email') }}<small>*</small></label>
        {{ Form::text('email','',['class'=>'form-control','id'=>'email','placeholder'=>'Your Email','required'=>'required']) }}

    </div>
    <div class="form-group">
        <label for="password">{{ t('New Password') }}<small>*</small></label>
        {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>'Enter Password','autocomplete'=>'off','required'=>'required']) }}
    </div>

    <div class="form-group">
        <label for="password_confirmation">{{ t('Retype Confirmation') }}<small>*</small></label>
        {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=>'Confirm Password','autocomplete'=>'off','required'=>'required']) }}
    </div>
    {{ Form::submit('Reset Password',['class'=>'btn btn-success'])}}
    {{ Form::close() }}
</div>
@stop