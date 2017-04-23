@extends('master/index')

@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Flagging Post') }}</h1>
</div>
<div class="row">
    {{ Form::open() }}
    <div class="form-group">
        <label for="title">{{ t('Reason') }}</label>
        {{ Form::textarea('reason','',array('class'=>'form-control','placeholder' => t('Reason'))) }}
    </div>

    <div class="form-group">
        {{ Form::submit(t('Submit'),['class'=>'btn btn-info']) }}
    </div>

    {{ Form::close() }}
</div>
@stop