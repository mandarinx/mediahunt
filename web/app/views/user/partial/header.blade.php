<div class="row">
    <h1 class="page-header">{{{ ucfirst($user->fullname) }}} &nbsp;
        <small>{{{ $user->username }}}</small>
    </h1>
</div>

<div class="col-md-3 col-sm-12 col-xs-12">
    <a href="{{ route('user', array('username' => $user->username)) }}" class="pull-left user-profile-picture">
        <img src="{{ getAvatar($user,55) }}" class="img img-circle">
    </a>
    <h4>{{{ $user->fullname }}}<br>
        <small>{{{ $user->username }}}</small>
    </h4>
    <hr class="hidden-lg hidden-md"/>
</div>

<div class="col-md-3">
    <ul class="list-unstyled">
        <li></li>
        <li class="fa fa-check-circle-o fa-fw"></li>
        {{ $user->posts()->sum('views') }} {{ t('Views') }}
        <li></li>
        <li class="fa fa-chevron-circle-up fa-fw"></li>
        {{ $user->votes->count() }} {{ t('Post Voted') }}
        <li></li>
        <li class="fa fa-eye fa-fw"></li>
        {{ $user->posts->count() }} {{ t('Posts') }}
        <li></li>
        <li class="fa fa-comments-o fa-fw"></li>
        {{ $user->comments->count() }} {{ t('Comments') }}
    </ul>
    <hr class="hidden-lg hidden-md"/>
</div>

@if($user->fb_link || $user->tw_link || $user->blogurl)
<div class="col-md-3">
    <ul class="list-unstyled user-social">
        @if($user->fb_link)
        <li></li>
        <li class="fa fa-facebook fa-fw"></li>
        <a href="{{ addhttp($user->fb_link) }}">{{ t('Facebook Profile') }}</a>
        @endif
        @if($user->tw_link)
        <li></li>
        <li class="fa fa-twitter fa-fw"></li>
        <a href="{{ addhttp($user->tw_link) }}">{{ t('Twitter Profile') }}</a>
        @endif
        @if($user->blogurl)
        <li></li>
        <li class="fa fa-link fa-fw"></li>
        <a href="{{ addhttp($user->blogurl) }}">{{ t('Blog Url') }}</a>
        @endif
    </ul>
    <hr class="hidden-lg hidden-md"/>
</div>
@endif
<div class="col-md-3">
    <p><i class="fa fa-users fa-fw"></i> {{ $user->followers->count() }} <a href="{{ route('users-followers', ['username' => $user->username]) }}">{{ t('Followers') }}</a></p>
    <p><i class="fa fa-users fa-fw"></i> {{ $user->following->count() }} <a href="{{ route('users-following', ['username' => $user->username]) }}">{{ t('Following') }}</a></p>
    @if(Auth::check())
    @if(Auth::user()->id !== $user->id)
    @if(Auth::user()->following()->whereFollowId($user->id)->count() < 1)
    <button class="btn btn-info follow" data-id="{{ $user->id }}"><i class="fa fa-plus"></i> {{ t('Follow Me') }}</button>
    @else
    <button class="btn btn-danger follow" data-id="{{ $user->id }}"><i class="fa fa-minus"></i> {{ t('Un Follow') }}</button>
    @endif
    @endif
    @endif
</div>

<div class="clearfix"></div>
<hr/>