@extends('master/index')
@section('meta_title')
{{ strip_tags('Login') }} - {{ siteSettings('siteName') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Login') }}</h1>
</div>
<div class="row">
    <p><a href="{{ url('get/facebook') }}"><img src="{{ asset('static/img/facebook.png') }}"></a>&nbsp;<a href="{{ url('get/google') }}"><img src="{{ asset('static/img/google.png') }}"></a></p>
    {{ Form::open() }}
    <div class="form-group">
        <label for="username">{{ t('Username or Email') }}</label>
        {{ Form::text('username','',['class'=>'form-control','placeholder' => t('Username or Email')]) }}
    </div>

    <div class="form-group">
        <label for="password">{{ t('Password') }}</label>
        {{ Form::password('password',['class'=>'form-control','id'=>'password','placeholder'=>t('Password'),'autocomplete'=>'off']) }}
    </div>

    <div class="form-group">
        {{ Form::checkbox('remember-me', 'value') }}
        <label>
            {{ t('Remember Me') }}
        </label>
        &nbsp;&middot;&nbsp; <a href="{{ url('password/remind') }}">{{ t('Forgot your password?') }}</a>
    </div>

    <div class="form-group">
        {{ Form::submit(t('Login'),['class'=>'btn btn-info']) }}
    </div>

    {{ Form::close() }}
    <p><strong>{{ t('Don\'t have an account yet?') }} <a href="{{ route('registration') }}">{{ t('Sign up here.') }}</a></strong></p>
</div>
@stop