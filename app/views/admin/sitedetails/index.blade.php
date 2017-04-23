@extends('admin/master')
@section('extra-css')
<link rel="stylesheet" href="http://startbootstrap.com/templates/sb-admin-v2/css/plugins/morris/morris-0.4.3.min.css"/>
@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            <small><i class="fa fa-B"></i></small>
            Dashboard
        </h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<!-- First Row -->
<div class="row">
    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ Comment::count() }}</p>

                        <p class="announcement-text">Comments</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a href="{{ url('admin/comments') }}">
                            <div class="col-xs-6">
                                View Comments
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>

                    </div>
                </div>
            </a>
        </div>
    </div>
    <!--Users-->
    <div class="col-lg-3">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ User::count() }}</p>

                        <p class="announcement-text">Users</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a href="{{ url('admin/users') }}">
                            <div class="col-xs-6">
                                View All Users
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-bookmark-o fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ Post::approved()->count() }}</p>
                        <p class="announcement-text">Posts</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a href="{{ url('admin/posts') }}">
                            <div class="col-xs-6">
                                 Posts
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-star-o fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ Post::approved()->whereNotNull('featured_at')->count() }}</p>

                        <p class="announcement-text">Featured Posts</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a href="{{ url('admin/posts/featured') }}">
                            <div class="col-xs-6">
                                Featured Posts
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- Second Row -->
<div class="row">

    <!--Bannd Users-->
    <div class="col-lg-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-frown-o fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ User::wherePermission('ban')->count() }}</p>

                        <p class="announcement-text">Banned Users</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <a href="{{ url('admin/users/banned') }}">
                        <div class="row">
                            <div class="col-xs-6">
                                View Banned Users
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                    </a>
                </div>
        </div>
        </a>
    </div></div>

<div class="col-lg-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-flag-o fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">{{ Flags::whereNull('checked_at')->count() }}</p>

                        <p class="announcement-text">Flags</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a href="{{ url('admin/reports') }}">
                            <div class="col-xs-6">
                                View Reports
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>

@if(siteSettings('autoApprove') == 0)
<div class="col-lg-3">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <i class="fa fa-question fa-5x"></i>
                </div>
                <div class="col-xs-6 text-right">
                    <p class="announcement-heading">{{ Post::whereNull('approved_at')->count() }}</p>

                    <p class="announcement-text">Require Approval</p>
                </div>
            </div>
        </div>
        <a href="#">
            <div class="panel-footer announcement-bottom">
                <div class="row">
                    <a href="{{ url('admin/posts/approval') }}">
                        <div class="col-xs-6">
                            View Reports
                        </div>
                        <div class="col-xs-6 text-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </div>
                    </a>
                </div>
            </div>
        </a>
    </div>
</div>
@endif
</div>
<!-- Third Row -->
<div class="row">


</div>
<!-- Fourth Row -->
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Daily Signup Chart
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row section">
                    <div class="col-md-12">
                        <h4 class="title">Daily Signup Chart
                            <small>Number of registered users daily</small>
                        </h4>
                    </div>
                    <div class="col-md-12 chart">
                        <div id="stats-container"></div>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Daily Posts
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row section">
                    <div class="col-md-12">
                        <h4 class="title">Daily Posts Created
                            <small>Number of Posts posted daily</small>
                        </h4>
                    </div>
                    <div class="col-md-12 chart">
                        <div id="news-container"></div>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>

    </div>
    <!-- /.col-lg-8 -->
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Site details Quick Look
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="list-group">
                    <div id="donut-qucikLook"></div>
                </div>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

        <!-- /.panel -->
    </div>

    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bell fa-fw"></i> Ratio of posts
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="list-group">
                    <div id="donut-nqratio"></div>
                </div>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->

        <!-- /.panel -->
    </div>
    <!-- /.col-lg-4 -->

</div>
<!-- /.row -->


@stop

@section('extra-js')
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
<script>
    var data = JSON.parse('{{ $signup }}');
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'stats-container',
        data: data,
        xkey: 'date',
        ykeys: ['value'],
        labels: ['Users'],
    });

    var newsdata = JSON.parse('{{ $videos }}');
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'news-container',
        data: newsdata,
        xkey: 'date',
        ykeys: ['value'],
        labels: ['News'],
    });

    Morris.Donut({
        element: 'donut-qucikLook',
        data: [
            {label: "Posts", value: {{ Post::approved()->count() }} },
            {label: "Users", value: {{ User::count() }} },
            {label: "Comments", value: {{ Comment::count() }} },
    ],
    colors: ['#36A9E1','#BDEA74','#FABB3D','#FF5454']
    });

    Morris.Donut({
        element: 'donut-nqratio',
        data: [
            {label: "YouTube", value: {{ Post::approved()->whereProvider('youtube')->count() }} },
            {label: "Vine", value: {{ Post::approved()->whereProvider('vine')->count() }} },
            {label: "Vimeo", value: {{ Post::approved()->whereProvider('vimeo')->count() }} },
            {label: "SoundCloud", value: {{ Post::approved()->whereProvider('soundcloud')->count() }} },
            {label: "Blogs", value: {{ Post::approved()->whereProvider('blog')->count() }} },
            {label: "Links", value: {{ Post::approved()->whereProvider('links')->count() }} }
    ],
    colors: ['#36A9E1','#FF5454','#16a085']
    });
</script>
@stop