@extends('master/index')
@section('meta_title')
{{{ strip_tags($post->title) }}} - {{ siteSettings('siteName') }}
@stop
@section('meta_description')
    {{{ Str::limit(strip_tags($post->summary),200) }}}
@stop
@section('extra_meta')
<meta name="keywords" content="{{{ $post->title }}}">
<meta property="og:title" content="{{{ $post->title }}} - {{{ siteSettings('siteName') }}}"/>
<meta property="og:url" content="{{ route('post', ['id' => $post->id, 'slug' => $post->slug]) }}"/>
<meta property="og:image" content="{{ thumbnail($post) }}"/>
@stop
@section('page-content')
<div class="row">
    <h2 class="page-header">{{{ $title }}}</h2>

    <div class="util-list">
        @if($previous)
        <a href="{{ route('post', ['id' => $previous->id , 'slug' => $previous->slug]) }}"><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;{{ t('Previous') }}</a>&nbsp;
        @endif
        @if($next)
        <a href="{{ route('post', ['id' => $next->id , 'slug' => $next->slug]) }}">{{ t('Next') }} &nbsp;<span class="glyphicon glyphicon-chevron-right"></span></a>
        @endif

    </div>

</div>

<div class="row post-item post-{{ $post->type }} post-fix">
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-2 up-vote">
        <ul class="list-unstyled text-center">
            @if(Auth::user())
            @if(checkVoted($post->votes))
            <li class="up-vote-icon"><i class="fa fa-chevron-circle-up vote-btn voted" data-id="{{ $post->id }}"></i></li>
            @else
            <li class="up-vote-icon"><i class="fa fa-chevron-circle-up vote-btn" data-id="{{ $post->id }}"></i></li>
            @endif
            <li><span id="data-number-{{ $post->id }}">{{ $post->votes->count() }}</span></li>
            @else
            <li class="up-vote-icon"><a href="{{ route('login') }}"><i class="fa fa-chevron-circle-up" data-id="{{ $post->id }}"></i></a></li>
            <li><span id="data-number-{{ $post->id }}">{{ $post->votes->count() }}</span></li>
            @endif
        </ul>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        <h1 class="post-title">{{ $post->type == 'link' ? link_to(filter_var($post->source,FILTER_SANITIZE_URL), ucfirst($post->title), ['target'=>'_blank','rel'=>'nofollow']) : link_to_route('post', ucfirst(e($post->title)), ['id' => $post->id, 'slug'=> $post->slug], ['target'=>'_blank']) }}</h1>

        <p><abbr class="timeago" title="{{ $post->created_at->toISO8601String() }}">{{ $post->created_at->toDateTimeString() }}</abbr> in {{ link_to_route('latest', $post->category->name, ['category'=>$post->category->slug]) }} {{ t('by')}} {{ link_to_route('user',ucfirst($post->user->fullname), ['username'=>$post->user->username]) }}</p>

        <ul class="list-inline">
            <li><i class="fa fa-comments-o"></i>&nbsp;{{ link_to_route('post', $post->comments->count() . '&nbsp;'. t('comments'),['id'=>$post->id,'slug'=>$post->slug]) }}</li>
            <li><i class="fa fa-eye"></i>&nbsp;{{ $post->views }}&nbsp;{{ t('views') }}</li>
            <li><i class="fa fa-flag-o flag"></i>&nbsp;{{ link_to_route('flag', t('Flag'), ['id'=>$post->id], ['class' => 'flag']) }}</li>
            @if(Auth::check())
                @if(Auth::user()->id === $post->user->id)
                    <li><i class="fa fa-edit flag"></i>&nbsp;{{ link_to_route('post-edit', t('Edit'), ['id'=>$post->id, 'slug' => $post->slug], ['class' => 'flag']) }}</li>
                @endif
                @if(Auth::user()->permission == 'admin')
                    <li><i class="fa fa-edit flag"></i>&nbsp;{{ link_to('admin/posts/'.$post->id.'/edit', 'Edit From Admin Panel', ['class' => 'flag']) }}</li>
                @endif
            @endif
        </ul>

        <p>{{ $post->summary }}</p>

        @if($post->type == 'media' || $post->type == 'image')
        <div class="col-md-10">
            <div class="row">
                @if($post->provider == 'image')
                    <img src="{{ JitImage::source('uploads/'. $post->thumbnail)->resize(800,0) }}" alt="{{{ $post->title }}}" class="img img-responsive"/>
                @else
                {{ Embedder::html($post) }}
                @endif
            </div>
        </div>
        @endif

        @include('post/extra/social-share')
    </div>
    <!--/.col-lg-9 col-md-9 col-sm-9 col-xs-9-->
    <div class="col-md-1 col-lg-1 hidden-sm hidden-xs">
        <a href="{{ route('user',$post->user->username) }}"><img src="{{ getAvatar($post->user) }}" class="img-circle" alt="{{{ $post->user->username }}}"/></a>
    </div>
    <!--/.col-md-1 col-lg-1 hidden-sm hidden-xs-->
</div>
@include('post/comments')<!--.post-item-->
@include('post/extra/related')
@stop