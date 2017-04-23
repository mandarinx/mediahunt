@extends('admin/master')
@section('content')
<div class="col-md-12">
    <h2>{{ $title }}</h2>
    <hr>
    @if($report->type == 'user')
    <h5>Reported {{ $report->type }}: <a href="{{ url('user/'.$report->report) }}" target="_blank">{{ $report->report }} <i class="fa fa-external-link"></i></a></h5>
    @elseif($report->type == 'image')
    <h5>Reported {{ $report->type }}: With id {{ $report->report }} <a href="{{ url('image/'.$report->report)}}" target="_blank">View Image <i class="fa fa-external-link"></i></a></h5>
    @endif
    <h5>Reported By: <a href="{{ url('user/'.$report->user->username) }}">{{ $report->user->username }}</a> <small>( {{{ $report->user->fullname }}} )</small> </h5>
    <h5>Reported: <abbr class="timeago" title="{{ date(DATE_ISO8601,strtotime($report->updated_at)) }}">{{ date(DATE_ISO8601,strtotime($report->updated_at)) }}</abbr> </h5>
    <hr>
    <h4>Description</h4>
    <hr>
    <p>{{{ $report->reason }}}</p>
</div>
@stop