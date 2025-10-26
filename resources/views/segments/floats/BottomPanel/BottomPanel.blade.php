<section class="BottomPanel live-setting" data-live="{{$data->area_name.'_'.$data->part}}" >
    <ul>
        @foreach(getMenuBySettingItems($data->area_name.'_'.$data->part.'_menu') as $item)
            <li>
                <a href="{{$item->webUrl()}}" title="{{$item->title}}">
                    <i class="{{$item->icon}}"></i>
                    <br>
                    {{$item->title}}
                </a>
            </li>
        @endforeach
    </ul>
</section>
