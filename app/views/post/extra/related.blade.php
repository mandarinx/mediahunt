<div class="row gallery">
    <h2 class="page-header">{{ t('Related Posts') }}</h2>
    @foreach(array_chunk($related->getCollection()->all(),4) as $pts)
    <div class="row">
        <!--/.row-->
        @foreach($pts as $post)
        @if($post->user)
        <div class="col-lg-3 col-md-3 gallery-display">
            <figure>
                <a href="{{ route('post',array('id' => $post->id, 'slug' => $post->slug )) }}">
                    <img src="{{ JitImage::source('uploads/'.$post->thumbnail)->cropAndResize(280, 280, 5) }}" alt="{{{ $post->title }}}" class="display-image">
                </a>
                <a href="{{ route('post',array('id' => $post->id, 'slug' => $post->slug )) }}" class="figcaption">
                    <h4>{{{ $post->title }}}</h4>
                </a>
            </figure>
            <!--figure-->

            <div class="box-detail">
                <h5 class="heading"><a href="{{ route('post',array('id' => $post->id, 'slug' => $post->slug )) }}">{{{ Str::limit($post->title,30) }}}</a></h5>
                <ul class="list-inline gallery-details">
                    <li>{{ t('by') }} <a href="{{ route('user', $post->user->username) }}">{{{ Str::limit(ucfirst($post->user->fullname),18) }}}</a></li>
                    <li class="pull-right"><i class="fa fa-eye fa-fw"></i>&nbsp;{{ $post->views }}&nbsp;<i class="fa fa-chevron-circle-up fa-fw"></i>{{ $post->votes->count() }}&nbsp;<i class="fa fa-comments fa-fw"></i> {{ $post->comments->count() }}
                    </li>
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