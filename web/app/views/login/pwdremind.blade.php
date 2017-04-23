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
    <div class="form-group">
        <label for="email">Email
            <small>*</small>
        </label>
        {{ Form::text('email','',['class'=>'form-control','id'=>'email','placeholder'=>'Your Email','required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="recaptcha">Type these words
            <small>*</small>
        </label>
        {{ app('captcha')->display() }}
    </div>

    {{ Form::submit('Reset Password',['class'=>'btn btn-success'])}}
    {{ Form::close() }}
</div>
@stop