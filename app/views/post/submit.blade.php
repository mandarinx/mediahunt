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
        {{ Form::text('url',$url,['class'=>'form-control','placeholder' => t('Url of webpage'), 'readonly']) }}
    </div>

    <div class="form-group">
        <label for="title">{{ t('Title') }}*</label>
        {{ Form::text('title',$title,['class'=>'form-control','placeholder' => t('Title')]) }}
    </div>

    <div class="form-group">
        <label for="title">{{ t('Summary') }}</label>
        {{ Form::textarea('summary',null,['class' => 'form-control ckeditor', 'id' => 'editor', 'placeholder' => t('Summary')]) }}
    </div>

    <div class="form-group">
        <label for="category">{{ t('Category') }}*</label>
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