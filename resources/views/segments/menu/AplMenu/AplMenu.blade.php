<nav id="AplMenu">
    <ul class="{{gfx()['container']}}">
        <li class="icon-menu" id="logo-menu">
            <a href="{{url('/')}}">
                <img src="{{asset('upload/images/logo.svg')}}" alt="">
{{--                <i class="ri-apple-line "></i>--}}
            </a>
        </li>

        @foreach(getMenuBySettingItems($data->area->name.'_'.$data->part.'_menu') as $item)
            <li>
                @if($item->meta == null)
                    <a href="{{$item->webUrl()}}">
                        {{$item->title}}
                    </a>
                    @switch($item->menuable_type)
                        @case(\App\Models\Group::class)
                        @case(\App\Models\Category::class)
                            <div class="sub-menu">
                                <div class="{{gfx()['container']}}">
                                    <div>
                                        <h4>
                                            {{$item->dest->name}}
                                        </h4>
                                        <ul>
                                            @if($item->dest->children()->count() == 0)
                                                @foreach($item->dest->published(5,'view') as $itm)
                                                    <li>
                                                        <a href="{{$itm->webUrl()}}">
                                                            {{\Illuminate\Support\Str::limit($itm->title,25)}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                @foreach($item->dest->children as $itm)
                                                    <li>
                                                        <a href="{{$itm->webUrl()}}">
                                                            {{$itm->name}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div>
                                        <h4>
                                            {{__("Latest ")}} {{$item->dest->name}}
                                        </h4>
                                        <ul>
                                            @foreach($item->dest->published(5) as $itm)

                                                <li>
                                                    <a href="{{$itm->webUrl()}}">
                                                        {{\Illuminate\Support\Str::limit($itm->title,25)}}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div>
                                        <h4>
                                            {{$item->dest->subtitle}}
                                        </h4>
                                        <p>
                                            {{$item->dest->description}}

                                        </p>
                                    </div>
                                </div>
                            </div>
                            @break
                        @default

                    @endswitch
                @else
                    <a href="{{$item->webUrl()}}">
                        {{$item->title}}
                    </a>
                @endif

            </li>
        @endforeach

        <li class="icon-menu">
            <a href="#">
                <i class="ri-search-line"></i>
            </a>
        </li>
        <li class="icon-menu">
            <a href="#">
                <i class="ri-shopping-bag-2-line"></i>
                <span class="badge bg-danger card-count">
                    @if(cardCount() > 0)
                        {{cardCount()}}
                    @endif
                </span>
            </a>
        </li>
        <li id="toggler-menu" class="icon-menu">
            <a href="#">
                <i class="ri-menu-line"></i>
            </a>
        </li>
    </ul>
    <div id="reps-menu">
    </div>
</nav>
