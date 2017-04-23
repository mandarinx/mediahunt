@extends('master/index')
@section('meta_title')
{{ strip_tags(ucfirst($title)) }} - {{ siteSettings('siteName') }}
@stop
@section('page-content')
<div class="row">
    @if(Input::get('provider') && Input::get('category'))
    <h1 class="page-header">{{{ ucfirst($title) }}} {{ t('from') }} {{{ t(ucfirst(Input::get('provider'))) }}} {{{ t('in category') }}} {{ getCategoryName(Input::get('category')) }}</h1>
    @elseif(Input::get('provider') && !Input::get('category'))
    <h1 class="page-header">{{{ ucfirst($title) }}} {{{ t('from') }}} {{{ t(ucfirst(Input::get('provider'))) }}}</h1>
    @elseif(Input::get('category') && !Input::get('provider'))
    <h1 class="page-header">{{{ ucfirst($title) }}} {{{ t('in category') }}} {{ getCategoryName(Input::get('category')) }}</h1>
    @else
    <h1 class="page-header">{{{ ucfirst($title) }}}</h1>
    @endif
    @include('master/util-list')
    <!-- /.col-lg-12 -->
</div>
<!-- /.col-lg-12 -->

@if(Input::get('provider') == 'blog')
    @include('blogs/list')
@elseif(Input::get('provider') == 'link')
    @include('links/list')
@else
<!--/.row-->
<div class="row gallery">

    @foreach(array_chunk($posts->getCollection()->all(),4) as $pts)
    <div class="row post">
        <!--/.row-->
        @foreach($pts as $post)
        @if($post->user)
        <div class="col-lg-3 col-md-3 gallery-display">
            <figure>
                <a href="{{ route('post',array('id' => $post->id, 'slug' => $post->slug )) }}">
                    <img data-original="{{ thumbnail($post) }}" alt="{{{ $post->title }}}" class="display-image">
                </a>
                <a href="{{ route('post',array('id' => $post->id, 'slug' => $post->slug )) }}" class="figcaption">
                    <h4>{{{ $post->title }}}</h4>
                </a>
            </figure>
            <!--figure-->
            <div class="box-detail">
                <h5 class="heading"><a href="{{ route('post',array('id' => $post->id, 'slug' => $post->slug )) }}">{{{ Str::limit($post->title,30) }}}</a></h5>
                <ul class="list-inline gallery-details">
                    <li class="pull-left">{{ t('by') }} <a href="{{ route('user', $post->user->username) }}">{{{ Str::limit(ucfirst($post->user->fullname),9) }}}</a></li>
                    <li class="pull-right"><i class="fa fa-eye fa-fw"></i> {{ $post->views }} <i class="fa fa-chevron-circle-up fa-fw"></i>{{ $post->votes->count() }} <i class="fa fa-comments fa-fw"></i> {{ $post->comments->count() }}
                    </li>
                </ul>
            </div>
            <div class="shares">
                <ul class="list-inline">
                    <li><a href="//www.facebook.com/sharer/sharer.php?u={{ route('post', array('id' => $post->id, 'slug' => $post->slug)) }}" class="fa fa-facebook-square share-facebook popup"></a></li>
                    <li><a href="//twitter.com/intent/tweet?text={{{ $post->title }}} {{ route('post', array('id' => $post->id, 'slug' => $post->slug)) }}" class="fa fa-twitter share-twitter popup"></a></li>
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
@endif
@stop

@section('pagination')
<div class="row">{{ $posts->links() }}</div>
@stop