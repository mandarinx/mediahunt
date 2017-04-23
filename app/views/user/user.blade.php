@extends('master/index')
@section('meta_title')
    {{{ ucfirst($user->fullname) }}}'s Profile - {{ siteSettings('siteName') }}
@stop
@section('page-content')
@include('user.partial.header')
<div class="row gallery">

    @foreach(array_chunk($posts->getCollection()->all(),4) as $pts)
    <div class="row">
        <!--/.row-->
        @foreach($pts as $post)
        @if($post->user)
        <div class="col-lg-3 col-md-3 gallery-display" data-scroll-reveal="enter left and move 10px over 1s">
            <figure>
                <a href="{{ route('post',['id' => $post->id, 'slug' => $post->slug ]) }}">
                    <img data-original="{{ thumbnail($post) }}" alt="{{{ $post->title }}}" class="display-image">
                </a>
                <a href="{{ route('post',['id' => $post->id, 'slug' => $post->slug ]) }}" class="figcaption">
                    <h4>{{{ $post->title }}}</h4>
                </a>
            </figure>
            <!--figure-->
            <div class="box-detail">
                <h5 class="heading"><a href="{{ route('post',['id' => $post->id, 'slug' => $post->slug ]) }}">{{{ Str::limit($post->title,30) }}}</a></h5>
                <ul class="list-inline gallery-details">
                    <li class="pull-left">{{ t('by') }} <a href="{{ route('user', $post->user->username) }}">{{{ Str::limit(ucfirst($post->user->fullname),18) }}}</a></li>
                    <li class="pull-right"><i class="fa fa-eye fa-fw"></i> {{ $post->views }} <i class="fa fa-chevron-circle-up fa-fw"></i>{{ $post->votes->count() }} <i class="fa fa-comments fa-fw"></i> {{ $post->comments->count() }}
                    </li>
                </ul>
            </div>
            <div class="shares">
                <ul class="list-inline">
                    <li><a href="//www.facebook.com/sharer/sharer.php?u={{ route('post', ['id' => $post->id, 'slug' => $post->slug]) }}" class="fa fa-facebook-square share-facebook popup"></a></li>
                    <li><a href="//twitter.com/intent/tweet?text={{{ $post->title }}} {{ route('post', ['id' => $post->id, 'slug' => $post->slug]) }}" class="fa fa-twitter share-twitter popup"></a></li>
                    </ul>
            </div>
            <!--.box-detail-->
        </div>
        @endif
        @endforeach
    </div>
    @endforeach
</div>
<div class="clearfix"></div>
<p class="row"><i class="fa fa-flag-o flag"></i> {{ link_to_route('flag-user',t('Flag'),['username'=>$user->username],['class'=>'flag']) }}</p>
@stop

@section('pagination')
<div class="row">{{ $posts->links() }}</div>
@stop