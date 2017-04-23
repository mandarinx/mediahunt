@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-users"></i></small>
            {{ $title }}
        </h3>
    </div>
</div>

<hr/>
<table class="table table-bordered table-hover table-striped tablesorter">
    <thead>
    <tr>
        <th>Id <i class="fa fa-sort"></i></th>
        <th>From <i class="fa fa-sort"></i></th>
        <th>On Post <i class="fa fa-sort"></i></th>
        <th>Comment <i class="fa fa-sort"></i></th>
        <th>Created At <i class="fa fa-sort"></i></th>
        <th>Action <i class="fa fa-sort"></i></th>
    </tr>
    </thead>
    <tbody>
    @foreach($comments as $comment)
    <tr>
        <td>{{ $comment->id }}</td>
        <td><span data-toggle="tooltip" data-placement="left" data-original-title="{{ $comment->user->username }}"><a href="{{ url('user/'.$comment->user->username) }}">{{{ Str::limit($comment->user->fullname,15) }}}</a></span></td>
        <td>{{ link_to_route('post', $comment->post->title,array('id'=>$comment->post->id, 'slug'=>$comment->post->slug)) }}</td>
        <td>{{{ Str::limit($comment->description,20) }}}</td>
        <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($comment->created_at)) }}">{{ date(DATE_ISO8601,strtotime($comment->created_at)) }}</abbr></td>
        <td>
            <a class="btn btn-info" href="{{ url('admin/comment/'.$comment->id. '/edit') }}">
                <i class="glyphicon glyphicon-edit"></i>
            </a></td>
    </tr>
    @endforeach

    </tbody>
</table>
@stop