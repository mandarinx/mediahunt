@extends('admin/master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-picture-o"></i></small>
            {{ $title }}
            <small>( {{ $images->count() }} images )</small>
        </h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Filter Table</label>
                    <input class="form-control" id="filter" placeholder="Filter Table">
                </div>
            </div>
            <form method="GET">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sort By</label>
                        {{ Form::select('sortBy', array('username' => 'Username', 'fullname' => 'Fullname','created_at'=>'Registered on','updated_at'=>'Last Login'), Request::get('sortBy'),array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Direction</label>
                        {{ Form::select('direction', array('asc' => 'Asc', 'desc' => 'Desc'), Request::get('direction'),array('class'=>'form-control')) }}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <input type="submit" class="btn btn-default form-control" value="Filter Data"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover footable toggle-medium" data-filter="#filter">
        <thead>
        <tr>
            <th>#</th>
            <th>Original Name</th>
            <th>Title</th>
            <th>Uploaded By</th>
            <th>Add/Remove</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($images as $image)
        @if($image and $image->user)
        <tr>
            <td><a href="{{ url('image/'.$image->id.'/'.$image->slug) }}"><img src="{{ asset(zoomCrop('uploads/'.$image->image_name. '.' . $image->type,69,69)) }}"/></a></td>
            <td><a data-toggle="tooltip" data-placement="right" data-original-title="View Original Image" href="{{ url('uploads/'.$image->image_name.'.'.$image->type) }}" target="_blank">{{ $image->image_name }}.{{ $image->type }}</a></td>
            <td><span data-toggle="tooltip" data-placement="right" data-original-title="{{{ $image->title }}}">{{{ Str::limit($image->title,10) }}}</span></td>
            <td><a data-toggle="tooltip" data-placement="right" data-original-title="{{{ $image->user->fullname }}}" href="{{ url('user/'.$image->user->username) }}">{{{ Str::limit($image->user->fullname,15) }}}</a></td>
            <td>
                <a id="{{ $image->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Approve" class="btn btn-success admin-image-approve" href="{{ url('image/'.$image->id.'/'.$image->slug) }}">
                    <i class="fa fa-check"></i>
                </a>
                <a id="{{ $image->id }}" data-toggle="tooltip" data-placement="top" data-original-title="Disapprove" class="btn btn-danger admin-image-disapprove"  href="{{ url('admin/editimage/'.$image->id) }}">
                    <i class="fa fa-times"></i>
                </a></td>
            <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($image->created_at)) }}">{{ date(DATE_ISO8601,strtotime($image->created_at)) }}</abbr></td>
            <td>
                <a class="btn btn-success" href="{{ url('image/'.$image->id.'/'.$image->slug) }}">
                    <i class="glyphicon glyphicon-zoom-in"></i>
                </a>
                <a class="btn btn-info" href="{{ url('admin/editimage/'.$image->id) }}">
                    <i class="glyphicon glyphicon-edit"></i>
                </a></td>
        </tr>
        @endif
        @endforeach
        </tbody>
    </table>
</div>
{{ $images->links() }}
<!-- /.table-responsive -->

@stop
