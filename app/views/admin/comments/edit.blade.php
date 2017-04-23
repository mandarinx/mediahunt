@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-file-text-o"></i></small>
            Editing a comment
        </h3>
    </div>
</div>
<div class="row">
    <div class="col-md-10">
        {{ Form::open() }}


        <div class="form-group">
            <label for="description">Comment</label>
            {{ Form::textarea('description',$comment->description,array('class'=>'form-control')) }}
        </div>

        <div class="form-group">
            <label for="featured">Delete this comment </label>
            {{ Form::checkbox('delete','TRUE', false) }}
            ( <i class="fa fa-info" data-toggle="tooltip" data-placement="top" data-original-title="Deleting this comment, it can't restored also all the replies it will be deleted"></i> )
        </div>

        {{ Form::submit('Update',array('class'=>'btn btn-success')) }}
        {{ Form::close() }}
    </div>
</div>
@stop
