@extends('master/index')
@section('meta_title')
{{ $title }} - {{ $post->title }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{{ $title }}}</h1>
</div>
<div class="row">
    {{ Form::open() }}
    @if($post->type == 'news')
    <div class="form-group">
        <label for="url">{{ t('Link') }}*</label>
        {{ Form::text('url',$post->url,array('class'=>'form-control','placeholder' => t('Url of webpage'))) }}
    </div>
    @endif

    <div class="form-group">
        <label for="title">{{ t('Title') }}*</label>
        {{ Form::text('title',$post->title,['class'=>'form-control','placeholder' => t('Title')]) }}
    </div>

    <div class="form-group">
        <label for="title">{{ t('Summary') }}</label>
        {{ Form::textarea('summary',$post->summary,['class' => 'form-control ckeditor', 'id' => 'editor', 'placeholder' => t('Summary')]) }}
    </div>

    <div class="form-group">
        <label for="category">{{ t('Category') }}*</label>
        <select class="form-control" name="category" required>
            <option value="{{ $post->category->id }}">{{ $post->category->name }}</option>
            <option>-------</option>
            @foreach(siteCategories() as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="title">{{ t('Delete') }}</label>
        {{ Form::checkbox('delete',1) }}
    </div>

    <div class="form-group">
        {{ Form::submit(t('Submit'),['class'=>'btn btn-info']) }}
    </div>

    {{ Form::close() }}
</div>
@stop