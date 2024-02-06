<nav>
    <ul id="mega-menu">
        @foreach(\App\Helpers\getMainCats(8) as $mcat)
            <li>
                <a href="{{route('product-category.show',$mcat->slug)}}">
                    {{$mcat->name}}
                </a>
                <ul>
                    <li>
                        <h3>
                            محبوب ترین
                            {{$mcat->name}}
                            ها
                        </h3>
                        <ul>
                            @foreach($mcat->products()->orderby('stock_quantity','desc')->limit(5)->get() as $p)
                                <li>
                                    <a href="{{route('product',$p->slug)}}">
                                        {{$p->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li>
                        <h3>
                            {{$mcat->name}}
                            به تفکیک
                        </h3>
                        <ul>
                            @foreach(\App\Helpers\getSubCats($mcat->id) as $subcat)
                                <li>
                                    <a href="{{route('product-category.show',$subcat->slug)}}">
                                        {{$subcat->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="x-highlight">
                        <h3>
                            {{$mcat->name}}
                        </h3>
                        <br>
                        <p>
                            {{$mcat->description}}
                        </p>
                    </li>
                    <li>
                        <img src="{{$mcat->thumbUrl()}}" alt="">
                    </li>
                </ul>
            </li>
        @endforeach
        {!! \App\Helpers\MenuShowByName('menu')  !!}
    </ul>
</nav>
<div id="search-list"></div>
