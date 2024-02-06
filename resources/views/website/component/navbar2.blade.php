<nav>
    <ul id="mega-menu">
        @foreach(\App\Helpers\getMainCats(8) as $mcat)
            <li>
                <a href="{{route('product-category.show',$mcat->slug)}}">
                    {{$mcat->name}}
                </a>
                <ul>
                @foreach(\App\Helpers\getSubCats($mcat->id,4) as $subcat)
                    <li>
                        <h3>
                            <a href="{{route('product-category.show',$subcat->slug)}}">
                                {{$subcat->name}}
                            </a>
                        </h3>
                        <ul>
                            @foreach(\App\Helpers\getSubCats($subcat->id) as $sc)
                                <li>
                                    <a href="{{route('product-category.show',$sc->slug)}}">
                                        {{$sc->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
                </ul>
            </li>
        @endforeach
        {!! \App\Helpers\MenuShowByName('menu')  !!}
    </ul>
</nav>
<div id="search-list"></div>
