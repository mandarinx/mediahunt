@extends('master/index')

@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Notifications') }}</h1>
</div>

<!--/.row-->
@foreach($notifications as $notice)
@if($notice->post || $notice->fromUser)
<div class="row post-item">
    @if($notice->reason == 'comment')
    <p>{{ t('New comment on') }} {{ link_to_route('post', ucfirst(e($notice->post->title)), array('id' => $notice->post->id, 'slug'=> $notice->post->slug), array('target'=>'_blank')) }} by {{ link_to_route('user',ucfirst(e($notice->fromUser->fullname)),array('user' => $notice->fromUser->username)) }} <span class="pull-right"><abbr class="timeago" title="{{ $notice->created_at->toISO8601String() }}">{{ $notice->created_at->toDateTimeString() }}</abbr></span></p>
    @endif

    @if($notice->reason == 'reply')
    <p>{{ t('New reply on comment at') }} {{ link_to_route('post', ucfirst(e($notice->post->title)), array('id' => $notice->post->id, 'slug'=> $notice->post->slug), array('target'=>'_blank')) }} by {{ link_to_route('user',ucfirst(e($notice->fromUser->fullname)),array('user' => $notice->fromUser->username)) }} <span class="pull-right"><abbr class="timeago" title="{{ $notice->created_at->toISO8601String() }}">{{ $notice->created_at->toDateTimeString() }}</abbr></span></p>
    @endif

    @if($notice->reason == 'vote')
    <p>{{ t('New Vote on') }} {{ link_to_route('post', ucfirst
        (e($notice->post->title)), array('id' => $notice->post->id, 'slug'=> $notice->post->slug), array('target'=>'_blank')) }} by {{ link_to_route('user',ucfirst(e($notice->fromUser->fullname)),array('user' => $notice->fromUser->username)) }} <span class="pull-right"><abbr class="timeago" title="{{ $notice->created_at->toISO8601String() }}">{{ $notice->created_at->toDateTimeString() }}</abbr></span></p>
    @endif

    @if($notice->reason == 'follow')
    <p>{{ t('You are now followed by') }} {{ link_to_route('user',ucfirst(e($notice->fromUser->fullname)),array('user' => $notice->fromUser->username)) }}<span class="pull-right"><abbr class="timeago" title="{{ $notice->created_at->toISO8601String() }}">{{ $notice->created_at->toDateTimeString() }}</abbr></span></p>
    @endif
</div>
@endif
@endforeach
@stop

@section('pagination')
<div class="row">
    {{ $notifications->links() }}
</div>

@stop