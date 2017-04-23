@extends('admin/master')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-bookmark-o"></i></small>
            {{ $title }}
        </h3>
    </div>
</div>
<table class="table table-bordered table-hover table-striped tablesorter">
    <thead>
    <tr>
        <th>On id <i class="fa fa-sort"></i></th>
        <th>Reported <i class="fa fa-sort"></i></th>
        <th>Reported By <i class="fa fa-sort"></i></th>
        <th>Reason <i class="fa fa-sort"></i></th>
        <th>Created <i class="fa fa-sort"></i></th>
        <th>Checked <i class="fa fa-sort"></i></th>
        <th>Read Full Report <i class="fa fa-sort"></i></th>
    </tr>
    </thead>
    <tbody>
    @foreach($reports as $report)
    <tr>
        @if($report->type == 'user')
        <td><a href="{{ url('user/'.$report->reportedUser->username)  }}">{{ $report->reportedUser->username }}</a></td>
        @else
        <td>{{ link_to_route('post', ucfirst($report->post_id),array('id' => $report->post_id, 'slug' => $report->post->slug)) }}</td>
        @endif
        <td>{{ $report->type }}</td>
        <td><a href="{{ url('user/'.$report->user->username) }}">{{ $report->user->username }}</a></td>
        <td>{{ $report->reason }}</td>
        <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($report->created_at)) }}">{{ date(DATE_ISO8601,strtotime($report->created_at)) }}</abbr></td>
        @if($report->checked_at == null)
        <td>Unchecked</td>
        @else
        <td><abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($report->updated_at)) }}">{{ date(DATE_ISO8601,strtotime($report->checked_at)) }}</abbr></td>
        @endif
        <td><a href="{{ url('admin/report/'.$report->id) }}">Read Full</a></td>
    </tr>
    @endforeach

    </tbody>
</table>
@stop