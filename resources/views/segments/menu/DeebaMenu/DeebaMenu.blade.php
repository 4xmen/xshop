<nav id='DeebaMenu'>
    <div class="{{gfx()['container']}}">
        <ul>
            @php($items = getMenuBySetting($data->area_name.'_'.$data->part.'_menu')->items)
            @php($menuShow = false)
            @foreach($items as $i => $item)
                {{-- find center --}}
                @if(!$menuShow && ($i > (count($items) / 2) -1 )  )
                    @php($menuShow = true)
                    <li id="deeba-logo-main">
                        <a href="#">
                            <img src="{{asset('upload/images/logo.png')}}" alt="">
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{$item->webUrl()}}">
                        {{$item->title}}
                    </a>
                </li>
            @endforeach
            <li id="deeba-toggle">
                <a >
                    <i class="ri-menu-line"></i>
                </a>
            </li>
        </ul>
    </div>
    <ul id="deeba-sided">
        @foreach(getMenuBySetting($data->area_name.'_'.$data->part.'_menu')->items as $item)
            <li>
                <a href="{{$item->webUrl()}}">
                    {{$item->title}}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
