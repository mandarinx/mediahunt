<div class="row">
    <hr/>
    {{ Form::open(['url' => route('post-comment', ['id' => $post->id, 'slug' => $post->slug ])]) }}
    <div class="form-group">
        {{ Form::label('comment', t('Comments'), ['class' => 'control-label']) }}
        {{ Form::textarea('comment',null,['class'=>'form-control','placeholder' => t('Comment'),'rows'=>3]) }}
    </div>
    <div class="form-group">
        {{ Form::submit(t('Add Comment'),['class'=>'btn btn-info']) }}
    </div>
    {{ Form::close() }}
</div>
<div class="row comments-block">
    @foreach($comments as $comment)
        <div class="media" id="comment-{{ $comment->id }}">
            <a class="pull-left" href="{{ route('user', $comment->user->username) }}">
                <img class="media-object img-circle" src="{{ getAvatar($comment->user,64) }}" alt="{{{ $comment->user->fullname }}}">
            </a>

            <div class="media-body">
                <h4 class="media-heading"><a href="{{ route('user',$comment->user->username) }}">{{{ ucfirst($comment->user->fullname) }}}</a> <span class="pull-right">
                         @if(Auth::check())
                            @if($comment->user_id == Auth::user()->id || $post->user->id == Auth::user()->id)
                                <button data-content="{{ $comment->id }}" type="button" class="close delete-comment" aria-hidden="true">&times;</button>@endif
                        @endif
                        <i class="comment-time fa fa-clock-o"></i> <abbr class="timeago comment-time" title="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->toIso8601String() }}</abbr> </span></h4>
                <p>{{ Smilies::parse(e($comment->description)) }}</p>
                <span class="comment-vote"><span id="data-comment-{{ $comment->id }}">{{ $comment->votes->count() }}</span> <a class="fa fa-chevron-circle-up fa-fw {{ checkVoted($comment->votes) == true ? 'comment-voted':'' }}  {{ Auth::check() == true ? 'vote-comment':'' }}" data-id="{{ $comment->id }}"></a></span>
                @if(Auth::check())
                    <a class="replybutton" id="box-{{ $comment->id }}"><i class="fa fa-reply-all fa-fw"></i> {{ t('Reply') }}</a>

                    <div class="commentReplyBox" id="openbox-{{ $comment->id }}">
                        <input type="hidden" name="pid" value="19">
                        {{ Form::textarea('comment','',['id'=>'textboxcontent'.$comment->id,'class'=>"form-control",'rows'=>2,'placeholder'=>t('Comment')]) }}
                        </br>
                        <button class="btn btn-info replyMainButton" id="{{ $comment->id }}">{{ t('Reply') }}</button>
                        <a class="closebutton" id="box-{{ $comment->id }}"><i class="fa fa-times fa-fw"></i>{{ t('Cancel') }}</a>
                    </div>
                    <span class="reply-add-{{ $comment->id }}"></span>
                    @endif
                            <!-- reply block stats here -->
                    @foreach($comment->reply as $reply)
                        <hr/>
                        <div class="media" id="reply-{{ $reply->id }}">
                            <a class="pull-left" href="{{ route('user',$reply->user->username) }}">
                                <img class="media-object img-circle" src="{{ getAvatar($reply->user,64) }}" alt="{{{ $reply->user->fullname }}}">
                            </a>

                            <div class="media-body">
                                <h4 class="media-heading"><a href="{{ url('user/'.$reply->user->username) }}">{{{ ucfirst($reply->user->fullname) }}}</a> <span class="pull-right">
                        @if(Auth::check())
                                            @if($reply->user_id == Auth::user()->id || $post->id == Auth::user()->id || $reply->comment->user->id == Auth::user()->id)
                                                <span class="right"><button data-content="{{ $reply->id }}" type="button" class="close delete-reply" aria-hidden="true">&times;</button></span>
                                            @endif
                                        @endif
                                        <i class="comment-time fa fa-clock-o"></i> <abbr class="timeago comment-time" title="{{ $reply->created_at->toIso8601String() }}">{{ $reply->created_at->toIso8601String() }}</abbr> </span></h4>
                                <p>{{ Smilies::parse(e($reply->description)) }}</p>

                                <p><span class="comment-vote"><span id="data-reply-{{ $reply->id }}">{{ $reply->votes->count() }}</span> <a class="fa fa-chevron-circle-up fa-fw {{ checkVoted($reply->votes) == true ? 'comment-voted':'' }} {{ Auth::check() == true ? 'vote-reply':'' }}" data-id="{{ $reply->id }}"></a></span></p>
                            </div>
                        </div>
                    @endforeach
            </div>
            <hr/>
        </div>
    @endforeach
</div>