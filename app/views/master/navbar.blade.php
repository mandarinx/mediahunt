<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ route('home') }}">{{ siteSettings('siteName') }} </a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right user-links-navbar">

        @if(Auth::check())
        <li class="dropdown">
            <a  href="{{ route('users-feeds') }}">
                <i class="fa fa fa-bolt fa-fw"></i>
            </a>
        </li>
        <li class="dropdown">
            <a  href="{{ route('notifications') }}">
                <i class="fa fa fa-bell fa-fw"></i> <span class="badge">{{ (Auth::user()->notifications()->whereNull('seen_at')->count() > 0  ? Auth::user()->notifications()->whereNull('seen_at')->count() :false) }}</span>
            </a>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="{{ route('user',Auth::user()->username)}}"><i class="fa fa-user fa-fw"></i> {{ t('My Profile')}}</a>
                </li>
                <li><a href="{{ route('settings')}}"><i class="fa fa-gear fa-fw"></i> {{ t('Settings') }}</a>
                </li>
                <li class="divider"></li>
                <li><a href="{{ route('logout')}}"><i class="fa fa-sign-out fa-fw"></i> {{ t('Logout')}}</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
        @else
        <li>{{ link_to_route('login',t('Login')) }}</li>
        <li>{{ link_to_route('registration',t('Create Account')) }}</li>
        @endif
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default navbar-static-side sidebar-extra" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="{{ route('trending') }}"><i class="fa fa-signal fa-fw"></i> {{ t('Trending') }}</a>
                </li>
                <li>
                    <a href="{{ route('latest') }}"><i class="fa fa-clock-o fa-fw"></i> {{ t('Latest') }}</a>
                </li>
                <li>
                    <a href="{{ route('featured') }}"><i class="fa fa-star-o fa-fw"></i> {{ t('Featured') }}</a>
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-image fa-fw"></i> {{ t('Images') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ route('trending', array('provider' => 'image')) }}">{{ t('Trending')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('latest', array('provider' => 'image')) }}">{{ t('Latest')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('featured', array('provider' => 'image')) }}">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-youtube-play fa-fw"></i> {{ t('YouTube') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ route('trending', array('provider' => 'youtube')) }}">{{ t('Trending')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('latest', array('provider' => 'youtube')) }}">{{ t('Latest')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('latest', array('provider' => 'youtube')) }}">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-vine fa-fw"></i> {{ t('Vine') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ route('trending', array('provider' => 'vine')) }}">{{ t('Trending')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('latest', array('provider' => 'vine')) }}">{{ t('Latest')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('featured', array('provider' => 'vine')) }}">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-vimeo-square fa-fw"></i> {{ t('Vimeo') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ route('trending', array('provider' => 'vimeo')) }}">{{ t('Trending')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('latest', array('provider' => 'vimeo')) }}">{{ t('Latest')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('featured', array('provider' => 'vimeo')) }}">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-soundcloud fa-fw"></i> {{ t('SoundCloud') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ route('trending', array('provider' => 'soundcloud')) }}">{{ t('Trending')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('latest', array('provider' => 'soundcloud')) }}">{{ t('Latest')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('featured', array('provider' => 'soundcloud')) }}">{{ t('Featured')}}</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>

                <li class="">
                    <a href="#"><i class="fa fa-pencil fa-fw"></i> {{ t('Blogs') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ route('trending', array('provider' => 'blog')) }}">{{ t('Trending')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('latest', array('provider' => 'blog')) }}">{{ t('Latest')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('featured', array('provider' => 'blog')) }}">{{ t('Featured')}}</a>
                        </li>
                         <li>
                            <a href="{{ route('blog-submit') }}"><i class="fa fa-file-image-o fa-fw"></i> {{ t('Submit Blog') }}</a>
                         </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li class="">
                    <a href="#"><i class="fa fa-link fa-fw"></i> {{ t('Links') }}<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" style="height: 0px;">
                        <li>
                            <a href="{{ route('trending', array('provider' => 'link')) }}">{{ t('Trending')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('latest', array('provider' => 'link')) }}">{{ t('Latest')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('featured', array('provider' => 'link')) }}">{{ t('Featured')}}</a>
                        </li>
                         <li>
                            <a href="{{ route('link-submit') }}"><i class="fa fa-file-image-o fa-fw"></i> {{ t('Submit Link') }}</a>
                         </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="{{ route('image-submit') }}"><i class="fa fa-file-image-o fa-fw"></i> {{ t('Upload Image') }}</a>
                </li>
                <li>
                    <a href="{{ route('post-submit') }}"><i class="fa fa-play-circle fa-fw"></i> {{ t('Submit Media') }}</a>
                </li>
                <li class="sidebar-search">
                    {{ Form::open(array('url'=>'search', 'method' => 'get')) }}
                    <div class="input-group custom-search-form">
                        <input type="text" name="q" class="form-control" placeholder="{{ t('Search') }}...">
                             <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </div>
                    {{ Form::close() }}
                    <!-- /input-group -->
                </li>
            </ul>
            <!-- /#side-menu -->
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>