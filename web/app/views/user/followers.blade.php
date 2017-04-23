@extends('master/index')
@section('meta_title')
    {{{ ucfirst($user->fullname) }}}'s Profile - {{ siteSettings('siteName') }}
@stop
@section('page-content')
@include('user.partial.header')
<div class="gallery">
@foreach($followers as $user)
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-3 col-sm-3 pull-left" style="margin-bottom:15px;min-wdth:100px">
                <a href="{{ url('user/'.$user->username) }}"><img class="thumbnail img-responsive" src="{{ getAvatar($user,114,114) }}"></a></div>
            <div class="col-md-8">
                <h3 style="margin-top:0px"><a href="{{ route('user', ['usernmae' => $user->username]) }}">{{{ ucfirst($user->fullname) }}}</a></h3>
                    <p>
                        <small><i class="glyphicon glyphicon-comment"></i> {{ $user->comments->count() }} {{t('comments')}} &middot; <i class="glyphicon glyphicon-share-alt"></i> {{ $user->posts->count() }} {{ t('posts') }}</small>
                    </p>
        </div>
    </div>

</div>
</div>
<hr>
@endforeach

<div class="clearfix"></div>
<p class="row"><i class="fa fa-flag-o flag"></i> {{ link_to_route('flag-user',t('Flag'),['username'=>$user->username],['class'=>'flag']) }}</p>
@stop

@section('pagination')
<div class="row">{{ $followers->links() }}</div>
@stop