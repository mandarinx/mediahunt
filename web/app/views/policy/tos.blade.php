@extends('master/index')
@section('meta_title')
{{ t('Terms of Services') }} - {{ siteSettings('siteName') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Terms of Services') }}</h1>
</div>
<div class="row">
    <p>
        {{ siteSettings('tos') }}
    </p>
</div>
@stop