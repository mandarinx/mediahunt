@extends('master/index')
@section('meta_title')
{{ strip_tags('Registration') }} - {{ siteSettings('siteName') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Registration') }}</h1>
</div>
@if (Session::has('error'))
<div class="alert alert-danger fade in">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>{{ trans(Session::get('reason')) }}</strong>
</div>
@endif
<div class="row">
    <p><a href="{{ url('get/facebook') }}"><img src="{{ asset('static/img/facebook.png') }}"></a>&nbsp;<a href="{{ url('get/google') }}"><img src="{{ asset('static/img/google.png') }}"></a></p>
    {{ Form::open() }}
    <div class="form-group">
        <label for="username">{{ t('Select Username') }}
            <small>*</small>
        </label>
        {{ Form::text('username',null,['class'=>'form-control','id'=>'username','placeholder'=>t('Select Username'),'required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="email">{{ t('Your Email') }}
            <small>*</small>
        </label>
        {{ Form::text('email',null,['class'=>'form-control','type'=>'email','id'=>'email','placeholder'=>t('Your Email'),'required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="fullname">{{ t('Your Full Name') }}
            <small>*</small>
        </label>
        {{ Form::text('fullname',null,['class'=>'form-control','id'=>'fullname','placeholder'=>t('Your Full Name'),'required'=>'required']) }}
    </div>

    <div class="form-group">
        <label for="gender">{{ t('Gender') }}
            <small>*</small>
        </label>
        {{ Form::select('gender', ['male' => t('Male'), 'female' => t('Female')], 'male',['id'=>'gender','class'=>'form-control','required'=>'required']) }}
    </div>


    <div class="form-group">
        <label for="password">{{ t('Password') }}
            <small>*</small>
        </label>
        {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>t('Enter Password'),'autocomplete'=>'off','required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="password_confirmation">{{ t('Retype Password') }}
            <small>*</small>
        </label>
        {{ Form::password('password_confirmation',['class'=>'form-control','id'=>'password_confirmation','placeholder'=> t('Confirm Password'),'autocomplete'=>'off','required'=>'required']) }}
    </div>
    <div class="form-group">
        <label for="recaptcha">{{ t('Type these words') }}
            <small>*</small>
        </label>
        {{ app('captcha')->display() }}
    </div>
    <p>
        <small>{{ t('policy.by_clicking') }} <a href="{{ url('tos') }}">{{ t('policy.terms_and_conditions') }}</a> {{ t('policy.and_our') }} <a href="{{ url('privacy') }}">privacy policy</a></small>
    </p>
    {{ Form::submit(t('Create New Account'),['class'=>'btn btn-success']) }}
    {{ Form::close() }}
    </div>
@stop