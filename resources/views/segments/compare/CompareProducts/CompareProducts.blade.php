<section class='CompareProducts content'>
    <div class="{{gfx()['container']}}">
        <h1>
            {{$title}}
        </h1>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md">
                    <div class="compare">
                        <div class="top">
                            <img src="{{$product->originalImageUrl()}}" alt="" loading="lazy">
                            <h2>
                                {{$product->name}}
                            </h2>
                        </div>
                        <ul>
                            <li>
                                <span>
                                    {{__("Price")}}
                                </span>
                                <b>
                                    {{$product->getPrice()}}
                                </b>
                            </li>
                            @foreach($product->fullMeta() as $meta)
                                <li>
                                    <span>
                                        {{$meta['data']->label}}
                                    </span>
                                    <b class="float-end">
                                        {!! $meta['human_value'] !!}
                                    </b>
                                </li>
                            @endforeach
                        </ul>
                        <div class="p-2">
                            <a href="{{ route('client.product-card-toggle',$product->slug) }}" class="btn btn-outline-primary w-100 add-to-card">
                                <i class="ri-shopping-bag-3-line"></i>
                                {{__("Add to card")}}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
