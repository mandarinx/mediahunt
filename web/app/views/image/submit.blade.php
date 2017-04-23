@extends('master/index')
@section('meta_title')
{{ t('Submitting Image') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Submitting Image') }}</h1>
</div>

<div class="row">
    {{ Form::open(array('files' => true)) }}
    <div class="form-group">
         {{ Form::label('image', t('Image')) }}
         {{ Form::file('image') }}
    </div>
    <div class="form-group">
        {{ Form::label('title', t('Title')) }}*
        {{ Form::text('title','',array('class'=>'form-control','placeholder' => t('Title'))) }}
    </div>

    <div class="form-group">
        {{ Form::label('summary', t('Summary')) }}
        {{ Form::textarea('summary','',['class' => 'form-control ckeditor', 'id' => 'editor', 'placeholder' => t('Summary')]) }}
    </div>

    <div class="form-group">
        {{ Form::label('category', t('Category')) }}*
        <select class="form-control" name="category">
            <option>-------</option>
            @foreach(siteCategories() as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        {{ Form::submit(t('Submit'),['class'=>'btn btn-info']) }}
    </div>

    {{ Form::close() }}
</div>
@stop