<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('meta_title', siteSettings('siteName'))</title>
    <link rel="shortcut icon" href="{{ asset(siteSettings('favIcon')) }}" type="image/x-icon"/>
    <meta name="description" content="@yield('meta_description', siteSettings('siteName'))"/>
    <meta property="og:title" content="@yield('meta_title', siteSettings('siteName'))"/>
    <meta property="og:type" content="website"/>
    <meta property='og:description' content="@yield('meta_description', siteSettings('siteName'))"/>
    <meta property="og:url" content="@yield('og_url',Request::url())"/>
    <meta property="og:site_name" content="{{ siteSettings('siteName') }}"/>
    @yield('extra_meta')
    <!--[if lt IE 9]>
    <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300italic,600italic,700italic,800italic,400,300,600,700,800" rel='stylesheet' type='text/css'>
    {{ HTML::style('static/css/bootstrap.min.css') }}
    {{ HTML::style('static/font-awesome/css/font-awesome.css') }}
    {{ HTML::style('static/css/style.css') }}
    {{ HTML::style('static/css/sb.css') }}
    {{ HTML::style('static/css/rrssb.css') }}
    {{ HTML::style('static/css/oembed.css') }}
    {{ HTML::style('static/css/nprogress.css') }}
</head>

<body>

<div id="wrapper">
    @include('master/notices')
    @include('master/navbar')

    <div id="page-wrapper">
        @yield('page-content')
        @yield('pagination')
        @include('master/footer')
    </div>
    <!-- /#page-wrapper -->


</div>
<!-- /#wrapper -->

<!-- Core Scripts - Include with every page -->
{{ HTML::script('static/js/jquery-1.10.2.js') }}
{{ HTML::script('static/js/bootstrap.min.js') }}
{{ HTML::script('static/js/plugins/metisMenu/jquery.metisMenu.js') }}
{{ HTML::script('static/js/infiniteScroll.js') }}
{{ HTML::script('static/js/jquery.timeago.js') }}
{{ HTML::script('static/js/rrssb.min.js') }}
{{ HTML::script('static/js/json2html.js') }}
{{ HTML::script('static/js/jquery.json2html.js') }}
{{ HTML::script('static/js/jquery.oembed.js') }}
{{ HTML::script('static/js/nprogress.js') }}
{{ HTML::script('static/js/editor/ckeditor.js') }}
{{ HTML::script('static/js/jquery.fitvids.js') }}
{{ HTML::script('static/js/jquery.lazyload.min.js') }}
{{ HTML::script('static/js/custom.js') }}
</body>
</html>