<nav id='SideMenu'>
    <div class="text-center py-3" id="side-menu-logo">
        <a href="{{url('/')}}">
            <img src="{{asset('upload/images/logo.svg')}}" alt="">
            {{--                <i class="ri-apple-line "></i>--}}
        </a>
    </div>
    <div id="side-menu-btn">
        <i class="ri-menu-line"></i>
    </div>
    <ul>
        @foreach(getMenuBySetting($data->area_name.'_'.$data->part.'_menu')->items as $item)
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
    </ul>
    <div class="p-2" id="side-menu-content">
        {!! getSetting($data->area_name.'_'.$data->part.'_text') !!}
    </div>
</nav>
