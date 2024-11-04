<div class="MinooProductGrid xshop-product-item">
    <a href="{{$product->webUrl()}}">
        <img src="{{$product->thumbUrl()}}" alt="{{$product->name}}" loading="lazy">
        <img src="{{$product->thumbUrl2()}}" class="img-2" alt="{{$product->name}}" loading="lazy">
        <div class="">
            <div class="btns">
                @if($product->stock_status == 'IN_STOCK')
                    <a href="{{ route('client.product-card-toggle',$product->slug) }}"
                       class="btn btn-primary add-to-card">
                        <i class="ri-shopping-bag-3-line"></i>
                        {{__("Add to card")}}
                    </a>
                @else
                    <a
                        class="btn btn-primary disabled">
                        <i class="ri-shopping-bag-3-line"></i>
                        {{__("Not available")}}
                    </a>
                @endif
                <a class="btn btn-outline-dark compare-btn text-dark" data-slug="{{$product->slug}}"
                   data-bs-custom-class="custom-tooltip"
                   data-bs-toggle="tooltip" data-bs-placement="top"
                   title="{{__("Add to/ Remove from compare list")}}">
                    <i class="ri-scales-3-line"></i>
                </a>
                <a class="btn btn-outline-secondary fav-btn" data-slug="{{$product->slug}}" data-is-fav="{{$product->isFav()}}"
                   data-bs-custom-class="custom-tooltip"
                   data-bs-toggle="tooltip" data-bs-placement="top" title="{{__("Add to / Remove from favorites")}}">
                    <i class="ri-heart-line"></i>
                    <i class="ri-heart-fill"></i>
                </a>
            </div>
        </div>
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
    </a>
</div>
