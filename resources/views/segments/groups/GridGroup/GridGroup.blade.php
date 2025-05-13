<section class='GridGroup live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <div class="grid-grp-container">
            @foreach(getGroupsSet($data->area_name.'_'.$data->part.'_groups') as $group)
                <div class="grid-grp-item">
                    <i class="ri-quote-text"></i>
                    <a href="{{$group->webUrl()}}">
                        <img src="{{$group->imgUrl()}}" alt="{{$group->name}}">
                        <h3>
                            {{$group->name}}
                        </h3>
                    </a>
                    {{--                <img src="{{$clip->imgUrl()}}" alt="">--}}
                </div>
            @endforeach
        </div>
    </div>
</section>
