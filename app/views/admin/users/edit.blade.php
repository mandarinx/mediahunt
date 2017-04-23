@extends('admin/master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-edit"></i></small>
            Editing "{{ $user->username }}"
            <small>( {{{ $user->fullname }}} )</small>
        </h3>
    </div>
</div>

<div class="col-md-3">
    <p><img src="{{ getAvatar($user,200) }}" class="thumbnail"/></p>
    <h4 class="content-heading">User Details</h4>
    <hr/>
    <p><strong><i class="fa fa-bookmark-o"></i> Videos</strong> {{ $user->posts->count() }}</p>

    <p><strong><i class="fa fa-chevron-circle-up"></i> Votes</strong> {{ $user->votes->count() }}</p>

    <p><strong><i class="fa fa-comments-o"></i> Comments</strong> {{ $user->comments->count() }}</p>

    <p><strong><i class="fa fa-users"></i> Follower</strong> {{ $user->followers->count() }}</p>

    <p><strong><i class="fa fa-users"></i> Following</strong> {{ $user->following->count() }}</p>

    <p><strong><i class="fa fa-clock-o"></i> Register</strong> <abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($user->created_at)) }}">{{ date(DATE_ISO8601,strtotime($user->created_at)) }}</abbr></p>

    <p><strong><i class="fa fa-clock-o"></i> Last Login</strong> <abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($user->updated_at)) }}">{{ date(DATE_ISO8601,strtotime($user->updated_at)) }}</abbr></p>
    @if($user->fbid)
    <p><strong><i class="fa fa-facebook"></i> Facebook ID</strong> {{ $user->fbid }}</p>
    @endif
</div>

<div class="col-md-9">
    {{ Form::open() }}
    {{ Form::hidden('userid',$user->id) }}
    <div class="form-group">
        <label for="username">Username</label>
        {{ Form::text('username',$user->username,array('class'=>'form-control','disabled'=>'disabled')) }}
    </div>

    <div class="form-group">
        <label for="fullname">Full Name</label>
        {{ Form::text('fullname',$user->fullname,array('class'=>'form-control')) }}
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        {{ Form::text('email',$user->email,array('class'=>'form-control')) }}
    </div>

    <div class="form-group">
        <label for="blogurl">Blog Url</label>
        {{ Form::text('blogurl',$user->blogurl,array('class'=>'form-control')) }}
    </div>

    <div class="form-group">
        <label for="blogurl">Facebook Link</label>
        {{ Form::text('fb_link',$user->fb_link,array('class'=>'form-control')) }}
    </div>

    <div class="form-group">
        <label for="blogurl">Twitter Link</label>
        {{ Form::text('tw_link',$user->tw_link,array('class'=>'form-control')) }}
    </div>

    <div class="form-group">
        <label for="featured">Featured</label>
        @if($user->is_featured == true)
        {{ Form::checkbox('featured','TRUE', true) }}
        @else
        {{ Form::checkbox('featured','TRUE', false) }}
        @endif
    </div>

    <div class="form-group">
        <label for="featured">Ban</label>
        @if($user->permission == 'ban')
        {{ Form::checkbox('ban','TRUE', true) }}
        @else
        {{ Form::checkbox('ban','TRUE', false) }}
        @endif
    </div>

    <div class="form-group">
        <label for="featured">Is Admin</label>
        @if($user->permission == 'admin')
        {{ Form::checkbox('make_admin','TRUE', true) }}
        @else
        {{ Form::checkbox('make_admin','TRUE', false) }}
        @endif
        ( <i class="fa fa-info" data-toggle="tooltip" data-placement="top" data-original-title="Making this user admin at your own risk"></i> )
    </div>

    @if($user->confirmed != '1')
    <div class="form-group">
        <label for="featured">Confirm this user
            <small>( Validating email )</small>
        </label>
        {{ Form::checkbox('confirmed','1', false) }}
        ( <i class="fa fa-info" data-toggle="tooltip" data-placement="top" data-original-title="Manually confirm users email"></i> )
    </div>
    @endif

    <div class="form-group">
        <label for="featured">Delete this user </label>
        {{ Form::checkbox('delete','TRUE', false) }}
        ( <i class="fa fa-info" data-toggle="tooltip" data-placement="top" data-original-title="Users details can't be restored"></i> )
    </div>

    <div class="form-group">
        {{ Form::submit('Edit User',array('class'=>'btn btn-info')) }}
    </div>
    {{ Form::close() }}
</div>


@stop
