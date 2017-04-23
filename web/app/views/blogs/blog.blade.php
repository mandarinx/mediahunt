@extends('master/index')

@section('page-content')
<div class="row">
    <h1 class="page-header">{{ link_to_route('blog', ucfirst($post->title), array('id' => $post->id, 'slug' => $post->slug)) }}</h1>
</div>
<div class="row">
<p>{{ $post->created_at->diffForHumans() }} {{ t('by')}} {{ link_to_route('user',ucfirst(e($post->user->fullname)), array('username'=>$post->user->username)) }}</p>
<p>{{ $post->description }}</p>
    @include('post/extra/social-share')
</div>
@stop