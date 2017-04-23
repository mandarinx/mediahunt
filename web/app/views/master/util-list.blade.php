<div class="util-list">
    <a href="#" data-toggle="dropdown">{{ t('Select Category') }}<span class="caret"></span></a>

    <ul class="dropdown-menu" role="menu">
        @if(Input::get('provider'))
        @foreach(siteCategories() as $category)
        <li><a href="{{ Request::url() }}?provider={{ Input::get('provider') }}&category={{ $category->slug }}">{{ $category->name }}</a></li>
        @endforeach
        @else
        @foreach(siteCategories() as $category)
        <li><a href="{{ Request::url() }}?category={{ $category->slug }}">{{ $category->name }}</a></li>
        @endforeach
        @endif
    </ul>
</div>
