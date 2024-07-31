<section class='ProductGridSidebar content' id="product-list-view">
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <div class="row">
            @if(!getSetting($data->area->name.'_'.$data->part.'_invert'))
                <div class="col-lg-3 p-lg-1 pt-lg-0">
                    @include('segments.products_page.ProductGridSidebar.inc.product-sidebar')
                </div>
            @endif
            <div class="col-lg-9">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 p-2">
                            <div class="product-item">
                                <a class="fav-btn" data-slug="{{$product->slug}}" data-is-fav="{{$product->isFav()}}">
                                    <i class="ri-heart-line"></i>
                                    <i class="ri-heart-fill"></i>
                                </a>
                                <a class="compare-btn" data-slug="{{$product->slug}}">
                                    <i class="ri-scales-3-line"></i>
                                </a>
                                <a href="{{$product->webUrl()}}">
                                    <img src="{{$product->imgUrl()}}" alt="{{$product->name}}">
                                    <h3>
                                        {{$product->name}}
                                    </h3>
                                    <div class="prices">
                                        @if($product->hasDiscount())
                                            <span class="old-price">
                                        {{$product->oldPrice()}}
                                    </span>
                                        @endif
                                        <span class="price">
                                    {{$product->getPrice()}}
                                </span>
                                    </div>
                                    <div class="p-2">
                                        <a href="{{ route('client.product-card-toggle',$product->slug) }}"
                                           class="btn btn-outline-primary w-100 add-to-card">
                                            <i class="ri-shopping-bag-3-line"></i>
                                            {{__("Add to card")}}
                                        </a>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{$products->withQueryString()->links()}}

            </div>
            @if(getSetting($data->area->name.'_'.$data->part.'_invert'))
                <div class="col-lg-3">
                    @include('segments.products_page.ProductGridSidebar.inc.product-sidebar')
                </div>
            @endif
        </div>
    </div>
</section>
