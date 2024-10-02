<nav id="AplMenu">
    <ul class="{{gfx()['container']}}">
        <li class="icon-menu" id="logo-menu">
            <a href="{{url('/')}}">
                <img src="{{asset('upload/images/logo.svg')}}" alt="">
                {{--                <i class="ri-apple-line "></i>--}}
            </a>
        </li>

        @foreach(getMenuBySettingItems($data->area_name.'_'.$data->part.'_menu') as $item)
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
            <a data-bs-toggle="modal" data-bs-target="#apl-search">
                <i class="ri-search-line"></i>
            </a>
        </li>
        <li class="icon-menu">
            <a href="{{route('client.card')}}">
                <i class="ri-shopping-bag-2-line"></i>
                <span class="badge bg-danger card-count">
                    @if(cardCount() > 0)
                        {{cardCount()}}
                    @endif
                </span>
            </a>
        </li>
        @if(auth('customer')->check())
        <li class="icon-menu">
            <a href="{{route('client.profile')}}">
                <i class="ri-user-line"></i>
            </a>
        </li>
        @else
        <li class="icon-menu">
            <a href="{{route('client.sign-in')}}">
                <i class="ri-user-line"></i>
            </a>
        </li>
        @endif
        <li id="toggler-menu" class="icon-menu">
            <a href="#">
                <i class="ri-menu-line"></i>
            </a>
        </li>
    </ul>
    <div id="reps-menu">
    </div>
</nav>

<!-- Modal -->
<div class="modal fade" id="apl-search" tabindex="-1" aria-labelledby="apl-search" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title fs-5" id="apl-search">
                    {{__("Search")}}
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('client.search')}}" class="side-data">
                    <div class="input-group mb-3">
                        <input type="search" name="q" class="form-control" placeholder="{{__('Search')}}...">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <i class="ri-search-2-line"></i>
                        </button>
                    </div>
                </form>
            </div>
            {{--            <div class="modal-footer">--}}
            {{--                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
            {{--            </div>--}}
        </div>
    </div>
</div>
