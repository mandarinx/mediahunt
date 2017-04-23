@extends('admin/master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-edit"></i></small>
            Editing Image
        </h3>
    </div>
</div>

<div class="col-md-3">
    <p><img src="{{ asset(zoomCrop('uploads/'.$image->image_name. '.' . $image->type,200,200)) }}" class="thumbnail"/></p>
    <h4 class="content-heading">Image Details</h4>
    <hr/>
    <p><strong><i class="fa fa-user"></i> Create By</strong> <a href="{{ url('user/'.$image->user->username) }}">{{{ $image->user->fullname }}}</a></p>

    <p><strong><i class="fa fa-picture-o"></i> Original Image</strong> <a href="{{ url('uploads/' . $image->image_name .'.'. $image->type) }}">{{ $image->image_name }}.{{ $image->type }}</a></p>

    <p><strong><i class="fa fa-heart-o"></i> Favorites</strong> {{ $image->favorite()->count() }}</p>

    <p><strong><i class="fa fa-comments-o"></i> Comments</strong> {{ $image->comments()->count() }}</p>


    <p><strong><i class="fa fa-clock-o"></i> Created</strong> <abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($image->created_at)) }}">{{ date(DATE_ISO8601,strtotime($image->created_at)) }}</abbr></p>

</div>

<div class="col-md-9">
    <div class="row">
        {{ Form::open() }}
        <div class="form-group">
            <label for="title">Title</label>
            {{ Form::text('title',$image->title,array('class'=>'form-control','required'=>'required')) }}
        </div>
        <div class="form-group">
            <label for="title">Description</label>
            {{ Form::textarea('description',$image->image_description,array('class'=>'form-control')) }}
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" class="form-control" required>
                <option value="{{ $image->category }}">{{ ucfirst($image->category) }}</option>
                @foreach(siteCategories() as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <input type="text" autocomplete="off" name="tags" placeholder="Tags" class="form-control tm-input tm-input-success" data-original-title=""/>
        </div>


        <div class="form-group">
            <p>Featured {{ Form::checkbox('featured',1,$image->is_featured) }}</p>
            <p>Delete {{ Form::checkbox('delete',1,0) }}</p>
        </div>

        <div class="form-group">
            {{ Form::submit('Update Image',array('class'=>'btn btn-success')) }}
        </div>


        {{ Form::close() }}
    </div>


</div>


@stop

@section('extra-js')
<script>
    var tagApi = jQuery(".tm-input").tagsManager({
        prefilled: [@foreach(explode(',',$image->tags) as $tag) "{{ $tag }}", @endforeach],
    delimiters: [9, 13, 44, 32],
        maxTags:{{ (int)siteSettings('tagsLimit')}}
    });
</script>
@stop
