@extends('master/index')

@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Profile Settings')}}</h1>
</div>

<div class="row">
    {{ Form::open(['url' => 'settings/avatar', 'files' => true,'role'=>'form']) }}
    <div class="form-group">
        <label for="avatar">{{ t('Avatar') }}</label>
        <input type="file" name="avatar"/>
    </div>
    <div class="form-group">
        {{ Form::submit(t('Update Avatar'),['class'=>'btn btn-default btn-success']) }}
    </div>
    {{ Form::close() }}

    <h3 class="page-header">{{ t('Basic Settings')}}</h3>
    {{ Form::open(['url'=>'settings/profile']) }}
    <div class="form-group">
        <label for="fullname">{{ t('Fullname') }}</label>
        {{ Form::text('fullname',Auth::user()->fullname,['class'=>'form-control','placeholder' => t('Fullname')]) }}
    </div>

    <div class="form-group">
        <label for="gender">{{ t('Gender') }}
            <small>*</small>
        </label>
        {{ Form::select('gender', ['male' => t('Male'), 'female' => t('Female')], Auth::user()->gender, ['id'=>'gender','class'=>'form-control','required'=>'required']) }}
    </div>

    <div class="form-group">
        <label for="blogurl">{{ t('Facebook Profile') }}
            <small>( {{ t('Your Facebook Profile Link') }} )</small>
        </label>
        {{ Form::text('fbLink',Auth::user()->fb_link,['class'=>'form-control']) }}
    </div>

    <div class="form-group">
        <label for="blogurl">{{ t('Twitter Profile') }}
            <small>( {{ t('Your Twitter Profile Link') }} )</small>
        </label>
        {{ Form::text('twLink',Auth::user()->tw_link,['class'=>'form-control']) }}
    </div>

    <div class="form-group">
        <label for="blogurl">{{ t('Blog url') }}
            <small>( {{ t('Your blog or social profile url') }} )</small>
        </label>
        {{ Form::text('blogurl',Auth::user()->blogurl,['class'=>'form-control']) }}
    </div>

    <div class="form-group">
        {{ Form::submit(t('Submit'),['class'=>'btn btn-info']) }}
    </div>
    {{ Form::close() }}

    <h3 class="page-header">{{ t('Email Settings')}}</h3>
    {{ Form::open(['url' => 'settings/mailsettings', 'method' => 'POST']) }}
    <div class="form-group">
        <label for="emailcomment">{{ t('Email me when someone comment') }}</label>
        {{ Form::checkbox('emailcomment',1,Auth::user()->email_comment) }}
    </div>
    <div class="form-group">
        <label for="emailreply">{{ t('Email me when someone reply on my comment') }}</label>
        {{ Form::checkbox('emailreply',1,Auth::user()->email_reply) }}
    </div>
    <div class="form-group">
        <label for="emailfavorite">{{ t('Email me when someone upvote my posts') }}</label>
        {{ Form::checkbox('emailfavorite',1,Auth::user()->email_favorite) }}
    </div>
    <div class="form-group">
        <label for="emailfollow">{{ t('Email me when someone follow me') }}</label>
        {{ Form::checkbox('emailfollow',1,Auth::user()->email_follow) }}
    </div>
    <div class="form-group">
        {{ Form::submit(t('Update Mail Settings'),['class'=>'btn btn-default btn-success']) }}
    </div>
    {{ Form::close() }}

    <h3 class="page-header">{{ t('Change Password')}}</h3>
    {{ Form::open(['url'=>'settings/changepassword']) }}
    <div class="form-group">
        <label for="currentpassword">{{ t('Current Password') }}</label>
        {{ Form::password('currentpassword',['class'=>'form-control', 'required']) }}
    </div>
    <div class="form-group">
        <label for="password">{{ t('New Password') }}</label>
        {{ Form::password('password',['class'=>'form-control', 'required']) }}
    </div>
    <div class="form-group">
        <label for="password_confirmation">{{ t('Confirm Password') }}</label>
        {{ Form::password('password_confirmation',['class'=>'form-control', 'required']) }}
    </div>

    <div class="form-group">
        {{ Form::submit(t('Change Password'),['class'=>'btn btn-danger btn-success']) }}
    </div>
    {{ Form::close() }}
</div>
@stop