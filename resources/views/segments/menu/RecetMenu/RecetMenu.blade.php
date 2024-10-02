<nav id='RecetMenu'>
    <ul>
        <li>
            <a href="#" id="rect-toggle">
                <i class="ri-menu-line"></i>
            </a>
        </li>
        @foreach(getMenuBySettingItems($data->area_name.'_'.$data->part.'_menu') as $item)
            <li>
                <a href="{{$item->webUrl()}}">
                    {{$item->title}}
                </a>
            </li>
        @endforeach
        <li class="float-end">
            <a href="{{ route('client.card') }}" class="d-inline-block px-1 card-link">
                <i class="ri-shopping-bag-2-line"></i>
                <span class="badge bg-danger card-count">
                    @if(cardCount() > 0)
                        {{cardCount()}}
                    @endif
                </span>
            </a>

        @if(auth('customer')->check())
                <a href="{{route('client.profile')}}"  class="d-inline-block px-1 card-link">
                    <i class="ri-user-line"></i>
                </a>
        @else
                <a href="{{route('client.sign-in')}}"  class="d-inline-block px-1 card-link">
                    <i class="ri-user-line"></i>
                </a>
        @endif
            @if(config('app.xlang.active'))
                @foreach(\App\Models\XLang::all() as $lang)
                    @if($lang->tag != app()->getLocale())
                        <a href="/{{$lang->tag}}" class="d-inline-block px-1">
                            {{$lang->emoji}}
                        </a>
                    @endif
                @endforeach
            @endif
        </li>
    </ul>
</nav>
