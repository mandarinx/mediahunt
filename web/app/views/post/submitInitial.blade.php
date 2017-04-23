@extends('master/index')
@section('meta_title')
{{ t('Submitting Post') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Submitting Post') }}</h1>
</div>
<div class="row">
    {{ Form::open() }}
    <div class="form-group">
        <label for="url">{{ t('Link') }}*</label>
        {{ Form::text('url',null,array('class'=>'form-control','placeholder' => t('Url of webpage'))) }}
        <input type="hidden" name="initial" value="initial"/>
    </div>
    <div class="form-group">
        {{ Form::submit(t('Submit'),array('class'=>'btn btn-info')) }}
    </div>
    {{ Form::close() }}
</div>
@stop