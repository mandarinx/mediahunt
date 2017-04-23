@extends('master/index')
@section('meta_title')
{{ t('Privacy Policy') }} - {{ siteSettings('siteName') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Privacy Policy') }}</h1>
</div>
<div class="row">
    <p>
        {{ siteSettings('privacy') }}
    </p>
</div>
@stop