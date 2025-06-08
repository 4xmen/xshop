<section class="SarvMenu live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <div class="sarv-row">
            <div>
                <img src="{{asset('upload/images/logo.svg')}}" alt="{{config('app.name')}}">
            </div>
            <div>

                <form action="{{route('client.search')}}">
                    <div class="form-control omg-search">
                        <i class="ri-search-2-line"></i>
                        <input type="text" name="q" class="live-search" placeholder="{{__("Search")}}...">
                    </div>
                </form>

                <nav class="no-view">
                    <ul>
                        @foreach(getMenuBySettingItems($data->area_name.'_'.$data->part.'_menu') as $item)
                            <li>
                                @if($item->meta == null)
                                    <a href="{{$item->webUrl()}}">
                                        {{$item->title}}
                                    </a>
                                    @switch($item->menuable_type)
                                        @case(\App\Models\Group::class)
                                        @case(\App\Models\Category::class)
                                            <div class="sub-menu main-dir">
                                                <h6 class="p-3">
                                                    <a href="{{$item->webUrl()}}">
                                                        {{$item->title}}
                                                    </a>
                                                </h6>
                                                <ul>
                                                    @foreach($item->dest->children()->where('hide',false)->get() as $itm)
                                                        <li>
                                                            <a href="{{$itm->webUrl()}}">
                                                                <i class="{{$itm->icon}}"></i>
                                                                <b>
                                                                    {{$itm->name}}
                                                                </b>
                                                                <i class="ri-arrow-down-s-line"></i>
                                                            </a>
                                                            <ul>
                                                                @foreach($itm->children()->where('hide',false)->get() as $im)
                                                                    <li>
                                                                        <a href="{{$im->webUrl()}}">
                                                                            <i class="{{$im->icon}}"></i> {{$im->name}}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
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
                    </ul>
                </nav>

            </div>
            <div>
                <div class="sarv-btn-container">

                    @if(auth('customer')->check())
                        <a href="{{route('client.profile')}}" class="btn btn-outline-primary">
                            <i class="ri-user-line"></i>
                            {{__("Profile")}}
                        </a>
                    @else
                        <a href="{{route('client.sign-in')}}" class="btn btn-outline-primary">
                            <i class="ri-user-line"></i>
                            <span>
                                {{__("Login")}} / {{__('Register')}}
                            </span>
                        </a>
                    @endif
                    <a href="{{ route('client.card') }}" class="btn btn-outline-primary live-card-show"
                       data-url="{{route('client.card.items')}}">
                        <i class="ri-shopping-bag-2-line"></i>
                        <span class="badge bg-danger card-count">
                            @if(cardCount() > 0)
                                {{cardCount()}}
                            @endif
                        </span>
                    </a>
                    <a class="btn btn-outline-primary" id="sarv-toggle" href="#">
                        <i class="ri-menu-line"></i>
                    </a>
                </div>
                <a href="{{getSetting($data->area_name.'_'.$data->part.'_link')}}" class="float-end mb-2 no-view">
                    <i class="{{getSetting($data->area_name.'_'.$data->part.'_icon')}}"></i>
                    {{getSetting($data->area_name.'_'.$data->part.'_title')}}
                </a>
            </div>
        </div>
        <form action="{{route('client.search')}}">
            <div class="form-control mobile-search">
                <i class="ri-search-2-line"></i>
                <input type="text" name="q" class="live-search" placeholder="{{__("Search")}}...">
            </div>
        </form>


    </div>
</section>
<div id="sarv-responsive-menu">
    <nav class="nested-list">

        <ul>
            @foreach(getMenuBySettingItems($data->area_name.'_'.$data->part.'_menu') as $item)
                <li>
                    @if($item->meta == null)
                        <a href="{{$item->webUrl()}}">
                            {{$item->title}}
                        </a>
                        @switch($item->menuable_type)
                            @case(\App\Models\Group::class)
                            @case(\App\Models\Category::class)
                                <ul>
                                    @foreach($item->dest->children()->where('hide',false)->get() as $itm)
                                        <li>
                                            <a href="{{$itm->webUrl()}}">
                                                <b>
                                                    {{$itm->name}}
                                                </b>
                                            </a>
                                            @if($itm->children()->where('hide',false)->count() > 0)
                                                <ul>
                                                    @foreach($itm->children()->where('hide',false)->get() as $im)
                                                        <li>
                                                            <a href="{{$im->webUrl()}}">
                                                                {{$im->name}}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
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
        </ul>
    </nav>

</div>
