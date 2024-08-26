<nav id='RecetMenu'>
    <ul>
        <li>
            <a href="#" id="rect-toggle">
                <i class="ri-menu-line"></i>
            </a>
        </li>
        @foreach(getMenuBySettingItems($data->area->name.'_'.$data->part.'_menu') as $item)
            <li>
                <a href="{{$item->webUrl()}}">
                    {{$item->title}}
                </a>
            </li>
        @endforeach
        <li class="float-end">
            @foreach(\App\Models\XLang::all() as $lang)
                <a href="" class="d-inline-block px-1">
                    {{$lang->emoji}}
                </a>
            @endforeach
        </li>
    </ul>
</nav>
