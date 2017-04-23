@extends('master/index')
@section('meta_title')
{{ t('About Us') }} - {{ siteSettings('siteName') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('About Us') }}</h1>
</div>
<div class="row">
    <p>
        {{ siteSettings('about') }}
    </p>
</div>
@stop