<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    {{ HTML::style('static/admin/css/bootstrap.min.css') }}
    {{ HTML::style('static/admin/font-awesome/css/font-awesome.css') }}
    @yield('extra-css')
    {{ HTML::style('static/css/jquery-ui.css') }}
    {{ HTML::style('static/admin/plugins/footable/css/footable.core.css') }}
    {{ HTML::style('static/admin/css/sb-admin.css') }}

</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('admin') }}">Admin Panel</a>
            <ul class="nav navbar-nav">
                <li>
                    <a href="{{ url('/') }}">Return to site</a>
                </li>
            </ul>
        </div>
    </nav>
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{ url('admin') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-users fa-fw"></i> Users<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/users') }}">All Users</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/users/featured') }}">Featured Users</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/users/banned') }}">Banned Users</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/adduser') }}">Add real/fake user</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-file-image-o fa-fw"></i> {{ t('Images') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ url('admin/posts') }}?provider=image">All Posts</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/posts/featured') }}?provider=image">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-youtube-play fa-fw"></i> {{ t('YouTube') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ url('admin/posts') }}?provider=youtube">All Posts</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/posts/featured') }}?provider=youtube">Featured</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-vine fa-fw"></i> {{ t('Vine') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ url('admin/posts') }}?provider=vine">All Posts</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/posts/featured') }}?provider=vine">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-vimeo-square fa-fw"></i> {{ t('Vimeo') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ url('admin/posts') }}?provider=vimeo">All Posts</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/posts/featured') }}?provider=vimeo">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li class="">
                    <a href="#"><i class="fa fa-soundcloud fa-fw"></i> {{ t('SoundCloud') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ url('admin/posts') }}?provider=soundcloud">All Posts</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/posts/featured') }}?provider=soundcloud">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Blogs<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/posts') }}?provider=blog">All Blogs</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/posts/featured') }}?provider=blog">Featured Blogs</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-link fa-fw"></i> Links<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/posts') }}?provider=link">All Links</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/posts/featured') }}?provider=link">Featured Links</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i> Site Settings<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/sitesettings') }}">Site Details</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/limitsettings') }}">Limit Settings</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/sitecategory') }}">Sites Category</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li>
                    <a href="#"><i class="fa fa-plus fa-fw"></i> Extra<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="{{ url('admin/updatesitemap') }}">Update Site Map</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            </ul>
            <!-- /#side-menu -->
        </div>
        <!-- /.sidebar-collapse -->
    </nav>
    <div id="page-wrapper">
        @if(Session::has('flashSuccess'))
        <div class="alert alert-success fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ Session::get('flashSuccess') }}</strong>
        </div>
        @endif

        @if(Session::has('flashError'))
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ Session::get('flashError') }}</strong>
        </div>
        @endif

        @if(Session::has('errors'))
        <div class="alert alert-danger fade in">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <strong>{{ Session::get('errors')->first() }}</strong>
        </div>
        @endif

        <!--content-->
        @yield('content')

    </div> <!--.page-wrapper-->
</div>

{{ HTML::script('static/admin/js/jquery-1.10.2.js') }}
{{ HTML::script('static/admin/js/jquery-ui.min.js') }}
{{ HTML::script('static/admin/js/bootstrap.min.js') }}
{{ HTML::script('static/admin/js/plugins/metisMenu/jquery.metisMenu.js') }}
{{ HTML::script('static/admin/js/sb-admin.js') }}
{{ HTML::script('static/js/jquery.timeago.js') }}
{{ HTML::script('static/admin/plugins/footable/js/footable.js') }}
{{ HTML::script('static/admin/plugins/footable/js/footable.filter.js') }}
{{ HTML::script('static/admin/plugins/footable/js/footable.sort.js') }}
{{ HTML::script('static/admin/js/sortable.js') }}
{{ HTML::script('static/js/editor/ckeditor.js') }}
@yield('extra-js')
<script>
    var time = $('abbr.timeago');
    time.timeago();
    $('[data-toggle="tooltip"]').tooltip();
    $('.footable').footable();
</script>
</body>
</html>