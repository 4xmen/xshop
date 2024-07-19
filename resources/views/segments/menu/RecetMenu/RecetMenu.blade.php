<nav id='RecetMenu'>
    <ul>
        <li>
            <a href="#" id="rect-toggle">
                <i class="ri-menu-line"></i>
            </a>
        </li>
        @foreach(getMenuBySetting($data->area->name.'_'.$data->part.'_menu')->items as $item)
            <li>
                @if($item->meta == null)
                <a href="{{$item->dest->webUrl()}}">
                    {{$item->title}}
                </a>
                @else
                <a href="{{$item->meta}}">
                    {{$item->title}}
                </a>
                @endif

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
