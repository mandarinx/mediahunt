@foreach($posts as $post)
<div class="row post-item post-{{ $post->type }}" id="{{ $post->id }}">
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
    <div class="col-lg-10 col-md-9 col-sm-10 col-xs-10">
        <h2 class="post-title">{{ link_to(filter_var($post->source,FILTER_SANITIZE_URL), ucfirst(e($post->title)), array('target'=>'_blank','rel'=>'nofollow')) }}&nbsp;
            <i class="fa fa-external-link fa-fw small"></i><small>&nbsp;({{{ parseUrl($post->source) }}})</small>
        </h2>
        <p><abbr class="timeago" title="{{ $post->created_at->toISO8601String() }}">{{ $post->created_at->toDateTimeString() }}</abbr> in {{ link_to_route('latest', $post->category->name, array('category'=>$post->category->slug)) }} {{ t('by')}} {{ link_to_route('user',ucfirst(e($post->user->fullname)), array('username'=>$post->user->username)) }}</p>
        <ul class="list-inline">
            <li><i class="fa fa-comments-o"></i>&nbsp;{{ link_to_route('post', $post->comments->count() . '&nbsp;'. t('comments'),array('id'=>$post->id,'slug'=>$post->slug)) }}</li>
            <li><i class="fa fa-eye"></i>&nbsp;{{ $post->views }}&nbsp;{{ t('views') }}</li>
            <li><i class="fa fa-flag-o flag"></i>&nbsp;{{ link_to_route('flag', t('Flag'), array('id'=>$post->id), array('class' => 'flag')) }}</li>
        </ul>
    </div>
    <!--/.col-lg-9 col-md-9 col-sm-9 col-xs-9-->
    <div class="col-lg-1 col-md-2 hidden-sm hidden-xs">
        <a href="{{ route('user',$post->user->username) }}"><img src="{{ getAvatar($post->user) }}" class="img-circle"/></a>
    </div>
    <!--/.col-md-1 col-lg-1 hidden-sm hidden-xs-->
</div>
@endforeach