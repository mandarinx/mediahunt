@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <i class="fa fa-bookmark-o fa-fw"></i>
            @if(Input::get('provider') && Input::get('category'))
            {{{ ucfirst($title) }}} {{ t('from') }} {{{ ucfirst(Input::get('provider')) }}} {{{ t('in category') }}} {{ getCategoryName(Input::get('category')) }}
            @elseif(Input::get('provider') && !Input::get('category'))
            {{{ ucfirst($title) }}} {{{ t('from') }}} {{{ ucfirst(Input::get('provider')) }}}
            @elseif(Input::get('category') && !Input::get('provider'))
            {{{ ucfirst($title) }}} {{{ t('in category') }}} {{ getCategoryName(Input::get('category')) }}
            @else
            {{{ ucfirst($title) }}}
            @endif
           <small>( {{ $posts->count() }} posts )</small>
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
                        <select class="form-control" name="category">
                            <option value="">---</option>
                            @foreach(siteCategories() as $category)
                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <input type="submit" class="btn btn-info form-control" value="Filter Data"/>
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
            <th>Title</th>
            <th data-hide="tablet,phone">Created By</th>
            <th data-hide="tablet,phone">Votes</th>
            <th data-hide="tablet,phone">Views</th>
            <th data-hide="phone">Created At</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
        @if($post and $post->user)
        <tr>
            <td>{{ $post->id }}</td>
            <td><a data-toggle="tooltip" data-placement="right" data-original-title="Click To Visit" href="{{ route('post', array('id' => $post->id, 'slug' => $post->slug )) }}" target="_blank">{{{ $post->title }}}</a></td>
            <td><a data-toggle="tooltip" data-placement="right" data-original-title="{{{ $post->user->fullname }}}" href="{{ route('user', array('username' => $post->user->username)) }}">{{{ Str::limit($post->user->fullname,15) }}}</a></td>
            <td>{{ $post->votes->count() }}</td>
            <td>{{ $post->views }}</td>
            <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($post->created_at)) }}">{{ date(DATE_ISO8601,strtotime($post->created_at)) }}</abbr></td>
            <td>
                <a class="btn btn-success" href="{{ route('post', array('id' => $post->id, 'slug' => $post->slug )) }}" target="_blank">
                    <i class="glyphicon glyphicon-zoom-in"></i>
                </a>
                <a class="btn btn-info" href="{{ url('admin/posts/'.$post->id.'/edit') }}">
                    <i class="glyphicon glyphicon-edit"></i>
                </a></td>
        </tr>
        @endif
        @endforeach
        </tbody>
    </table>
</div>
{{ $posts->links() }}
<!-- /.table-responsive -->

@stop
