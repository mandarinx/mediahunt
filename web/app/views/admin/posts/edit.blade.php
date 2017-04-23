@extends('admin/master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-edit"></i></small>
            Editing
            <small><a href="{{ route('post', array('id' => $post->id, 'slug' => $post->slug)) }}" target="_blank">See Post <i class="fa fa-external-link"></i></a></small>
        </h3>
    </div>
</div>

{{ Form::open() }}
@if($post->provider != 'blog' && $post->provider != 'image')
<div class="form-group">
    <label for="url">URL*</label>
    {{ Form::text('url', $post->source, array('class'=>'form-control')) }}
</div>
@endif
<div class="form-group">
    <label for="title">{{ t('Title') }}*</label>
    {{ Form::text('title',$post->title, array('class'=>'form-control','placeholder' => t('Title'))) }}
</div>

<div class="form-group">
    <label for="title">{{ t('Summary') }}</label>
    {{ Form::textarea('summary',$post->summary,array('class'=>'form-control ckeditor','placeholder' => t('Summary'))) }}
</div>

<div class="form-group">
    <label for="category">{{ t('Category') }}*</label>
    <select class="form-control" name="category">
        <option value="{{ $post->category_id }}">{{ $post->category->name }}</option>
        <option>-------</option>
        @foreach(siteCategories() as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

@if( ! $post->approved_at)
<div class="form-group">
    <lable for="delete">Approve this</lable>
    {{ Form::checkbox('approve', 1, false) }}
</div>
@endif

<div class="form-group">
    <lable for="delete">Featured this</lable>
    @if($post->featured_at)
    {{ Form::checkbox('featured', 1, true) }}
    @else
    {{ Form::checkbox('featured', 1, false) }}
    @endif
</div>

<div class="form-group">
    <lable for="featured">Delete This</lable>
    {{ Form::checkbox('delete', 1, false) }}
</div>


<div class="form-group">
    {{ Form::submit(t('Submit'),array('class'=>'btn btn-info')) }}
</div>

{{ Form::close() }}

@stop

