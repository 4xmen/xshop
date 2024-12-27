<header class='HomayonMenu live-setting' data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="homayon-logo"
         style="background-image: url('{{asset('upload/images/'.$data->area_name.'.'.$data->part.'.svg')}}')">
        <div class="logo-container">
            <a href="{{route('client.welcome')}}">
                <img src="{{asset('upload/images/logo.png')}}" alt="logo">
            </a>
        </div>
    </div>
    <div class="homayon-top">
        <div class="container">
            <div class="row pt-4">
                <div class="col-6">
                    <ul class="social mt-5">
                        @foreach(getSettingsGroup('social_')??[] as $k => $social)
                            <li class="d-inline-block mx-2">
                                <a href="{{$social}}">
                                    <i class="ri-{{$k}}-line"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-6 text-end">
                    @if(getSetting($data->area_name.'_'.$data->part.'_btn'))
                    <a href="{{route('client.products')}}" class="btn btn-primary mt-5">
                        {{getSetting($data->area_name.'_'.$data->part.'_title')}}
                    </a>
                    @else
                        &nbsp;
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="container homayon-middle">
        <ul>
            <li id="homa-toggle-menu" class="icon-menu ms-auto">
                <a href="#">
                    <i class="ri-menu-line"></i>
                </a>
            </li>
            <li class="icon-menu">
                <a data-bs-toggle="modal" data-bs-target="#homa-search">
                    <i class="ri-search-line"></i>
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

        </ul>
    </div>
    <div class="homayon-bottom">

        <div class="container">
            <nav>
                <ul>
                    @php($items = getMenuBySetting($data->area_name.'_'.$data->part.'_menu')->items)
                    @php($menuShow = false)
                    @foreach($items as $i => $item)
                        {{-- find center --}}
                        @if(!$menuShow && ($i > (count($items) / 2) -1 )  )
                            @php($menuShow = true)
                            <li class="homayon-divider">
                                &nbsp;
                            </li>
                        @endif

                        <li>
                            <a href="{{$item->webUrl()}}">
                                {{$item->title}}
                            </a>
                            @if($item->meta == null)

                                @switch($item->menuable_type)
                                    @case(\App\Models\Group::class)
                                    @case(\App\Models\Category::class)
                                        @if($item->dest->children()->where('hide',false)->count() > 0)
                                            <ul class="sub-menu-item">
                                                @foreach($item->dest->children()->where('hide',false)->get() as $itm)
                                                    <li>
                                                        <a href="{{$itm->webUrl()}}">
                                                            {{$itm->name}}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @break
                                        @endif
                                    @default

                                @endswitch
                            @endif

                        </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
    <nav class="homayon-resp-menu" style="display: none">
        <ul>
            @foreach(getMenuBySettingItems($data->area_name.'_'.$data->part.'_menu') as $item)
                <li>
                    <a href="{{$item->webUrl()}}">
                        {{$item->title}}
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</header>


<!-- Modal -->
<div class="modal fade" id="homa-search" tabindex="-1" aria-labelledby="apl-search" aria-hidden="true">
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

