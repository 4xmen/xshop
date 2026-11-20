<section class="RitterProducts live-setting" data-live="{{$data->area_name.'_'.$data->part}}">
    <div class="{{gfx()['container']}}">
        <div class="row g-4">
            @foreach(\App\Models\Product::with('category','creators')->where('status',1)->orderByDesc('id')->limit(4)->get() as $product)
                <div class="col-6 col-md-3">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="{{$product->imgUrl()}}" alt="{{$product->name}}">
                            <div class="product-actions">
                                <button type="button" data-slug="{{$product->slug}}" data-is-fav="{{$product->isFav()}}"
                                        data-bs-custom-class="custom-tooltip"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="{{__("Add to / Remove from favorites")}}"><i class="ri-heart-line"></i>
                                </button>
                                <button type="button"><i class="ri-eye-line"></i></button>
                            </div>
                        </div>
                        <div class="product-info">
                            <a class="product-category" href="{{$product->category->webUrl()}}">
                                <i class="product-dot"></i>
                                {{$product->category->name}}
                            </a>
                            <h3>
                                <a href="{{$product->webUrl()}}">
                                    {{$product->name}}
                                </a>
                            </h3>
                            <div class="product-price">{{$product->getPrice()}}</div>
                            <button class="product-btn">{{__("Add to card")}}</button>
                            <ul class="product-specs">
                                @foreach($product->creators as $c)
                                    <li>{{$c->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach


        </div>
    </div>
</section>
