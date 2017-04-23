@extends('master/index')
@section('meta_title')
{{ t('Frequently Asked Questions') }} - {{ siteSettings('siteName') }}
@stop
@section('page-content')
<div class="row">
    <h1 class="page-header">{{ t('Frequently Asked Questions') }}</h1>
</div>
<div class="row">
    <p>
        {{ siteSettings('faq') }}
    </p>
</div>
@stop