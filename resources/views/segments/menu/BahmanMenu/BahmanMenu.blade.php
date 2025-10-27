<section class="BahmanMenu live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <ul id="bahman-desktop">
        <li id="bahman-toggle">
            <a href="#" >
                <i class="ri-menu-line"></i>
            </a>
        </li>
        @foreach(getMenuBySettingItems($data->area_name.'_'.$data->part.'_menu') as $item)

            @if($item->dest == null)
                <li class="bahman-item">
                    <a href="{{$item->webUrl()}}">
                        <i class="{{$item->icon}}"></i>
                        {{$item->title}}
                    </a>
                </li>
            @else
                @if(!$item->hide)
                    <li class="bahman-item">
                        <a href="{{$item->webUrl()}}">
                            <i class="{{$item->icon}}"></i>
                            {{$item->title}}
                        </a>
                        @if(method_exists($item->dest,'children') && $item->dest->children()->count())
                            <ul>
                                @foreach($item->dest->children()->where('hide',0)->get() as $subitem)
                                    <li>
                                        <a href="{{$subitem->webUrl()}}">
                                            <i class="{{$subitem->icon??'ri-octagon-line'}}"></i>
                                            {{$subitem->name}}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>

                @endif
            @endif
        @endforeach
        <li class="ms-auto">
            <a href="{{ route('client.card') }}" class="d-inline-block px-1 card-link">
                <i class="ri-shopping-bag-2-line"></i>
                <span class="badge bg-danger card-count">
                    @if(cardCount() > 0)
                        {{cardCount()}}
                    @endif
                </span>
            </a>

            @if(auth('customer')->check())
                <a href="{{route('client.profile')}}" class="d-inline-block px-1 card-link mx-2">
                    <i class="ri-user-line"></i>
                </a>
            @else
                <a href="{{route('client.sign-in')}}" class="d-inline-block px-1 card-link mx-2">
                    <i class="ri-user-line"></i>
                </a>
            @endif
            @if(config('app.xlang.active'))
                @foreach(\App\Models\XLang::all() as $lang)
                    @if($lang->tag != app()->getLocale())
                        <a href="/{{$lang->tag}}" class="d-inline-block px-1" hreflang="{{$lang->tag}}">
                            {{$lang->emoji}}
                        </a>
                    @endif
                @endforeach
            @endif
        </li>
    </ul>

    <div id="bahman-modal">
        <ul id="bahman-mobile" class="nested-list">
            <li class="p-1">
                <form action="{{route('client.search')}}" class="side-data">
                    <div class="input-group">
                        <input type="search" name="q" class="form-control" placeholder="{{__('Search')}}...">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
                            <i class="ri-search-2-line"></i>
                        </button>
                    </div>
                </form>
            </li>
            @foreach(getMenuBySettingItems($data->area_name.'_'.$data->part.'_menu') as $item)

                @if($item->dest == null)
                    <li>
                        <a href="{{$item->webUrl()}}">
                            <i class="{{$item->icon}}"></i>
                            {{$item->title}}
                        </a>
                    </li>
                @else
                    @if(!$item->hide)
                        <li >
                            <a href="{{$item->webUrl()}}">
                                <i class="{{$item->icon}}"></i>
                                {{$item->title}}
                            </a>
                            @if(method_exists($item->dest,'children') && $item->dest->children()->count())
                                <ul>
                                    @foreach($item->dest->children()->where('hide',0)->get() as $subitem)
                                        <li>
                                            <a href="{{$subitem->webUrl()}}">
                                                <i class="{{$subitem->icon??'ri-octagon-line'}}"></i>
                                                {{$subitem->name}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>

                    @endif
                @endif
            @endforeach

        </ul>
    </div>
</section>
